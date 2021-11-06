<div class="row">
    <div class="col-sm-12">      
        <div class="card">
            <div class="card-header container-fluid">
                <div class="row">
                    <div class="col-md-10">
                        <h3>
                            <i class="fas fa-cash-register"></i>
                            Caja
                        </h3>
                    </div>
                    <div class="col-md-1 float-right">
                        <div class="text-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Modal">
                                <i class="fas fa-door-open"></i>
                                Aperturar
                            </button>
                        </div>
                    </div>

                    <div class="col-md-1 float-right">
                        <div class="text-right">
                            <button type="button" class="btn btn-danger">
                                <i class="fas fa-door-closed"></i>
                                Cierre
                            </button>
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
                                    <th>Id</th>
                                    <th>F. Apertura</th>
                                    <th>F. Cierre</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cajas as $c)
                                   <tr>
                                       <td> {{$c->caj_id}} </td>
                                       <td> {{$c->caj_feaper}} </td>
                                       <td> {{$c->caj_fecierr}} </td>
                                       <td>
                                            
                                            
                                        @if ($c->caj_st =='Aperturado')
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
