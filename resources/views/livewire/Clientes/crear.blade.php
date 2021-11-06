<div wire:ignore.self class="modal fade" id="Modal" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            @if ($updateMode == false)
                <div class="modal-header modal-header-success"> {{-- Modal color verde Success --}}
                @else
                    <div class="modal-header modal-header-warning"> {{-- Modal color amarillo Success --}}
            @endif
            <h5 class="modal-title" id="exampleModalLabel">
                @if ($updateMode == false)
                    Registrar Clientes
                @else
                    Modificar Clientes
                @endif
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form>
                <div class="form-row">
                    <div class="col-md-6">
                        <label>Tp. Documento</label>
                        <select wire:model="clie_tpdi" class="form-control">
                            <option value="Elegir">Elegir</option>
                            @foreach ($tipodoc as $td)
                                <option value="{{ $td->tpdi_id }}">{{ $td->tpdi_desc }} </option>
                            @endforeach
                        </select>
                        @error('clie_tpdi') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="clie_numdoc">Nro Documento</label>
                        <input wire:model="clie_numdoc" type="text" class="form-control" id="clie_numdoc"
                            placeholder="N° Documento">
                        @error('clie_numdoc') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="clie_nombres">Nombres / Razon Social</label>
                    <input wire:model="clie_nombres" type="text" class="form-control" id="clie_nombres"
                        placeholder="Nombres">
                    @error('clie_nombres') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="clie_celular">Celular</label>
                    <input wire:model="clie_celular" type="text" class="form-control" id="clie_celular"
                        placeholder="Celular">
                    @error('clie_celular') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="clie_email">Email</label>
                    <input wire:model="clie_email" type="text" class="form-control" id="clie_email" placeholder="Email">
                    @error('clie_email') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>

            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                wire:click="resetInput">Cancelar</button>
            @if ($updateMode == false)
                <button type="button" wire:click.prevent="store_update()" class="btn btn-primary">Registrar</button>
            @else
                <button type="button" wire:click.prevent="store_update()" class="btn btn-warning">Modificar</button>
            @endif
        </div>
    </div>
</div>
</div>

