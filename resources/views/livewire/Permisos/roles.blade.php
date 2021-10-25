<div class="tab-pane fade show active" id="roles_listado" role="tabpanel">
    <div class="row">
        <div class="col-sm-12 col-md-7">
            <h6 class="text-center"><b>Listado de Roles</b></h6>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-trash-alt"></i>
                    </span>
                </div>
                <input type="text" id="rolName" class="form-control" autocomplete="off">
                <input type="hidden" id="rolId">
                <div class="input-group-prepend">
                    <span class="input-group-text" wire:click="$emit('CrearRole',$('#rolName').val(), $('#rolId').val())">
                        <i class="fas fa-save"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table id="tblRoles" class="table table-striped table-bordered dt-responsive nowrap">
                <thead>
                    <tr class="text-center">Rol</tr>
                    <tr class="text-center">Usuarios<br>Asignados</tr>
                    <tr class="text-center">Acciones</tr>
                    <tr class="text-center"></tr>
                </thead>
                <tbody>
                    @foreach ($roles as $r)
                        <tr>
                            <td> {{$r->name}} </td>
                            <td class="text-center"> {{\App\User::role($r->name)->count()}} </td>
                            <td class="text-center">
                                <span style="cursor: pointer" onclick="showRole('{{$r}}')">
                                    <i class="fas fa-pencil-alt text-center"></i>
                                </span>

                                @if (\App\User::role($r->name)->count() <=0)
                                    <a href="javascript:void(0)" onclick="Confirmar('{{$r->id}}')" title="Eliminar Role">
                                    <i class="fas fa-trash text-center"></i>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="n-check" id="divRoles">
                                    <label class="new-control new-checkbox checkbox-primary">
                                        <input data-name="{{$r->name}} " type="checkbox-rol" class="new-control-input checkbox-rol">
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
            <select wire:model="userSelected" id="userId" class="form-control">
                <option value="Seleccionar">Seleccionar</option>
                @foreach ($usuarios as $u)
                    <option value="{{$u->us_id}}"> {{$u->us_usuario}} </option>
                @endforeach
            </select>
        </div>

        <button type="button" onclick="AsignarRoles()" class="btn btn-primary mt-4">Asignar Roles</button>
    </div>
</div>
