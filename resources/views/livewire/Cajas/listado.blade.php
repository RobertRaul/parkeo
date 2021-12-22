<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header container-fluid">
                <div class="row">
                    <div class="col-md-10">
                        <h3>
                            <i class="fas fa-cash-register"></i>
                            Caja
                        </h3>
                    </div>
                    <div class="col-md-1 float-right">
                        <div class="text-right">
                            @if ($caj_codigo==-1)
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Modal">
                                <i class="fas fa-door-open"></i>
                                Aperturar
                            </button>
                            @else
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Modal"
                                disabled>
                                <i class="fas fa-door-open"></i>
                                Aperturar
                            </button>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-1 float-right">
                        <div class="text-right">

                            @if ($caj_codigo==-1)
                            <button type="button" class="btn btn-danger" disabled>
                                <i class="fas fa-door-closed"></i>
                                Cierre
                            </button>
                            @else
                            <button type="button" class="btn btn-danger" onclick="Cerrar_Caja()">
                                <i class="fas fa-door-closed"></i>
                                Cierre
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <div class="card">
                    <div class="table-responsive">
                        <table id="tabla_caja" class="table table-striped table-bordered dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center">Id</th>
                                    <th class="text-center">F. Apertura</th>
                                    <th class="text-center">F. Cierre</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cajas as $c)
                                <tr>
                                    <td class="text-center" style="cursor: pointer"
                                        wire:click="$set('caja_codigo','{{$c->caj_id}}')"> {{$c->caj_id}} </td>
                                    <td class="text-center" style="cursor: pointer"
                                        wire:click="$set('caja_codigo','{{$c->caj_id}}')">
                                        {{\Carbon\Carbon::parse($c->caj_feaper)->format('H:i:s d/m/Y')}} </td>
                                    <td class="text-center" style="cursor: pointer"
                                        wire:click="$set('caja_codigo','{{$c->caj_id}}')"> {{$c->caj_fecierr ?
                                        \Carbon\Carbon::parse($c->caj_fecierr)->format('H:i:s d/m/Y') : null }} </td>
                                    <td class="text-center">
                                        @if ($c->caj_st =='Open')
                                        <h5><span class="badge badge-success">{{$c->caj_st}}</span></h5>
                                        @else
                                        <h5><span class="badge badge-danger">{{$c->caj_st}}</span></h5>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-secondary" wire:click='generar_reporte({{ $c->caj_id }})'>
                                            <i class="fas fa-file-invoice-dollar"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <p>
                            Mostrando registros del {{ $cajas->firstItem() }} al {{ $cajas->lastItem() }} de un total de {{ $cajas->total() }} registros
                        </p>
                        <p>
                            {{ $cajas->links() }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xs-8 col-sm-8 col-sm-8 col-lg-8">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center">Cliente</th>
                                    <th class="text-center">Placa</th>
                                    <th class="text-center">Tarifa</th>
                                    <th class="text-center">Horas</th>
                                    <th class="text-center">Cajon</th>
                                    <th class="text-center">Ticket</th>
                                    <th class="text-center">Tp. Pago</th>
                                    <th class="text-center">Nro Ref</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($detalles)
                                @foreach ($detalles as $d)
                                <tr>
                                    <td class="text-center"> {{$d->clie_nombres}} </td>
                                    <td class="text-center"> {{$d->veh_placa}} </td>
                                    <td class="text-center"> {{$d->tar_precio}} </td>
                                    <td class="text-center"> {{$d->rent_totalhoras}} </td>
                                    <td class="text-center"> {{$d->caj_desc}} </td>
                                    <td class="text-center"> {{$d->ing_serie}}-{{$d->ing_numero}} </td>
                                    <td class="text-center"> {{$d->ing_tppago}} </td>
                                    <td class="text-center"> {{$d->ing_nref}} </td>
                                    <td class="text-center"> {{$d->ing_total}} </td>

                                    <td class="text-center">
                                        @if ($d->ing_estado =='Emitido')
                                        <h5><span class="badge badge-success">{{$d->ing_estado}}</span></h5>
                                        @else
                                        <h5><span class="badge badge-danger">{{$d->ing_estado}}</span></h5>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <h5>
                                            @if ($d->ing_estado =='Emitido')
                                            <button type="button" class="btn btn-secondary">
                                                <i class="fas fa-print"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger"
                                                onclick="Anular_Comprobante('{{$d->ing_id}}','{{$d->ing_serie}}-{{$d->ing_numero}}')">
                                                <i class="fas fa-arrow-down"></i>
                                            </button>
                                            @else
                                            <button type="button" class="btn btn-secondary" disabled>
                                                <i class="fas fa-print"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger" disabled>
                                                <i class="fas fa-arrow-down"></i>
                                            </button>
                                            @endif
                                        </h5>
                                    </td>

                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @include('livewire.cajas.crear')
    </div>
</div>


<script>
    //funcion eliminar roles
    function Cerrar_Caja()
    {
        Swal.fire({
                title: 'Confirmar',
                text: '¿Deseas Cerrar la caja? Esta accion no se puede deshacer',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
            }).then((result)=>{
                if (result.value)
                {
                    window.livewire.emit('CerrarCaja')
                    swal.close()
                }
            })
    }

    function Anular_Comprobante($idingreso,$ticket)
    {
        var texto ="Anular Comprobante " + $ticket

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
                window.livewire.emit('AnularTicket',$idingreso,result.value);
            }
        });
    }

    // document.addEventListener('DOMContentLoaded', function() {

    //     $('#tabla_caja tbody tr').click(function() {
    //     $(this).addClass('bg-success').siblings().removeClass('bg-success');
    // });

    // })

    document.addEventListener('DOMContentLoaded',function ()
       {
            //el evento print se emite en la linea 192 del controlador Rentas
            window.livewire.on('caja_pdf',idcaja =>
            {
                //var ruta="{{ url('imprimir/pdf') }}"
                var ruta="{{ url('reportes/caja') }}" +'/' + idcaja
                var w =window.open(ruta,"_blank","=width1,height=1")
                //w.close()//cierra la ventana de impresion
            })
       })

</script>
