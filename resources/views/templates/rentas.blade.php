@extends('adminlte::page')

@section('title', 'Rentas')

@section('content')
    <br>
    @livewire('rentas')
    @include('actions.badge')
@stop

