<form id="formEdicaoBeneficiario-{{ $beneficiario->id }}"
    action="{{ route('beneficiarios.update', $beneficiario->id) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="hidden" name="beneficiario_id_for_validation" value="{{ $beneficiario->id }}">

    <div class="modal-header bg-orange text-dark">
        <h5 class="modal-title" id="tituloModalEdicao-{{ $beneficiario->id }}">
            <i class="fas fa-edit mr-2"></i>Editar Cadastro de:
            <strong>{{ $beneficiario->nome }}</strong>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body">

        <div class="row">
            <div class="col-md-6">

                <div class="form-group">
                    <label for="nome-{{ $beneficiario->id }}">Nome Completo</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i
                                    class="fas fa-user"></i></span></div>
                        <input type="text" id="nome-{{ $beneficiario->id }}" name="nome"
                            class="form-control @error('nome') is-invalid @enderror"
                            value="{{ old('nome', $beneficiario->nome) }}" required>
                    </div>
                    @error('nome')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="data_nascimento-{{ $beneficiario->id }}">Data de
                        Nascimento</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i
                                    class="fas fa-calendar-alt"></i></span></div>
                        <input type="date" id="data_nascimento-{{ $beneficiario->id }}" name="data_nascimento"
                            class="form-control @error('data_nascimento') is-invalid @enderror"
                            value="{{ old('data_nascimento', $beneficiario->data_nascimento->format('Y-m-d')) }}"
                            required>
                    </div>
                    @error('data_nascimento')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="cpf-{{ $beneficiario->id }}">CPF</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i
                                    class="fas fa-id-card"></i></span></div>
                        <input type="text" id="cpf-{{ $beneficiario->id }}" name="cpf"
                            class="form-control cpf-mask @error('cpf') is-invalid @enderror"
                            value="{{ old('cpf', $beneficiario->cpf) }}" required>
                    </div>
                    @error('cpf')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="telefone-{{ $beneficiario->id }}">Telefone</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i
                                    class="fas fa-phone"></i></span></div>
                        <input type="text" id="telefone-{{ $beneficiario->id }}" name="telefone"
                            class="form-control phone-mask @error('telefone') is-invalid @enderror"
                            value="{{ old('telefone', $beneficiario->telefone) }}">
                    </div>
                    @error('telefone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">

                <div class="form-group">
                    <label for="endereco-{{ $beneficiario->id }}">Endereço</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i
                                    class="fas fa-map-marker-alt"></i></span></div>
                        <input type="text" id="endereco-{{ $beneficiario->id }}" name="endereco"
                            class="form-control @error('endereco') is-invalid @enderror"
                            value="{{ old('endereco', optional($beneficiario->endereco)->logradouro) }}"
                            placeholder="Endereço completo">
                    </div>
                    @error('endereco')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="escolaridade-{{ $beneficiario->id }}">Escolaridade</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i
                                    class="fas fa-graduation-cap"></i></span></div>
                        <select id="escolaridade-{{ $beneficiario->id }}" name="escolaridade"
                            class="form-control @error('escolaridade') is-invalid @enderror">
                            <option value="">Selecione...</option>

                            <option value="Fundamental Incompleto" {{ old('escolaridade', $beneficiario->escolaridade) == 'Fundamental Incompleto' ? 'selected' : '' }}>Fundamental
                                Incompleto</option>
                            <option value="Fundamental Completo" {{ old('escolaridade', $beneficiario->escolaridade) == 'Fundamental Completo' ? 'selected' : '' }}>Fundamental
                                Completo</option>
                            <option value="Médio Incompleto" {{ old('escolaridade', $beneficiario->escolaridade) == 'Médio Incompleto' ? 'selected' : '' }}>Médio Incompleto</option>
                            <option value="Médio Completo" {{ old('escolaridade', $beneficiario->escolaridade) == 'Médio Completo' ? 'selected' : '' }}>Médio Completo</option>
                            <option value="Superior Incompleto" {{ old('escolaridade', $beneficiario->escolaridade) == 'Superior Incompleto' ? 'selected' : '' }}>Superior
                                Incompleto</option>
                            <option value="Superior Completo" {{ old('escolaridade', $beneficiario->escolaridade) == 'Superior Completo' ? 'selected' : '' }}>Superior Completo
                            </option>
                            <option value="Pós-graduação" {{ old('escolaridade', $beneficiario->escolaridade) == 'Pós-graduação' ? 'selected' : '' }}>Pós-graduação
                            </option>
                            <option value="Analfabeto" {{ old('escolaridade', $beneficiario->escolaridade) == 'Analfabeto' ? 'selected' : '' }}>Analfabeto</option>
                        </select>
                    </div>
                    @error('escolaridade')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="cadunico-{{ $beneficiario->id }}">Número do
                        CadÚnico</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i
                                    class="fas fa-file-alt"></i></span></div>
                        <input type="text" id="cadunico-{{ $beneficiario->id }}" name="cadunico"
                            class="form-control @error('cadunico') is-invalid @enderror"
                            value="{{ old('cadunico', $beneficiario->cadunico) }}">
                    </div>
                    @error('cadunico')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group">
            <label><i class="fas fa-wheelchair mr-1"></i> Limitações</label>
            @php
                $limitacoes_salvas = old('limitacoes', json_decode($beneficiario->limitacoes, true) ?? []);
            @endphp
            <div class="border p-3 rounded">
                <div class="row">
                    <div class="col-md-3">
                        <div class="custom-control custom-checkbox">

                            <input type="checkbox" class="custom-control-input" id="cognitiva-{{ $beneficiario->id }}"
                                name="limitacoes[]" value="Cognitiva" {{ is_array($limitacoes_salvas) && in_array('Cognitiva', $limitacoes_salvas) ? 'checked' : '' }}>
                            <label class="custom-control-label"
                                for="cognitiva-{{ $beneficiario->id }}">Cognitiva</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="locomocao-{{ $beneficiario->id }}"
                                name="limitacoes[]" value="Locomoção" {{ is_array($limitacoes_salvas) && in_array('Locomoção', $limitacoes_salvas) ? 'checked' : '' }}>
                            <label class="custom-control-label"
                                for="locomocao-{{ $beneficiario->id }}">Locomoção</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="visao-{{ $beneficiario->id }}"
                                name="limitacoes[]" value="Visão" {{ is_array($limitacoes_salvas) && in_array('Visão', $limitacoes_salvas) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="visao-{{ $beneficiario->id }}">Visão</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="audicao-{{ $beneficiario->id }}"
                                name="limitacoes[]" value="Audição" {{ is_array($limitacoes_salvas) && in_array('Audição', $limitacoes_salvas) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="audicao-{{ $beneficiario->id }}">Audição</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">Outras</span></div>
                            <input type="text" class="form-control @error('outras_limitacoes') is-invalid @enderror"
                                name="outras_limitacoes"
                                value="{{ old('outras_limitacoes', $beneficiario->outras_limitacoes) }}"
                                placeholder="Especifique outras limitações">
                        </div>
                        @error('outras_limitacoes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="observacoes-{{ $beneficiario->id }}"><i class="fas fa-comment-dots mr-1"></i>
                Observações</label>
            <textarea id="observacoes-{{ $beneficiario->id }}" name="observacoes"
                class="form-control @error('observacoes') is-invalid @enderror"
                rows="3">{{ old('observacoes', $beneficiario->observacoes) }}</textarea>
            @error('observacoes')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>


    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times mr-1"></i>
            Cancelar</button>
        <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i>
            Salvar Alterações</button>
    </div>
</form>