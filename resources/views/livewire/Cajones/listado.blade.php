@extends('actions.listado')

@section('name_component')
    <i class="fas fa-grip-horizontal"></i>
    Cajones
@endsection

@section('button_new')
    @include('actions.btnnuevo-modal',['nuevo' =>'cajones_nuevo'])
@endsection

@section('card_body')
    @include('livewire.cajones.crear')
@endsection

@section('btn_reports')
    @include('actions.btnreportes',['reports' => 'cajones_reports'])
@endsection

@section('table_header')
    <th class="text-center" wire:click="Header_Orderby('caj_id')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'caj_id']) Id</th>

    <th class="text-center" wire:click="Header_Orderby('tip_desc')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'tip_desc']) Tp. Vehiculo</th>

    <th class="text-center" wire:click="Header_Orderby('caj_desc')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'caj_desc']) Cajones</th>

    <th class="text-center" wire:click="Header_Orderby('caj_estado')" class="text-center" style="cursor: pointer;">
        @include('actions.headerorder',['campo_a_ordenar' => 'caj_estado']) Estado</th>

    <th class="text-center">Acciones</th>
@endsection

@section('table_body')
    @foreach ($data as $d)
        <tr>
            <td class="text-center">{{ $d->caj_id }} </td>

            <td class="text-center">{{ $d->tip_desc }} </td>

            <td class="text-center">{{ $d->caj_desc }} </td>

            <td class="text-center">
                @if ($d->caj_estado == 'Libre')
                    <h5><span class="badge badge-success">{{ $d->caj_estado }}</span></h5>
                @else
                    <h5><span class="badge badge-danger">{{ $d->caj_estado }}</span></h5>
                @endif
            </td>

            <td class="text-center">
                @can('cajones_acciones')
                    {{-- --------------------------editar---------------------------------- --}}
                    <button wire:click="edit({{ $d->caj_id }})" type="button" class="btn btn-warning" data-toggle="modal"
                        data-target="#Modal">
                        <i class="fas fa-pencil-alt"></i>
                    </button>
                    {{-- --------------------------activar desactivar---------------------------------- --}}
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
                @endcan
            </td>
        </tr>
    @endforeach
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            //el evento print se emite en la linea 192 del controlador Rentas
            window.livewire.on('pdf_cajones', report => {
                //var ruta="{{ url('imprimir/pdf') }}"
                var ruta = "{{ url('reportes/cajones/') }}"
                var w = window.open(ruta, "_blank", "=width1,height=1")
                //w.close()//cierra la ventana de impresion
            })
        })
    </script>
@endsection
