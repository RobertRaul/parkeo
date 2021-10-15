@extends('actions.listado')

@section('name_component')
    Tipos de Documento
@endsection

{{-------------------- CABECERA DE LA TABLA  -------------------}}

@section('table_header')
    <th class="text-center" wire:click="Header_Orderby('tpdi_id')" class="text-center" style="cursor: pointer;" >
        @include('actions.headerorder',['campo_a_ordenar' => 'tpdi_id'])  Id</th>

    <th class="text-center" wire:click="Header_Orderby('tpdi_desc')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'tpdi_desc'])  Descripcion</th>

    <th class="text-center" wire:click="Header_Orderby('tpdi_estado')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'tpdi_estado']) Estado</th>

    <th class="text-center">Acciones</th>
@endsection

{{-------------------- CUERPO DE LA TABLA  -------------------}}
@section('table_body')
        @foreach ($data as $d)
            <tr>
                <td class="text-center">{{$d->tpdi_id }} </td>

                <td>{{$d->tpdi_desc }} </td>

                <td class="text-center">
                    @if ($d->tpdi_estado =='Activo')
                        <h5><span class="badge badge-success">{{ $d->tpdi_estado }}</span></h5>
                    @else
                        <h5><span class="badge badge-danger">{{ $d->tpdi_estado }}</span></h5>
                    @endif
                </td>

                <td class="text-center">
                    @if ($d->tpdi_estado=='Activo')
                        @if ($selected_id==$d->tpdi_id)
                            <button wire:click="Desactivar_Activar({{ $d->tpdi_id }},'Desactivado')" type="button" class="btn btn-secondary"><i class="fa fa-check"></i></button>
                        @else
                            <button wire:click="Confirmar_Desactivar({{ $d->tpdi_id }})" type="button" class="btn btn-danger"><i class="fas fa-arrow-down"></i>
                            </button>
                        @endif
                    @else
                        @if ($selected_id==$d->tpdi_id)
                        <button wire:click="Desactivar_Activar({{ $d->tpdi_id }},'Activo')" type="button" class="btn btn-secondary"><i class="fas fa-check"></i></i></button>
                        @else
                            <button wire:click="Confirmar_Desactivar({{ $d->tpdi_id }})" type="button" class="btn btn-success"><i class="fas fa-arrow-up"></i>

                            </button>
                        @endif
                    @endif
                </td>
            </tr>
        @endforeach
@endsection
