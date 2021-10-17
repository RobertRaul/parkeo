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
                    Registrar Empleados
                @else
                    Modificar Empleados
                @endif
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form>
                <div class="form-row">
                    <div class="col-md-6">
                        <label>Tp. Documento</label>
                        <select wire:model="emp_tpdi" class="form-control">
                            <option value="Elegir">Elegir</option>
                            @foreach ($tipodocumento as $td)
                                <option value="{{ $td->tpdi_id }}">{{ $td->tpdi_desc }} </option>
                            @endforeach
                        </select>
                        @error('emp_tpdi') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="emp_numdoc">Numero de Documento</label>
                        <input wire:model="emp_numdoc" type="text" class="form-control" id="emp_numdoc"
                            placeholder="N° Documento">
                        @error('emp_numdoc') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="emp_apellidos">Apellidos</label>
                    <input wire:model="emp_apellidos" type="text" class="form-control" id="emp_apellidos"
                        placeholder="Apellidos del Empleado">
                    @error('emp_apellidos') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="emp_nombres">Nombres</label>
                    <input wire:model="emp_nombres" type="text" class="form-control" id="emp_nombres"
                        placeholder="Nombres">
                    @error('emp_nombres') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="emp_celular">Celular</label>
                    <input wire:model="emp_celular" type="text" class="form-control" id="emp_celular"
                        placeholder="Celular">
                    @error('emp_celular') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="emp_email">Email</label>
                    <input wire:model="emp_email" type="text" class="form-control" id="emp_email" placeholder="Email">
                    @error('emp_email') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="emp_direccion">Direccion</label>
                    <input wire:model="emp_direccion" type="text" class="form-control" id="emp_direccion"
                        placeholder="Direccion">
                    @error('emp_direccion') <span class="error text-danger">{{ $message }}</span> @enderror
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

