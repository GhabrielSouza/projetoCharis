<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profissional;

class ProfissionalController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $profissionais = Profissional::query()
            ->when(request('search'), function ($query) {
                return $query->buscar(request('search'));
            })
            ->orderBy('nome_completo')
            ->paginate(10);

        $totalAtivos = $profissionais->where('status', 'ativo')->count();
        $totalInativos = $profissionais->where('status', 'inativo')->count();

        $ultimaAtualizacao = $profissionais->isNotEmpty() ? $profissionais->max('updated_at') : now();

        return view('profissional', compact('profissionais', 'totalAtivos', 'totalInativos', 'ultimaAtualizacao'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome_completo' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'cpf' => 'required|string|max:14|unique:profissionais',
            'telefone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'numero_registro' => 'required|string',
            'area_atuacao' => 'required|string',
            'perfil' => 'required|in:Médico,Enfermeiro,Psicólogo,Assistente Social,Outro',
            'observacoes' => 'nullable|string'
        ]);

        Profissional::create($validated);

        return redirect()->route('cadastro.profissional')
            ->with('success', 'Profissional cadastrado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $profissional = Profissional::findOrFail($id);

        $validated = $request->validate([
            'nome_completo' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'cpf' => 'required|string|max:14|unique:profissionais,cpf,' . $profissional->id,
            'telefone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'numero_registro' => 'required|string',
            'area_atuacao' => 'required|string',
            'perfil' => 'required|in:Médico,Enfermeiro,Psicólogo,Assistente Social,Outro',
            'observacoes' => 'nullable|string'
        ]);

        $profissional->update($validated);

        return redirect()->route('cadastro.profissional')
            ->with('success', 'Profissional atualizado com sucesso!');
    }

    public function toggleStatus($id)
    {
        $profissional = Profissional::findOrFail($id);

        $novoStatus = $profissional->status == 'ativo' ? 'inativo' : 'ativo';

        $profissional->status = $novoStatus;
        $profissional->save();

        $mensagem = "Beneficiário " . ($novoStatus == 'ativo' ? 'ativado' : 'inativado') . " com sucesso!";

        return redirect()->back()->with('success', $mensagem);
    }

    public function destroy(Profissional $profissional)
    {
        $profissional->delete();

        return redirect()->route('profissionais.index')
            ->with('success', 'Profissional removido com sucesso!');
    }
}
