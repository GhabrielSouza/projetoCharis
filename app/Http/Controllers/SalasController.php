<?php

namespace App\Http\Controllers;

use App\Models\Profissional;
use Illuminate\Http\Request;
use App\Models\Sala;
use App\Models\Beneficiario;

class SalasController extends Controller
{
    public function index()
    {

        $salas = Sala::with('profissional')->get();
        $profissionais = Profissional::all();

        return view('salas_de_aula', compact('salas', 'profissionais'));
    }

    public function show($id)
    {
        $sala = Sala::with('profissional', 'alunos')->findOrFail($id);
        $beneficiarios = Beneficiario::all();

        return view('alunos_sala', compact('sala', 'beneficiarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'profissional_id' => 'required|exists:profissionais,id',
        ]);

        try {
            Sala::create([
                'nome' => $request->input('nome'),
                'descricao' => $request->input('descricao'),
                'profissional_id' => $request->input('profissional_id'),
            ]);

            return redirect()->back()->with('success', 'Sala de aula criada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao criar sala de aula: ' . $e->getMessage());
        }
    }

    public function storeStudents(Request $request, $id)
    {
        $request->validate([
            'sala_id' => 'required|exists:salas,id',
            'beneficiario_id' => 'required|exists:beneficiarios,id',
        ]);

        try {
            $sala = Sala::findOrFail($id);
            $sala->alunos()->attach($request->input('beneficiario_id'));

            return redirect()->back()->with('success', 'Aluno adicionado à sala com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao adicionar aluno à sala: ' . $e->getMessage());
        }

    }

    public function removeStudents($sala_id, $beneficiario_id)
    {
        try {
            $sala = Sala::findOrFail($sala_id);

            $sala->alunos()->detach($beneficiario_id);

            return redirect()->back()->with('success', 'Aluno removido da sala com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao remover aluno da sala: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'profissional_id' => 'required|exists:profissionais,id',
        ]);

        try {
            $sala = Sala::findOrFail($id);
            $sala->update([
                'nome' => $request->input('nome'),
                'descricao' => $request->input('descricao'),
                'profissional_id' => $request->input('profissional_id'),
            ]);

            return redirect()->back()->with('success', 'Sala de aula atualizada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar sala de aula: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $sala = Sala::findOrFail($id);
            $sala->delete();

            return redirect()->back()->with('success', 'Sala de aula excluída com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir sala de aula: ' . $e->getMessage());
        }
    }
}
