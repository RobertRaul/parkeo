@extends('adminlte::page')

@section('title', 'Clientes')

@section('content')
    <br>
    @livewire('clientes')
    @include('actions.modal') {{-- css para el color de los modals --}}
@stop

