<?php

namespace App\Http\Controllers;

use App\Models\AtendimentoRealizado;
use App\Models\CestaBasicaEntregue;
use App\Models\Profissional;
use Illuminate\Http\Request;
use \App\Models\Beneficiario;

class HomeController extends Controller
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

        $beneficiariosCount = Beneficiario::count();
        $profissionaisCount = Profissional::count();
        $cestasCount = CestaBasicaEntregue::count();
        $atendimentosCount = AtendimentoRealizado::count();

        //quantidade de beneficiarios por faixa etaria para os charts
        $faixaEtariaCounts = Beneficiario::selectRaw('
            CASE
                WHEN data_nascimento BETWEEN 0 AND 12 THEN "0-12"
                WHEN data_nascimento BETWEEN 13 AND 18 THEN "13-18"
                WHEN data_nascimento BETWEEN 19 AND 30 THEN "19-30"
                WHEN data_nascimento BETWEEN 31 AND 50 THEN "31-50"
                WHEN data_nascimento BETWEEN 51 AND 65 THEN "51-65"
                ELSE "66+"
            END AS faixa_etaria,
            COUNT(*) as count
        ')
            ->groupBy('faixa_etaria')
            ->pluck('count', 'faixa_etaria')
            ->toArray();

        //filtrar profissionais por area de atuacao
        $profissionaisPorArea = Profissional::with('areaAtuacao')
            ->get()
            ->groupBy(function ($profissional) {
                return $profissional->areaAtuacao->nome;
            })
            ->map(function ($group) {
                return $group->count();
            })
            ->toArray();

        //quantidade por mes para os charts
        $cestasPorMes = CestaBasicaEntregue::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $atendimentosPorMes = AtendimentoRealizado::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();


        return view('home', compact('beneficiariosCount', 'profissionaisCount', 'cestasCount', 'atendimentosCount', 'faixaEtariaCounts', 'cestasPorMes', 'atendimentosPorMes'));
    }
}
