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
                Registrar Tarifa
            @else
                Modificar Tarifa
            @endif
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form>

                <div class="form-group">
                    <label for="tar_desc">Descripcion</label>
                    <input wire:model="tar_desc" type="text" class="form-control" id="tar_desc" placeholder="Descripcion de la Tarifa">
                    @error('tar_desc') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Tiempo</label>
                    <select wire:model="tar_tiempo" class="form-control">
                        <option value="Elegir">Elegir</option>
                        <option value="Minutos">Minutos</option>
                        <option value="Hora">Hora</option>
                        <option value="Dia">Dia</option>
                        <option value="Semana">Semana</option>
                        <option value="Mes">Mes</option>
                    </select>
                    @error('tar_tiempo') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="tar_precio">Precio Tarifa</label>
                    <input wire:model="tar_precio" type="text" class="form-control" id="tar_precio" placeholder="Precio">
                    @error('tar_precio') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Tipo de Vehiculo</label>
                    <select wire:model="tar_tipoid" class="form-control">
                        <option value="Elegir">Elegir</option>
                        @foreach ($tipos as $t)
                        <option value="{{ $t->tip_id }}">{{ $t->tip_desc }}</option>
                        @endforeach
                    </select>
                    @error('tar_tipoid') <span class="error text-danger">{{ $message }}</span> @enderror
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
