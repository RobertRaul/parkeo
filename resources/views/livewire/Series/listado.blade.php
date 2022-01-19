@extends('actions.listado')

@section('name_component')
<i class="fas fa-digital-tachograph"></i>
    Series
@endsection

@section('button_new')
    @include('actions.btnnuevo-modal',['nuevo' => 'series_nuevo'])
@endsection

@section('card_body')
    @include('livewire.series.crear')
@endsection

@section('btn_reports')
    @include('actions.btnreportes',['reports'=>'series_reportes'])   
@endsection

@section('table_header')
    <th class="text-center" wire:click="Header_Orderby('ser_id')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'ser_id']) Id</th>

    <th class="text-center" wire:click="Header_Orderby('ser_tpcomid')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'ser_tpcomid']) Comprobante</th>

    <th class="text-center" wire:click="Header_Orderby('ser_serie')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'ser_serie']) Serie</th>

    <th class="text-center" wire:click="Header_Orderby('ser_numero')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'ser_numero']) Numero</th>

    <th class="text-center" wire:click="Header_Orderby('ser_estado')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'ser_estado']) Estado</th>

    <th class="text-center">Acciones</th>
@endsection

@section('table_body')
    @foreach ($data as $d)
        <tr>
            <td class="text-center">{{ $d->ser_id }} </td>

            <td>{{ $d->TipoComprobante->tpc_desc }} </td>

            <td>{{ $d->ser_serie }} </td>

            <td>{{ $d->ser_numero }} </td>

            <td class="text-center">
                @if ($d->ser_estado == 'Activo')
                    <h5><span class="badge badge-success">{{ $d->ser_estado }}</span></h5>
                @else
                    <h5><span class="badge badge-danger">{{ $d->ser_estado }}</span></h5>
                @endif
            </td>

            <td class="text-center">
                @can('series_acciones')
                    
               
                                {{----------------------------editar------------------------------------}}
                <button wire:click="edit({{ $d->ser_id}})" type="button" class="btn btn-warning" data-toggle="modal" data-target="#Modal">
                    <i class="fas fa-pencil-alt"></i>
                </button>
                                {{----------------------------activar desactivar------------------------------------}}             
                @if ($d->ser_estado == 'Activo')
                    @if ($selected_id == $d->ser_id)
                        <button wire:click="Desactivar_Activar({{ $d->ser_id }},'Desactivado')" type="button"
                            class="btn btn-secondary"><i class="fa fa-check"></i></button>
                    @else
                        <button wire:click="Confirmar_Desactivar({{ $d->ser_id }})" type="button"
                            class="btn btn-danger"><i class="fas fa-arrow-down"></i>
                        </button>
                    @endif
                @else
                    @if ($selected_id == $d->ser_id)
                        <button wire:click="Desactivar_Activar({{ $d->ser_id }},'Activo')" type="button"
                            class="btn btn-secondary"><i class="fas fa-check"></i></i></button>
                    @else
                        <button wire:click="Confirmar_Desactivar({{ $d->ser_id }})" type="button"
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
        document.addEventListener('DOMContentLoaded',function()
        {
            //el evento print se emite en la linea 192 del controlador Rentas
            window.livewire.on('pdf_series', report =>
            {
                //var ruta="{{ url('imprimir/pdf') }}"
                var ruta="{{ url('reportes/series/') }}"
                var w =window.open(ruta,"_blank","=width1,height=1")
                //w.close()//cierra la ventana de impresion
            })
        })
    </script>
@endsection