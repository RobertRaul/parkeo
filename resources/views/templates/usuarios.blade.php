@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content')
    <br>
    @livewire('usuarios')
    @include('actions.modal') {{-- css para el color de los modals --}}
@stop


{{-- EN LA FUNCION EDITAR, NO RECUPERA EL NOMBRE DEL EMPLEADO, SOLO RECUPERA EL 1 Y NO SE MUESTRA EL NOMBRE EN EL SELECT2 --}}
