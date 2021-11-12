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
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                        </div>
                                        <input type="text" id="code" class="form-control" maxlength="9"
                                            placeholder="Escanea el código de barras" autofocus>
                                        <div class="input-group-append">
                                            <span wire:click="$set('rent_codigo','')" class="input-group-text"
                                                style="cursor:pointer; "><i class="fas fa-trash-alt"></i> </span>
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
                                                    data-status="{{ $c->caj_estado }}" data-id="{{ $c->caj_id }}"
                                                    data-toggle="modal" data-target="#modalTicket"
                                                    class="badge-chip badge-success mt-2 mb-2 ml-2 bs-popover col-sm-12"
                                                    wire:click="$set('rent_cajonid','{{ $c->caj_id }}')">
                                                @else
                                                    <span id="{{ $c->caj_id }}" style="cursor: pointer;"
                                                        data-status="{{ $c->caj_estado }}"
                                                        data-id="{{ $c->caj_id }}" data-barcode="{{ $c->caj_id }}"
                                                        onclick="$set('accion',1)"
                                                        class="badge-chip badge-danger mt-2 mb-2 ml-2 bs-popover col-sm-12">
                                            @endif
                                            <img src="{{ url('images/tipos_tumb/' . $c->tip_img) }}" alt=""
                                                class="img" width="96" height="96">
                                            <span > {{ $c->caj_desc }} </span>
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @elseif($accion==1)
        @include('livewire.rentas.crear')
    @endif

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        //en el cuerpo buscamos un click que tenga la clase "clientes"
        $('body').on('click', '.clientes', function() {
            //verificamos si esta chekeado o no                      
            /*
            var estado = $(this).is(':checked') ? true : false;
            $("#tipodoc").prop('disabled', estado);
            $("#nrodoc").prop('disabled', estado);
            $("#nombres").prop('disabled', estado);
            $("#celular").prop('disabled', estado);
            $("#email").prop('disabled', estado);
            $("#cliente_select").prop('disabled', estado);*/
            //limpiamos el texto de las validaciones

            $("#tpdoc_message").text('');
            $("#numdoc_message").text('');
            $("#nombres_message").text('');
            $("#cel_message").text('');
            
            var valu = $(this).is(':checked') ? "yes" : "no";
            @this.set('cliente_general',valu);
        })

        //en el cuerpo buscamos un click que tenga la clase "vehiculos"
        $('body').on('click', '.vehiculos', function() {
            //verificamos si esta chekeado o no
            /*
            var estado = $(this).is(':checked') ? true : false;       
            $("#placa").prop('disabled', estado);
            $("#modelo").prop('disabled', estado);
            $("#marca").prop('disabled', estado);
            $("#color").prop('disabled', estado);*/

            $("#foto_message").text('');
            //limpiamos el texto de las validacones
            $("#placa_message").text('');
            $("#modelo_message").text('');
            var valu = $(this).is(':checked') ? "yes" : "no";
            @this.set('vehiculo_general',valu);
        })
    })

</script>
