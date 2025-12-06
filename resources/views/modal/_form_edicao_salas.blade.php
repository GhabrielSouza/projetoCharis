<div class="modal-content">
    <form id="formCadastroSala" action="{{ route('salas.update', $sala->id) }}" method="post" class="needs-validation"
        name="formCadastroSala" novalidate>
        <input type="hidden" name="id" value="{{ $sala->id }}">
        @csrf
        @method('PUT')
        <div class="modal-header bg-gradient-orange text-white">
            <h5 class="modal-title">
                <i class="fas fa-calendar-plus mr-2"></i> Registro de Sala de Aula
            </h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="nome">Nome da Sala</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-door-open"></i></span>
                            </div>
                            <input type="text" id="nome" name="nome"
                                class="form-control @error('nome') is-invalid @enderror"
                                value="{{ old('nome', $sala->nome) }}" required>
                        </div>
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="professor_responsavel">Professor responsável</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-chalkboard-teacher"></i></span>
                            </div>
                            <select id="professor_responsavel" name="profissional_id"
                                class="form-control @error('professor_responsavel') is-invalid @enderror" required>
                                <option value="" disabled selected>Selecione o professor responsável</option>
                                @foreach ($profissionais as $professor)
                                    <option value="{{ $professor->id }}"
                                        {{ old('professor_responsavel', $sala->profissional_id) == $professor->id ? 'selected' : '' }}>
                                        {{ $professor->nome_completo }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('professor_responsavel')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="observacoes-{{ $sala->id }}"><i class="fas fa-comment-medical mr-1"></i>
                            Observações</label>

                        <textarea id="observacoes-{{ $sala->id }}" name="descricao"
                            class="form-control @error('descricao') is-invalid @enderror" rows="3"
                            placeholder="Informe sintomas, histórico relevante ou outras observações">{{ old('descricao', $sala->descricao) }}</textarea>
                        @error('descricao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>


            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Cancelar
                </button>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-calendar-check mr-1"></i> Salvar
                </button>
            </div>
    </form>
</div>
