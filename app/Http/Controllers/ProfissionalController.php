<?php

namespace App\Http\Controllers;

use App\Models\Beneficiario;
use Illuminate\Http\Request;
use App\Models\Profissional;
use App\Models\AreaAtucao;
use Carbon\CarbonPeriod;
use App\Models\TipoDeAtendimento;


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
    public function index(Request $request)
    {

        $inicio = '08:00';
        $fim = '19:00';

        $periodo = CarbonPeriod::create("today $inicio", '30 minutes', "today $fim");
        $horariosDisponiveis = [];
        foreach ($periodo as $hora) {
            $horariosDisponiveis[] = $hora->format('H:i');
        }

        $search = $request->input('search');

        $query = Profissional::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nome_completo', 'like', "%{$search}%")
                    ->orWhere('numero_registro', 'like', "%{$search}%")
                    ->orWhere('perfil', 'like', "%{$search}%");
            });
        }

        $profissionais = $query->orderBy('nome_completo')->with('areaAtuacao:id,nome_area')->get();


        $areas = AreaAtucao::orderBy('nome_area')->get();
        $tiposDeAtendimento = TipoDeAtendimento::orderBy('nome')->get();
        $beneficiarios = Beneficiario::orderBy('nome')->get();

        $totalAtivos = $profissionais->where('status', 'ativo')->count();
        $totalInativos = $profissionais->where('status', 'inativo')->count();

        $ultimaAtualizacao = $profissionais->isNotEmpty() ? $profissionais->max('updated_at') : now();

        return view('profissional', compact('profissionais', 'totalAtivos', 'totalInativos', 'ultimaAtualizacao', 'areas', 'beneficiarios', 'horariosDisponiveis', 'tiposDeAtendimento'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome_completo' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'sexo' => 'required|string|max:10',
            'cpf' => 'required|string|max:14|unique:profissionais',
            'telefone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'numero_registro' => 'required|string',
            'area_atuacao_id' => 'required|exists:areas_atuacao,id',
            'perfil' => 'required|in:Médico,Enfermeiro,Psicólogo,Assistente Social,Outro',
            'observacoes' => 'nullable|string'
        ], [
            'nome_completo.required' => 'O campo nome completo é obrigatório.',
            'data_nascimento.required' => 'O campo data de nascimento é obrigatório.',
            'sexo.required' => 'O campo sexo é obrigatório.',
            'cpf.required' => 'O campo CPF é obrigatório.',
            'cpf.unique' => 'O CPF informado já está cadastrado.',
            'telefone.required' => 'O campo telefone é obrigatório.',
            'numero_registro.required' => 'O campo número de registro é obrigatório.',
            'area_atuacao_id.required' => 'O campo área de atuação é obrigatório.',
            'area_atuacao_id.exists' => 'A área de atuação selecionada não existe.',
            'perfil.required' => 'O campo perfil é obrigatório.',
            'perfil.in' => 'O campo perfil contém um valor inválido.',
        ]);

        Profissional::create($validated);

        if ($request->ajax()) {
            return response()->json(['message' => 'Profissional cadastrado com sucesso!']);
        }

        return redirect()->route('profissionais.index')->with('success', 'Profissional cadastrado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $profissional = Profissional::findOrFail($id);

        try {
            $validated = $request->validate([
                'nome_completo' => 'required|string|max:255',
                'data_nascimento' => 'required|date',
                'sexo' => 'required|string|max:10',
                'cpf' => 'required|string|max:14|unique:profissionais,cpf,' . $profissional->id,
                'telefone' => 'required|string|max:20',
                'email' => 'nullable|email',
                'numero_registro' => 'required|string',
                'area_atuacao_id' => 'required|exists:areas_atuacao,id',
                'perfil' => 'required|in:Médico,Enfermeiro,Psicólogo,Assistente Social,Outro',
                'observacoes' => 'nullable|string'
            ], [
                'nome_completo.required' => 'O campo nome completo é obrigatório.',
                'data_nascimento.required' => 'O campo data de nascimento é obrigatório.',
                'sexo.required' => 'O campo sexo é obrigatório.',
                'cpf.required' => 'O campo CPF é obrigatório.',
                'cpf.unique' => 'O CPF informado já está cadastrado.',
                'telefone.required' => 'O campo telefone é obrigatório.',
                'numero_registro.required' => 'O campo número de registro é obrigatório.',
                'area_atuacao_id.required' => 'O campo área de atuação é obrigatório.',
                'area_atuacao_id.exists' => 'A área de atuação selecionada não existe.',
                'perfil.required' => 'O campo perfil é obrigatório.',
                'perfil.in' => 'O campo perfil contém um valor inválido.',
            ]);

            $profissional->update($validated);

            return response()->json(['message' => 'Profissional atualizado com sucesso!']);

        } catch (\Illuminate\Validation\ValidationException $e) {
            if (!$request->ajax()) {
                return back()
                    ->withErrors($e->errors())
                    ->withInput()
                    ->with('professional_id_with_error', $profissional->id);
            }
            throw $e;
        }
    }

    public function toggleStatus($id)
    {
        $profissional = Profissional::findOrFail($id);

        $novoStatus = $profissional->status == 'ativo' ? 'inativo' : 'ativo';

        $profissional->status = $novoStatus;
        $profissional->save();

        $mensagem = "Beneficiário " . ($novoStatus == 'ativo' ? 'ativado' : 'inativado') . " com sucesso!";

        return response()->json(['message' => $mensagem]);
    }

    public function perfil(Profissional $profissional)
    {
        $profissional->load('areaAtuacao');

        return view('profissional-perfil', compact('profissional'));
    }

    public function destroy(Profissional $profissional)
    {
        $profissional->delete();

        return redirect()->route('profissionais.index')
            ->with('success', 'Profissional removido com sucesso!');
    }
}
