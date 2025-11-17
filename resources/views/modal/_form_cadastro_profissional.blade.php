<form id="formCadastroProfissional" action="{{ route('profissionais.store') }}" method="POST">
    @csrf
    <input type="hidden" name="id" id="profissionalId">
    <div class="modal-content">
        <div class="modal-header bg-orange text-white">
            <h5 class="modal-title" id="addProfessionalLabel"><i class="fas fa-user-md mr-2"></i>Cadastro de
                Profissional</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><i class="fas fa-user mr-1"></i>Nome Completo</label>
                    <input type="text" class="form-control" name="nome_completo" required>
                </div>
                <div class="form-group col-md-6">
                    <label><i class="fas fa-calendar-alt mr-1"></i>Data de Nascimento</label>
                    <input type="date" class="form-control" name="data_nascimento" required>
                </div>
                <div class="form-group col-md-6">
                    <label><i class="fas fa-venus-mars mr-1"></i>Sexo</label>
                    <select name="sexo" class="form-control" required>
                        <option value="">Selecione...</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Feminino">Feminino</option>
                        <option value="Outro">Outro</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label><i class="fas fa-id-card mr-1"></i>CPF</label>
                    <input type="text" class="form-control cpf-mask" name="cpf" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><i class="fas fa-phone mr-1"></i>Telefone</label>
                    <input type="text" class="form-control phone-mask" name="telefone" required>
                </div>
                <div class="form-group col-md-4">
                    <label><i class="fas fa-envelope mr-1"></i>Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="area_atuacao_id">Área de Atuação</label>
                    <select name="area_atuacao_id" id="area_atuacao_id" class="form-control" required>
                        <option value="">Selecione uma área...</option>
                        @foreach($areas as $area)
                            <option value="{{ $area->id }}">{{ $area->nome_area }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><i class="fas fa-id-badge mr-1"></i>Número de Registro</label>
                    <input type="text" class="form-control" name="numero_registro" required>
                </div>
                <div class="form-group col-md-6">
                    <label><i class="fas fa-user-tag mr-1"></i>Perfil</label>
                    <select name="perfil" class="form-control" required>
                        <option value="">Selecione...</option>
                        <option value="Médico">Médico</option>
                        <option value="Enfermeiro">Enfermeiro</option>
                        <option value="Psicólogo">Psicólogo</option>
                        <option value="Assistente Social">Assistente Social</option>
                        <option value="Outro">Outro</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label><i class="fas fa-comment-dots mr-1"></i>Observações</label>
                <textarea class="form-control" name="observacoes" rows="2"></textarea>
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