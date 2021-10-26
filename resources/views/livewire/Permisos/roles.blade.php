<div class="tab-pane fade {{ $tab == 'roles' ? 'show active' : '' }}" id="roles_listado" role="tabpanel">
    <div class="row">
        <div class="col-sm-12 col-md-7 mb-4">
            <h6 class="text-center"><b>Listado de Roles</b></h6>
            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-trash-alt"></i>
                    </span>
                </div>
                <input type="text" id="rolName" class="form-control" autocomplete="off">
                <input type="text" id="rolId">
                <div class="input-group-prepend">
                    <span class="input-group-text" wire:click="$emit('CrearRol',$('#rolName').val(), $('#rolId').val())">
                        <i class="fas fa-save"></i>
                    </span>
                </div>
            </div>

              <div class="table-responsive">
                <table id="tblroles" class="table table-striped table-bordered dt-responsive nowrap mb-4">
                    <thead>
                        <tr>
                            <th class="text-center">Rol</th>
                            <th class="text-center">Asignados</th>
                            <th class="text-center">Acciones</th>
                            <th class="text-center">Todos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $r)
                        <tr>
                            <td> {{$r->name}} </td>
                            <td class="text-center"> {{\App\Models\User::role($r->name)->count()}}</td>
                            <td class="text-center">
                                <span style="cursor: pointer" onclick="showRole('{{$r}}')">
                                    <i class="fas fa-pencil-alt text-center"></i>
                                </span>

                                @if (\App\Models\User::role($r->name)->count()<=0) <a href="javascript:void(0)"
                                    onclick="Confirm('{{$r->id}}')" title="Eliminar Role">
                                    <i class="fas fa-trash text-center"></i>
                                    @endif
                            </td>

                            <td class="text-center">

                                {{-- ESTE ES UN CONTROL PERSONALIZADO DE ADMINLTE/forms/general elements --}}
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success" id="divRoles">
                                    <input type="checkbox" class="custom-control-input" id="{{$r->id}}" data-name="{{$r->name}}"  {{ $r->checked ==  1 ? 'checked' : ''}}>
                                    <label class="custom-control-label" for="{{$r->id}}"></label>
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
</div>
