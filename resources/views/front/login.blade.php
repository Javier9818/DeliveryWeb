
<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title')</title>
    <link rel="apple-touch-icon" href="/theme-assets/images/ico/apple-icon-120.png">
    <link href="assets/images/favicon/favicon2.ico"  rel="icon">
    <link href="https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,600,600i,700,700i%7CComfortaa:300,400,700" rel="stylesheet">
    <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/theme-assets/css/vendors.css">
    <link rel="stylesheet" type="text/css" href="/theme-assets/css/app-lite.css">
    <link rel="stylesheet" type="text/css" href="/theme-assets/css/core/colors/palette-gradient.css">
  </head>
  <body >

    <section id="wrapper" class="login-register login-sidebar flexbox-container d-flex" style="background-image:url(assets/images/backgrounds/LoginDelivery-02.png);background-size: cover; height: 100vh">
        <div class="login-box col-12 d-flex align-items-center justify-content-center"> <!--class="login-box card shadow-none" -->
            <div class="card-body m-0 p-0" style="height: 90vh">
                <div class="col-12 col-sm-8 col-md-6 col-lg-4 m-0 p-0">
                    <div class="card-header border-0 bg-transparent">
                        <div class="text-center mb-1">
                                <img src="assets/images/logo/logo-v8.png" alt="AQUI VA EL LOGO" style="width: 50%;">

                        </div>
                        <div class="font-large-1  text-center">
                            Acceso al sistema
                        </div>
                    </div>
                    <div class="card-content" id="app">
                        <div class="card-body">
                            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                                @csrf
                                @error('login-error')
                                    <p class="red ml-1"><i class="ft-alert-circle"></i> {{$message}}</p>
                                @enderror
                                <fieldset class="form-group position-relative has-icon-left">
                                    <input type="text" class="form-control round" id="username" name="username" placeholder="Usuario o Email" required="" aria-invalid="false">
                                    <div class="form-control-position">
                                        <i class="ft-user"></i>
                                    </div>
                                </fieldset>
                                <fieldset class="form-group position-relative has-icon-left">
                                    <input type="password" class="form-control round" id="password" name="password" placeholder="Contraseña" required="" aria-invalid="false">
                                    <div class="form-control-position">
                                        <i class="ft-lock"></i>
                                    </div>
                                </fieldset>
                                <div class="form-group row">
                                    <div class="col-md-6 col-12 text-center text-sm-left">

                                    </div>
                                    <div class="col-md-6 col-12 float-sm-left text-center text-sm-right" >
                                        <recover-component></recover-component>
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <button type="submit" class="btn round btn-block btn-glow btn-bg-gradient-x-purple-blue col-12 mr-1 mb-1">Iniciar Sesion</button>
                                </div>

                            </form>
                        </div>
                        {{-- <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-2 "><span>Inicia sesion usando</span></p>
                        <div class="text-center">
                            <a href="#" class="btn btn-social-icon round mr-1 mb-1 btn-facebook"><span class="ft-facebook"></span></a>
                            <a href="#" class="btn btn-social-icon round mr-1 mb-1 btn-twitter"><span class="ft-twitter"></span></a>
                            <a href="#" class="btn btn-social-icon round mr-1 mb-1 btn-instagram"><span class="ft-instagram"></span></a>
                        </div> --}}

                        <p class="card-subtitle text-muted text-right font-small-3 mx-2 mb-1"><span>¿No tienes una cuenta? <a href="/registro" class="card-link">Regístrate</a></span></p>
                    </div>
                </div>
            </div>
        </div>
    </section>


  </body>
  <script src="/js/fronted.js" type="text/javascript"></script>
</html>



