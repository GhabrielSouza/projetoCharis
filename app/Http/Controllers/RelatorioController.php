<?php

namespace App\Http\Controllers;

use App\Models\AreaAtucao;
use App\Models\AtendimentoRealizado;
use App\Models\Beneficiario;
use App\Models\CestaBasicaEntregue;
use App\Models\Profissional;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RelatorioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $beneficiarios = Beneficiario::all();
        $profissionais = Profissional::all();
        return view('relatorios', compact('beneficiarios', 'profissionais'));
    }

    public function atendimentosPorPeriodo(Request $request)
    {
        set_time_limit(300);

        $validated = $request->validate([
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
        ]);

        $atendimentos = AtendimentoRealizado::whereBetween('data_hora_atendimento', [$validated['data_inicio'], $validated['data_fim']])
            ->with(['beneficiario', 'profissional'])
            ->get();

        $pdf = PDF::loadView('pdf.relatorios.atendimentos_periodo', compact('atendimentos', 'validated'));
        return $pdf->download('atendimentos_periodo.pdf');
    }

    public function atendimentosPorBeneficiario(Request $request)
    {
        set_time_limit(300);

        $validated = $request->validate([
            'beneficiario_id' => 'required|exists:beneficiarios,id',
        ]);

        $beneficiario = Beneficiario::findOrFail($validated['beneficiario_id']);

        $atendimentos = AtendimentoRealizado::where('beneficiario_id', $validated['beneficiario_id'])
            ->with(['profissional', 'areaAtendimento'])
            ->get();

        $pdf = PDF::loadView('pdf.relatorios.atendimentos_beneficiario', compact('atendimentos', 'beneficiario'));
        return $pdf->download('atendimentos_beneficiario.pdf');
    }

    public function cestas(Request $request)
    {
        set_time_limit(300);

        $validated = $request->validate([
            'beneficiario_id' => 'nullable|exists:beneficiarios,id',
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
        ]);

        if (isset($validated['data_inicio']) && isset($validated['data_fim']) && isset($validated['beneficiario_id'])) {
            $cestas = CestaBasicaEntregue::where('beneficiario_id', $validated['beneficiario_id'])
                ->whereBetween('data_entrega', [$validated['data_inicio'], $validated['data_fim']])
                ->with(['beneficiario'])
                ->get();
        } elseif (isset($validated['beneficiario_id'])) {
            $cestas = CestaBasicaEntregue::where('beneficiario_id', $validated['beneficiario_id'])
                ->with(['beneficiario'])
                ->get();
        } else {
            $cestas = CestaBasicaEntregue::whereBetween('data_entrega', [$validated['data_inicio'], $validated['data_fim']])
                ->with(['beneficiario'])
                ->get();
        }

        $pdf = PDF::loadView('pdf.relatorios.cestas', compact('cestas', 'validated'));
        return $pdf->download('cestas.pdf');
    }

    public function anual(Request $request)
    {
        set_time_limit(300);

        $meses = [
            1 => 'Janeiro',
            2 => 'Fevereiro',
            3 => 'Março',
            4 => 'Abril',
            5 => 'Maio',
            6 => 'Junho',
            7 => 'Julho',
            8 => 'Agosto',
            9 => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro'
        ];

        $validated = $request->validate([
            'ano' => 'required|integer|min:2000|max:' . date('Y'),
        ]);

        $ano = $validated['ano'];

        $atendimentos = AtendimentoRealizado::whereYear('data_hora_atendimento', $ano)
            ->with(['beneficiario', 'profissional.areaAtuacao'])
            ->get();

        $cestas = CestaBasicaEntregue::whereYear('data_entrega', $ano)
            ->with('beneficiario')
            ->get();

        $areas = AreaAtucao::with('profissionais')->get();

        // Contagem de atendimentos por profissional e mês
        $atendimentosPorProfissional = [];
        foreach ($areas as $area) {
            foreach ($area->profissionais as $profissional) {
                for ($mes = 1; $mes <= 12; $mes++) {
                    $atendimentosPorProfissional[$area->id][$profissional->id][$mes] =
                        $atendimentos->where('profissional_id', $profissional->id)
                            ->filter(fn($at) => \Carbon\Carbon::parse($at->data_hora_atendimento)->month == $mes)
                            ->count();
                }
            }
        }

        // Total de atendimentos por área
        $atendimentosPorArea = [];
        foreach ($areas as $area) {
            for ($mes = 1; $mes <= 12; $mes++) {
                $atendimentosPorArea[$area->id][$mes] =
                    array_sum(array_column($atendimentosPorProfissional[$area->id] ?? [], $mes));
            }
        }

        // Totais gerais por mês
        $atendimentosPorMes = array_map(
            fn($mes) =>
            $atendimentos->filter(fn($at) => \Carbon\Carbon::parse($at->data_hora_atendimento)->month == $mes)->count(),
            array_keys($meses)
        );

        // Cestas por mês
        $cestasPorMes = array_map(
            fn($mes) =>
            $cestas->filter(fn($c) => \Carbon\Carbon::parse($c->data_entrega)->month == $mes)->count(),
            array_keys($meses)
        );

        // Totais
        $totalAnoAtendimentos = array_sum($atendimentosPorMes);
        $totalAnoCestas = array_sum($cestasPorMes);

        $pdf = PDF::loadView('pdf.relatorios.relatorio_anual', compact(
            'validated',
            'meses',
            'areas',
            'atendimentosPorProfissional',
            'atendimentosPorArea',
            'atendimentosPorMes',
            'totalAnoAtendimentos',
            'cestasPorMes',
            'totalAnoCestas'
        ))->setPaper('a4', 'landscape');

        return $pdf->download("relatorio_anual_{$ano}.pdf");
    }


}
