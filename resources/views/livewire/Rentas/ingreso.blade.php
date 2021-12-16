<div wire:ignore.self class="modal fade" id="modalIngreso" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header-success">
                <h5 class="text-center" style="color: white">TICKET DE SALIDA</h5>
            </div>
            <div class="modal-body">
                <form action="">
                    <!--div Datos del Iniciales -->
                    <div class="row">
                        <div class="form-group col-4">
                            <label class="text-danger">Codigo:</label>
                            <div class="input-group mb-2 mr-sm-2">
                                {{ $data_rent->rent_id }}
                            </div>
                        </div>

                        <div class="form-group col-4">
                            <label class="text-danger">Tarifa:</label>
                            <div class="input-group mb-2 mr-sm-2">
                                {{ $data_rent->Tarifas->tar_precio }} x {{ $data_rent->Tarifas->tar_tiempo }}
                            </div>
                        </div>

                        <div class="form-group col-4">
                            <label class="text-danger">Tolerancia:</label>
                            <div class="input-group mb-2 mr-sm-2">
                                {{ $data_rent->Tarifas->tar_tolerancia }} Minutos
                            </div>
                        </div>
                    </div>



                    <div class="row">      
                        <div class="form-group col-4">
                            <label class="text-danger">Fecha Ingreso:</label>
                            <div class="input-group mb-2 mr-sm-2">
                                {{ \Carbon\Carbon::parse($data_rent->rent_feching)->format('d/m/Y H:m:s') }}
                            </div>
                        </div>

                        <div class="form-group col-4" wire:ignore>
                            <label class="text-danger">T. Transcurrido:</label>
                            <div class="input-group mb-2 mr-sm-2">
                                {{ $data_rent->tiempo }}
                            </div>
                        </div>

                        <div class="form-group col-4" wire:ignore>
                            <label class="text-danger">Total</label>
                            <div class="input-group mb-2 mr-sm-2">
                                S/ {{ number_format($data_rent->Total, 2) }}
                            </div>
                        </div>
                    </div>

                    <!--div Datos del pago -->
                    <div class="row">
                        <div class="form-group col-4">
                            <label class="text-danger">Serie</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <select class="form-control" wire:model="ing_serid">
                                    <option value="Elegir">Elegir</option>
                                    @foreach ($series as $s)
                                        <option value="{{ $s->ser_id }}"> {{ $s->ser_serie }} </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('ing_serid') <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-4">
                            <label class="text-danger">Tp. Pago</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <select class="form-control" wire:model="ing_tppago">
                                    <option value="Elegir">Elegir</option>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Mastercard">Mastercard</option>
                                    <option value="Visa">Visa</option>
                                </select>
                            </div>
                            @error('ing_tppago') <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-3">
                            <label class="text-danger">Nro Ref</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <input wire:model="ing_nref" type="text" class="form-control" maxlength="11">
                            </div>
                            @error('ing_nref') <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group">
                        <button wire:click.prevent="$emit('ticketrenta')" class="btn btn-primary mt-4">Registrar
                            Renta</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" wire:click="cancel()"> Cancelar</button>
                <button type="button" class="btn btn-primary" wire:click="renta_visita()">Guardar</button>

            </div>
        </div>
    </div>
</div>
