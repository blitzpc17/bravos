@extends('Backend.layouts.body')

@section('title', 'Empleados')

@section('seccion', 'Administración de empleados')

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
    <li class="breadcrumb-item"><a href="{{route('admin.home')}}"><i class="feather icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{route('empleados.show')}}">Sistema</a></li>
    <li class="breadcrumb-item"><a href="{{route('empleados.show')}}">Administración de Empleados</a></li>
@endsection

@section('contenido')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5>Gestión de empleados</h5>
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
                                    <th>Puesto</th>
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
            
            <form id="frm-add" >
                @csrf
                <input type="hidden" name="id" id="iden">
                <div id="divClaveRegistro" class="form-group">
                    <label for="">Clave empleado</label>
                    <input type="text"
                        class="form-control" name="claveRegistro" id="claveRegistro" aria-describedby="helpId" readonly>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                    <label for="">Nombre(s)</label>
                    <input type="text" class="form-control" name="nombres" id="nombres"  >
                    <small id="nombres_err" class="form-text"></small>
                    </div>
                </div>
                <div class="form-group">
                <label for="">Apellidos</label>
                <input type="text" class="form-control" name="apellidos" id="apellidos" aria-describedby="helpId" placeholder="">
                <small id="apellidos_err" class="form-text">Help text</small>
                </div>
                
                <div class="form-row">
                    <div class="form-group col">
                        <label for="">Telefono</label>
                        <input class="form-control" type="number" name="telefono" id="telefono" >
                        <small id="telefono_err" class="form-text"></small>
                    </div>
                    <div class="form-group col">
                        <label for="">Correo</label>
                        <input class="form-control" type="text" name="correo" id="correo" >
                        <small id="correo_err" class="form-text"></small>
                    </div>
                </div>

                <div class="form-group">
                <label for="">DNI</label>
                <input type="text"
                    class="form-control" name="dni" id="dni" aria-describedby="helpId" placeholder="">
                    <small id="dni_err" class="form-text">Help text</small>
                </div>

                <div class="form-group">
                <label for="">CURP</label>
                <input type="text"
                    class="form-control" name="curp" id="curp" aria-describedby="helpId" placeholder="">
                <small id="curp_err" class="form-text">Help text</small>
                </div>

                <div class="form-row">
                    <div class="form-group col">
                        <label for="">Fotografía INE (Derecho y reverso)</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Subir</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="docIne[]" id="docIne[]" onclick="this.value=null;" onchange="CargarArchivo(this, 'Ine')" multiple>
                                <label class="custom-file-label" for="inputGroupFile01">Elija un archivo</label>
                            </div>
                        </div>
                        <small id="docIne_cargados" style="font-weight:bold"></small>
                        <small id="docIne_err" class="form-text">Help text</small>
                        <div id="divIneFotos" style="width:100%"></div>
                    </div>
                    <div class="form-group col">
                        <center>
                            <img id="picIne" src="{{asset('Backend/assets/images/backend/credentialOff.png')}}" alt="" class="img-fluid">
                        </center>                    
                    </div>
                </div>

                <div class="form-row">
                <div class="form-group col">
                        <label for="">Fotografía Empleado</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Subir</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="docFotografia" id="docFotografia" onclick="this.value=null;" onchange="CargarArchivo(this, 'Fotografia')" multiple>
                                <label class="custom-file-label" for="inputGroupFile01">Elija un archivo</label>
                            </div>
                        </div>
                        <small id="docFotografia_cargados"></small>
                        <small id="docFotografia_err" class="form-text">Help text</small>
                        <div id="divFotografiaFotos" style="width:100%"></div>
                    </div>
                    <div class="form-group col">
                        <center>
                            <img id="picFoto" src="{{asset('Backend/assets/images/backend/fotoPersonOff.png')}}" alt="" class="img-fluid">
                        </center>                    
                    </div>
                </div>

                
                <div class="form-row">                
                    <div class="form-group col">
                        <label for="">Fotografía Licencia</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Subir</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="docLicencia[]" id="docLicencia[]" onclick="this.value=null;" onchange="CargarArchivo(this, 'Licencia')" multiple>
                                <label class="custom-file-label" for="inputGroupFile01">Elija un archivo</label>
                            </div>
                        </div>
                        <small id="docLicencia_cargados"></small>
                        <small id="docLicencia_err" class="form-text">Help text</small>
                        <div id="divLicenciaFotos" style="width:100%"></div>
                    </div>
                    <div class="form-group col">
                        <center>
                            <img id="picLicencia" src="{{asset('Backend/assets/images/backend/credentialOff.png')}}" alt="" class="img-fluid">
                        </center>                    
                    </div>
                </div>            

                <div class="form-row">
                    <div class="form-group col">
                        <label for="">Tipo Empleado</label>
                        <select name="tipoEmpleado" id="tipoEmpleado" class="form-control" >
                            @foreach($tipoEmpleados as $tip)
                                <option value="{{$tip->id}}">{{$tip->nombre}}</option>
                            @endforeach
                        </select>
                        <small id="tipoEmpleado_err" class="form-text"></small>
                    </div>
                    <div class="form-group col">
                        <label for="">Estado del Empleado</label>
                        <select name="estado" id="estado" class="form-control">
                            @foreach($estados as $edo)
                                <option value="{{$edo->id}}">{{$edo->nombre}}</option>
                            @endforeach
                        </select>
                        <small id="estado_err" class="form-text"></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col">
                        <label for="">Puesto</label>
                        <select id="puestos" name="puestos" class="form-control">
                            @foreach($puestos as $pue)
                                <option value="{{$pue->id}}">{{$pue->nombre}}</option>
                            @endforeach                            
                        </select>
                        <small id="puestos_err" class="form-text">Help text</small>
                    </div>
                    <div class="form-group col">
                        <label for="">Código Postal</label>
                        <input type="text" class="form-control" name="codigoPostal" id="codigoPostal" aria-describedby="helpId" placeholder="">
                        <small id="codigoPostal_err" class="form-text">Help text</small>
                    </div>              
                </div>

                <div class="form-row">                         
                    <div class="form-group col">
                        <label for="">Estado</label>
                        <input type="text" class="form-control" name="estadoUbicacion" id="estadoUbicacion" aria-describedby="helpId" placeholder="">
                        <small id="estadoUbicacion_err" class="form-text">Help text</small>
                    </div>   
                     <div class="form-group col">
                        <label for="">Municipio</label>
                        <input type="text" class="form-control" name="municipio" id="municipio" aria-describedby="helpId" placeholder="">
                        <small id="municipio_err" class="form-text">Help text</small>
                    </div>        
                </div>

                <div class="form-row">
                    <div class="form-group col">
                        <label for="">Localidad</label>
                        <input type="text" class="form-control" name="localidad" id="localidad" aria-describedby="helpId" placeholder="">
                        <small id="localidad_err" class="form-text">Help text</small>
                    </div>
                    <div class="form-group col">
                        <label for="">Colonia</label>
                        <input type="text" class="form-control" name="colonia" id="colonia" aria-describedby="helpId" placeholder="">
                        <small id="colonia_err" class="form-text">Help text</small>
                    </div>
                </div>
                

                <div class="form-group">
                <label for="">Calle</label>
                <input type="text" class="form-control" name="calle" id="calle" aria-describedby="helpId" placeholder="">
                <small id="calle_err" class="form-text">Help text</small>
                </div>

                <div class="form-row">
                    <div class="form-group col">
                        <label for="">No. Ext:</label>
                        <input type="text" class="form-control" name="noext" id="noext" aria-describedby="helpId" placeholder="">
                        <small id="noext_err" class="form-text">Help text</small>
                    </div>
                    <div class="form-group col">
                        <label for="">No. Int:</label>
                        <input type="text" class="form-control" name="noint" id="noint" aria-describedby="helpId" placeholder="">
                        <small id="noint_err" class="form-text">Help text</small>
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
    
    <!-- select2 Js -->
    <script src="{{asset('Backend/assets/plugins/select2/js/select2.full.min.js')}}"></script>

    <script>
        var tabla = '';
        $(document).ready(function () {

            console.log("running...") 
            $('#divClaveRegistro').hide();

            tabla =  $('#tb-registros').DataTable({
                            language:{
                                "url":"{{asset('Backend/assets/jsons/datatable-lengua.json')}}"
                            },
                            ajax: "{{url('admin/empleados/listar')}}",                         
                            columns: [
                               {"data": null},
                               {"data":"clave"},
                               {"data":"nombre"},
                               {"data":"puesto"},
                               {"data":"estado"}
                            ],
                            columnDefs:[
                                {
                                    "targets":5,
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


               
         //   ReiniciarForm();
            

            $("#btn-new").on('click', function(){
                $(".modal-title").text("Nuevo registro");
                $("#op").val("I");
                ReiniciarModalSave('Ine, Licencia, Fotografia')
                setImagenesSubidas(null);
                $('#iden').val();
                $('#claveRegistro').val();
                $('#divClaveRegistro').hide();
                $('#md-add').modal('toggle')
                   
            });
            


            $('#frm-add').on('submit', function(event){
                event.preventDefault();
                $.ajax({
                    method: "POST",
                    url: "{{route('empleados.save')}}",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType:"json",
                    success: function (response) {
                        console.log(response)
                        if(response.code== 200){
                            swal("Aviso", response.msj, "success").then(function(){
                                ReiniciarModalSave('Ine, Licencia, Fotografia');
                                ResetTabla();
                                $('#md-add').modal('toggle');
                            });
                        }else if(response.code==400){
                            swal("Advertencia", response.msj, "warning").then(()=>{
                                printErrorMsg(response.Contenido);
                            });
                        }else{
                            swal("Error", response.msj, "error");
                            console.log(response.code);
                        }
                        
                    },

                });

                

            });

            function ReiniciarModalSave(imgdivs){
                $("#frm-add")[0].reset();
                BorrarArchivosCargados(imgdivs);
                LimpiarSmallError();                
            }

        });

        function Modificar(id){
            $.get("{{url('admin/empleados/obtener/')}}"+"/"+id, function (data) {
                    $("#op").val('M');                    
                    $("#iden").val(data.id);
                    $("#nombres").val(data.nombres);
                    $("#apellidos").val(data.apellidos);
                    $("#telefono").val(data.telefono);
                    $("#correo").val(data.correo);
                    $("#dni").val(data.dni);
                    $("#curp").val(data.curp);
                    $("#tipoEmpleado").val(data.tipoempleadoid);
                    $("#estado").val(data.estadoprocesoid);
                    $("#puestos").val(data.puestobravosid);
                    $("#estadoUbicacion").val(data.estado);
                    $("#localidad").val(data.localidad);
                    $("#calle").val(data.calle);
                    $("#colonia").val(data.colonia);
                    $("#noext").val(data.noext);
                    $("#noint").val(data.noint);
                    $("#codigoPostal").val(data.cp);
                    $("#municipio").val(data.municipio);
                    $("#claveRegistro").val(data.clave);

                    setImagenesSubidas(data)
                    $('#divClaveRegistro').show();
                    $("#md-add").modal('toggle');
                });
        }

        function Eliminar(id){
            $.get("{{url('admin/empleos/del/')}}"+"/"+id, function (data) {
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
              $('#'+key+'_err').css({'color':'orange', 'font-wight':'bold'})
              $('#'+key+'_err').css({'color':'orange', 'font-wight':'bold'})
              $('#'+key).css('border','2px solid orange');
            });
        }

        function LimpiarSmallError(){
            $('small').text('');
            $('input').css('border','1px solid #ced4da');
        }

        function ReiniciarForm(){
            ResetTabla();
            LimpiarSmallError();
        }

        function CargarArchivo(control, origen){

            console.log(control.files);
            if(origen=='Ine'){
                if(control.files.length>2){
                    swal("Advertencia", "Solo se pueden subir maximo dos archivos (derecho y reverso del INE.", "warning");
                    return;
                }
            }else if(origen=='Fotografia'){
                if(control.files.length>1){
                    swal("Advertencia", "Solo se pueden subir maximo 1 archivo,", "warning");
                    return;
                }

            }else if(origen=='Licencia'){
                if(control.files.length>2){
                    swal("Advertencia", "Solo se pueden subir maximo dos archivos (derecho y reverso de la licencia de conducir.", "warning");
                    return;
                }
            }

            if(control.files && control.files[0]){                
                $('#div'+origen+'Fotos img').remove();                
                for(var i=0; i<control.files.length;i++){
                    var reader = new FileReader();
                    reader.readAsDataURL(control.files[i]);
                    reader.onload=function(e){
                        console.log(e)
                        $('#div'+origen+'Fotos').append('<img src="'+e.target.result+'" width="145" height="85" style="margin-right:5px;" />');
                        
                    }
                }
                $('#doc'+origen+'_cargados').text(control.files.length+' archivos listos para subir.');
               
            }
        }

         function BorrarArchivosCargados(proceso){
             var procesos = proceso.split(',')
             console.log(procesos);
             procesos.forEach(function(pro, index, procesos){
                $('#div'+pro+'Fotos img').remove();
             });
            
         }

         function setImagenesSubidas(data){    
            if(data!=null&&data.urlfotocara){
                if(data.urlfotocara!="SIN ARCHIVOS"){
                    $('#picFoto').attr('src','{{url("storage/empleados/expedientes/EMP_")}}'+data.clave+'/'+data.urlfotocara);
                }           
            }else{
               $('#picFoto').attr('src', "{{asset('Backend/assets/images/backend/fotoPersonOff.png')}}");
            }
         
            if(data!=null&&data.urllicencia){
                if(data.urllicencia != 'SIN ARCHIVOS'){
                    var imgLic = data.urllicencia.split(',');
                    $('#picLicencia').attr('src', '{{url("storage/empleados/expedientes/EMP_")}}'+data.clave+'/'+imgLic[0]);
                }
               
            }else{
                $('#picLicencia').attr('src', "{{asset('Backend/assets/images/backend/credentialOff.png')}}");
            }

            if(data!=null&&data.urline){
                if(data.urline!='SIN ARCHIVOS'){
                    var imgIne = data.urline.split(',');               
                    $('#picIne').attr('src','{{url("storage/empleados/expedientes/EMP_")}}'+data.clave+'/'+imgIne[0]);
                }     
            }else{
                $('#picIne').attr('src', "{{asset('Backend/assets/images/backend/credentialOff.png')}}");
            } 
            
         }

        


        
    </script>

     <script type="text/javascript">
        
    </script>

@endpush