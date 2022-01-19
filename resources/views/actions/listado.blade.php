<div class="card card-light">
    <div class="card-header container-fluid">
        <div class="row">
            <div class="col-md-10">
                <h3>@yield('name_component') {{-- Yield para el nombre del componente --}} </h3>
            </div>

            @yield('button_new') {{-- Yield para ver si se agrega el boton nuevo o no --}}
        </div>
    </div>

    <div class="card-body">

        @yield('card_body')

        {{--BUSCADOOR --}}
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
                    @yield('btn_reports')
            </div>
        
            <div class="form-group col-lg-2">
                <input wire:model="buscar" class="form-control" type="text" placeholder="Buscar..">
            </div>
        </div>
        
       {{-- FINAL DEL BUSCADOR--}}  

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
            {{-- PAGINACION --}}
            @include('actions.paginacion')
        </div>
    </div>
</div>

