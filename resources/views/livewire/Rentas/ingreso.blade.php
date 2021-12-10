<div wire:ignore.self class="modal fade" id="modalIngreso" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header-danger">
                <h5 class="text-center">TICKET DE SALIDA</h5>
            </div>
            <div class="modal-body">
                <form action="">
                    <!--div Datos del Cliente -->
                    <div class="row">
                        <div class="form-group col-4">
                            <label>Serie</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <select class="form-control" wire:model="ing_serid">
                                    <option value="Elegir">Elegir</option>
                                    @foreach ($series as $s)
                                        <option value="{{ $s->ser_id }}"> {{ $s->ser_serie }} </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('ing_serid') <span class="error text-danger"
                                    id="numdoc_message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-4">
                            <label>Tp. Pago</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <select class="form-control" wire:model="ing_tppago">
                                    <option value="Elegir">Elegir</option>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Mastercard">Mastercard</option>
                                    <option value="Visa">Visa</option>
                                </select>
                            </div>
                            @error('ing_tppago') <span class="error text-danger"
                                    id="numdoc_message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-3">
                            <label>Nro Ref</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <input wire:model="ing_nref" type="text" class="form-control" maxlength="11">
                            </div>
                            @error('ing_nref') <span class="error text-danger"
                                    id="numdoc_message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    

                    <div class="row">
                        <div class="form-group col-4">
                            <label>Subtotal</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <input wire:model="ing_subtotal" type="text" class="form-control" maxlength="11"
                                    disabled>
                            </div>
                            @error('ing_subtotal') <span class="error text-danger"
                                id="numdoc_message">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group col-4">
                            <label>IGV</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <input wire:model="ing_igv" type="text" class="form-control" maxlength="11" disabled>
                            </div>
                            @error('ing_igv') <span class="error text-danger"
                                    id="numdoc_message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-4">
                            <label>Total</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <input wire:model="ing_total" type="text" class="form-control" maxlength="11"
                                    disabled>
                            </div>
                            @error('ing_total') <span class="error text-danger"
                                    id="numdoc_message">{{ $message }}</span>
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
