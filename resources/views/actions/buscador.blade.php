<div class="row mb-4">
    <div class="col form-inline">
        Mostrar&nbsp;
        <select wire:model="pagination" class="form-control">
            <option>5</option>
            <option>10</option>
            <option>20</option>
            <option>50</option>
        </select>
        &nbsp;Registros
    </div>
    <div class="">
        <button type="button" wire:click="reporte_excel" class="btn btn-success">
            <i class="fas fa-file-excel"></i>
        </button>
        <button type="button" wire:click="reporte_pdf" class="btn btn-danger">
            <i class="fas fa-file-pdf"></i>
        </button>
    </div>
    <div class="form-group col-lg-2">
        <input wire:model="buscar" class="form-control" type="text" placeholder="Buscar..">
    </div>
</div>


