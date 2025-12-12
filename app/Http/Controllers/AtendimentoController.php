<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\AtendimentoRealizado;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use App\Models\Beneficiario;
use App\Models\Profissional;
use App\Models\AreaAtucao;
use Carbon\CarbonPeriod;
use App\Models\TipoDeAtendimento;


class AtendimentoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $atendimentos = AtendimentoRealizado::with('beneficiario', 'profissional', 'areaAtendimento', 'agendamentoOrigem', 'tipoDeAtendimento')
            ->orderBy('created_at', 'desc')
            ->get();

        $agendamentosPendentes = Agendamento::with('beneficiario', 'profissional', 'areaAtendimento', 'atendimentoRealizado', 'tipoDeAtendimento')
            ->whereDoesntHave('atendimentoRealizado')
            ->where('status_agendamento', 'pendente')
            ->orderBy('data_hora_agendamento', 'asc')
            ->get();

        $atendimentosHoje = AtendimentoRealizado::whereDate('created_at', today())->count();
        $totalAgendamentosPendentes = Agendamento::where('status_agendamento', 'pendente')->count();
        $atendimentosSemana = AtendimentoRealizado::whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ])->count();
        $totalCancelamentos = Agendamento::where('status_agendamento', 'cancelado')->count();

        // Adiciona variáveis necessárias para o modal de atendimento
        $inicio = '08:00';
        $fim = '19:00';
        $periodo = CarbonPeriod::create("today $inicio", '30 minutes', "today $fim");
        $horariosDisponiveis = [];
        foreach ($periodo as $hora) {
            $horariosDisponiveis[] = $hora->format('H:i');
        }
        $beneficiarios = Beneficiario::where('status', 'ativo')->get();
        $profissionais = Profissional::where('status', 'ativo')->get();
        $areas = AreaAtucao::all();
        $tiposDeAtendimento = TipoDeAtendimento::all();

        return view('atendimentos_agendamentos_realizados', compact(
            'atendimentos',
            'agendamentosPendentes',
            'atendimentosHoje',
            'totalAgendamentosPendentes',
            'atendimentosSemana',
            'totalCancelamentos',
            'beneficiarios',
            'profissionais',
            'areas',
            'horariosDisponiveis',
            'tiposDeAtendimento'
        ));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'beneficiario_id' => 'required|exists:beneficiarios,id',
                'profissional_id' => 'required|exists:profissionais,id',
                'tipo_de_atendimento_id' => 'required|exists:tipo_de_atendimento,id',
                'area_atendimento_id' => 'required|exists:areas_atuacao,id',
                'data_hora_atendimento' => 'required|date|before_or_equal:now',
                'hora_registro' => 'required|string|max:5',
                'descricao_atendimento' => 'required|string|max:2000',
                'agendamento_origem_id' => 'nullable|exists:agendamentos,id|unique:atendimentos_realizados,agendamento_origem_id',
            ],
            [
                'agendamento_origem_id.unique' => 'O agendamento selecionado já possui um atendimento realizado associado.',
                'beneficiario_id.required' => 'O campo beneficiário é obrigatório.',
                'profissional_id.required' => 'O campo profissional é obrigatório.',
                'tipo_de_atendimento_id.required' => 'O campo tipo de atendimento é obrigatório.',
                'area_atendimento_id.required' => 'O campo área de atendimento é obrigatório.',
                'data_hora_atendimento.required' => 'O campo data e hora do atendimento é obrigatório.',
                'hora_registro.required' => 'O campo hora do registro é obrigatório.',
                'descricao_atendimento.required' => 'O campo descrição do atendimento é obrigatório.',
                'data_hora_atendimento.before_or_equal' => 'A data e hora do atendimento não podem ser futuras.',
            ]
        );

        try {
            $atendimento = new AtendimentoRealizado();
            $atendimento->beneficiario_id = $request->input('beneficiario_id');
            $atendimento->profissional_id = $request->input('profissional_id');
            $atendimento->tipo_de_atendimento_id = $request->input('tipo_de_atendimento_id');
            $atendimento->area_atendimento_id = $request->input('area_atendimento_id');
            $atendimento->data_hora_atendimento = $request->input('data_hora_atendimento');
            $atendimento->hora_registro = $request->input('hora_registro');
            $atendimento->descricao_atendimento = $request->input('descricao_atendimento');
            $atendimento->agendamento_origem_id = $request->input('agendamento_origem_id');
            $atendimento->save();

            // Se um agendamento foi associado, atualizar seu status para "realizado"
            if ($request->filled('agendamento_origem_id')) {
                $agendamento = Agendamento::find($request->input('agendamento_origem_id'));
                if ($agendamento) {
                    $agendamento->status_agendamento = 'realizado';
                    $agendamento->save();
                }
            }

            return redirect()->route('atendimentos.index')->with('success', 'Atendimento realizado cadastrado com sucesso.');
        } catch (Exception $e) {
            return redirect()->route('atendimentos.index')->with('error', 'Erro ao cadastrar atendimento realizado. Tente novamente.' . $e->getMessage());
        }

    }

    public function update(Request $request, $id)
    {
        $atendimento = AtendimentoRealizado::findOrFail($id);

        $request->validate(
            [
                'beneficiario_id' => 'required|exists:beneficiarios,id',
                'profissional_id' => 'required|exists:profissionais,id',
                'area_atendimento_id' => 'required|exists:areas_atuacao,id',
                'data_hora_atendimento' => 'required|date|before_or_equal:now',
                'hora_registro' => 'required|string|max:5',
                'descricao_atendimento' => 'nullable|string|max:2000',
                'agendamento_origem_id' => 'nullable|exists:agendamentos,id|unique:atendimentos_realizados,agendamento_origem_id,' . $atendimento->id,
                'tipo_de_atendimento_id' => 'required|exists:tipo_de_atendimento,id',
            ],
            [
                'agendamento_origem_id.unique' => 'O agendamento selecionado já possui um atendimento realizado associado.',
                'beneficiario_id.required' => 'O campo beneficiário é obrigatório.',
                'profissional_id.required' => 'O campo profissional é obrigatório.',
                'area_atendimento_id.required' => 'O campo área de atendimento é obrigatório.',
                'data_hora_atendimento.required' => 'O campo data e hora do atendimento é obrigatório.',
                'hora_registro.required' => 'O campo hora do registro é obrigatório.',
                'data_hora_atendimento.before_or_equal' => 'A data e hora do atendimento não podem ser futuras.',
            ]
        );

        try {
            $atendimento->update($request->all());

            return redirect()->route('atendimentos.index')->with('success', 'Atendimento realizado atualizado com sucesso.');
        } catch (Exception $e) {
            return redirect()->route('atendimentos.index')->with('error', 'Erro ao atualizar atendimento realizado. Tente novamente.' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $atendimento = AtendimentoRealizado::findOrFail($id);
            $atendimento->delete();

            return redirect()->route('atendimentos.index')->with('success', 'Atendimento realizado excluído com sucesso.');
        } catch (Exception $e) {
            return redirect()->route('atendimentos.index')->with('error', 'Erro ao excluir atendimento realizado. Tente novamente.' . $e->getMessage());
        }

    }
}
