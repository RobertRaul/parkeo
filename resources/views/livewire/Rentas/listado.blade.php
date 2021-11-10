<div>
    @if ($accion==0)
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
                                        <span wire:click="$set('barcode','')" class="input-group-text"
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
                                <button class="btn btn-primary btn-block" wire:click="$set('accion',1)">
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
                                        data-status="{{ $c->caj_estado }}" data-id="{{ $c->caj_id }}"
                                        data-toggle="modal" data-target="#modalTicket"
                                        class="badge-chip badge-success mt-2 mb-2 ml-2 bs-popover"
                                        wire:click="$set('rent_cajonid','{{$c->caj_id}}')">
                                        @else
                                        <span id="{{ $c->caj_id }}" style="cursor: pointer;"
                                            data-status="{{ $c->caj_estado }}" data-id="{{ $c->caj_id }}"
                                            data-barcode="{{ $c->caj_id }}" onclick="$set('accion',1)"
                                            class="badge-chip badge-danger mt-2 mb-2 ml-2 bs-popover">
                                            @endif
                                            <img src="{{ url('images/tipos_tumb/'. $c->tip_img) }}" alt="" class="img"
                                                width="96" height="96">
                                            <span> {{ $c->caj_desc }} </span>
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
    function cliente_desactivar()
    {
        if (document.getElementById('checkboxpublico').checked == true)
        {
            document.getElementById('tipodoc').setAttribute('disabled','disabled');
            document.getElementById('nrodoc').setAttribute('disabled','disabled');
            document.getElementById('nombres').setAttribute('disabled','disabled');
            document.getElementById('celular').setAttribute('disabled','disabled');
            document.getElementById('email').setAttribute('disabled','disabled');
            document.getElementById('tpdoc_messa').innerHTML ='';

            window.livewire.emit('cliente_general',true)
        }
        else
        {

            document.getElementById('tipodoc').removeAttribute('disabled');
            document.getElementById('nrodoc').removeAttribute('disabled');
            document.getElementById('nombres').removeAttribute('disabled');
            document.getElementById('celular').removeAttribute('disabled');
            document.getElementById('email').removeAttribute('disabled');
            document.getElementById('tpdoc_messa').innerHTML ='';

            window.livewire.emit('cliente_general',false)
        }
    }
    function vehiculo_desactivar()
    {
        if (document.getElementById('checkboxvehiculo').checked == true)
        {
            document.getElementById('placa').setAttribute('disabled','disabled');
            document.getElementById('modelo').setAttribute('disabled','disabled');
            document.getElementById('marca').setAttribute('disabled','disabled');
            document.getElementById('color').setAttribute('disabled','disabled');
            document.getElementById('foto').setAttribute('disabled','disabled');
        }
        else
        {

            document.getElementById('placa').removeAttribute('disabled');
            document.getElementById('modelo').removeAttribute('disabled');
            document.getElementById('marca').removeAttribute('disabled');
            document.getElementById('color').removeAttribute('disabled');
            document.getElementById('foto').removeAttribute('disabled');
        }
    }
</script>
