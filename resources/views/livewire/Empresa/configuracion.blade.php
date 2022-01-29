
<div class="card card-light">
    <div class="card-header container-fluid">
        <div class="row">
            <div class="col-md-10">
                <h3>Configuraciones Empresa</h3>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="form-row">
            <div class="col-md-2">
                <label for="">Ruc:</label>
                <input type="number" class="form-control" wire:model='empr_ruc'>
                @error('empr_ruc') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-4">
                <label for="">Razon Social:</label>
                <input type="text" class="form-control" wire:model='empr_razon'>
                @error('empr_razon') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-4">
                <label for="">Direccion:</label>
                <input type="text" class="form-control" wire:model='empr_direcc'>
                @error('empr_direcc') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-2">
                <label for="">Telefono:</label>
                <input type="number" class="form-control" wire:model='empr_telef'>
                @error('empr_telef') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-row">

            <div class="col-md-2">
                <label for="">Logo Actual:</label>
                @if ($empr_logo==null)
                <img src="{{ asset('images/logo/no_logo.png') }}" width="180" height="100" />
                @else
                <img src="{{ asset('images/logo/'. $empr_logo) }}" width="180" height="100" />
                @endif
            </div>

            <div class="col-md-4">
                <label for="">Logo:</label>
                <input type="file" class="form-control" wire:model='empr_logo'>
                @error('empr_logo') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-4">
                <label for="">Email:</label>
                <input type="text" class="form-control" wire:model='empr_email'>
                @error('empr_email') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-2">
                <label for="">Impresora Tickets:</label>
                <select  class="form-control" wire:model='empr_impr'>
                    <option value="Seleccionar">Seleccionar</option>
                    @foreach ($impresoras as $i)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endforeach
                </select>
                @error('empr_impr') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>

        </div>

        <div class="form-row mt-2">
            <div class="col-md-3">
                <button type="button" class="btn btn-primary" wire:click='Guardar' >Guardar</button>
                <button type="button" class="btn btn-primary" wire:click='ListadoImpresoras' >Probando</button>
            </div>
        </div>
    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded',function()
    {
        window.onload = function()
        {
            window.livewire.emit("carga_impresora")
        };
    })
</script>


