<div class="card text-center">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">

            <li class="nav-item">
                <a href="#roles_listado" class="nav-link {{ $tab == 'roles' ? 'active' : ''}}" data-toggle="pill"
                    role="tab" wire:click="$set('tab','roles')">
                    <i class="fas fa-user-tag"></i> Roles</a>
            </li>
            <li class="nav-item">
                <a href="#permisos_listado" class="nav-link {{ $tab == 'permisos' ? 'active' : ''}}" data-toggle="pill"
                    role="tab" wire:click="$set('tab','permisos')">
                    <i class="fas fa-key"></i>Permisos</a>
            </li>

            {{-- con el wire:click($set), cambiamos el valor de la variable "tab" a permisos, la variable tab se
            encuentra en livewire/permisos.php --}}
        </ul>
    </div>
    <div class="card-body">
        @if ($tab =='roles')
        @include('livewire.permisos.roles')
        @else
        @include('livewire.permisos.permisos')
        @endif
    </div>
</div>

<script>
    //-------------------------------------------- FUNCIONES PARA ROLES ---------------------------------------//

    //poner los id y nombres a los input ocultos
    function showRole(role) {
        var data = JSON.parse(role)
        $('#rolName').val(data['name']); //roles.blade linea 11
        $('#rolId').val(data['id']) //roles.blade linea 12
    }
    //limpiar el input y el id
    function clearRoleSelected() {
        $('#rolName').val('') //roles.blade linea 11
        $('#rolId').val(0) //roles.blade linea 12
        $('#rolName').focus() //roles.blade linea 11 focusea al momento de terminar
    }


    //funcion eliminar roles
    function Confirm(id)
    {
        Swal.fire({
                title: 'Confirmar',
                text: '¿Deseas Eliminar el Rol?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
            }).then((result)=>{
                if (result.value)
                {
                    window.livewire.emit('destroyRol', id)
                    swal.close()
                }
            })
    }
    //obtenemos los checks de la tabla tblRoles para registrarlos
    function AsignarRoles()
    {
      var rolesList = []
      $('#tblroles').find('input[type=checkbox]:checked').each(function(){
        rolesList.push($(this).attr('data-name'))  //recupera el input dela linea 46 roles.blade
      })
      if(rolesList.length<1)
      {
        toastr.error("Selecciona al menos un rol","Informe",{ timeOut: 2000 })
        return;
      }
      else if($('#userId option:selected').val() == 'Seleccionar') //validamos el combo que este seleccionado, roles.blade linea 63
      {
        toastr.error("Selecciona al menos un usuario","Informe",{ timeOut: 2000 })
        return;
      }

      window.livewire.emit('AsignarRoles',rolesList)
      //funcion para desactivar todos los checkboxes despues de la carga
      //es necesario por que no algunos checkboxes no se desactivan solos
      $('table#tblroles input[type=checkbox]').attr('disabled','true');
    }

    document.addEventListener('DOMContentLoaded',function(){
      //escuchamos el evento del backend donde se ejecute activar tab
      window.livewire.on('activarTab',Tabname =>{
        var tab = "[href='" + Tabname+"']"
        $(tab).tab('show')
      })

    window.livewire.on('msgOK',msgText =>{
        $('#permisoName').val('')
        $('#permisoId').val(0)
        $('#rolName').val('')
        $('#rolId').val(0)
      })

      //en el cuerpo buscamos un click que tenga la clase "seleccionar todos"
      $('body').on('click','.seleccionar-todos',function(){
        //verificamos si esta chekeado o no
        var estado = $(this).is(':checked') ? true : false;
        //buscamos todos lo checkbox en la tabla tblPermisos con el "each"
        $('#tblPermisos').find('input[type=checkbox]').each(function(e){
            //cambiamos el valor de los checkbox de acuerdo a si el todos esta checkeado o no
            $(this).prop('checked',estado)
        })

      })
    })
//-------------------------------------------- FUNCIONES PARA PERMISOS ---------------------------------------//
    function showPermission(permission) {
        var data = JSON.parse(permission)
        $('#permisoName').val(data['name']); //permisos.blade linea 11
        $('#permisoId').val(data['id']) //permisos.blade linea 12
    }

    function clearPermissionSelected() {
        $('#permisoName').val('') //permisos.blade linea 11
        $('#permisoId').val(0) //permisos.blade linea 12
        $('#permisoName').focus() //permisos.blade linea 11 focusea al momento de terminar
    }

    //obtenemos los checks de la tabla tblRoles para registrarlos
    function AsignarPermisos()
    {
      var permisosList = []
      $('#tblPermisos').find('input[type=checkbox]:checked').each(function(){
        permisosList.push($(this).attr('data-name'))  //recupera el input dela linea 46 roles.blade
      })
      if(permisosList.length<1)
      {
        toastr.error("Selecciona al menos un permiso","Informe",{ timeOut: 2000 })
        return;
      }
      if($('#rolesSelected option:selected').val() == 'Seleccionar') //validamos el combo que este seleccionado, roles.blade linea 63
      {
        toastr.error("Selecciona al menos un rol","Informe",{ timeOut: 2000 })
        return;
      }

      window.livewire.emit('AsignarPermisos',permisosList) //$('#rolesSelected :option:selected').val()
    //funcion para desactivar todos los checkboxes despues de la carga
      //es necesario por que no algunos checkboxes no se desactivan solos
        $('table#tblPermisos input[type=checkbox]').attr('disabled','true');
    }


</script>
