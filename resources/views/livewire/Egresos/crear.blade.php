<div wire:ignore.self class="modal fade" id="Modal" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header modal-header-success"> {{-- Modal color verde Success --}}

            <h5 class="modal-title" id="exampleModalLabel">
              Registrar Egreso
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form>

                <div class="form-group">
                    <label for="egr_motivo">Motivo de Egreso:</label>
                    <textarea rows="2" wire:model='egr_motivo' class="form-control" id="egr_motivo" ></textarea>
                    @error('egr_motivo') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="egr_total">Monto del Egreso:</label>
                    <input wire:model="egr_total" type="number" class="form-control" id="egr_total" placeholder="0.00">
                    @error('egr_total') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>

            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="resetInput">Cancelar</button>
            <button type="button" wire:click.prevent="registrar()" class="btn btn-primary">Registrar</button>

        </div>
    </div>
</div>
</div>
