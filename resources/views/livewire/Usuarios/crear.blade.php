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
                    Registrar Usuarios
                @else
                    Modificar Usuarios
                @endif
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form>

                <div class="form-group">
                    <label for="us_usuario">Usuario</label>
                    <input wire:model="us_usuario" type="text" class="form-control" id="us_usuario"
                        placeholder="Usuario">
                    @error('us_usuario') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="us_password">Password</label>
                    <input wire:model="us_password" type="password" class="form-control" id="us_password"
                        placeholder="Contraseña">
                    @error('us_password') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="us_rol">Rol</label>
                    <select class="form-control">
                        <option value="Elegir">Elegir</option>
                        <option value="Empleado">Empleado</option>
                        <option value="Administrador">Administrador</option>
                    </select>
                    @error('us_rol') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Rol</label>
                    <select wire:model.lazy="us_empid" class="form-control" id="emp">
                        <option value="Elegir">Elegir</option>
                        @foreach ($empleados as $e)
                            <option value="{{ $e->emp_id }}">{{ $e->emp_apellidos }} {{ $e->emp_nombres }}
                            </option>
                        @endforeach
                    </select>
                    @error('us_empid') <span class="error text-danger">{{ $message }}</span> @enderror
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


<script>

    $(document).ready(function() {
    $('.emp').select2();
});

</script>

