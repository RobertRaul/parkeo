@extends('actions.listado')

@section('name_component')
    Tarifas
@endsection

@section('button_new')
    @include('actions.btnnuevo-modal')
@endsection

@section('card_body')
    @include('livewire.tarifas.crear')
@endsection

@section('table_header')
    <th class="text-center" wire:click="Header_Orderby('tar_id')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'tar_id']) Id</th>

    <th class="text-center" wire:click="Header_Orderby('tar_desc')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'tar_desc']) Tarifa</th>

    <th class="text-center" wire:click="Header_Orderby('tar_tiempo')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'tar_tiempo'])Tiempo</th>

    <th class="text-center" wire:click="Header_Orderby('tar_precio')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'tar_precio']) Precio</th>

    <th class="text-center" wire:click="Header_Orderby('tar_tipoid')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'tar_tipoid']) Tipo de Vehiculo</th>

    <th class="text-center" wire:click="Header_Orderby('tar_estado')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'tar_estado']) Estado</th>

    <th class="text-center">Acciones</th>
@endsection

@section('table_body')
    @foreach ($data as $d)
        <tr>
            <td class="text-center">{{ $d->tar_id }} </td>

            <td>{{ $d->tip_desc }} </td>

            <td>{{ $d->tar_tiempo }} </td>

            <td>{{ $d->tar_precio }} </td>

            <td>{{ $d->Tipos->tip_desc }} </td>

            <td class="text-center">
                @if ($d->tar_estado == 'Activo')
                    <h5><span class="badge badge-success">{{ $d->tar_estado }}</span></h5>
                @else
                    <h5><span class="badge badge-danger">{{ $d->tar_estado }}</span></h5>
                @endif
            </td>

            <td class="text-center">
                                {{----------------------------editar------------------------------------}}
                <button wire:click="edit({{ $d->tar_id}})" type="button" class="btn btn-warning" data-toggle="modal" data-target="#Modal">
                    <i class="fas fa-pencil-alt"></i>
                </button>
                                {{----------------------------activar desactivar------------------------------------}}
                @if ($d->tar_estado == 'Activo')
                    @if ($selected_id == $d->tar_id)
                        <button wire:click="Desactivar_Activar({{ $d->tar_id }},'Desactivado')" type="button"
                            class="btn btn-secondary"><i class="fa fa-check"></i></button>
                    @else
                        <button wire:click="Confirmar_Desactivar({{ $d->tar_id }})" type="button"
                            class="btn btn-danger"><i class="fas fa-arrow-down"></i>
                        </button>
                    @endif
                @else
                    @if ($selected_id == $d->tar_id)
                        <button wire:click="Desactivar_Activar({{ $d->tar_id }},'Activo')" type="button"
                            class="btn btn-secondary"><i class="fas fa-check"></i></i></button>
                    @else
                        <button wire:click="Confirmar_Desactivar({{ $d->tar_id }})" type="button"
                            class="btn btn-success"><i class="fas fa-arrow-up"></i>
                        </button>
                    @endif
                @endif
            </td>
        </tr>
    @endforeach
@endsection
