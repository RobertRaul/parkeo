@if ($accion == 'registrar')
        <div class="card card-success">
    @else
        <div class="card card-warning">
@endif

<div class="card-header">
    @if ($accion == 'registrar')
        <h6 class="card-tittle">Nuevo Usuario</h6>
    @else
        <h6 class="card-tittle">Editar Usuario</h6>
    @endif
</div>

<div class="card-body form-row">
    <div class="col-md-2 mb-3">
        <label for="us_usuario">Usuario</label>
        <input wire:model="us_usuario" type="text" class="form-control" id="us_usuario" placeholder="Usuario">
        @error('us_usuario') <span class="error text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="col-md-2 mb-3">
        <label for="us_password">Password</label>
        <input wire:model="us_password" type="password" class="form-control" id="us_password"
            placeholder="Contraseña">
        @error('us_password') <span class="error text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="col-md-2 mb-3">
        <label for="us_rol">Rol</label>
        <select class="form-control">
            <option value="Elegir">Elegir</option>
            <option value="Empleado">Empleado</option>
            <option value="Administrador">Administrador</option>
        </select>
        @error('us_rol') <span class="error text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="col-md-2 mb-3" wire:ignore wire:key="us_empid">
        <label>Empleado</label>
        <select class="form-control" id="cboempleado">
            <option value="Elegir">Elegir</option>
            @foreach ($empleados as $e)
                <option value="{{ $e->emp_id }}">{{ $e->emp_nombres }}</option>
            @endforeach
        </select>
        @error('us_empid') <span class="error text-danger">{{ $message }}</span> @enderror
        {{ $us_empid }}
    </div>
</div>

<div class="card-footer">
    <button type="button" class="btn btn-secondary" wire:click="resetInput">Cancelar</button>
    @if ($accion == 'registrar')
        <button type="button" wire:click.prevent="store_update()" class="btn btn-primary">Registrar</button>
    @else
        <button type="button" wire:click.prevent="store_update()" class="btn btn-warning">Modificar</button>
    @endif
</div>
</div>

<script>
    $(document).ready(function() {
        $('#cboempleado').select2();
        $('#cboempleado').on('change', function(e) {
            var data = $('#cboempleado').select2("val");
            @this.set('us_empid', data);
        });

        $('#cboempleado').val(@this.us_empid).trigger('change');
    });
</script>
