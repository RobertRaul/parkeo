<section id="Crear">
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Registrar Renta</h3>
        </div>
        <div class="card-body">
            <div class="widget-one">
                <!--div titulo y boton regersar -->
                <div class="row">
                    <div class="col-2">
                        <button class="btn btn-danger" wire:click="$set('accion',0)">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                    </div>
                    <div class="col-8">
                        <h5 class="text-center"><b>TICKET DE PENSIÓN</b></h5>
                    </div>
                    <div class="col-2 text-right">
                        <label></label>
                    </div>
                </div>
                <!--div Datos del Cliente -->
                <div class="row mt-4">
                    <h4 class="col-sm-4">
                        <span class="badge badge-pill badge-primary">
                            Datos del Cliente
                        </span>
                        <input type="hidden" id="cliente_value">
                    </h4>

                    <div class="col-sm-4 custom-control custom-checkbox">
                        <input class="custom-control-input clientes" type="checkbox" id="checkboxpublico">
                        <label for="checkboxpublico" class="custom-control-label">Publico General</label>
                    </div>

                    <div class="col-sm-4" wire:ignore>
                        <select class="form-control" id="cliente_select">
                            <option value="Buscar">Buscar</option>
                            @foreach ($clientes as $c)
                            <option value="{{$c->clie_id}}">{{$c->clie_nombres}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-lg-2 col-md-2 col-sm-12">
                        <label class="text-danger">Tipo Documento</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-filter"></i></div>
                            </div>
                            <select class="form-control" id="tipodoc" wire:model="clie_tpdi">
                                <option value="Elegir">Elegir</option>
                                @foreach ($tipodoc as $t)
                                <option value="{{$t->tpdi_id}}">{{$t->tpdi_desc}}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('clie_tpdi') <span class="error text-danger" id="tpdoc_message">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-lg-2 col-md-2 col-sm-12">
                        <label class="text-danger">Nro Doc</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-sort-numeric-up-alt"></i></div>
                            </div>
                            <input wire:model="clie_numdoc" type="text" class="form-control" maxlength="30"
                                placeholder="123456789" id="nrodoc">
                        </div>
                        @error('clie_numdoc') <span class="error text-danger" id="numdoc_message">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <label class="text-danger">Nombres</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-text-height"></i></div>
                            </div>
                            <input wire:model="clie_nombres" type="text" class="form-control" maxlength="30"
                                placeholder="Pepe Luis Fox" id="nombres">
                        </div>
                        @error('clie_nombres') <span class="error text-danger" id="nombres_message">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group col-lg-2 col-md-2 col-sm-12">
                        <label class="text-danger">Celular</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-phone"></i></div>
                            </div>
                            <input wire:model="clie_celular" type="text" class="form-control" maxlength="30"
                                placeholder="955 555 355" id="celular">
                        </div>
                        @error('clie_celular') <span class="error text-danger" id="cel_message">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <label for="">Email</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-at"></i></div>
                            </div>
                            <input wire:model="clie_email" type="text" class="form-control" maxlength="30" placeholder="hola@gmail.com"
                                id="email">
                        </div>
                    </div>
                </div>
                <!--div Datos del Vehiculo -->
                <div class="row mt-4">
                    <h4 class="col-sm-4">
                        <span class="badge badge-pill badge-primary">
                            Datos del Vehiculo
                        </span>
                        <input type="hidden" id="vehiculo_value">
                    </h4>
                    <div class="col-sm-4 custom-control custom-checkbox">
                        <input class="custom-control-input vehiculos" type="checkbox" id="checkboxvehiculo">
                        <label for="checkboxvehiculo" class="custom-control-label">Vehiculo General</label>
                    </div>

                    <div class="col-sm-4">

                    </div>

                    <div class="form-group col-lg-2 col-md-2 col-sm-12">
                        <label class="text-danger">Placa</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-chess-board"></i></div>
                            </div>
                            <input wire:model="veh_placa" type="text" class="form-control" maxlength="30"
                                placeholder="ABC-123" id="placa">
                        </div>
                        @error('veh_placa') <span class="error text-danger" id="placa_message">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group col-lg-2 col-md-2 col-sm-12">
                        <label class="text-danger">Modelo</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-car"></i></div>
                            </div>
                            <input wire:model="veh_modelo" type="text" class="form-control" maxlength="30"
                                placeholder="Centra" id="modelo">
                        </div>
                        @error('veh_modelo') <span class="error text-danger" id="modelo_message">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <label for="">Marca</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-stroopwafel"></i></div>
                            </div>
                            <input wire:model="veh_marca" type="text" class="form-control" maxlength="30" id="marca" placeholder="Toyota">
                        </div>
                    </div>

                    <div class="form-group col-lg-2 col-md-2 col-sm-12">
                        <label for="">Color</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-tint"></i></div>
                            </div>
                            <input wire:model="veh_color" type="text" class="form-control" maxlength="30" placeholder="Rojo" id="color">
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <label for="">Foto</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-camera-retro"></i></div>
                            </div>
                            <input wire:model="veh_foto" type="file" class="form-control" id="tip_img" id="foto">
                        </div>
                        @error('veh_foto') <span class="error text-danger" id="foto_message">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-2 col-lg-2 col-sm-12">
                        <label for="">Dejo Llaves?</label>
                        <select wire:model="rent_llaves" class="form-control">
                            <option value="Elegir">Elegir</option>
                            <option value="Si">Si</option>
                            <option value="No">No</option>
                          </select>
                          @error('rent_llaves') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 col-lg-4 col-sm-12">
                        <label>Observacion</label>
                        <input class="form-control" wire:model="rent_obser">
                    </div>

                    <div class="col-md-4 col-lg-4 col-sm-12">
                        <label>Tarifa</label>
                        <select wire:model="rent_tarifa" class="form-control">
                          <option value="Elegir">Elegir</option>
                          @foreach ($tarifas as $t)
                              <option value="{{$t->tar_id}}" class="form-control">{{$t->tar_desc}} - Precio: S/ {{$t->tar_precio}} * {{$t->tar_tiempo}}</option>
                          @endforeach
                        </select>
                        @error('rent_tarifa') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>                    
                </div>
                <div class="col-md-2 col-lg-2 col-sm-12">                
                    <button wire:click.prevent="$emit('ticketrenta',$('#cliente_value').val(),$('#vehiculo_value').val())" class="btn btn-primary mt-4">Registrar Renta</button>
                </div>
            </div>
        </div>        
    </div>

</section>


<script>

    $(document).ready(function(){
        //buscamos el select con el id cliente_Select y cargamos el plugin select2
        $('#cliente_select').select2();

        $('#cliente_select').on('change',function(e){
            //cuando se haga el cambio del select capturamos el valor y lo pondemos en data
            var data = $('#cliente_select').select2("val")
            @this.set('clie_findID',data);
            window.livewire.emit('cargar_data',data)
        });
    });

</script>
