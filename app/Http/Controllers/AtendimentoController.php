<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\AtendimentoRealizado;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Beneficiario;
use App\Models\Profissional;
use App\Models\AreaAtucao;
use Carbon\CarbonPeriod;


class AtendimentoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $atendimentos = AtendimentoRealizado::with('beneficiario', 'profissional', 'areaAtendimento', 'agendamentoOrigem')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        $agendamentosPendentes = Agendamento::with('beneficiario', 'profissional', 'areaAtendimento', 'atendimentoRealizado')
            ->whereDoesntHave('atendimentoRealizado')
            ->where('status_agendamento', 'pendente')
            ->orderBy('data_hora_agendamento', 'asc')
            ->paginate(5);

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
            'horariosDisponiveis'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'beneficiario_id' => 'required|exists:beneficiarios,id',
            'profissional_id' => 'required|exists:profissionais,id',
            'area_atendimento_id' => 'required|exists:areas_atuacao,id',
            'data_hora_atendimento' => 'required|date|before_or_equal:now',
            'hora_registro' => 'required|string|max:5',
            'descricao_atendimento' => 'required|string|max:2000',
            'agendamento_origem_id' => 'nullable|exists:agendamentos,id|unique:atendimentos_realizados,agendamento_origem_id',
        ]);

        AtendimentoRealizado::create($request->all());

        // Se um agendamento foi associado, atualizar seu status para "realizado"
        if ($request->filled('agendamento_origem_id')) {
            $agendamento = Agendamento::find($request->input('agendamento_origem_id'));
            if ($agendamento) {
                $agendamento->status_agendamento = 'realizado';
                $agendamento->save();
            }
        }

        return redirect()->route('atendimentos.index')->with('success', 'Atendimento realizado cadastrado com sucesso.');
    }

    public function update(Request $request, $id)
    {
        $atendimento = AtendimentoRealizado::findOrFail($id);

        $request->validate([
            'beneficiario_id' => 'required|exists:beneficiarios,id',
            'profissional_id' => 'required|exists:profissionais,id',
            'area_atendimento_id' => 'required|exists:areas_atuacao,id',
            'data_hora_atendimento' => 'required|date|before_or_equal:now',
            'hora_registro' => 'required|string|max:5',
            'descricao_atendimento' => 'required|string|max:2000',
            'agendamento_origem_id' => 'nullable|exists:agendamentos,id|unique:atendimentos_realizados,agendamento_origem_id,' . $atendimento->id,
        ]);

        $atendimento->update($request->all());

        return redirect()->route('atendimentos.index')->with('success', 'Atendimento realizado atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $atendimento = AtendimentoRealizado::findOrFail($id);
        $atendimento->delete();

        return redirect()->route('atendimentos.index')->with('success', 'Atendimento realizado excluído com sucesso.');
    }
}
