<div>
    @if ($accion == 0)
        <div class="main-content">
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
                                            <span wire:click="$set('barcode','')" class="input-group-text "
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
                                    <button class="btn btn-primary btn-block">
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
                                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
                                            @if ($c->caj_estado == 'Libre')
                                                <span id="{{ $c->caj_id }}" style="cursor: pointer;"
                                                    data-status="{{ $c->caj_estado }}" data-id="{{ $c->caj_id }}" onclick="$set('accion',1)"
                                                    class="badge-chip badge-success mt-2 mb-2 ml-2 bs-popover">
                                                @else
                                                    <span id="{{ $c->caj_id }}" style="cursor: pointer;"
                                                        data-status="{{ $c->caj_estado }}" data-id="{{ $c->caj_id }}" data-barcode="{{ $c->caj_id }}" onclick="$set('accion',1)"
                                                        class="badge-chip badge-danger mt-2 mb-2 ml-2 bs-popover">
                                            @endif
                                            <img src="{{ url('images/tipos_tumb/'. $c->tip_img) }}" alt="" class="img" width="96" height="96">
                                            <span> {{ $c->caj_desc }} </span>            
                                            </span>                                
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="caj_id"/> {{--input para que cuando se haga click en ticket rapido se ponga aqui ---}}
                </div>
            </div>
        </div>
    @else

    @endif

</div>
