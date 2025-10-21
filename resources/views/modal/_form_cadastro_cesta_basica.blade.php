<div class="modal-content">
    <form id="formCadastroCesta-{{ $beneficiario->id }}" action="{{ route('cesta.store') }}" method="post"
        class="needs-validation" name="formCadastroCesta" novalidate>
        @csrf
        <input type="hidden" name="beneficiario_id" value="{{ $beneficiario->id }}">

        <div class="modal-header bg-gradient-orange text-white">
            <h5 class="modal-title" id="tituloModalCadastro-{{ $beneficiario->id }}">
                <i class="fas fa-calendar-plus mr-2"></i> Registro de Entrega de Cesta Básica
            </h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
            <div class="alert alert-info">
                <i class="fas fa-info-circle mr-2"></i> Entrega para:
                <strong>{{ $beneficiario->nome }}</strong>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="data_entrega">Data de entrega</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                            </div>
                            <input type="date" id="data_entrega" name="data_entrega"
                                class="form-control @error('data_entrega') is-invalid @enderror"
                                value="{{ old('data_entrega') }}" required>
                        </div>
                        @error('data_entrega')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="quantidade_cestas">Quantidade de Cestas Entregues</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-box"></i></span>
                            </div>
                            <input type="number" id="quantidade_cestas" name="quantidade"
                                class="form-control @error('quantidade_cestas') is-invalid @enderror"
                                value="{{ old('quantidade_cestas') }}" required min="1">
                        </div>
                        @error('quantidade_cestas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="observacoes-{{ $beneficiario->id }}"><i class="fas fa-comment-medical mr-1"></i>
                            Observações</label>

                        <textarea id="observacoes-{{ $beneficiario->id }}" name="observacoes"
                            class="form-control @error('observacoes') is-invalid @enderror" rows="3"
                            placeholder="Informe sintomas, histórico relevante ou outras observações">{{ old('observacoes') }}</textarea>
                        @error('observacoes')
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