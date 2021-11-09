<div wire:ignore.self class="modal fade" id="modalTicket" data-backdrop="static" tabindex="-1" role="dialog"   aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header-success">
                <h5 class="modal-title">Generar Ticket Rapido</h5>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label>Tarifa</label>
                        <select wire:model="rent_tarifa" class="form-control">
                          <option value="Elegir">Elegir</option>
                          @foreach ($tarifas as $t)
                              <option value="{{$t->tar_id}}"> {{$t->tar_desc}} - Precio: {{$t->tar_precio}} Tiempo: {{$t->tar_tiempo}}</option>
                          @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Dejo Llaves?</label>
                        <select wire:model="rent_llaves" class="form-control">
                          <option value="Elegir">Elegir</option>
                          <option value="Si">Si</option>
                          <option value="No">No</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Observacion</label>
                        <textarea class="form-control" rows="3"></textarea>
                        <input type="text" wire:model="rent_obser" id="comment" maxlength="30" class="form-control">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-dark" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                <button type="button" class="btn btn-primary saveRenta">Guardar</button>

            </div>
        </div>
    </div>
</div>
