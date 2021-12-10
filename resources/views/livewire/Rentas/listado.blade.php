<div>
    @if ($accion == 0)
        <div class="main-content">
            @include('livewire.rentas.visita')
            <div class="row">
                <div class="col-lg-12 layout-spacing layout-top-spacing">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-center">
                                PARKEO DE VEHICULOS
                            </h3>
                        </div>
                    </div>
                    @if ($caja_aperturada > 0)
                        <div class="card">
                            <div class="card-body">
                                <div  class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                            </div>
                                            <input wire:model="barcode" type="text" id="code" class="form-control" 
                                            maxlength="9" placeholder="Escanea el código de barras"  wire:keydown.enter="$emit('darSalida','')" autofocus>
                                            <div class="input-group-append">
                                                <span wire:click="$set('barcode','')" class="input-group-text"
                                                    style="cursor:pointer; "><i class="fas fa-trash-alt"></i> 
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        {{-- <button class="btn btn-primary btn-block">
                                    <i class="fas fa-print"></i>
                                    TICKET DE VISITA
                                </button> --}}
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <button class="btn btn-primary btn-block" wire:click="ticketrenta">
                                            <i class="fas fa-print"></i>
                                            Ticket de Renta
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="col">
                                    <div class="row">
                                        @foreach ($cajones as $c)
                                            <div class="col-lg-2 col-md-2 col-sm-12 text-center">
                                                @if ($c->caj_estado == 'Libre')
                                                    <span id="{{ $c->caj_id }}" style="cursor: pointer;"
                                                        data-status="{{ $c->caj_estado }}"
                                                        data-id="{{ $c->caj_id }}" data-toggle="modal"
                                                        data-target="#modalTicket"
                                                        class="badge-chip badge-success mt-2 mb-2 ml-2 bs-popover col-sm-12"
                                                        wire:click="$set('rent_cajonid','{{ $c->caj_id }}')">
                                                    @else
                                                        <span id="{{ $c->caj_id }}" style="cursor: pointer;"
                                                            data-status="{{ $c->caj_estado }}"
                                                            data-id="{{ $c->caj_id }}"
                                                            data-barcode="{{ $c->caj_id }}" 
                                                            wire:click="$emit('darSalida','{{$c->caj_id}}')"
                                                            class="badge-chip badge-danger mt-2 mb-2 ml-2 bs-popover col-sm-12">
                                                @endif
                                                <img src="{{ url('images/tipos_tumb/' . $c->tip_img) }}" alt=""
                                                    class="img" width="96" height="96">
                                                <span> {{ $c->caj_desc }} </span>
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <script>
                            window.addEventListener("DOMContentLoaded", function() {
                                Livewire.emit("renta_mensaje");
                            });
                        </script>
                    @endif
                </div>
            </div>
            @include('livewire.rentas.ingreso')
        </div>
    @elseif($accion==1)
        @include('livewire.rentas.crear')
    @elseif($accion==2)
        @include('livewire.rentas.probando')
    @endif
</div>

<script>
    function checkOut(eventName, accion) {
        window.livewire.emit(eventName, accion)

    }

    document.addEventListener('DOMContentLoaded', function() {

        //en el cuerpo buscamos un click que tenga la clase "clientes"
        $('body').on('click', '.clientes', function() {
            //verificamos si esta chekeado o no
            //limpiamos el texto de las validaciones

            $("#tpdoc_message").text('');
            $("#numdoc_message").text('');
            $("#nombres_message").text('');
            $("#cel_message").text('');

            var valu = $(this).is(':checked') ? "yes" : "no";
            @this.set('cliente_general', valu);
        })

        //en el cuerpo buscamos un click que tenga la clase "vehiculos"
        $('body').on('click', '.vehiculos', function() {
            //verificamos si esta chekeado o no
            $("#foto_message").text('');
            //limpiamos el texto de las validacones
            $("#placa_message").text('');
            $("#modelo_message").text('');
            var valu = $(this).is(':checked') ? "yes" : "no";
            @this.set('vehiculo_general', valu);
        })
    })
</script>

