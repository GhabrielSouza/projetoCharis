<?php

namespace App\Http\Controllers;

use App\Models\CestaBasicaEntregue;
use Illuminate\Http\Request;

class CestaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cestas = CestaBasicaEntregue::with('beneficiario')->get();
        return view('cestas', compact('cestas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate(
            [
                'beneficiario_id' => 'required|exists:beneficiarios,id',
                'data_entrega' => 'required|Date',
                'quantidade' => 'required|int',
                'observacoes' => 'nullable|string',
            ]
        );

        try {
            CestaBasicaEntregue::create($validate);
            return redirect()->route('beneficiarios.index')
                ->with('success', 'Cesta Básica cadastrada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao cadastrar cesta básica: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $cesta = CestaBasicaEntregue::findOrFail($id);
            return view('cestas.show', compact('cesta'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao exibir cesta básica: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validade = $request->validate([
            'beneficiario_id' => 'required|exists:beneficiarios,id',
            'data_entrega' => 'required|Date',
            'quantidade' => 'required|int',
            'observacoes' => 'nullable|string',
        ]);

        try {
            $cesta = CestaBasicaEntregue::findOrFail($id);
            $cesta->update($validade);
            return redirect()->back()->with('success', 'Cesta básica atualizada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar cesta básica: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $cesta = CestaBasicaEntregue::findOrFail($id);
            $cesta->delete();
            return redirect()->back()->with('success', 'Cesta básica removida com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao remover cesta básica: ' . $e->getMessage());
        }
    }
}
