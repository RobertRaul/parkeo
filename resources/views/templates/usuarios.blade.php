@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content')
    <br>
    @livewire('usuarios')
    @include('actions.modal') {{-- css para el color de los modals --}}
@stop


{{-- EN LA FUNCION EDITAR, NO RECUPERA EL NOMBRE DEL EMPLEADO, SOLO RECUPERA EL 1 Y NO SE MUESTRA EL NOMBRE EN EL SELECT2 --}}


<script>
    document.addEventListener('DOMContentLoaded',function()
    {
        //el evento print se emite en la linea 192 del controlador Rentas
        window.livewire.on('pdf_usuarios', report =>
        {
            //var ruta="{{ url('imprimir/pdf') }}"
            var ruta="{{ url('reportes/usuarios/') }}"
            var w =window.open(ruta,"_blank","=width1,height=1")
            //w.close()//cierra la ventana de impresion
        })
    })
</script>



