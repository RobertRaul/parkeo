@extends('adminlte::page')

@section('title', 'Egresos')

@section('content')
    <br>
    @livewire('egresos')
    @include('actions.modal') {{-- css para el color de los modals --}}
@stop

