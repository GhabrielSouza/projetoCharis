<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agendamento;
use App\Models\AtendimentoRealizado;
use Barryvdh\DomPDF\Facade\PDF;

class AgendamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agendamentosPendentes = Agendamento::with('beneficiario', 'profissional', 'areaAtendimento', 'atendimentoRealizado')
            ->whereDoesntHave('atendimentoRealizado')
            ->where('status_agendamento', 'pendente')
            ->orderBy('data_hora_agendamento', 'asc')
            ->paginate(5);

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
            'area_atendimento_id' => 'required|exists:areas_atuacao,id',
            'hora_registro' => 'required|string|max:5',
            'data_hora_agendamento' => 'required|date|after:now',
            'observacoes_agendamento' => 'nullable|string|max:1000',
        ]);

        $agendamento = new Agendamento();
        $agendamento->beneficiario_id = $request->input('beneficiario_id');
        $agendamento->profissional_id = $request->input('profissional_id');
        $agendamento->area_atendimento_id = $request->input('area_atendimento_id');
        $agendamento->data_hora_agendamento = $request->input('data_hora_agendamento');
        $agendamento->observacoes_agendamento = $request->input('observacoes_agendamento');
        $agendamento->hora_registro = $request->input('hora_registro');
        $agendamento->status_agendamento = 'pendente';
        $agendamento->agendamento = 'Agendado';
        $agendamento->save();

        return redirect()->route('atendimentos.index')->with('success', 'Agendamento criado com sucesso.');
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
            'area_atendimento_id' => 'required|exists:areas_atendimento,id',
            'data_hora_agendamento' => 'required|date|after:now',
            'hora_registro' => 'required|string|max:5',
            'observacoes_agendamento' => 'nullable|string|max:1000',
            'status_agendamento' => 'required|string|max:50',
            'agendamento' => 'required|in:Agendado,Confirmado,Cancelado,Realizado',
        ]);

        Agendamento::where('id', $id)->update($request->all());

        return redirect()->route('atendimentos.index')->with('success', 'Agendamento atualizado com sucesso.');
    }

    public function confirmar($id)
    {
        $agendamento = Agendamento::findOrFail($id);
        $agendamento->status_agendamento = 'confirmado';
        $agendamento->agendamento = 'Realizado';
        $agendamento->save();

        // criar atendimento relacionado
        AtendimentoRealizado::create([
            'beneficiario_id' => $agendamento->beneficiario_id,
            'profissional_id' => $agendamento->profissional_id,
            'area_atendimento_id' => $agendamento->area_atendimento_id,
            'data_hora_atendimento' => $agendamento->data_hora_agendamento,
            'hora_registro' => $agendamento->hora_registro,
            'descricao_atendimento' => 'Atendimento realizado conforme agendamento.',
            'agendamento_origem_id' => $agendamento->id,
        ]);
        return redirect()->route('atendimentos.index')->with('success', 'Agendamento confirmado com sucesso.');
    }

    public function cancelar($id)
    {
        $agendamento = Agendamento::findOrFail($id);
        $agendamento->status_agendamento = 'cancelado';
        $agendamento->save();

        return redirect()->route('atendimentos.index')->with('success', 'Agendamento cancelado com sucesso.');
    }

    public function gerarProntuario($id)
    {
        set_time_limit(300); // Aumenta o tempo máximo de execução para 5 minutos

        $agendamento = Agendamento::with('beneficiario', 'profissional', 'areaAtendimento')->findOrFail($id);

        $pdf = PDF::loadView('pdf.prontuario.prontuario', compact('agendamento'));

        return $pdf->stream('prontuario-' . $agendamento->beneficiario->nome . '.pdf');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
