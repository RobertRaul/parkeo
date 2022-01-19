<div class="tab-pane fade {{ $tab == 'permisos' ? 'show active' : '' }}" id="permisos_listado" role="tabpanel">
    <div class="row">
        <div class="col-sm-12 col-md-7">
            <h6 class="text-center"><b>Listado de Permisos</b></h6>
            <div class="input-group mb-4">
                   
                <div class="input-group-prepend">
                    {{-- <span class="input-group-text">
                        <i class="fas fa-trash-alt"></i>
                    </span> --}}
                </div>
             <input type="text" id="permisoName" class="form-control" autocomplete="off" wire:keydown.enter="$emit('CrearPermiso',$('#permisoName').val(),$('#permisoId').val())">
                <input type="hidden" id="permisoId">
                <div class="input-group-prepend">
                    <span class="input-group-text" wire:click="$emit('CrearPermiso',$('#permisoName').val(),$('#permisoId').val())">
                        <i class="fas fa-save"></i>
                    </span>
                </div>
            </div>

        <div class="table-responsive">
            <table id="tblPermisos" class="table table-striped table-bordered dt-responsive nowrap">
                <thead>
                    <tr>
                        <th class="text-center">Permisos</th>
                        <th class="text-center">Roles Con el Permiso</th>
                        <th class="text-center">Acciones</th>
                        {{-- <th class="text-center">Acciones</th> --}}
                        <th class="text-center">
                            <div class="n-check">

                                <label for="">Todos</label>
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" class="custom-control-input seleccionar-todos" id="all_select">
                                    <label class="custom-control-label" for="all_select"></label>
                                </div>

                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permisos as $p)
                        <tr>
                            <td> {{$p->name}} </td>
                            <td class="text-center"> {{\App\Models\User::permission($p->name)->count()}} </td>
                            <td class="text-center">

                                 <button type="button" class="btn btn-warning" style="cursor: pointer" onclick="showPermission('{{$p}}')">
                                    <i class="fas fa-pencil-alt"></i>
                                </button> 

                              
                                @if (\App\Models\User::permission($p->name)->count() <=0)
                                <button type="button" class="btn btn-danger" onclick="Confirm_p('{{$p->id}}')">                                
                                    <i class="fas fa-trash text-center"></i>
                                </button>
                                @endif                       
                            </td>
                            <td class="text-center">

                                    {{-- ESTE ES UN CONTROL PERSONALIZADO DE ADMINLTE/forms/general elements --}}
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success" id="divPermisos">
                                        <input type="checkbox" class="custom-control-input" id="{{$p->id}}" data-name="{{$p->name}}"  {{ $p->checked ==  1 ? 'checked' : ''}}>
                                        <label class="custom-control-label" for="{{$p->id}}"></label>
                                    </div>
                            </td>
                        </tr>
                    @endforeach                    
                </tbody>
            </table>   
           
        </div>
    </div>

    <div class="col-sm-12 col-md-5">
        <h6 class="text-left"><b>Elegir Rol</b></h6>
        <div class="input-group">
            <select wire:model="rolSelected" id="rolesSelected" class="form-control">
                <option value="Seleccionar">Seleccionar</option>
                @foreach ($roles as $r)
                <option value="{{$r->id}}"> {{$r->name}} </option>
                @endforeach
            </select>
        </div>

        <button type="button" onclick="AsignarPermisos()" class="btn btn-primary mt-4">Asignar Permisos</button>
    </div>
</div>
