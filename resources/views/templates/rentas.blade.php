@extends('adminlte::page')


@section('title', 'Rentas')

@section('content')
    <br>
    @livewire('rentas')
    @include('actions.modal') {{-- modals --}}
    @include('actions.badge') {{-- modals --}}
@stop



