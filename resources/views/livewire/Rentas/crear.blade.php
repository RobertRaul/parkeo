<section id="Crear">
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Registrar Renta</h3>
        </div>
        <div class="card-body">
            <form action="">
                <div class="widget-one">
                    <!--div titulo y boton regersar -->
                    <div class="row">
                        <div class="col-2">
                            <button class="btn btn-danger" wire:click="$set('accion',0)">
                                <i class="fas fa-arrow-left"></i>
                            </button>
                        </div>
                        <div class="col-8">
                            <h5 class="text-center"><b>TICKET DE PENSIÓN</b></h5>
                        </div>
                        <div class="col-2 text-right">
                            <label id='ct'></label>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <h5 class="col-sm-6">
                            <label>Datos del Cliente</label>
                        </h5>
                        <div class="col-sm-6 custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="checkboxpublico">
                            <label for="checkboxpublico" class="custom-control-label">Publico General</label>
                        </div>

                        <div class="form-group col-lg-2 col-md-2 col-sm-12">
                            <label for="">Tipo Documento*</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-filter"></i></div>
                                </div>
                                <select class="form-control" id="selecttipo">
                                    <option value="AA">AA</option>
                                    <option value="AA">AA</option>
                                    <option value="AA">AA</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-md-2 col-sm-12">
                            <label for="">Nro Doc*</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-sort-numeric-up-alt"></i></div>
                                </div>
                                <input type="text" class="form-control" maxlength="30" placeholder="123456789">

                            </div>
                        </div>

                        <div class="form-group col-lg-3 col-md-3 col-sm-12">
                            <label for="">Nombres*</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-text-height"></i></div>
                                </div>
                                <input type="text" class="form-control" maxlength="30" placeholder="Pepe Luis Fox">

                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-md-2 col-sm-12">
                            <label for="">Celular*</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-phone"></i></div>
                                </div>
                                <input type="text" class="form-control" maxlength="30" placeholder="955 555 355">

                            </div>
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-12">
                            <label for="">Email*</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-at"></i></div>
                                </div>
                                <input type="text" class="form-control" maxlength="30" placeholder="hola@gmail.com">

                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>

</section>


<script>
    $(function() {
        $('#checkboxpublico').on('click', function() {
            if ($(this).is(':checked')) {
                $('#selecttipo').attr('disabled', true);
            } else {
                $('#selecttipo').attr('disabled', false);
            }
        });


</script>
