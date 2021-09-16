@extends('Backend.layouts.body')

@section('title', 'Giros Empresa')

@section('seccion', 'Administración de Giros de Empresa')

@push('css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">
@endpush

@section('bread')
    <li class="breadcrumb-item"><a href="{{route('admin.home')}}"><i class="feather icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{route('giros.show')}}">Sistema</a></li>
    <li class="breadcrumb-item"><a href="{{route('giros.show')}}">Giros de Empresa</a></li>
@endsection

@section('contenido')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5>Catálogo de giros de empresa</h5>
                </div>
                <div class="card-block">
                    
                    <div class="d-flex flex-row-reverse">
                        <div class="p-2">
                            <button type="button" id="btn-new" class="btn btn-primary">Nuevo registro</button>
                        </div>                        
                    </div>
                    <div class="table-responsive">
                        <table id="tb-registros" class="table table-bordered table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    

                </div>
            </div>

        </div>

    </div>



@endsection

@section('modals')

<div id="md-add" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frm-add" >
            @csrf
            <input type="hidden" name="op" id="op">
            <input type="hidden" name="id" id="iden">
            <div class="form-row">
                <div class="form-group col">
                  <label for="">Nombre:</label>
                  <input type="text" class="form-control" name="nombre" id="nombre"  >
                  <small id="nombre_err" class="form-text"></small>
                </div>
            </div>  
      </div>
      <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </form>
      </div>
    </div>
  </div>
</div>


@endsection



@push('js')

    <script src="//cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>

    <script>
        var tabla = '';
        $(document).ready(function () {

            console.log("running...")

            tabla =  $('#tb-registros').DataTable({
                            language:{
                                "url":"{{asset('Backend/assets/jsons/datatable-lengua.json')}}"
                            },
                            ajax: "{{url('admin/girosEmpresa/listar')}}",                         
                            columns: [
                               {"data": null},
                               {"data":"nombre"}
                            ],
                            columnDefs:[
                                {
                                    "targets":2,
                                    "render":function (data, type, row, meta){
                                        var html = '<button type="button" class="btn btn-warning" onclick="Modificar('+row.id+')"><i class="fas fa-edit"></i></button>';
                                            html+= '<button type="button" class="btn btn-danger" onclick="Eliminar('+row.id+')"><i class="fas fa-trash"></i></button>';
                                       return html;
                                    }
                                }
                            ],

                        });

                        tabla.on( 'order.dt search.dt', function () {
                        tabla.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                                cell.innerHTML = i+1;
                            } );
                        } ).draw();
            
            

            $("#btn-new").on('click', function(){
                $(".modal-title").text("Nuevo registro");
                $("#op").val("I");
                $("#md-add").modal('toggle');
            });


            $('#frm-add').on('submit', function(event){
                event.preventDefault();
                $.ajax({
                    method: "POST",
                    url: "{{route('giros.save')}}",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType:"json",
                    success: function (response) {
                        if(response.code== 200){
                            swal("Aviso", response.msj, "success").then(function(){
                                ReiniciarModalSave();
                                //tabla.ajax.reload(null,false);
                                ResetTabla();
                            });
                        }else if(response.code==401){                            
                            printErrorMsg(response.Contenido);
                            swal("Advertencia", response.msj, "warning");
                        }else if(response.code==400){
                            swal("Advertencia", response.msj, "warning");
                        }else{
                            swal("Error", response.msj, "error");
                            console.log(response.code);
                        }
                        
                    },

                });

                function ReiniciarModalSave(){
                    $("#frm-add")[0].reset();
                    $("#md-add").modal('toggle');
                }

            });
        });

        function Modificar(id){
            $.get("{{url('admin/girosEmpresa/obtener/')}}"+"/"+id, function (data) {
                    $("#op").val('M');                    
                    $("#iden").val(data.id);
                    $("#nombre").val(data.nombre);
                    $("#md-add").modal('toggle');
                });
        }

        function Eliminar(id){
            $.get("{{url('admin/girosEmpresa/del/')}}"+"/"+id, function (data) {
                var titulo ="";
                var tipo ="";
                if(data.code==200){
                    titulo = "Aviso";
                    tipo = "success";
                }else if(data.code == 400){
                    titulo = "Advertencia";
                    tipo = "warning";
                }else{
                    titulo = "Error";
                    tipo = "error";
                }

                swal(titulo, data.msj, tipo).then(function(){                     
                      ResetTabla();
                });
                    
            });
        }        

        function ResetTabla(){
            tabla.ajax.reload(null, false);
        }

        function printErrorMsg (msg) {
            LimpiarSmallError();
            $.each( msg, function( key, value ) {
              $('#'+key+'_err').text(value);
              $('#'+key+'_err').css({'color':'red', 'font-wight':'bold'})
            });
        }

        function LimpiarSmallError(){
            $('small').text('');
        }


        
    </script>

@endpush