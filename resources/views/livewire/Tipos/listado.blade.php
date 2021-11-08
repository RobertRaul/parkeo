@extends('actions.listado')

@section('name_component')
Tipos de Vehiculos
@endsection

@section('button_new')
@include('actions.btnnuevo-modal')
@endsection

@section('card_body')
@include('livewire.tipos.crear')
@endsection


{{-------------------- CABECERA DE LA TABLA  -------------------}}

@section('table_header')
<th class="text-center" wire:click="Header_Orderby('tip_id')" class="text-center" style="cursor: pointer;">
    @include('actions.headerorder',['campo_a_ordenar' => 'tip_id']) Id</th>

<th class="text-center" wire:click="Header_Orderby('tip_desc')" class="text-center" style="cursor: pointer;">
    @include('actions.headerorder',['campo_a_ordenar' => 'tip_desc'])Vehiculos</th>

<th class="text-center" wire:click="Header_Orderby('tip_img')" class="text-center" style="cursor: pointer;">
    @include('actions.headerorder',['campo_a_ordenar' => 'tip_img']) Imagen</th>

<th class="text-center" wire:click="Header_Orderby('tip_estado')" class="text-center" style="cursor: pointer;">
    @include('actions.headerorder',['campo_a_ordenar' => 'tip_estado']) Estado</th>

<th class="text-center">Acciones</th>
@endsection

{{-------------------- CUERPO DE LA TABLA  -------------------}}
@section('table_body')
@foreach ($data as $d)
<tr>
    <td class="text-center">{{$d->tip_id }} </td>

    <td class="text-center">{{$d->tip_desc }} </td>

    <td class="text-center" style="width:350px;">
        @if (!@empty($d->tip_img))
        <img with="100px" src="{{ url('images/tipos_tumb/'. $d->tip_img) }}" alt="">
        @else
        Sin Foto Registrada
        @endif
    </td>

    <td class="text-center">
        @if ($d->tip_estado =='Activo')
        <h5><span class="badge badge-success">{{ $d->tip_estado }}</span></h5>
        @else
        <h5><span class="badge badge-danger">{{ $d->tip_estado }}</span></h5>
        @endif
    </td>

    <td class="text-center">
        {{----------------------------editar------------------------------------}}
        <button wire:click="edit({{ $d->tip_id}})" type="button" class="btn btn-warning" data-toggle="modal"
            data-target="#Modal">
            <i class="fas fa-pencil-alt"></i>
        </button>
        {{----------------------------activar desactivar------------------------------------}}
        @if ($d->tip_estado=='Activo')
        @if ($selected_id==$d->tip_id)
        <button wire:click="Desactivar_Activar({{ $d->tip_id }},'Desactivado')" type="button"
            class="btn btn-secondary"><i class="fa fa-check"></i></button>
        @else
        <button wire:click="Confirmar_Desactivar({{ $d->tip_id }})" type="button" class="btn btn-danger"><i
                class="fas fa-arrow-down"></i>
        </button>
        @endif
        @else
        @if ($selected_id==$d->tip_id)
        <button wire:click="Desactivar_Activar({{ $d->tip_id }},'Activo')" type="button" class="btn btn-secondary"><i
                class="fas fa-check"></i></i></button>
        @else
        <button wire:click="Confirmar_Desactivar({{ $d->tip_id }})" type="button" class="btn btn-success"><i
                class="fas fa-arrow-up"></i>

        </button>
        @endif
        @endif
    </td>
</tr>
@endforeach
@endsection
