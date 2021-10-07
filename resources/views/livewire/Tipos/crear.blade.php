<div wire:ignore.self class="modal fade" id="Modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
            @if($updateMode ==false)
                Registrar Tipo
            @else
                Modificar Tipo
            @endif
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form>

                <div class="form-group">
                    <label for="tip_desc">Descripcion</label>
                    <input wire:model="tip_desc" type="text" class="form-control" id="tip_desc" placeholder="Tipo">
                    @error('tip_desc') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="tip_img">Imagen</label>
                    <input wire:model="tip_img" type="file" class="form-control" id="tip_img" placeholder="Imagen a Seleccionar">
                    @error('tip_img') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>

            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="resetInput">Cancelar</button>
            @if($updateMode ==false)
            <button type="button" wire:click.prevent="store_update()" class="btn btn-primary">Registrar</button>
            @else
            <button type="button" wire:click.prevent="store_update()" class="btn btn-warning">Modificar</button>
            @endif
        </div>
      </div>
    </div>
  </div>
