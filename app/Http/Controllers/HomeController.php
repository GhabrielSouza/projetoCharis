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

        //quantidade de beneficiarios de cada sexo
        $beneficiariosPorSexo = Beneficiario::selectRaw('sexo, COUNT(*) as count')
            ->groupBy('sexo')
            ->pluck('count', 'sexo')
            ->toArray();

        //filtrar profissionais por area de atuacao
        $profissionaisPorArea = Profissional::with('areaAtuacao')
            ->get()
            ->groupBy(function ($profissional) {
                return $profissional->areaAtuacao->nome_area;
            })
            ->map(function ($group) {
                return $group->count();
            })
            ->toArray();


        //quantidade por mes para os charts (preencher todos os meses)
        $cestasRaw = CestaBasicaEntregue::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $atendimentosRaw = AtendimentoRealizado::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();


        $cestasPorMes = [];
        $atendimentosPorMes = [];
        for ($i = 1; $i <= 12; $i++) {
            $cestasPorMes[$i] = isset($cestasRaw[$i]) ? $cestasRaw[$i] : 0;
            $atendimentosPorMes[$i] = isset($atendimentosRaw[$i]) ? $atendimentosRaw[$i] : 0;
        }

        return view('home', compact('beneficiariosCount', 'profissionaisCount', 'cestasCount', 'atendimentosCount', 'beneficiariosPorSexo', 'cestasPorMes', 'atendimentosPorMes', 'profissionaisPorArea'));
    }
}
