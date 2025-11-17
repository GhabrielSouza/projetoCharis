<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Relatório de Atendimentos por Período</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            font-size: 13px;
            color: #333;
        }

        .header-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .header-table td {
            vertical-align: middle;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            color: #005c2e;
            margin: 10px 0 5px;
            text-transform: uppercase;
        }

        .periodo {
            text-align: center;
            font-size: 13px;
            color: #666;
            margin-bottom: 20px;
        }

        .section {
            margin-top: 15px;
            border: 1px solid #d0d0d0;
            border-radius: 4px;
        }

        .section-header {
            background-color: #dff0d8;
            font-weight: bold;
            padding: 6px 10px;
            border-bottom: 1px solid #c5e1a5;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table th,
        .info-table td {
            border: 1px solid #e0e0e0;
            padding: 6px 8px;
            text-align: left;
        }

        .info-table th {
            background-color: #f9f9f9;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            font-size: 11px;
            color: #555;
            margin-top: 40px;
        }

        .summary {
            margin-top: 15px;
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>

<body>
    <!-- Cabeçalho -->
    <table class="header-table">
        <tr>
            <td style="width:40%; text-align:left;">
                <img src="{{ public_path('imgs/charis_logo.png') }}" width="150" alt="Projeto Charis">
            </td>
            <td style="width:20%;"></td>
            <td style="width:40%; text-align:right;">
                <img src="{{ public_path('imgs/ipbrive_logo.png') }}" width="100" alt="IPBRive">
            </td>
        </tr>
    </table>

    <div class="title">Relatório de Atendimentos por Período</div>
    <div class="periodo">
        Período: <strong>{{ \Carbon\Carbon::parse($validated['data_inicio'])->format('d/m/Y') }}</strong>
        a
        <strong>{{ \Carbon\Carbon::parse($validated['data_fim'])->format('d/m/Y') }}</strong>
    </div>

    <!-- Tabela de atendimentos -->
    <div class="section">
        <div class="section-header">Atendimentos Realizados</div>
        <table class="info-table">
            <thead>
                <tr>
                    <th style="width: 15%;">Data</th>
                    <th style="width: 25%;">Beneficiário</th>
                    <th style="width: 25%;">Profissional</th>
                    <th style="width: 20%;">Área</th>
                    <th style="width: 15%;">Tipo</th>
                    <th style="width: 15%;">Observações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($atendimentos as $at)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($at->data_hora_atendimento)->format('d/m/Y') }}</td>
                        <td>{{ $at->beneficiario->nome }}</td>
                        <td>{{ $at->profissional->nome_completo ?? '—' }}</td>
                        <td>{{ $at->areaAtendimento->nome_area ?? '—' }}</td>
                        <td>{{ $at->TipoDeAtendimento->nome ?? '—' }}</td>
                        <td>{{ $at->observacoes ?? '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;">Nenhum atendimento encontrado neste período.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Resumo -->
    <div class="summary">
        Total de atendimentos: {{ $atendimentos->count() }}
    </div>

    <!-- Rodapé -->
    <div class="footer">
        <p>Rua Theodoro Pinto de Souza, s/nº, Rive - Alegre/ES</p>
        <p style="font-style: italic;">“...de graça recebestes, de graça dai.” (Jesus)</p>
    </div>
</body>

</html>