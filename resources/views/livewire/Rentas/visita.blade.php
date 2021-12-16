<div wire:ignore.self class="modal fade" id="modalTicket" data-backdrop="static" tabindex="-1" role="dialog"   aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h5 class="modal-title">Generar Ticket Rapido</h5>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label class="text-danger">Tarifa:</label>
                        <select wire:model="rent_tarifa" class="form-control text-primary">
                          <option value="Elegir">Elegir</option>
                          @foreach ($tarifas as $t)
                            <option value="{{$t->tar_id}}" class="form-control"> {{$t->tar_valor}} {{$t->tar_tiempo}} * S/ {{$t->tar_precio}}                                 
                              - Tolerancia: {{$t->tar_tolerancia}} Minutos
                            </option>
                          @endforeach
                        </select>
                        @error('rent_tarifa') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="text-danger">Dejo Llaves:</label>
                        <select wire:model="rent_llaves" class="form-control">
                          <option value="Elegir">Elegir</option>
                          <option value="Si">Si</option>
                          <option value="No">No</option>
                        </select>
                        @error('rent_llaves') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="text-danger">Observacion:</label>
                        <textarea class="form-control" rows="2"  wire:model="rent_obser"></textarea>
                        @error('rent_obser') <span class="error text-danger">{{ $message }}</span> @enderror
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
