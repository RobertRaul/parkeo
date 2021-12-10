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
{{-- 
                <div class="form-group">
                    <label>Tarifa Tiempo</label>
                    <select wire:model="tar_tiempo" class="form-control">
                        <option value="Elegir">Elegir</option>
                        <option value="Minutos">Minutos</option>
                        <option value="Hora">Hora</option>
                        <option value="Dia">Dia</option>
                    </select>
                    @error('tar_tiempo') <span class="error text-danger">{{ $message }}</span> @enderror
                </div> --}}

                {{-- <div class="form-group">
                    <label for="tar_valor">Valor del Tiempo en: </label> <label class="text-danger"> {{ $tar_tiempo }}</label>
                    <input wire:model="tar_valor" type="text" class="form-control" id="tar_valor">
                    @error('tar_valor') <span class="error text-danger">{{ $message }}</span> @enderror
                </div> --}}

                <div class="form-group">
                    <label for="tar_precio">Costo por Hora S/</label>: 
                    <input wire:model="tar_precio" type="text" class="form-control" id="tar_precio">
                    @error('tar_precio') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="tar_tolerancia">Tolerancia en minutos: </label>
                    <input wire:model="tar_tolerancia" type="text" class="form-control" id="tar_tolerancia">
                    @error('tar_tolerancia') <span class="error text-danger">{{ $message }}</span> @enderror
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
