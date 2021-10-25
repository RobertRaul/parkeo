<div class="card text-center">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#roles_listado" data-toggle="pill" role="tab">
                    <i class="fas fa-user-tag"></i> Roles</a>
            </li>
            <li class="nav-item active" href="#permisos_listado" data-toggle="pill" role="tab">
                <a class="nav-link" href="#" data-toggle="pill" role="tab">Permisos</a>
            </li>
        </ul>
    </div>
    <div class="card-body">

        @include('livewire.permisos.permisos')

        @include('livewire.permisos.roles')

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
    function Confirm(id) {
        swal({
                title: 'Confirmar',
                text: '¿Deseas Eliminar el Rol?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                closeOnConfirm: false
            },
            function() {
                window.livewire.emit('EliminarRol', id)
                toastr.success("Rol Eliminado con exito", "Informe", {
                    timeOut: 2000
                })
                $('#rolName').val('')
                $('#rolId').val(0)
                $('#permisoName').val('')
                $('#permisoId').val(0)

                swal.close()
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

      window.livewire.emit('AisgnarRoles',rolesList)
    }

    document.addEventListener('DOMContentLoaded',function(){
      //escuchamos el evento del backend donde se ejecute activar tab
      window.livewire.on('activarTab',Tabname =>{
        var tab = "[href='" + Tabname+"']"
        $(tab).tab('show')
      })

      windows.livewire.on('msg-ok',msgText =>{

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
     function AsignarRoles()
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
     /* else if($('#userId option:selected').val() == 'Seleccionar') //validamos el combo que este seleccionado, roles.blade linea 63
      {
        toastr.error("Selecciona al menos un usuario","Informe",{ timeOut: 2000 })
        return;
      }*/





</script>
