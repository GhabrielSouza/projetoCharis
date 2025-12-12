<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Agendamento;
use App\Models\AtendimentoRealizado;
use Barryvdh\DomPDF\Facade\Pdf;
use Nette\Schema\Expect;
use function PHPUnit\Framework\returnArgument;

class AgendamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agendamentosPendentes = Agendamento::with('beneficiario', 'profissional', 'areaAtendimento', 'atendimentoRealizado', 'tipoDeAtendimento')
            ->whereDoesntHave('atendimentoRealizado')
            ->where('status_agendamento', 'pendente')
            ->orderBy('data_hora_agendamento', 'asc')
            ->get();

        $totalAgendamentosPendentes = Agendamento::where('status_agendamento', 'pendente')->count();

        $totalCancelamentos = Agendamento::where('status_agendamento', 'cancelado')->count();

        return view('atendimentos_agendamentos_realizados', compact(
            'agendamentosPendentes',
            'totalAgendamentosPendentes',
            'totalCancelamentos'
        ));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'beneficiario_id' => 'required|exists:beneficiarios,id',
            'profissional_id' => 'required|exists:profissionais,id',
            'tipo_de_atendimento_id' => 'required|exists:tipo_de_atendimento,id',
            'area_atendimento_id' => 'required|exists:areas_atuacao,id',
            'hora_registro' => 'required|string|max:5',
            'data_hora_agendamento' => 'required|date|after_or_equal:today',
            'observacoes_agendamento' => 'nullable|string|max:1000',
        ], [
            'data_hora_agendamento.after_or_equal' => 'A data e hora do agendamento deve ser igual ou posterior à data atual.',
            'benefiaciarioi_id.required' => 'O campo beneficiário é obrigatório.',
            'profissional_id.required' => 'O campo profissional é obrigatório.',
            'tipo_de_atendimento_id.required' => 'O campo tipo de atendimento é obrigatório.',
            'area_atendimento_id.required' => 'O campo área de atendimento é obrigatório.',
            'hora_registro.required' => 'O campo hora de registro é obrigatório.',
            'data_hora_agendamento.required' => 'O campo data e hora do agendamento é obrigatório.',
        ]);

        try {
            $agendamento = new Agendamento();
            $agendamento->beneficiario_id = $request->input('beneficiario_id');
            $agendamento->profissional_id = $request->input('profissional_id');
            $agendamento->tipo_de_atendimento_id = $request->input('tipo_de_atendimento_id');
            $agendamento->area_atendimento_id = $request->input('area_atendimento_id');
            $agendamento->data_hora_agendamento = $request->input('data_hora_agendamento');
            $agendamento->observacoes_agendamento = $request->input('observacoes_agendamento');
            $agendamento->hora_registro = $request->input('hora_registro');
            $agendamento->status_agendamento = 'pendente';
            $agendamento->agendamento = 'Agendado';
            $agendamento->save();

            if ($agendamento === null) {
                throw new Exception("Falha ao salvar o agendamento.");
            }

            return redirect()->route('atendimentos.index')->with('success', 'Agendamento criado com sucesso.');
        } catch (Exception $e) {
            return redirect()->route('atendimentos.index')->with('error', 'Erro ao criar agendamento. Tente novamente.' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $agendamento = Agendamento::with('beneficiario', 'profissional', 'areaAtendimento', 'atendimentoRealizado')->findOrFail($id);
        return view('atendimentos.show', compact('agendamento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'beneficiario_id' => 'required|exists:beneficiarios,id',
            'profissional_id' => 'required|exists:profissionais,id',
            'tipo_de_atendimento_id' => 'required|exists:tipo_de_atendimento,id',
            'area_atendimento_id' => 'required|exists:areas_atendimento,id',
            'data_hora_agendamento' => 'required|date|after:now',
            'hora_registro' => 'required|string|max:5',
            'observacoes_agendamento' => 'nullable|string|max:1000',
            'status_agendamento' => 'required|string|max:50',
            'agendamento' => 'required|in:Agendado,Confirmado,Cancelado,Realizado',
        ], [
            'data_hora_agendamento.after' => 'A data e hora do agendamento deve ser posterior à data atual.',
            'benefiaciarioi_id.required' => 'O campo beneficiário é obrigatório.',
            'profissional_id.required' => 'O campo profissional é obrigatório.',
            'tipo_de_atendimento_id.required' => 'O campo tipo de atendimento é obrigatório.',
            'area_atendimento_id.required' => 'O campo área de atendimento é obrigatório.',
            'data_hora_agendamento.required' => 'O campo data e hora do agendamento é obrigatório.',
            'hora_registro.required' => 'O campo hora de registro é obrigatório.',
        ]);

        try {
            Agendamento::where('id', $id)->update($request->all());

            return redirect()->route('atendimentos.index')->with('success', 'Agendamento atualizado com sucesso.');
        } catch (Exception $e) {
            return redirect()->route('atendimentos.index')->with('error', 'Agendamento não encontrado.');
        }
    }

    public function confirmar($id)
    {
        try {
            $agendamento = Agendamento::findOrFail($id);
            $agendamento->status_agendamento = 'confirmado';
            $agendamento->agendamento = 'Realizado';
            $agendamento->save();


            // criar atendimento relacionado
            $atendimento = new AtendimentoRealizado();
            $atendimento->beneficiario_id = $agendamento->beneficiario_id;
            $atendimento->profissional_id = $agendamento->profissional_id;
            $atendimento->tipo_de_atendimento_id = $agendamento->tipo_de_atendimento_id;
            $atendimento->area_atendimento_id = $agendamento->area_atendimento_id;
            $atendimento->data_hora_atendimento = $agendamento->data_hora_agendamento;
            $atendimento->hora_registro = $agendamento->hora_registro;
            $atendimento->descricao_atendimento = 'Atendimento realizado conforme agendamento.';
            $atendimento->agendamento_origem_id = $agendamento->id;
            $atendimento->save();

            return redirect()->route('atendimentos.index')->with('success', 'Agendamento confirmado com sucesso.');
        } catch (Exception $e) {
            return redirect()->route('atendimentos.index')->with('error', 'Erro ao confirmar agendamento. Tente novamente.' . $e->getMessage());
        }

    }

    public function cancelar($id)
    {
        try {
            $agendamento = Agendamento::findOrFail($id);
            $agendamento->status_agendamento = 'cancelado';
            $agendamento->save();

            return redirect()->route('atendimentos.index')->with('success', 'Agendamento cancelado com sucesso.');
        } catch (Exception $e) {
            return redirect()->route('atendimentos.index')->with('error', 'Erro ao cancelar agendamento. Tente novamente.' . $e->getMessage());
        }
    }

    public function gerarProntuario($id)
    {
        set_time_limit(300);

        $agendamento = Agendamento::with('beneficiario', 'profissional', 'areaAtendimento')->findOrFail($id);

        $pdf = PDF::loadView('pdf.prontuario.prontuario', compact('agendamento'));

        return $pdf->download('prontuario-' . $agendamento->beneficiario->nome . '.pdf');
    }
}
