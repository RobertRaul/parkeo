@extends('adminlte::page')

@section('title', 'Tipo Comprobante')

@section('content')
    <br>
    @livewire('tipo-comprobantes')
    @include('actions.modal') {{-- css para el color de los modals --}}
@stop
