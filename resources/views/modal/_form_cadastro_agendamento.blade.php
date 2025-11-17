
<div class="modal-content">
    <form id="formCadastroAgendamento-{{ $profissional->id }}" action="{{ route('agendamento.store') }}" method="post" class="needs-validation" name="formCadastroAgendamento" novalidate>
        @csrf
        <input type="hidden" name="profissional_id" value="{{ $profissional->id }}">

        <div class="modal-header bg-gradient-orange text-white">
            <h5 class="modal-title" id="tituloModalCadastro-{{ $profissional->id }}">
                <i class="fas fa-calendar-plus mr-2"></i> Novo Agendamento
            </h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
            <div class="alert alert-info">
                <i class="fas fa-info-circle mr-2"></i> Agendamento para: <strong>{{ $profissional->nome_completo }}</strong> - {{ $profissional->perfil }}
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="beneficiario_id-{{ $profissional->id }}"><i class="fas fa-user mr-1"></i> Beneficiário</label>
                        <select id="beneficiario_id-{{ $profissional->id }}" name="beneficiario_id" class="form-control select2 @error('beneficiario_id') is-invalid @enderror" required>
                            <option value="">Selecione o beneficiário</option>
                            @foreach($beneficiarios as $beneficiario)
                                <option value="{{ $beneficiario->id }}" {{ old('beneficiario_id') == $beneficiario->id ? 'selected' : '' }}>
                                    {{ $beneficiario->nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('beneficiario_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="area_atendimento_id-{{ $profissional->id }}"><i class="fas fa-procedures mr-1"></i> Área de Atendimento</label>
                        <select id="area_atendimento_id-{{ $profissional->id }}" name="area_atendimento_id" class="form-control select2 @error('area_atendimento_id') is-invalid @enderror" required>
                            <option value="">Selecione a área</option>
                            @foreach($areas as $area)
                                <option value="{{ $area->id }}" {{ old('area_atendimento_id') == $area->id ? 'selected' : '' }}>
                                    {{ $area->nome_area }}
                                </option>
                            @endforeach
                        </select>
                        @error('area_atendimento_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="data-{{ $profissional->id }}"><i class="far fa-calendar-alt mr-1"></i> Data</label>
                        <input type="date" id="data-{{ $profissional->id }}" name="data_hora_agendamento"
                               class="form-control @error('data_hora_agendamento') is-invalid @enderror"
                               value="{{ old('data_hora_agendamento') }}" min="{{ date('Y-m-d') }}" required>
                        @error('data_hora_agendamento')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="hora-{{ $profissional->id }}"><i class="far fa-clock mr-1"></i> Hora</label>
                        <select name="hora_registro" id="hora-{{ $profissional->id }}" class="form-control @error('hora_registro') is-invalid @enderror" required>
                            <option value="">Selecione a hora</option>
                            @foreach($horariosDisponiveis as $hora)
                                <option value="{{ $hora }}" {{ old('hora_registro') == $hora ? 'selected' : '' }}>
                                    {{ $hora }}
                                </option>
                            @endforeach
                        </select>
                        @error('hora_registro')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="tipo_atendimento-{{ $profissional->id }}"><i class="fas fa-stethoscope mr-1"></i> Tipo de Atendimento</label>
                <select id="tipo_atendimento-{{ $profissional->id }}" name="tipo_de_atendimento_id" class="form-control @error('tipo_de_atendimento_id') is-invalid @enderror" required>
                    <option value="">Selecione o tipo</option>
                    @foreach($tiposDeAtendimento as $tipo)
                        <option value="{{ $tipo->id }}" {{ old('tipo_de_atendimento_id') == $tipo->id ? 'selected' : '' }}>
                            {{ $tipo->nome }}
                        </option>
                    @endforeach
                </select>
                @error('tipo_de_atendimento_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="observacoes-{{ $profissional->id }}"><i class="fas fa-comment-medical mr-1"></i> Observações</label>
                <textarea id="observacoes-{{ $profissional->id }}" name="observacoes_agendamento" class="form-control @error('observacoes_agendamento') is-invalid @enderror"
                          rows="3" placeholder="Informe sintomas, histórico relevante ou outras observações">{{ old('observacoes_agendamento') }}</textarea>
                @error('observacoes_agendamento')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="modal-footer bg-light">
            <button type="button" class="btn btn-danger" data-dismiss="modal">
                <i class="fas fa-times mr-1"></i> Cancelar
            </button>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-calendar-check mr-1"></i> Agendar
            </button>
        </div>
    </form>
</div>
