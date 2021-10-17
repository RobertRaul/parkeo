@extends('adminlte::page')

@section('title', 'Empleados')

@section('content')
    <br>
    @livewire('empleados')
    @include('actions.modal') {{-- css para el color de los modals --}}
@stop

