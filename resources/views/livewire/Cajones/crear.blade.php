
<div wire:ignore.self class="modal fade" id="Modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        @if($updateMode ==false)
        <div class="modal-header modal-header-success"> {{--Modal color verde Success--}}
        @else
        <div class="modal-header modal-header-warning"> {{--Modal color amarillo Success--}}
        @endif
          <h5 class="modal-title" id="exampleModalLabel">
            @if($updateMode ==false)
                Registrar Cajones
            @else
                Modificar Cajones
            @endif
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form>
                <div class="form-group">
                    <label for="caj_desc">Cajon</label>
                    <input wire:model="caj_desc" type="text" class="form-control" id="caj_desc" placeholder="Descripcion">
                    @error('caj_desc') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
       
                  <label>Tipo de Vehiculo</label>
                    <select wire:model="caj_tipoid" class="form-control">
                        <option value="Elegir">Elegir</option>
                        @foreach ($vehiculos as $v)
                            <option value="{{ $v->tip_id }}">{{ $v->tip_desc }} </option>
                        @endforeach
                    </select>
                    @error('caj_tipoid') <span class="error text-danger">{{ $message }}</span> @enderror
              
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