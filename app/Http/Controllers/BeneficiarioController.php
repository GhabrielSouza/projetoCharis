<?php

namespace App\Http\Controllers;

use App\Models\Beneficiario;
use App\Models\Cidade;
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
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Beneficiario::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                    ->orWhere('cpf', 'like', "%{$search}%");
            });
        }

        $beneficiarios = $query->orderBy('nome')->paginate(3);

        $beneficiarios->appends(['search' => $search]);

        $totalAtivos = Beneficiario::where('status', 'ativo')->count();
        $totalInativos = Beneficiario::where('status', 'inativo')->count();
        $ultimaAtualizacao = $beneficiarios->isNotEmpty() ? $beneficiarios->max('updated_at') : now();
        $cidades = Cidade::orderBy('nome')->get();


        return view('beneficiario', compact(
            'beneficiarios',
            'totalAtivos',
            'totalInativos',
            'ultimaAtualizacao',
            'cidades'
        ));
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100',
            'cpf' => 'required|string|max:14|unique:beneficiarios',
            'data_nascimento' => 'required|date',
            'telefone' => 'nullable|string|max:20',
            'escolaridade' => 'nullable|string',
            'cadunico' => 'nullable|string',
            'limitacoes' => 'nullable|array',
            'outras_limitacoes' => 'nullable|string',
            'observacoes' => 'nullable|string',
            'endereco_logradouro' => 'nullable|string|max:255',
            'endereco_numero' => 'nullable|string|max:20',
            'endereco_complemento' => 'nullable|string|max:100',
            'endereco_bairro' => 'nullable|string|max:100',
            'cidade_id' => 'required|exists:cidades,id',
            'cep' => 'nullable|string|max:10',
        ]);

        try {
            $beneficiario = Beneficiario::create($validated);

            return redirect()->route('beneficiarios.index')
                ->with('success', 'Beneficiário cadastrado com sucesso!');

        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'Ocorreu um erro inesperado ao cadastrar o beneficiário. Por favor, tente novamente.'])
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
            'endereco_logradouro ' => 'nullable|string|max:255',
            'endereco_numero' => 'nullable|string|max:20',
            'endereco_complemento' => 'nullable|string|max:100',
            'endereco_bairro' => 'nullable|string|max:100',
            'cidade_id' => 'required|exists:cidades,id',
            'cep' => 'nullable|string|max:10',
        ]);

        try {
            $validated['limitacoes'] = json_encode($request->limitacoes);

            $beneficiario->update($validated);

            return redirect()->back()->with('success', 'Beneficiário atualizado com sucesso!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Se for erro de validação, redirecione de volta com os erros e o ID do beneficiário
            return back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('beneficiario_id_com_erro', $beneficiario->id); // <<-- Adicionar isso!
        } catch (\Exception $e) {
            // Para outros erros gerais
            return back()
                ->withInput()
                ->with('error', 'Ocorreu um erro inesperado ao atualizar o beneficiário. Tente novamente.');
        }

    }

    public function toggleStatus($id)
    {
        $beneficiario = Beneficiario::findOrFail($id);

        $novoStatus = $beneficiario->status == 'ativo' ? 'inativo' : 'ativo';

        $beneficiario->status = $novoStatus;
        $beneficiario->save();

        $mensagem = "Beneficiário " . ($novoStatus == 'ativo' ? 'ativado' : 'inativado') . " com sucesso!";

        return response()->json(['message' => $mensagem]);
    }

    public function perfil(Beneficiario $beneficiario)
    {
        $beneficiario->load(['cidade', 'agendamentos', 'atendimentosRealizados', 'cestasBasicasEntregues']);

        return view('beneficiario-perfil', compact('beneficiario'));
    }

    public function destroy($id)
    {
        $beneficiario = Beneficiario::findOrFail($id);
        $beneficiario->delete();

        return redirect()->route('cadastro.beneficiario')
            ->with('success', 'Beneficiário excluído com sucesso!');
    }
}
