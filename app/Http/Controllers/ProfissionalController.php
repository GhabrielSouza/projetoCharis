<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('profissional');
    }

    public function store(Request $request)
    {
        // Validate and process the request data
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14',
            'especialidade' => 'required|string|max:100',
        ]);


        return redirect()->route('cadastro.profissional')->with('success', 'Profissional cadastrado com sucesso!');
    }
}
