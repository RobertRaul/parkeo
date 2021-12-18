@extends('actions.listado')

@section('name_component')
<i class="fas fa-wallet"></i>
Egresos
@endsection


@section('button_new')
@include('actions.btnnuevo-modal')
@endsection

@section('card_body')

@endsection

@section('table_header')
<th class="text-center" wire:click="Header_Orderby('egr_id')" class="text-center" style="cursor: pointer;">
    @include('actions.headerorder',['campo_a_ordenar' => 'egr_id']) Codigo Egreso</th>

<th class="text-center" wire:click="Header_Orderby('egr_motivo')" class="text-center" style="cursor: pointer;">
    @include('actions.headerorder',['campo_a_ordenar' => 'egr_motivo'])Motivo Egreso</th>

<th class="text-center" wire:click="Header_Orderby('egr_total')" class="text-center" style="cursor: pointer;">
    @include('actions.headerorder',['campo_a_ordenar' => 'egr_total']) Total</th>

<th class="text-center" wire:click="Header_Orderby('egr_estado')" class="text-center" style="cursor: pointer;">
    @include('actions.headerorder',['campo_a_ordenar' => 'egr_estado']) Estado</th>

<th class="text-center" wire:click="Header_Orderby('egr_anulm')" class="text-center" style="cursor: pointer;">
    @include('actions.headerorder',['campo_a_ordenar' => 'egr_anulm'])Motivo Anulacion</th>

<th class="text-center">Acciones</th>
@endsection

@section('table_body')

@foreach ($data as $d)
<tr>
    <td class="text-center">{{ $d->egr_id }} </td>

    <td class="text-center">{{ $d->egr_motivo }} </td>

    <td class="text-center">S/ {{ $d->egr_total }} </td>

    <td class="text-center">
        @if ($d->egr_estado == 'Emitido')
        <h5><span class="badge badge-success">{{ $d->egr_estado }}</span></h5>
        @else
        <h5><span class="badge badge-danger">{{ $d->egr_estado }}</span></h5>
        @endif
    </td>

    <td class="text-center">{{ $d->egr_anulm }}</td>

    <td class="text-center">
        {{----------------------------Anular------------------------------------}}
        <h5>
            @if ($d->egr_estado =='Emitido')
            <button type="button" class="btn btn-danger" onclick="Anular_egreso('{{$d->egr_id}}')">
                <i class="fas fa-arrow-down"></i>
            </button>
            @else
            <button type="button" class="btn btn-danger" disabled>
                <i class="fas fa-arrow-down"></i>
            </button>
            @endif
        </h5>
    </td>
</tr>
@endforeach
@endsection


<script>
    function Anular_egreso($idegreso)
    {
        var texto ="Anular Egreso " + $idegreso

        const{value: motivo} = Swal.fire({
            title: texto ,
            text: "Esta operacion no se puede deshacer",
            type: 'warning',
            input: 'text',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            inputPlaceholder: "Ingresa el motivo de anulacion",
            inputValidator: (value) =>{
                return !value && 'Ingrese un motivo de anulacion!'
            }
        }).then((result) =>
        {
            if (result.value)
            {
                //console.log("Result: " + result.value);
                window.livewire.emit('Anularegreso',$idegreso,result.value);
            }
        });
    }
</script>
