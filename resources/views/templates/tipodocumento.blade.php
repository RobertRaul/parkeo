@extends('adminlte::page')

@section('title', 'Tipo Comprobante')

@section('content')
    <br>
    @livewire('tipo-documentos')
    @include('actions.modal') {{-- css para el color de los modals --}}
@stop
