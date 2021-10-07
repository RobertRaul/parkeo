<div class="card">
    <div class="card-header container-fluid">
        <div class="row">
            <div class="col-md-10">
                <h3>@yield('name_component') {{--Yield para el nombre del componente--}} </h3>
            </div>

            @yield('button_new') {{--Yield para ver si se agrega el boton nuevo o no --}}
        </div>
    </div>

    <div class="card-body">

        @yield('card_body')
        
        {{--BUSCADOOR --}}
        @include('actions.buscador')

        <div class="table-responsive">
            <table class="table table-striped table-bordered dt-responsive nowrap">
                <thead>
                    <tr>
                        @yield('table_header')
                    </tr>
                </thead>
                <tbody>
                        @yield('table_body')
                </tbody>
            </table>
              {{--PAGINACION --}}
            @include('actions.paginacion')
        </div>
    </div>

</div>
