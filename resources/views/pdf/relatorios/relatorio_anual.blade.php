<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Relatório Anual — {{ $validated['ano'] }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 24px;
            font-size: 12px;
            color: #333;
        }

        .header-table {
            width: 100%;
            margin-bottom: 14px;
        }

        .header-table td {
            vertical-align: middle;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            color: #005c2e;
            margin: 8px 0 2px;
            text-transform: uppercase;
        }

        .periodo {
            text-align: center;
            font-size: 12px;
            color: #666;
            margin-bottom: 14px;
        }

        .section {
            margin-top: 14px;
            border: 1px solid #d0d0d0;
            border-radius: 4px;
            page-break-inside: avoid;
        }

        .section-header {
            background-color: #dff0d8;
            font-weight: bold;
            padding: 6px 10px;
            border-bottom: 1px solid #c5e1a5;
        }

        .table-wrap {
            padding: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid #e0e0e0;
            padding: 6px 6px;
            word-wrap: break-word;
        }

        th {
            background-color: #f9f9f9;
            font-weight: bold;
            text-align: center;
        }

        td.txt {
            text-align: left;
        }

        td.num {
            text-align: center;
        }

        .tot-area-row th,
        .tot-area-row td {
            background: #f3fbf3;
            font-weight: bold;
        }

        .summary {
            margin-top: 12px;
            font-weight: bold;
            text-align: right;
        }

        .footer {
            text-align: center;
            font-size: 11px;
            color: #555;
            margin-top: 24px;
        }

        /* Melhor leitura em paisagem */
        .w-name {
            width: 28%;
        }

        .w-month {
            width: calc((72% - 8%) / 12);
        }

        /* 12 meses distribuídos */
        .w-total {
            width: 8%;
        }

        /* Quebra entre áreas longas */
        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    <!-- Cabeçalho -->
    <table class="header-table">
        <tr>
            <td style="width:40%; text-align:left;">
                <img src="{{ public_path('imgs/charis_logo.png') }}" width="140" alt="Projeto Charis">
            </td>
            <td style="width:20%;"></td>
            <td style="width:40%; text-align:right;">
                <img src="{{ public_path('imgs/ipbrive_logo.png') }}" width="95" alt="IPBRive">
            </td>
        </tr>
    </table>

    <div class="title">Relatório Anual de Atendimentos e Ações Sociais</div>
    <div class="periodo">
        Ano de referência: <strong>{{ $validated['ano'] }}</strong>
    </div>

    {{-- ===========================
    Seção 1: Áreas e Profissionais
    =========================== --}}
    @php $areaIndex = 0; @endphp
    @foreach($areas as $area)
        @php $areaIndex++; @endphp
        <div class="section {{ $areaIndex > 1 ? 'page-break' : '' }}">
            <div class="section-header">
                Atendimentos — Área: {{ $area->nome_area ?? 'Não Informada' }}
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th class="w-name">Profissional</th>
                            @foreach($meses as $mesNumero => $mesNome)
                                <th class="w-month">{{ $mesNome }}</th>
                            @endforeach
                            <th class="w-total">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // Segurança: se não vier relação, evita erro
                            $profsArea = $area->profissionais ?? collect();
                        @endphp

                        @forelse($profsArea as $prof)
                            @php
                                $linhaTotal = 0;
                            @endphp
                            <tr>
                                <td class="txt">{{ $prof->nome_completo ?? ('#' . $prof->id) }}</td>
                                @foreach($meses as $mesNumero => $mesNome)
                                    @php
                                        $qtd = $atendimentosPorProfissional[$area->id][$prof->id][$mesNumero] ?? 0;
                                        $linhaTotal += $qtd;
                                    @endphp
                                    <td class="num">{{ $qtd }}</td>
                                @endforeach
                                <td class="num"><strong>{{ $linhaTotal }}</strong></td>
                            </tr>
                        @empty
                            <tr>
                                <td class="txt" colspan="{{ 2 + count($meses) }}">Nenhum profissional cadastrado nesta área.
                                </td>
                            </tr>
                        @endforelse

                        {{-- Total da área por mês + total anual da área --}}
                        @php
                            $totalAreaAnual = 0;
                        @endphp
                        <tr class="tot-area-row">
                            <td class="txt"><strong>Total da Área ({{ $area->nome_area ?? '—' }})</strong></td>
                            @foreach($meses as $mesNumero => $mesNome)
                                @php
                                    $colTot = $atendimentosPorArea[$area->id][$mesNumero] ?? 0;
                                    $totalAreaAnual += $colTot;
                                @endphp
                                <td class="num"><strong>{{ $colTot }}</strong></td>
                            @endforeach
                            <td class="num"><strong>{{ $totalAreaAnual }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach

    {{-- ===========================
    Seção 2: Cestas por mês
    =========================== --}}
    <div class="section page-break">
        <div class="section-header">Cestas Básicas — Totais por mês</div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        @foreach($meses as $mesNome)
                            <th class="w-month">{{ $mesNome }}</th>
                        @endforeach
                        <th class="w-total">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php $somaCestas = 0; @endphp
                    <tr>
                        @foreach($meses as $mesNumero => $mesNome)
                            @php
                                $qtd = $cestasPorMes[$mesNumero] ?? 0;
                                $somaCestas += $qtd;
                            @endphp
                            <td class="num">{{ $qtd }}</td>
                        @endforeach
                        <td class="num"><strong>{{ $somaCestas }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- ===========================
    Seção 3: Totais Gerais
    =========================== --}}
    <div class="section">
        <div class="section-header">Totais Gerais do Ano</div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th class="txt">Indicador</th>
                        <th class="num">Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="txt">Total geral de atendimentos (todas as áreas)</td>
                        <td class="num"><strong>{{ $totalAnoAtendimentos }}</strong></td>
                    </tr>
                    <tr>
                        <td class="txt">Total geral de cestas básicas</td>
                        <td class="num"><strong>{{ $totalAnoCestas }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Rodapé -->
    <div class="footer">
        <p>Rua Theodoro Pinto de Souza, s/nº — Rive, Alegre/ES</p>
        <p style="font-style: italic;">“...de graça recebestes, de graça dai.” (Jesus)</p>
    </div>
</body>

</html>