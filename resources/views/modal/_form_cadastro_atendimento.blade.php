<div class="modal-content">
    <form id="formCadastroAtendimento" action="{{ route('atendimentos.store') }}" method="post" class="needs-validation"
        novalidate>
        @csrf

        <div class="modal-header bg-gradient-orange text-white">
            <h5 class="modal-title" id="tituloModalCadastro">
                <i class="fas fa-calendar-plus mr-2"></i> Novo Atendimento
            </h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="beneficiario_id"><i class="fas fa-user mr-1"></i>
                            Beneficiário</label>
                        <select id="beneficiario_id" name="beneficiario_id"
                            class="form-control select2 @error('beneficiario_id') is-invalid @enderror" required>
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
                        <label for="profissional_id"><i class="fas fa-user-md mr-1"></i> Profissional</label>
                        <select name="profissional_id" id="profissional_id"
                            class="form-control select2 @error('profissional_id') is-invalid @enderror" required>
                            <option value="">Selecione o profissional</option>
                            @foreach($profissionais as $profissional)
                                <option value="{{ $profissional->id }}" {{ old('profissional_id') == $profissional->id ? 'selected' : '' }}>
                                    {{ $profissional->nome_completo }} - {{ $profissional->perfil }}
                                </option>
                            @endforeach
                        </select>
                        @error('profissional_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="data_atendimento"><i class="far fa-calendar-alt mr-1"></i> Data</label>
                        <input type="date" id="data_atendimento" name="data_hora_atendimento"
                            class="form-control @error('data_hora_atendimento') is-invalid @enderror"
                            value="{{ old('data_hora_atendimento') }}" required>
                        @error('data_hora_atendimento')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="hora_registro"><i class="far fa-clock mr-1"></i> Hora</label>
                        <select name="hora_registro" id="hora_registro"
                            class="form-control @error('hora_registro') is-invalid @enderror" required>
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

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="area_atendimento_id"><i class="fas fa-procedures mr-1"></i> Área de
                            Atendimento</label>
                        <select id="area_atendimento_id" name="area_atendimento_id"
                            class="form-control select2 @error('area_atendimento_id') is-invalid @enderror" required>
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
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tipo_atendimento_id"><i class="fas fa-stethoscope mr-1"></i>
                            Tipo de Atendimento</label>
                        <select id="tipo_atendimento_id" name="tipo_de_atendimento_id"
                            class="form-control @error('tipo_de_atendimento_id') is-invalid @enderror" required>
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
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="descricao_atendimento"><i class="fas fa-notes-medical mr-1"></i>
                            Observações</label>
                        <textarea id="descricao_atendimento" name="descricao_atendimento" rows="3"
                            class="form-control @error('descricao_atendimento') is-invalid @enderror"
                            placeholder="Insira observações adicionais...">{{ old('descricao_atendimento') }}</textarea>
                        @error('descricao_atendimento')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer bg-light">
            <button type="button" class="btn btn-danger" data-dismiss="modal">
                <i class="fas fa-times mr-1"></i> Cancelar
            </button>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-calendar-check mr-1"></i> Cadastrar Atendimento
            </button>
        </div>
    </form>
</div>