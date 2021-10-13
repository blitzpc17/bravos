@extends('Backend.layouts.body')

@section('title', 'Usuarios')

@section('seccion', 'Administración de usuarios')

@push('css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">
     <!-- select2 css -->
    <link rel="stylesheet" href="{{asset('backend/assets/plugins/select2/css/select2.min.css')}}">
    <style>
        table th,
        table td {
            text-align:center;
        }
    </style>
@endpush

@section('bread')
    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="feather icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{route('empleados.show')}}">Sistema</a></li>
    <li class="breadcrumb-item"><a href="{{route('empleados.show')}}">Administración de Usuarios</a></li>
@endsection

@section('contenido')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5>Gestión de usuarios backend</h5>
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
                                    <th>Clave</th>
                                    <th>Nombre</th>
                                    <th>Alias</th>
                                    <th>Perfil</th>
                                    <th>Estado</th>
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

<div id="md-add" class="modal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            
            <form id="frm-add" autocomplete="off">
                @csrf
                <input type="hidden" name="iden" id="iden">
                <div class="form-group">
                    <label for="">Empleado</label>
                    <select name="empleado" id="cbxEmpleados"></select>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                    <label for="">Alias</label>
                    <input type="text" class="form-control" name="alias" id="alias"  >
                    <small id="alias_err" class="form-text"></small>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Contraseña</label>
                    <input type="text" class="form-control" name="password" id="password" aria-describedby="helpId" placeholder="">
                    <small id="password_err" class="form-text">Help text</small>
                </div>  
                 <div class="form-group">
                    <label for="">Perfil</label>
                    <select name="perfil" id="perfil" class="form-control">
                        @foreach($perfiles as $per)
                            <option value="{{$per->id}}">{{$per->nombre}}</option>
                        @endforeach
                    </select>
                    <small id="estado_err" class="form-text"></small>
                </div> 
                <div class="form-group">
                    <label for="">Estado</label>
                    <select name="estado" id="estado" class="form-control">
                        @foreach($estados as $edo)
                            <option value="{{$edo->id}}">{{$edo->nombre}}</option>
                        @endforeach
                    </select>
                    <small id="estado_err" class="form-text"></small>
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
    
    <!-- select2 Js -->
    <script src="{{asset('Backend/assets/plugins/select2/js/select2.full.min.js')}}"></script>

    <script>
        var tabla = '';
        $(document).ready(function () {

            console.log("running...") 
            tabla =  $('#tb-registros').DataTable({
                            language:{
                                "url":"{{asset('Backend/assets/jsons/datatable-lengua.json')}}"
                            },
                            ajax: "{{url('admin/usuarios/listar')}}",                         
                            columns: [
                               {"data": null},
                               {"data":"clave"},
                               {"data":"nombre"},
                               {"data":"alias"},
                               {"data":"perfil"},
                               {"data":"estado"}
                            ],
                            columnDefs:[
                                {
                                    "targets":6,
                                    "render":function (data, type, row, meta){
                                        var html = '<button type="button" class="btn btn-warning" onclick="Modificar('+row.id+')"><i class="fas fa-edit"></i></button>';                                          
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
            LlenarCbxEmpleados();

            function ReiniciarForm(){
                
                ResetTabla();
                LimpiarSmallError();
                LlenarCbxEmpleados();
            }   
       
            $("#btn-new").on('click', function(){
                $(".modal-title").text("Nuevo registro");   
                $('#iden').val();
                LlenarCbxEmpleados();
                $('#md-add').modal('toggle')                   
            });           


            $('#frm-add').on('submit', function(event){
                event.preventDefault();
                $.ajax({
                    method: "POST",
                    url: "{{route('admin.usuarios.save')}}",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType:"json",
                    success: function (response) {
                        console.log(response)
                        if(response.code== 200){
                            swal("Aviso", response.msj, "success").then(function(){    
                                ResetTabla();
                                ReiniciarModalSave();                                                           
                                $('#md-add').modal('toggle');
                            });
                        }else if(response.code==400){
                            if(response.control){
                                console.log('entro control')
                                if(response.control=="password"){
                                    //LimpiarSmallError();
                                    prinErrorMsgInvidual(response.control, response.msj);
                                }
                            }else{
                                swal("Advertencia", response.msj, "warning").then(()=>{
                                    printErrorMsg(response.Contenido);
                                });
                            }
                            
                        }else{
                            swal("Error", response.msj, "error");
                            console.log(response.code);
                        }
                        
                    },

                });
            });

            

        });

        function ReiniciarModalSave(){
            $("#frm-add")[0].reset();
            LlenarCbxEmpleados();               
            LimpiarSmallError();                
        }

        function Modificar(id){            
            $.get("{{url('admin/usuarios/obtener/')}}"+"/"+id, function (data) {
            
                    ReiniciarModalSave();
                    $("#op").val('M');                    
                    $("#iden").val(data.id);
                    $("#alias").val(data.alias);
                    $("#password").val(data.password);
                    $("#estado").val(data.estadoprocesousuarioid).trigger('change'); 
                    $("#cbxEmpleados").val(data.empleadoid).trigger('change'); 
                    $("#perfil").val(data.perfilusuarioadminid).trigger('change'); 
                    $("#md-add").modal('toggle');
                });
        }

        function ResetTabla(){
            tabla.ajax.reload(null, false);
        }

        function printErrorMsg (msg) {
            LimpiarSmallError();
            $.each( msg, function( key, value ) {
              $('#'+key+'_err').text(value);
              $('#'+key+'_err').css({'color':'orange', 'font-wight':'bold'})
              $('#'+key+'_err').css({'color':'orange', 'font-wight':'bold'})
              $('#'+key).css('border','2px solid orange');
            });
        }

        function prinErrorMsgInvidual(ctrl,msj){
           var ctrl = ctrl;
           var msj = msj;
            swal("Advertencia", msj, "warning").then(() =>{
                $('#'+this.ctrl+'_err').text(this.msj);
                $('#'+this.ctrl+'_err').css({'color':'orange', 'font-wight':'bold'})
                $('#'+this.ctrl+'_err').css({'color':'orange', 'font-wight':'bold'})
                $('#'+this.ctrl).css('border','2px solid orange');
            });            
        }

        function LimpiarSmallError(){
            $('small').text('');
            $('input').css('border','1px solid #ced4da');
        }

        

        function LlenarCbxEmpleados(){
            var url ="{{url('admin/empleados/listar/cbx')}}";         
            $(function(){
                $.ajax({
                    type:"GET",
                    url:url,
                    success:function(data){
                        $('#cbxEmpleados').append($('<option />').val(-1).text("Elija una opción"));
                        $.each(data, function(index, row){
                            $('#cbxEmpleados').append($('<option />').val(row.Id).text(row.nombre));
                        })
                        $('#cbxEmpleados').select2({
                            dropdownParent: $("#md-add")
                        });
                    }
                })
            });

        }
    </script>

     <script type="text/javascript">
        
    </script>

@endpush