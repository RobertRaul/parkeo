@extends('adminlte::page')

@section('title', 'Caja')

@section('content')
    <br>
    @livewire('cajas')
    @include('actions.modal') {{-- css para el color de los modals --}}
@stop

