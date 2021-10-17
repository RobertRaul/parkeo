@extends('adminlte::page')

@section('title', 'Cajones')

@section('content')
    <br>
    @livewire('cajones')
    @include('actions.modal') {{-- css para el color de los modals --}}
@stop

