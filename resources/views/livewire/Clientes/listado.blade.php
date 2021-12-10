@extends('actions.listado')

@section('name_component')
<i class="fas fa-user-friends"></i>
    Clientes
@endsection

@section('button_new')
    @include('actions.btnnuevo-modal')
@endsection

@section('card_body')
    @include('livewire.clientes.crear')
@endsection

@section('table_header')
    <th class="text-center" wire:click="Header_Orderby('clie_id')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'clie_id']) Id</th>

    <th class="text-center" wire:click="Header_Orderby('tpdi_desc')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'tpdi_desc']) Tp. Documento</th>

    <th class="text-center" wire:click="Header_Orderby('clie_numdoc')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'clie_numdoc'])Nro Documento</th>

    <th class="text-center" wire:click="Header_Orderby('clie_nombres')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'clie_nombres']) Nombres</th>

    <th class="text-center" wire:click="Header_Orderby('clie_celular')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'clie_celular']) Celular</th>

    <th class="text-center" wire:click="Header_Orderby('clie_email')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'clie_email']) Email</th>

    <th class="text-center" wire:click="Header_Orderby('clie_estado')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'clie_estado']) Estado</th>

    <th class="text-center">Acciones</th>
@endsection

@section('table_body')
    @foreach ($data as $d)
        <tr>
            <td class="text-center">{{ $d->clie_id }} </td>
            <td class="text-center">{{ $d->tpdi_desc }} </td>
            <td class="text-center">{{ $d->clie_numdoc }} </td>
            <td>{{ $d->clie_nombres }} </td>
            <td class="text-center">{{ $d->clie_celular }} </td>
            <td class="text-center">{{ $d->clie_email }} </td>

            <td class="text-center">
                @if ($d->clie_estado == 'Activo')
                    <h5><span class="badge badge-success">{{ $d->clie_estado }}</span></h5>
                @else
                    <h5><span class="badge badge-danger">{{ $d->clie_estado }}</span></h5>
                @endif
            </td>

            <td class="text-center">
                                {{----------------------------editar------------------------------------}}
                <button wire:click="edit({{ $d->clie_id}})" type="button" class="btn btn-warning" data-toggle="modal" data-target="#Modal">
                    <i class="fas fa-pencil-alt"></i>
                </button>
                                {{----------------------------activar desactivar------------------------------------}}
                @if ($d->clie_estado == 'Activo')
                    @if ($selected_id == $d->clie_id)
                        <button wire:click="Desactivar_Activar({{ $d->clie_id }},'Desactivado')" type="button"
                            class="btn btn-secondary"><i class="fa fa-check"></i></button>
                    @else
                        <button wire:click="Confirmar_Desactivar({{ $d->clie_id }})" type="button"
                            class="btn btn-danger"><i class="fas fa-arrow-down"></i>
                        </button>
                    @endif
                @else
                    @if ($selected_id == $d->clie_id)
                        <button wire:click="Desactivar_Activar({{ $d->clie_id }},'Activo')" type="button"
                            class="btn btn-secondary"><i class="fas fa-check"></i></i></button>
                    @else
                        <button wire:click="Confirmar_Desactivar({{ $d->clie_id }})" type="button"
                            class="btn btn-success"><i class="fas fa-arrow-up"></i>
                        </button>
                    @endif
                @endif
            </td>
        </tr>
    @endforeach
@endsection
