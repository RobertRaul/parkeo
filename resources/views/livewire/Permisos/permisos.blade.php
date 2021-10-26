<div class="tab-pane fade {{ $tab == 'permisos' ? 'show active' : '' }}" id="permisos_listado" role="tabpanel">
    <div class="row">
        <div class="col-sm-12 col-md-7">
            <h6 class="text-center"><b>Listado de Permisos</b></h6>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-trash-alt"></i>
                    </span>
                </div>
                <input type="text" id="permisoName" class="form-control" autocomplete="off">
                <input type="hidden" id="permisoId">
                <div class="input-group-prepend">
                    <span class="input-group-text" wire:click="CrearRol($('#permisoName').val(), $('#permisoId').val())">
                        <i class="fas fa-save"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table id="tblPermisos" class="table table-striped table-bordered dt-responsive nowrap">
                <thead>
                    <tr class="text-center">Permisos</tr>
                    <tr class="text-center">Roles<br>Con el Permiso</tr>
                    <tr class="text-center">Acciones</tr>
                    <tr class="text-center">
                        <div class="n-check">
                            <label class="new-control new-checkbox checkbox-primary">
                            <input type="checkbox" class="new-control-input seleccionar-todos">
                            <span class="new-control-indicator">Todos</span>
                            </label>
                        </div>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permisos as $p)
                        <tr>
                            <td> {{$p->name}} </td>
                            <td class="text-center"> {{\App\Models\User::permission($p->name)->count()}} </td>
                            <td class="text-center">
                                <span style="cursor: pointer" onclick="showPermission('{{$p}}')">
                                    <i class="fas fa-pencil-alt text-center"></i>
                                </span>

                                @if (\App\Models\User::permission($p->name)->count() <=0)
                                    <a href="javascript:void(0)" onclick="Confirmar('{{$p->id}}')" title="Eliminar Permiso">
                                    <i class="fas fa-trash text-center"></i>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="n-check" id="divPermisos">
                                    <label class="new-control new-checkbox checkbox-primary">
                                        <input data-name="{{$p->name}} " type="checkbox-rol" class="new-control-input checkbox-rol">
                                        <span class="new-control-indicator">
                                            Asignar
                                        </span>
                                    </label>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-sm-12 col-md-5">
        <h6 class="text-left"><b>Elegir Usuario</b></h6>
        <div class="input-group">
            <select wire:model="rolSelected" id="rolesSelected" class="form-control">
                <option value="Seleccionar">Seleccionar</option>
                @foreach ($roles as $r)
                    <option value="{{$r->id}}"> {{$r->rol_name}} </option>
                @endforeach
            </select>
        </div>

        <button type="button" onclick="AsignarRoles()" class="btn btn-primary mt-4">Asignar Permisos</button>
    </div>
</div>
