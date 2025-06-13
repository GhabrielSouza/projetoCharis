<?php

namespace App\Http\Controllers;

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
        return view('beneficiario');
    }

    public function consulta()
    {
        return view('beneficiario-consulta');
    }

    public function store(Request $request)
    {
        // Validate and process the request data
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14',
            'data_nascimento' => 'required|date',
            // Add other fields as necessary
        ]);


        return redirect()->route('cadastro.beneficiario')->with('success', 'Beneficiário cadastrado com sucesso!');
    }
}
