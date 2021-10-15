@extends('actions.listado')

@section('name_component')
    Cajones
@endsection

@section('button_new')
    @include('actions.btnnuevo-modal')
@endsection

@section('card_body')
    @include('livewire.cajones.crear')
@endsection

@section('table_header')
    <th class="text-center" wire:click="Header_Orderby('caj_id')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'caj_id']) Id</th>

    <th class="text-center" wire:click="Header_Orderby('caj_desc')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'caj_desc']) Caja</th>
    
    <th class="text-center" wire:click="Header_Orderby('caj_estado')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'caj_estado']) Estado</th>

    <th class="text-center">Acciones</th>
@endsection

@section('table_body')
    @foreach ($data as $d)
        <tr>
            <td class="text-center">{{ $d->caj_id }} </td>

            <td>{{ $d->caj_desc }} </td>

            <td class="text-center">
                @if ($d->caj_estado == 'Libre')
                    <h5><span class="badge badge-success">{{ $d->caj_estado }}</span></h5>
                @else
                    <h5><span class="badge badge-danger">{{ $d->caj_estado }}</span></h5>
                @endif
            </td>

            <td class="text-center">
                                {{----------------------------editar------------------------------------}}
                <button wire:click="edit({{ $d->caj_id}})" type="button" class="btn btn-warning" data-toggle="modal" data-target="#Modal">
                    <i class="fas fa-pencil-alt"></i>
                </button>
                                {{----------------------------activar desactivar------------------------------------}}             
                @if ($d->caj_estado == 'Libre')
                    @if ($selected_id == $d->caj_id)
                        <button wire:click="Desactivar_Activar({{ $d->caj_id }},'Ocupado')" type="button"
                            class="btn btn-secondary"><i class="fa fa-check"></i></button>
                    @else
                        <button wire:click="Confirmar_Desactivar({{ $d->caj_id }})" type="button"
                            class="btn btn-danger"><i class="fas fa-arrow-down"></i>
                        </button>
                    @endif
                @else
                    @if ($selected_id == $d->caj_id)
                        <button wire:click="Desactivar_Activar({{ $d->caj_id }},'Libre')" type="button"
                            class="btn btn-secondary"><i class="fas fa-check"></i></i></button>
                    @else
                        <button wire:click="Confirmar_Desactivar({{ $d->caj_id }})" type="button"
                            class="btn btn-success"><i class="fas fa-arrow-up"></i>
                        </button>
                    @endif
                @endif                           
            </td>
        </tr>
    @endforeach
@endsection
