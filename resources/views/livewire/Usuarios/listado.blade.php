@extends('actions.listado')

@section('name_component')
<i class="fas fa-users-cog"></i>
    Usuarios
@endsection

@section('button_new')
    @include('actions.btnnuevo-modal')
@endsection

@section('card_body')
    @include('livewire.usuarios.crear')
@endsection

@section('table_header')
    <th class="text-center" wire:click="Header_Orderby('us_id')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'us_id']) Id</th>

    <th class="text-center" wire:click="Header_Orderby('us_usuario')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'us_usuario']) Usuario</th>

    <th class="text-center" wire:click="Header_Orderby('us_rol')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'us_rol']) Rol</th>

    <th class="text-center" wire:click="Header_Orderby('emp_apellidos')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'emp_apellidos']) Empleado</th>

    <th class="text-center" wire:click="Header_Orderby('us_fechr')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'us_fechr']) Fecha R.</th>

    <th class="text-center" wire:click="Header_Orderby('us_estado')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'us_estado']) Estado</th>

    <th class="text-center">Acciones</th>
@endsection

@section('table_body')
    @foreach ($data as $d)
        <tr>
            <td class="text-center">{{ $d->us_id }} </td>

            <td class="text-center" >{{ $d->us_usuario }} </td>

            <td class="text-center">{{ $d->us_rol }} </td>

            <td>{{ $d->Empleados->emp_apellidos}} {{ $d->Empleados->emp_nombres}} </td>

            <td class="text-center">{{ $d->us_fechr }}</td>

            <td class="text-center">
                @if ($d->us_estado == 'Activo')
                    <h5><span class="badge badge-success">{{ $d->us_estado }}</span></h5>
                @else
                    <h5><span class="badge badge-danger">{{ $d->us_estado }}</span></h5>
                @endif
            </td>

            <td class="text-center">
                                {{----------------------------editar------------------------------------}}
                <button wire:click="edit({{ $d->us_id}})" type="button" class="btn btn-warning" data-toggle="modal" data-target="#Modal">
                    <i class="fas fa-pencil-alt"></i>
                </button>
                                {{----------------------------activar desactivar------------------------------------}}
                @if ($d->us_estado == 'Activo')
                    @if ($selected_id == $d->us_id)
                        <button wire:click="Desactivar_Activar({{$d->us_id}},'Desactivado')" type="button"
                            class="btn btn-secondary"><i class="fa fa-check"></i></button>
                    @else
                        <button wire:click="Confirmar_Desactivar({{$d->us_id}})" type="button"
                            class="btn btn-danger"><i class="fas fa-arrow-down"></i>
                        </button>
                    @endif
                @else
                    @if ($selected_id == $d->us_id)
                        <button wire:click="Desactivar_Activar({{$d->us_id}},'Activo')" type="button"
                            class="btn btn-secondary"><i class="fas fa-check"></i></i></button>
                    @else
                        <button wire:click="Confirmar_Desactivar({{$d->us_id}})" type="button"
                            class="btn btn-success"><i class="fas fa-arrow-up"></i>
                        </button>
                    @endif
                @endif
            </td>
        </tr>
    @endforeach
@endsection

