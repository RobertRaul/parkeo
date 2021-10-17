@extends('adminlte::page')

@section('title', 'Tarifas')

@section('content')
    <br>
    @livewire('tarifas')
    @include('actions.modal') {{-- css para el color de los modals --}}
@stop
