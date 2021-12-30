@extends('actions.listado')

@section('name_component')
<i class="fas fa-clipboard-list"></i>
    Tipos de Comprobante
@endsection

{{-------------------- CABECERA DE LA TABLA  -------------------}}

@section('table_header')
    <th class="text-center" wire:click="Header_Orderby('tpc_id')" class="text-center" style="cursor: pointer;" >
        @include('actions.headerorder',['campo_a_ordenar' => 'tpc_id'])  Id</th>

    <th class="text-center" wire:click="Header_Orderby('tpc_desc')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'tpc_desc'])  Descripcion</th>

    <th class="text-center" wire:click="Header_Orderby('tpc_estado')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'tpc_estado']) Estado</th>

    <th class="text-center">Acciones</th>
@endsection

{{-------------------- CUERPO DE LA TABLA  -------------------}}
@section('table_body')
        @foreach ($data as $d)
            <tr>
                <td class="text-center">{{$d->tpc_id }} </td>

                <td>{{$d->tpc_desc }} </td>

                <td class="text-center">
                    @if ($d->tpc_estado =='Activo')
                        <h5><span class="badge badge-success">{{ $d->tpc_estado }}</span></h5>
                    @else
                        <h5><span class="badge badge-danger">{{ $d->tpc_estado }}</span></h5>
                    @endif
                </td>

                <td class="text-center">
                    @if ($d->tpc_estado=='Activo')
                        @if ($selected_id==$d->tpc_id)
                            <button wire:click="Desactivar_Activar({{ $d->tpc_id }},'Desactivado')" type="button" class="btn btn-secondary"><i class="fa fa-check"></i></button>
                        @else
                            <button wire:click="Confirmar_Desactivar({{ $d->tpc_id }})" type="button" class="btn btn-danger"><i class="fas fa-arrow-down"></i>
                            </button>
                        @endif
                    @else
                        @if ($selected_id==$d->tpc_id)
                        <button wire:click="Desactivar_Activar({{ $d->tpc_id }},'Activo')" type="button" class="btn btn-secondary"><i class="fas fa-check"></i></i></button>
                        @else
                            <button wire:click="Confirmar_Desactivar({{ $d->tpc_id }})" type="button" class="btn btn-success"><i class="fas fa-arrow-up"></i>

                            </button>
                        @endif
                    @endif
                </td>
            </tr>
        @endforeach
@endsection


@section('js')
    <script>
        document.addEventListener('DOMContentLoaded',function()
        {
            //el evento print se emite en la linea 192 del controlador Rentas
            window.livewire.on('pdf_tipocomprobante', report =>
            {
                //var ruta="{{ url('imprimir/pdf') }}"
                var ruta="{{ url('reportes/tipocomprobante/') }}"
                var w =window.open(ruta,"_blank","=width1,height=1")
                //w.close()//cierra la ventana de impresion
            })
        })
    </script>
@endsection
