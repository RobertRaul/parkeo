<div>
    <div class="card" 4>
        <div class="card-header">
            Pruebas
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <div class="col-md-4 col-lg-4 col-sm-12">
                    <label class="text-danger">Tarifa</label>
                    <select wire:model="rent_tarifa" class="form-control">
                        <option value="Elegir">Elegir</option>
                        @foreach ($rentas as $r)
                            <option value="{{ $r->rent_id }}" class="form-control">{{$r->Tarifas->tar_valor}} {{$r->Tarifas->tar_tiempo}} * S/ {{$r->Tarifas->tar_precio}}  - Ingreso: {{$r->rent_feching}} </option>
                        @endforeach
                    </select>
                </div>
            </li>
            <li class="list-group-item">
                <div class="form-group">
                    <label>Ingreso: {{ $fecha_ing }} </label>
                    <div class="input-group date" data-target-input="nearest">
                        <input type="datetime-local" id="birthdaytime" name="birthdaytime" class="form-control"
                            wire:model="fecha_ing">
                    </div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="form-group">
                    <label>Salida: {{ $fecha_sal }} </label>
                    <div class="input-group date" id="ingreso" data-target-input="nearest">
                        <input type="datetime-local" id="birthdaytime" name="birthdaytime" class="form-control"
                            wire:model="fecha_sal">
                    </div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="form-group">
                    <button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false"
                        autocomplete="off">Prueba</button>
                </div>
            </li>
            <li class="list-group-item">
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker1'>
                        <input type='text' class="form-control" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>

@section('js')
<script>
    $(function () {
            $('#datetimepicker1').datetimepicker();
        });
</script>
  
@endsection
