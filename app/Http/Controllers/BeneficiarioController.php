<?php

namespace App\Http\Controllers;

use App\Models\Beneficiario;
use Illuminate\Http\Request;

class BeneficiarioController extends Controller
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
        $beneficiarios = Beneficiario::with(['endereco.cidade.estado'])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalAtivos = $beneficiarios->where('status', 'ativo')->count();
        $totalInativos = $beneficiarios->where('status', 'inativo')->count();

        $ultimaAtualizacao = $beneficiarios->isNotEmpty() ? $beneficiarios->max('updated_at') : now();

        return view('beneficiario', compact(
            'beneficiarios',
            'totalAtivos',
            'totalInativos',
            'ultimaAtualizacao'
        ));
    }

    // cadastro.beneficiario

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nome' => 'required|string|max:255',
                'cpf' => 'required|string|max:14|unique:beneficiarios',
                'data_nascimento' => 'required|date',
                'telefone' => 'nullable|string|max:20',
                'escolaridade' => 'nullable|string',
                'cadunico' => 'nullable|string',
                'limitacoes' => 'nullable|array',
                'outras_limitacoes' => 'nullable|string',
                'observacoes' => 'nullable|string',
                'endereco_id' => 'nullable|exists:enderecos,id'
            ]);

            // // Verificação adicional de CPF
            // if (Beneficiario::where('cpf', $validated['cpf'])->exists()) {
            //     throw new \Exception('CPF já cadastrado no sistema.');
            // }

            $beneficiario = Beneficiario::create($validated);

            return redirect()->route('cadastro.beneficiario')
                ->with('success', 'Beneficiário cadastrado com sucesso!');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Erro ao cadastrar beneficiário: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function update(Request $request, $id)
    {

        $beneficiario = Beneficiario::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:beneficiarios,cpf,' . $beneficiario->id,
            'data_nascimento' => 'required|date',
            'telefone' => 'nullable|string|max:20',
            'escolaridade' => 'nullable|string',
            'cadunico' => 'nullable|string',
            'limitacoes' => 'nullable|array',
            'outras_limitacoes' => 'nullable|string',
            'observacoes' => 'nullable|string',
            'endereco_id' => 'nullable|exists:enderecos,id'
        ]);

        $validated['limitacoes'] = json_encode($request->limitacoes);

        $beneficiario->update($validated);

        return redirect()->back()->with('success', 'Beneficiário atualizado com sucesso!');
    }

    public function toggleStatus($id)
    {
        $beneficiario = Beneficiario::findOrFail($id);

        $novoStatus = $beneficiario->status == 'ativo' ? 'inativo' : 'ativo';

        $beneficiario->status = $novoStatus;
        $beneficiario->save();

        $mensagem = "Beneficiário " . ($novoStatus == 'ativo' ? 'ativado' : 'inativado') . " com sucesso!";

        return redirect()->back()->with('success', $mensagem);
    }

    public function destroy($id)
    {
        $beneficiario = Beneficiario::findOrFail($id);
        $beneficiario->delete();

        return redirect()->route('cadastro.beneficiario')
            ->with('success', 'Beneficiário excluído com sucesso!');
    }
}
