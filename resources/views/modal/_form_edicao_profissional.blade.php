<form id="professionalForm-{{ $profissional->id }}" class="form-edicao-profissional"
    action="{{ route('profissionais.update', $profissional->id)}}" method="POST">
    @csrf
    @method('PUT')
    <input type="hidden" name="id" id="profissionalId">
    <div class="modal-content">
        <div class="modal-header bg-orange text-white">
            <h5 class="modal-title" id="tituloModalEdicao-{{ $profissional->id }}">
                <i class="fas fa-edit mr-2"></i>Editar Cadastro de:
                <strong>{{ $profissional->nome_completo }}</strong>
            </h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nome-{{ $profissional->id }}"><i class="fas fa-user mr-1"></i>Nome Completo</label>
                    <input type="text" id="nome-{{ $profissional->id }}" class="form-control" name="nome_completo"
                        value="{{ old('nome_completo', $profissional->nome_completo) }}" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="data_nascimento-{{ $profissional->id }}"><i class="fas fa-calendar-alt mr-1"></i>Data de
                        Nascimento</label>
                    <input id="data_nascimento-{{ $profissional->id }}" type="date"
                        value="{{ old('data_nascimento', $profissional->data_nascimento) }}" class="form-control"
                        name="data_nascimento" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="sexo-{{ $profissional->id }}"><i class="fas fa-venus-mars mr-1"></i>Sexo</label>
                    <select id="sexo-{{ $profissional->id }}" name="sexo" class="form-control" required>
                        <option value="">Selecione...</option>
                        <option value="Masculino" {{ old('sexo', $profissional->sexo) == 'Masculino' ? 'selected' : '' }}>
                            Masculino</option>
                        <option value="Feminino" {{ old('sexo', $profissional->sexo) == 'Feminino' ? 'selected' : '' }}>
                            Feminino</option>
                        <option value="Outro" {{ old('sexo', $profissional->sexo) == 'Outro' ? 'selected' : '' }}>Outro
                        </option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="cpf-{{ $profissional->id }}"><i class="fas fa-id-card mr-1"></i>CPF</label>
                    <input type="text" id="cpf-{{ $profissional->id }}" value="{{ old('cpf', $profissional->cpf) }}"
                        class="form-control cpf-mask" name="cpf" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="telefone-{{ $profissional->id }}"><i class="fas fa-phone mr-1"></i>Telefone</label>
                    <input type="text" id="telefone-{{ $profissional->id }}"
                        value="{{ old('telefone', $profissional->telefone) }}" class="form-control phone-mask"
                        name="telefone" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="email-{{ $profissional->email }}"><i class="fas fa-envelope mr-1"></i>Email</label>
                    <input type="email" id="email-{{ $profissional->id }}"
                        value="{{ old('email', $profissional->email) }}" class="form-control" name="email" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="area_atuacao_id">Área de Atuação</label>
                    <select name="area_atuacao_id" id="area_atuacao_id" class="form-control" required>
                        <option value="">Selecione uma área...</option>
                        @foreach($areas as $area)
                            <option value="{{ $area->id }}" {{ $profissional->area_atuacao_id == $area->id ? 'selected' : '' }}>
                                {{ $area->nome_area }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="numero_registro-{{ $profissional->id }}"><i class="fas fa-id-badge mr-1"></i>Número de
                        Registro</label>
                    <input type="text" id="numero_registro-{{ $profissional->id }}"
                        value="{{ old('numero_registro', $profissional->numero_registro) }}" class="form-control"
                        name="numero_registro" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="perfil-{{ $profissional->id }}"><i class="fas fa-user-tag mr-1"></i>Perfil</label>
                    <select name="perfil" id="perfil-{{ $profissional->id }}" class="form-control" required>
                        <option value="">Selecione...</option>
                        <option value="Médico" {{ $profissional->perfil == 'Médico' ? 'selected' : '' }}>Médico</option>
                        <option value="Enfermeiro" {{ $profissional->perfil == 'Enfermeiro' ? 'selected' : '' }}>
                            Enfermeiro</option>
                        <option value="Psicólogo" {{ $profissional->perfil == 'Psicólogo' ? 'selected' : '' }}>Psicólogo
                        </option>
                        <option value="Assistente Social" {{ $profissional->perfil == 'Assistente Social' ? 'selected' : '' }}>
                            Assistente Social</option>
                        <option value="Outro" {{ $profissional->perfil == 'Outro' ? 'selected' : '' }}>Outro</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="observacoes-{{ $profissional->id }}"><i
                        class="fas fa-comment-dots mr-1"></i>Observações</label>
                <textarea class="form-control" id="observacoes-{{ $profissional->id }}" name="observacoes"
                    rows="2">{{ old('observacoes', $profissional->observacoes) }}</textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">
                <i class="fas fa-times mr-1"></i>Cancelar
            </button>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save mr-1"></i>Salvar
            </button>
        </div>
    </div>
</form>