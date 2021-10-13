<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bienvenido a Bravo's</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <meta name="author" content="CodedThemes" />

    <!-- Favicon icon -->
    <link rel="icon" href="{{asset('Backend/assets/images/favicon.ico')}}" type="image/x-icon">
    <!-- fontawesome icon -->
    <link rel="stylesheet" href="{{asset('Backend/assets/fonts/fontawesome/css/fontawesome-all.min.css')}}">
    <!-- animation css -->
    <link rel="stylesheet" href="{{asset('Backend/assets/plugins/animation/css/animate.min.css')}}">
    <!-- vendor css -->
    <link rel="stylesheet" href="{{asset('Backend/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('Backend/assets/css/layouts/dark.css')}}">


</head>

<body>
    <div class="auth-wrapper aut-bg-img" style="background-image: url('{{asset('Backend/assets/images/bg-images/bg3.jpg')}}');">
        <div class="auth-content">
            <div class="text-white">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="feather icon-unlock auth-icon"></i>
                    </div>
                    <h3 class="mb-4 text-white">Iniciar sesión</h3>
                    @if(session()->has('fail'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <b>¡Acceso fallido!</b> {{ session()->get('fail') }}..
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    @endif
                    <form  method="POST" action="{{route('admin.login.submit')}}" autocomplete="off">
                        @csrf
                        <div class="form-group mb-3">                            
                            <input type="text" name="alias" class="form-control" placeholder="Usuario" >
                            <small class="validador">{{$errors->login->first('alias')}}</small>
                        </div>
                        <div class="form-group mb-4">                            
                            <input type="password" name="password" class="form-control" placeholder="Contraseña" >
                            <small class="validador">{{$errors->login->first('password')}}</small>
                        </div>
                        <button type="submit" class="btn btn-primary shadow-2 mb-4">Acceder</button> 
                    </form>
                                    
                </div>
            </div>
        </div>
    </div>

    <!-- Required Js -->
    <script src="{{asset('Backend/assets/js/vendor-all.min.js')}}"></script>
    <script src="{{asset('Backend/assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('Backend/assets/js/pcoded.min.js')}}"></script>

</body>
</html>
