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
                    <select class="form-control" wire:model="us_rol">
                        <option value="Elegir">Elegir</option>
                        <option value="Empleado">Empleado</option>
                        <option value="Administrador">Administrador</option>
                    </select>
                    @error('us_rol') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Empleado</label>
                    <select class="form-control" id="cbousuarios" style="width: 100%" wire:model.defer="us_empid">
                        <option value="Elegir">Elegir</option>
                        @foreach ($empleados as $e)
                            <option value="{{ $e->emp_id }}">{{ $e->emp_nombres }}</option>
                        @endforeach
                    </select>
                    @error('us_empid') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
            </form>
            {{ $us_empid }}

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="cancel()">Cancelar</button>
            @if ($updateMode == false)
                <button type="button" wire:click.prevent="store_update()" class="btn btn-primary">Registrar</button>
            @else
                <button type="button" wire:click.prevent="store_update()" class="btn btn-warning">Modificar</button>
            @endif
        </div>
    </div>
</div>
</div>

@section('js')
    <script>
        $(document).ready(function() {
            $('#cbousuarios').select2({
                dropdownParent: $('#Modal')
            });
            $('#cbousuarios').on('change', function(e) {
                var data = $('#cbousuarios').select2("val");
                @this.set('us_empid', data);
            });


            $('.cbousuarios').val(@this.us_empid).trigger('change');
        });
    </script>
@endsection
