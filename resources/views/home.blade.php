@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    
@stop

@section('content')
    <div class="main-content">
        
        <div class="row">

            <div class="col-lg-7">
                <div class="card mt-2">
                    <div class="card-body">
                       
                            {{-- metodo que genera un DIV con ID unico donde se carga el grafico --}}
                            {!! $chartIngresosmensual->container() !!}

                            {{-- INCLUYE archivo javascript de larapex --}}
                            
                            <script src="{{ @asset('vendor/larapex-charts/apexcharts.js') }}"></script>

                            {{-- Renderiza el json enviando desd el backed a javascript para renderizar al grafico --}}
                            {{ $chartIngresosmensual->script() }}
                      

                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card mt-2">
                    <div class="card-body">
                     
                            {{-- metodo que genera un DIV con ID unico donde se carga el grafico --}}
                            {!! $chartRentasSemanal->container() !!}

                            {{-- INCLUYE archivo javascript de larapex --}}
                   

                            {{-- Renderiza el json enviando desd el backed a javascript para renderizar al grafico --}}
                            {{ $chartRentasSemanal->script() }}
                     

                    </div>
                </div>
            </div>


            <div class="col-lg-12 col-md-12 col-ms-12 mt-2">
                <div class="card">
                    <div class="card-body">
                        
                           {{-- metodo que genera un DIV con ID unico donde se carga el grafico --}}
                           {!! $chartBalanceMensual->container() !!}

                           {{-- INCLUYE archivo javascript de larapex --}}
                           

                           {{-- Renderiza el json enviando desd el backed a javascript para renderizar al grafico --}}
                           {{ $chartBalanceMensual->script() }}
                       
                    </div>
                </div>
            </div>

        </div>
    </div>
@stop

