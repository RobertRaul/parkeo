@extends('adminlte::page')

@section('title', 'Series')

@section('content')
    <br>
    @livewire('series')
    @include('actions.modal') {{-- css para el color de los modals --}}
@stop
