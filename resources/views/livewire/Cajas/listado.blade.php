<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header container-fluid">
                <div class="row">
                    <div class="col-md-10">
                        <h3>
                            <i class="fas fa-cash-register"></i>
                            Caja {{ $caj_codigo }}
                        </h3>
                    </div>
                    <div class="col-md-1 float-right">
                        <div class="text-right">
                            @if ($caj_codigo==-1)
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Modal">
                                <i class="fas fa-door-open"></i>
                                Aperturar
                            </button>
                            @else
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Modal" disabled>
                                <i class="fas fa-door-open"></i>
                                Aperturar
                            </button>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-1 float-right">
                        <div class="text-right">

                          @if ($caj_codigo==-1)
                          <button type="button" class="btn btn-danger" disabled>
                            <i class="fas fa-door-closed"></i>
                            Cierre
                        </button>
                          @else
                          <button type="button" class="btn btn-danger" onclick="Cerrar_Caja()">
                            <i class="fas fa-door-closed"></i>
                            Cierre
                        </button>
                          @endif
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <div class="card">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center">Id</th>
                                    <th class="text-center">F. Apertura</th>
                                    <th class="text-center">F. Cierre</th>
                                    <th class="text-center">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cajas as $c)
                                   <tr>
                                       <td class="text-center"> {{$c->caj_id}} </td>
                                       <td class="text-center"> {{$c->caj_feaper}} </td>
                                       <td class="text-center"> {{$c->caj_fecierr}} </td>
                                       <td class="text-center">


                                        @if ($c->caj_st =='Open')
                                            <h5><span class="badge badge-success">{{$c->caj_st}}</span></h5>
                                        @else
                                            <h5><span class="badge badge-danger">{{$c->caj_st}}</span></h5>
                                        @endif
                                       </td>
                                   </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xs-8 col-sm-8 col-sm-8 col-lg-8">
                <div class="card">
                    nivel 2 b
                </div>
            </div>
        </div>
        @include('livewire.cajas.crear')
    </div>
</div>


<script>
    //funcion eliminar roles
    function Cerrar_Caja()
    {
        Swal.fire({
                title: 'Confirmar',
                text: '¿Deseas Cerrar la caja? Esta accion no puede modificarse',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
            }).then((result)=>{
                if (result.value)
                {
                    window.livewire.emit('CerrarCaja')
                    swal.close()
                }
            })
    }


    window.addEventListener("DOMContentLoaded", function () {
        Livewire.emit("caja_mensajes");
    });
</script>
