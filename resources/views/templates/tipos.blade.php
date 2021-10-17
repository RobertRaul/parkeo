@extends('adminlte::page')

@section('title', 'Tipos')

@section('content')
    <br>
    @livewire('tipos')
    @include('actions.modal') {{-- css para el color de los modals --}}
@stop
