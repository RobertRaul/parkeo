@extends('adminlte::page')

@section('title', 'Configuraciones')

@section('content')
    <br>
    @livewire('empresas')
    @include('actions.modal') {{-- css para el color de los modals --}}
@stop

