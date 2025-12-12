<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Prontuário do Paciente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            font-size: 13px;
            color: #333;
        }

        /* Cabeçalho */
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
            margin: 10px 0 25px;
            text-transform: uppercase;
        }

        /* Seções do documento */
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

        .info-table td {
            border: 1px solid #e0e0e0;
            padding: 6px 10px;
            vertical-align: top;
        }

        .info-table td.label {
            background-color: #f9f9f9;
            font-weight: bold;
            width: 35%;
        }

        /* Rodapé */
        .footer {
            text-align: center;
            font-size: 11px;
            color: #555;
            margin-top: 40px;
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

    <div class="title">PRONTUÁRIO DO PACIENTE</div>

    <!-- Dados do paciente -->
    <div class="section">
        <div class="section-header">Dados do Paciente</div>
        <table class="info-table">
            <tr>
                <td class="label">Nome</td>
                <td>{{ $agendamento->beneficiario->nome }}</td>
            </tr>
            <tr>
                <td class="label">Data de Nascimento</td>
                <td>{{ \Carbon\Carbon::parse($agendamento->beneficiario->data_nascimento)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td class="label">Idade</td>
                <td>{{ \Carbon\Carbon::parse($agendamento->beneficiario->data_nascimento)->age }} anos</td>
            </tr>
            <tr>
                <td class="label">Escolaridade</td>
                <td>{{ $agendamento->beneficiario->escolaridade }}</td>
            </tr>
            <tr>
                <td class="label">Ocupação</td>
                <td>{{ $agendamento->beneficiario->ocupacao ? $agendamento->beneficiario->ocupacao : 'Não informado' }}
                </td>
            </tr>
            <tr>
                <td class="label">Sexo</td>
                <td>{{ $agendamento->beneficiario->sexo }}</td>
            </tr>
            <tr>
                <td class="label">Telefone</td>
                <td>{{ $agendamento->beneficiario->telefone }}</td>
            </tr>
            <tr>
                <td class="label">Email</td>
                <td>{{ $agendamento->beneficiario->email ? $agendamento->beneficiario->email : 'Não informado' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-header">Dados do Responsável/Cuidador</div>
        <table class="info-table">
            <tr>
                <td class="label">Nome</td>
                <td>{{ $agendamento->beneficiario->nome_responsavel ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">Parentesco</td>
                <td>{{ $agendamento->beneficiario->parentesco_responsavel ?? '' }}</td>
            </tr>
            <tr></tr>
            <td class="label">Telefone</td>
            <td>{{ $agendamento->beneficiario->telefone_responsavel ?? '' }}</td>
            </tr>
        </table>
    </div>

    <!-- Limitações -->
    <div class="section">
        <div class="section-header">Limitações e Observações</div>
        <table class="info-table">
            <tr>
                <td class="label">Limitações</td>
                <td>{{ $agendamento->beneficiario->limitacoes ?? 'Nenhuma' }}</td>
            </tr>
            <tr>
                <td class="label">Outras Limitações</td>
                <td>{{ $agendamento->beneficiario->outras_limitacoes ?? 'Nenhuma' }}</td>
            </tr>
            <tr>
                <td class="label">Observações</td>
                <td>{{ $agendamento->beneficiario->observacoes ?? 'Nenhuma' }}</td>
            </tr>
        </table>
    </div>

    <!-- Profissional -->
    <div class="section">
        <div class="section-header">Profissional Responsável</div>
        <table class="info-table">
            <tr>
                <td class="label">Nome</td>
                <td>{{ $agendamento->profissional->nome_completo }}</td>
            </tr>
            <tr>
                <td class="label">Área de Atendimento</td>
                <td>{{ $agendamento->areaAtendimento->nome_area }}</td>
            </tr>
            <tr>
                <td class="label">Data</td>
                <td>{{ \Carbon\Carbon::parse($agendamento->data_hora_agendamento)->format('d/m/Y') }} |
                    {{ $agendamento->hora_registro }}
                </td>
            </tr>
        </table>
    </div>

    <!-- Rodapé -->
    <div class="footer">
        <p>Rua Theodoro Pinto de Souza, s/nº, Rive - Alegre/ES</p>
        <p style="font-style: italic;">“...de graça recebestes, de graça dai.” (Jesus)</p>
    </div>
</body>

</html>