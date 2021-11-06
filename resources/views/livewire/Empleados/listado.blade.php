@extends('actions.listado')

@section('name_component')
    Empleados
@endsection

@section('button_new')
    @include('actions.btnnuevo-modal')
@endsection

@section('card_body')
    @include('livewire.empleados.crear')
@endsection

@section('table_header')
    <th class="text-center" wire:click="Header_Orderby('emp_id')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'emp_id']) Id</th>

    <th class="text-center" wire:click="Header_Orderby('emp_tpdi')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'emp_tpdi']) Tp. Documento</th>

    <th class="text-center" wire:click="Header_Orderby('emp_numdoc')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'emp_numdoc'])Nro Documento</th>

    <th class="text-center" wire:click="Header_Orderby('emp_apellidos')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'emp_apellidos']) Apellidos</th>

    <th class="text-center" wire:click="Header_Orderby('emp_nombres')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'emp_nombres']) Nombres</th>

    <th class="text-center" wire:click="Header_Orderby('emp_celular')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'emp_celular']) Celular</th>

    <th class="text-center" wire:click="Header_Orderby('emp_email')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'emp_email']) Email</th>

    <th class="text-center" wire:click="Header_Orderby('emp_direccion')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'emp_direccion']) Direccion</th>

    <th class="text-center" wire:click="Header_Orderby('emp_estado')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'emp_estado']) Estado</th>

    <th class="text-center">Acciones</th>
@endsection

@section('table_body')
    @foreach ($data as $d)
        <tr>
            <td class="text-center">{{ $d->emp_id }} </td>
            <td>{{ $d->tpdi_desc }} </td>
            <td>{{ $d->emp_numdoc }} </td>
            <td>{{ $d->emp_apellidos }} </td>
            <td>{{ $d->emp_nombres }} </td>
            <td>{{ $d->emp_celular }} </td>
            <td>{{ $d->emp_email }} </td>
            <td>{{ $d->emp_direccion }} </td>

            <td class="text-center">
                @if ($d->emp_estado == 'Activo')
                    <h5><span class="badge badge-success">{{ $d->emp_estado }}</span></h5>
                @else
                    <h5><span class="badge badge-danger">{{ $d->emp_estado }}</span></h5>
                @endif
            </td>

            <td class="text-center">
                                {{----------------------------editar------------------------------------}}
                <button wire:click="edit({{ $d->emp_id}})" type="button" class="btn btn-warning" data-toggle="modal" data-target="#Modal">
                    <i class="fas fa-pencil-alt"></i>
                </button>
                                {{----------------------------activar desactivar------------------------------------}}
                @if ($d->emp_estado == 'Activo')
                    @if ($selected_id == $d->emp_id)
                        <button wire:click="Desactivar_Activar({{ $d->emp_id }},'Desactivado')" type="button"
                            class="btn btn-secondary"><i class="fa fa-check"></i></button>
                    @else
                        <button wire:click="Confirmar_Desactivar({{ $d->emp_id }})" type="button"
                            class="btn btn-danger"><i class="fas fa-arrow-down"></i>
                        </button>
                    @endif
                @else
                    @if ($selected_id == $d->emp_id)
                        <button wire:click="Desactivar_Activar({{ $d->emp_id }},'Activo')" type="button"
                            class="btn btn-secondary"><i class="fas fa-check"></i></i></button>
                    @else
                        <button wire:click="Confirmar_Desactivar({{ $d->emp_id }})" type="button"
                            class="btn btn-success"><i class="fas fa-arrow-up"></i>
                        </button>
                    @endif
                @endif
            </td>
        </tr>
    @endforeach
@endsection
