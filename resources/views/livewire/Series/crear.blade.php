<div wire:ignore.self class="modal fade" id="Modal" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            @if ($updateMode == false)
                <div class="modal-header modal-header-success"> {{-- Modal color verde Success --}}
                @else
                    <div class="modal-header modal-header-warning"> {{-- Modal color amarillo Success --}}
            @endif
            <h5 class="modal-title" id="exampleModalLabel">
                @if ($updateMode == false)
                    Registrar Serie
                @else
                    Modificar Serie
                @endif
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form>
                <div class="form-group">
                    <label>Tipo de Comprobante</label>
                    <select wire:model="ser_tpcomid" class="form-control">
                        <option value="Elegir">Elegir</option>
                        @foreach ($tipocomprobante as $t)
                            <option value="{{ $t->tpc_id }}">{{ $t->tpc_desc }} </option>
                        @endforeach
                    </select>
                    @error('ser_tpcomid') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="ser_serie">Serie</label>
                    <input wire:model="ser_serie" type="text" class="form-control" id="ser_serie"
                        placeholder="Serie del Comprobante ">
                    @error('ser_serie') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="ser_numero">Numero</label>
                    <input wire:model="ser_numero" type="number" class="form-control" id="ser_numero"
                        placeholder="Numero del Comprobante">
                    @error('ser_numero') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>


            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                wire:click="resetInput">Cancelar</button>
            @if ($updateMode == false)
                <button type="button" wire:click.prevent="store_update()" class="btn btn-primary">Registrar</button>
            @else
                <button type="button" wire:click.prevent="store_update()" class="btn btn-warning">Modificar</button>
            @endif
        </div>
    </div>
</div>
</div>
