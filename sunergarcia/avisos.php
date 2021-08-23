<!DOCTYPE html>
<html>
<head>
    <title></title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">



    <style type="text/css">
        .table{
            text-align: center;
        }
    </style>
</head>
<body>



<div class="container">
    <div class="row">
        <H2>Avisos</H2>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12 pb-5">
            <button type="button" onclick="modalNuevo()" class="btn btn-success">Nuevo Aviso</button>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Titulo</th>
                <th>Contenido</th>
                <th>Editar</th>
                <th>Borrar</th>
            </tr>
            </thead>
            <tbody id="bodyTabla">

            </tbody>
        </table>
    </div>

    <hr>

    <div class="modal fade" id="actualizarModal" tabindex="-1" role="dialog" aria-labelledby="actualizarModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="actualizarModalLongTitle">Actualizar aviso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="actualizaTitulo">Titulo</label>
                        <input type="text" class="form-control notEmptyActualiza" id="actualizaTitulo" placeholder="Ingresa el titulo">
                        <input type="hidden" id="actualizaId">
                    </div>
                    <div class="form-group">
                        <label for="actualizaContenido">Contenido</label>
                        <textarea class="form-control notEmptyNuevo" id="actualizaContenido" placeholder="Ingresa el contenido"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" onclick="updateAviso();">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="nuevoModal" tabindex="-1" role="dialog" aria-labelledby="nuevoModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="actualizarModalLongTitle">Nuevo aviso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nuevoNombre">Titulo</label>
                        <input type="text" class="form-control notEmptyNuevo" id="nuevoTitulo" placeholder="Ingresa el nombre">
                    </div>
                    <div class="form-group">
                        <label for="nuevoContenido">Contenido</label>
                        <textarea class="form-control notEmptyNuevo" id="nuevoContenido" placeholder="Ingresa el contenido"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" onclick="nuevoAviso();">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript">

        $( document ).ready(function() {
            loadContenido();
        });

        const  loadContenido =()=> {
            var dataAjax = "method=getInformationAviso";
            var c = 1
            $.ajax({
                data: dataAjax,
                dataType: "json",
                type: "POST",
                url: 'controllers/aviso.php',
                success: function (data) {
                  // console.log(data.json());
                    html = "";
                    $.each(data, function (index, val) {
                        console.log(c);
                        html += "<tr>";
                        html += "<td>" + val.id + "</td><td>" + val.titulo + "</td>";
                        html += "<td>" + val.contenido + "</td>";
                        html += "<td style='text-decoration:none;'><a style='cursor: pointer;' onclick='javascript:modalUpdate(" + val.id + ")'><i class='bi  bi-pencil-square'></i></a></td><td><a style='cursor: pointer;' onclick='javascript:deleteAviso(" + val.id + ")'><i class='fas bi-trash'></i></a></td>";
                        html += "</tr>";
                        c++;
                    });


                    $('#bodyTabla').html(html);


                },
                error: function (xhr, textStatus, errorThrown) {
                    console.log("Error:", xhr);
                }
            });
        }

        const modalNuevo=()=>{
            $('#nuevoTitulo').val("");
            $('#nuevoContenido').val("");
            $('#nuevoModal').modal('toggle');


        }

        const validateEmpty=(modal)=>{
            isEmpty = 0;


            $( ".notEmpty"+modal ).each(function( index ) {
                val = $(this).val();
                if((val == "") || (val == null)){
                    $(this).css("border-color", "red");
                    isEmpty = 1;
                }else{
                    $(this).css("border-color", "#ced4da");
                }
            });

            return isEmpty;
        }

        const nuevoAviso=()=>{
            titulo = $('#nuevoTitulo').val();
            contenido = $('#nuevoContenido').val();

            isEmpty = validateEmpty('Nuevo');
            if(isEmpty == 1){
                alert("Favor de llenar los campos marcados.");
            }else{
                var param = {titulo:titulo, contenido:contenido};
                var dataAjax = "method=insertAviso&param="+ JSON.stringify(param);
                $.ajax({
                    data: dataAjax,
                    dataType: "json",
                    type: "POST",
                    url: 'controllers/aviso.php',
                    success: function (data) {
                        if(data > 0){
                            alert("Los datos del aviso se insertaron correctamente.");
                        }else{
                            alert("Ocurrio un problema al insertar los datos, intente mas tarde.");
                        }

                        $('#nuevoModal').modal('toggle');
                        loadContenido();

                    },
                    error: function (xhr, textStatus, errorThrown) {
                        console.log("Error:", xhr);
                    }
                });
            }

        }

        const modalUpdate=(id)=>{

            var param = {id:id};
            var dataAjax = "method=getAviso&param="+ JSON.stringify(param);
            $.ajax({
                data: dataAjax,
                dataType: "json",
                type: "POST",
                url: 'controllers/aviso.php',
                success: function (data) {
                    $('#actualizaTitulo').val(data.titulo);
                    $('#actualizaContenido').val(data.contenido);
                    $('#actualizaId').val(id);
                    
                    $('#actualizarModal').modal('toggle');


                },
                error: function (xhr, textStatus, errorThrown) {
                    console.log("Error:", xhr);
                }
            });

        }

        function updateAviso(){
            id = $('#actualizaId').val();
            titulo = $('#actualizaTitulo').val();
            contenido = $('#actualizaContenido').val();


            isEmpty = validateEmpty('Actualiza');
            if(isEmpty == 1){
                alert("Los campos en rojo no pueden estar vacios.");
            }else{
                var param = {id:id, titulo:titulo, contenido:contenido};
                var dataAjax = "method=updateAviso&param="+ JSON.stringify(param);
                $.ajax({
                    data: dataAjax,
                    dataType: "json",
                    type: "POST",
                    url: 'controllers/aviso.php',
                    success: function (data) {
                        if(data == 1){
                            alert("Los datos del aviso se actualizaron correctamente.");
                        }else{
                            alert("Ocurrio un problema al actualizar los datos, intente mas tarde.");
                        }

                        $('#actualizarModal').modal('toggle');
                        loadContenido();

                    },
                    error: function (xhr, textStatus, errorThrown) {
                        console.log("Error:", xhr);
                    }
                });
            }

        }

        function deleteAviso(id){
            var borrar=confirm("¿Seguro de eliminar el aviso?");
            if(borrar){
                var param = {id:id};
                var dataAjax = "method=deleteAviso&param="+ JSON.stringify(param);
                $.ajax({
                    data: dataAjax,
                    dataType: "json",
                    type: "POST",
                    url: 'controllers/aviso.php',
                    success: function (data) {
                        if(data == 1){
                            alert("El aviso se eliminó correctamente.");
                        }else{
                            alert("Ocurrio un problema al eliminar el aviso, intente mas tarde.");
                        }
                        
                        loadContenido();
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        console.log("Error:", xhr);
                    }
                });
            }
        }
        
    </script>

</body>
</html>