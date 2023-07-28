<!DOCTYPE html>
<html lang="en">
<head>
<title>Cabeleleila App</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<link rel="icon" type="image/x-icon" href="/favicon/favicon.ico">

@vite(['resources/js/app.js' ,

  'resources/css/layout.css',
  'node_modules/jquery/dist/jquery.min.js',
])
{{-- Navbar --}}
@yield('css')
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      @if ( !session()->has('email') )
        <a class="navbar-brand" href="/login">Login</a>
      @else 
        <a class="navbar-brand" href="/agendamentos">Agendamentos</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="/servicos">Servicos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/clientes">Clientes</a>
            </li>
            @if( session()->get('tipousuario') == 1 )
            <li class="nav-item">
              <a class="nav-link" href="/gerenciamento">Gerenciar</a>
            </li>
            @endif
          </ul>
          
          <!-- Place the logout link in a separate list to align it to the right -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="/logout">Logout</a>
            </li>
          </ul>
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" >{{session()->get('email')}}</a>
            </li>
          </ul>
          @if ( session()->get('tipousuario') == 1 )
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link"  ><p class="text-danger">Gerente</p></a>
              </li>
            </ul>
          @endif
          <ul class="navbar-nav">
            
          </ul>
        </div>
      @endif
    </div>
  </nav>

        @yield('content')

 
{{-- Footer --}}
<section id="footer">
    
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-5">
            <ul class="list-unstyled list-inline social text-center">
                <li class="list-inline-item"><a href="https://github.com/waltereidi" target="_blank"><i class="fa fa-github"></i></a></li>
                <li class="list-inline-item"><a href="https://www.linkedin.com/in/mwaltr/" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                <li class="list-inline-item"><a href="https://www.instagram.com/laravel_official/" target="_blank"><i class="fa fa-instagram"></i></a></li>
            </ul>
        </div>
        </hr>
    
    </div>
    <div class="container">
   
        <div class="row text-center text-xs-center text-sm-left text-md-left">
            
            
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-2 text-center text-white">
                <p><u><a href="javascript:void();">Mande um email para walter-eidi@hotmail.com</a></u> indicando livros, preferencialmente história do planeta, tecnologia ,invenções e pessoas icônicas </p>
                <p class="h6">Enfeitar com esperança a sede de saber.<a class="text-green ml-2" href="https://www.sunlimetech.com" target="_blank"></a></p>
            
            </div>
            </hr>
            
        </div>	
    </div>
</section>
</body>
</html>