<div class="modal fade" id="modalRenta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Ticket Rapido</h5>
            </div>            
            <div class="modal-body">
             <input type="text" wire:keydown.enter="$emit('doCheckIn', $('#tarifa').val(),  $('#cajon').val(), 'DISPONIBLE', $('#comment').val() )" id="comment" maxlength="30" class="form-control"  autofocus> 
         </div>
         <div class="modal-footer">
            <button class="btn btn-dark" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
            <button type="button" class="btn btn-primary saveRenta">Guardar</button>

        </div>
    </div>
</div>
</div>