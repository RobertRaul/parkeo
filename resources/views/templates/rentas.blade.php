@extends('adminlte::page')

@section('title', 'Rentas')

@section('content')
    <br>
    @livewire('rentas')
    @include('actions.badge')
    @include('actions.modal') {{-- css para el color de los modals --}}

@stop
