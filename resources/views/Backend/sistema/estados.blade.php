@extends('Backend.layouts.body')

@section('title', 'Estados')

@section('seccion', 'Administración de estados')

@push('css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('bread')
    <li class="breadcrumb-item"><a href="{{route('admin.home')}}"><i class="feather icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{route('estados.show')}}">Sistema</a></li>
    <li class="breadcrumb-item"><a href="{{route('estados.show')}}">Administración Estados</a></li>
@endsection

@section('contenido')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5>Catálogo de Estados</h5>
                </div>
                <div class="card-block">
                    
                    <div class="d-flex flex-row-reverse">
                        <div class="p-2">
                            <button type="button" id="btn-new" onclick="NuevoRegistro()" class="btn btn-primary">Nuevo registro</button>
                        </div>                        
                    </div>
                    <div class="table-responsive">
                        <table id="tb-registros" class="table table-bordered table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Proceso</th>
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
            <div class="form-row">
                <div class="form-group col">
                  <label for="">Proceso:</label>
                  <select class="form-control" name="procesoId" id="procesoId">
                  </select>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        var tabla = '';
        $(document).ready(function () {

            console.log("running...")    

            tabla =  $('#tb-registros').DataTable({
                            language:{
                                "url":"{{asset('Backend/assets/jsons/datatable-lengua.json')}}"
                            },
                            ajax: "{{url('admin/estados/listar')}}",                         
                            columns: [
                               {"data": null},
                               {"data":"nombre"},
                               {"data":"NombreProceso"}
                            ],
                            columnDefs:[
                                {
                                    "targets":3,
                                    "render":function (data, type, row, meta){
                                        var html = '<button type="button" class="btn btn-warning" onclick="Modificar('+row.id+', '+row.ProcesoId+')"><i class="fas fa-edit"></i></button>';
                                            html+= '<button type="button" class="btn btn-danger" onclick="Eliminar('+row.id+', '+row.ProcesoId+')"><i class="fas fa-trash"></i></button>';
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


            $('#frm-add').on('submit', function(event){
                event.preventDefault();
                $.ajax({
                    method: "POST",
                    url: "{{route('estados.save')}}",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType:"json",
                    success: function (response) {
                        if(response.code== 200){
                            swal("Aviso", response.msj, "success").then(function(){
                                ReiniciarModalSave();
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

            });

            function ReiniciarModalSave(){
                $("#frm-add")[0].reset();
                $("#md-add").modal('toggle');
            }  

        });

        function ReiniciarCbxProcesos(){
            $("#procesoId").empty();
            $("#procesoId").select2({
                placeholder: "Elige un proceso...", 
                minimunInputLenght:2,
                dropdownParent: $("#md-add"),
                ajax:{
                    type: "GET",
                    url: "{{url('admin/procesos/cbx/listar')}}",                    
                    dataType: "json",
                    delay:250,
                    data: function(params){
                        return {
                            searchTerm:params.term  
                        };
                    },
                    processResults:function(response){
                        return {
                            results:response
                        };
                    },
                    cache:true
                }              
                
            });
        }      

        function NuevoRegistro(){
            $("#frm-add")[0].reset();
            ReiniciarCbxProcesos();
            $(".modal-title").text("Nuevo Estado");
            $("#op").val("I");
            $("#md-add").modal('toggle');
        }

        function Modificar(id, procesoId){
            $.get("{{url('admin/estados/obtener/')}}"+"/"+id+"/"+procesoId, function (data) {
                    $("#frm-add")[0].reset();
                    ReiniciarCbxProcesos();
                    $("#op").val('M');                    
                    $("#iden").val(data.id);
                    $("#nombre").val(data.nombre);
                    console.log(data.ProcesoId);
                // $("#procesoId").val(data.ProcesoId).trigger('change');
                $("#procesoId").select2("trigger", "select", {
                    data:{id:data.ProcesoId, text:data.NombreProceso}
                });
                    //setar proceso
                    $("#md-add").modal('toggle');
            });
        }

        function Eliminar(id, procesoId){
            $.get("{{url('admin/estados/del/')}}"+"/"+id+"/"+procesoId, function (data) {
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