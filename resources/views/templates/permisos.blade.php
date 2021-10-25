@extends('adminlte::page')

@section('title', 'Permisos')

@section('content')
    <br>
    @livewire('permisos')
    @include('actions.modal') {{-- css para el color de los modals --}}
@stop

