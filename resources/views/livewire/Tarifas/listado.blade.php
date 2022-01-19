@extends('actions.listado')

@section('name_component')
    <i class="fas fa-money-bill"></i>
    Tarifas
@endsection

@section('button_new')
    @include('actions.btnnuevo-modal',['nuevo' =>'tarifas_nuevo'])
@endsection

@section('card_body')
    @include('livewire.tarifas.crear')
@endsection

@section('btn_reports')
    @include('actions.btnreportes', ['reports' => 'tarifas_reportes'])
@endsection

@section('table_header')
    <th class="text-center" wire:click="Header_Orderby('tar_id')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'tar_id']) Id</th>

    <th class="text-center" wire:click="Header_Orderby('tar_tiempo')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'tar_tiempo'])Tiempo</th>

    <th class="text-center" wire:click="Header_Orderby('tar_precio')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'tar_precio']) Costo por Hora</th>

    <th class="text-center" wire:click="Header_Orderby('tar_tolerancia')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'tar_tolerancia']) Tolerancia en Minutos</th>

    <th class="text-center" wire:click="Header_Orderby('tar_estado')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'tar_estado']) Estado</th>

    <th class="text-center">Acciones</th>
@endsection

@section('table_body')
    @foreach ($data as $d)
        <tr>
            <td class="text-center">{{ $d->tar_id }} </td>

            <td class="text-center">{{ $d->tar_valor }} {{ $d->tar_tiempo }} </td>

            <td class="text-center">S/ {{ $d->tar_precio }} </td>

            <td class="text-center">{{ $d->tar_tolerancia }} Minutos</td>

            <td class="text-center">
                @if ($d->tar_estado == 'Activo')
                    <h5><span class="badge badge-success">{{ $d->tar_estado }}</span></h5>
                @else
                    <h5><span class="badge badge-danger">{{ $d->tar_estado }}</span></h5>
                @endif
            </td>

            <td class="text-center">
                @can('tarifas_acciones')
                    {{-- --------------------------editar---------------------------------- --}}
                    <button wire:click="edit({{ $d->tar_id }})" type="button" class="btn btn-warning" data-toggle="modal"
                        data-target="#Modal">
                        <i class="fas fa-pencil-alt"></i>
                    </button>
                    {{-- --------------------------activar desactivar---------------------------------- --}}
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
                @endcan
            </td>
        </tr>
    @endforeach
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            //el evento print se emite en la linea 192 del controlador Rentas
            window.livewire.on('pdf_tarifas', report => {
                //var ruta="{{ url('imprimir/pdf') }}"
                var ruta = "{{ url('reportes/tarifas/') }}"
                var w = window.open(ruta, "_blank", "=width1,height=1")
                //w.close()//cierra la ventana de impresion
            })
        })
    </script>
@endsection
