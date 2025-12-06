<div class="modal-content">
    <form id="formCadastroSala" action="{{ route('salas.adicionarAlunos', $sala->id) }}" method="post"
        class="needs-validation" name="formCadastroSala" novalidate>
        @csrf
        <input type="hidden" name="sala_id" value="{{ $sala->id }}">

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
                        <label for="alunos">Alunos</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-chalkboard-teacher"></i></span>
                            </div>
                            <select id="alunos" name="beneficiario_id"
                                class="form-control @error('beneficiario_id') is-invalid @enderror" required>
                                <option value="" disabled selected>Selecione o aluno</option>
                                @foreach ($beneficiarios as $beneficiario)
                                    <option value="{{ $beneficiario->id }}">
                                        {{ $beneficiario->nome}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('beneficiario_id')
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