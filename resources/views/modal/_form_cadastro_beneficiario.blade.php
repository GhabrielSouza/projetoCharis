
<form id="formCadastroBeneficiario" action="{{ route('beneficiarios.store') }}" method="POST">
    @csrf
    <div class="modal-header bg-orange text-white">
        <h5 class="modal-title" id="tituloModalCadastro">
            <i class="fas fa-user-plus mr-2"></i>Cadastro de Beneficiário
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                {{-- Nome --}}
                <div class="form-group">
                    <label for="nome">Nome Completo</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" id="nome" name="nome"
                            class="form-control @error('nome') is-invalid @enderror"
                            placeholder="Nome completo" value="{{ old('nome') }}" required>
                    </div>
                    @error('nome')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Data de nascimento --}}
                <div class="form-group">
                    <label for="data_nascimento">Data de Nascimento</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        </div>
                        <input type="date" id="data_nascimento" name="data_nascimento"
                            class="form-control @error('data_nascimento') is-invalid @enderror"
                            value="{{ old('data_nascimento') }}" required>
                    </div>
                    @error('data_nascimento')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- CPF --}}
                <div class="form-group">
                    <label for="cpf">CPF</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <input type="text" id="cpf" name="cpf"
                            class="form-control cpf-mask @error('cpf') is-invalid @enderror"
                            placeholder="000.000.000-00" value="{{ old('cpf') }}" required>
                    </div>
                    @error('cpf')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                {{-- Telefone --}}
                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        </div>
                        <input type="text" id="telefone" name="telefone"
                            class="form-control phone-mask @error('telefone') is-invalid @enderror"
                            placeholder="(00) 00000-0000" value="{{ old('telefone') }}">
                    </div>
                    @error('telefone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                {{-- Endereço --}}
                <div class="form-group">
                    <label for="endereco">Endereço</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                        </div>
                        <input type="text" id="endereco" name="endereco"
                            class="form-control @error('endereco') is-invalid @enderror"
                            placeholder="Endereço completo" value="{{ old('endereco') }}">
                    </div>
                    @error('endereco')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Escolaridade --}}
                <div class="form-group">
                    <label for="escolaridade">Escolaridade</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                        </div>
                        <select id="escolaridade" name="escolaridade"
                            class="form-control @error('escolaridade') is-invalid @enderror">
                            <option value="">Selecione...</option>
                            <option value="Fundamental Incompleto" {{ old('escolaridade') == 'Fundamental Incompleto' ? 'selected' : '' }}>Fundamental Incompleto</option>
                            <option value="Fundamental Completo" {{ old('escolaridade') == 'Fundamental Completo' ? 'selected' : '' }}>Fundamental Completo</option>
                            <option value="Médio Incompleto" {{ old('escolaridade') == 'Médio Incompleto' ? 'selected' : '' }}>Médio Incompleto</option>
                            <option value="Médio Completo" {{ old('escolaridade') == 'Médio Completo' ? 'selected' : '' }}>Médio Completo</option>
                            <option value="Superior Incompleto" {{ old('escolaridade') == 'Superior Incompleto' ? 'selected' : '' }}>Superior Incompleto</option>
                            <option value="Superior Completo" {{ old('escolaridade') == 'Superior Completo' ? 'selected' : '' }}>Superior Completo</option>
                            <option value="Pós-graduação" {{ old('escolaridade') == 'Pós-graduação' ? 'selected' : '' }}>Pós-graduação</option>
                            <option value="Analfabeto" {{ old('escolaridade') == 'Analfabeto' ? 'selected' : '' }}>Analfabeto</option>
                        </select>
                    </div>
                    @error('escolaridade')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- CadÚnico --}}
                <div class="form-group">
                    <label for="cadunico">Número do CadÚnico</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                        </div>
                        <input type="text" id="cadunico" name="cadunico"
                            class="form-control @error('cadunico') is-invalid @enderror"
                            placeholder="Número do CadÚnico" value="{{ old('cadunico') }}">
                    </div>
                    @error('cadunico')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="form-group">
                    <label><i class="fas fa-wheelchair mr-1"></i> Limitações</label>
                    <div class="border p-3 rounded">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="cognitiva"
                                        name="limitacoes[]" value="Cognitiva" {{ is_array(old('limitacoes')) && in_array('Cognitiva', old('limitacoes')) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="cognitiva">Cognitiva</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="locomocao"
                                        name="limitacoes[]" value="Locomoção" {{ is_array(old('limitacoes')) && in_array('Locomoção', old('limitacoes')) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="locomocao">Locomoção</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="visao"
                                        name="limitacoes[]" value="Visão" {{ is_array(old('limitacoes')) && in_array('Visão', old('limitacoes')) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="visao">Visão</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="audicao"
                                        name="limitacoes[]" value="Audição" {{ is_array(old('limitacoes')) && in_array('Audição', old('limitacoes')) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="audicao">Audição</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Outras</span>
                                    </div>
                                    <input type="text" class="form-control @error('outras_limitacoes') is-invalid @enderror" name="outras_limitacoes"
                                        placeholder="Especifique outras limitações" value="{{ old('outras_limitacoes') }}">
                                </div>
                                @error('outras_limitacoes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="observacoes"><i class="fas fa-comment-dots mr-1"></i> Observações</label>
            <textarea id="observacoes" name="observacoes"
                class="form-control @error('observacoes') is-invalid @enderror" rows="3"
                placeholder="Informações adicionais relevantes">{{ old('observacoes') }}</textarea>
            @error('observacoes')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="modal-footer ">
        <button type="button" class="btn btn-danger" data-dismiss="modal">
            <i class="fas fa-times mr-1"></i> Cancelar
        </button>
        <button type="submit" class="btn btn-success">
            <i class="fas fa-save mr-1"></i> Salvar Cadastro
        </button>
    </div>
</form>
