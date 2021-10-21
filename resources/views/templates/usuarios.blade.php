@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content')
    <br>
    @livewire('usuarios')
    @include('actions.modal') {{-- css para el color de los modals --}}
@stop
