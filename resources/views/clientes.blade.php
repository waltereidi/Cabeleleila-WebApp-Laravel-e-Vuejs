
@extends('layouts.app')

@section('css')
@vite(['resources/js/clientes/clientes.js' , 'resources/css/clientes/clientes.css'])

@endsection



@section('content')

<div id="vueClientes">
  <div class="row">
    <div class="col-1 sm-1"></div>
    <div class="col-4">

      <div class="container">
        <div class="row">

        
        <form action="/clientes/cadastrarClientes" method="POST">
            @csrf
            <vue-clientes> </vue-clientes>
            @if (session('mensagem'))
              <div class="alert alert-danger">
                  {{ session('mensagem') }}
              </div>
            @endif
        </form>
        
        </div>
      </div>
    </div>
  </div>
  
  <div class="row">
    </br>
    <div class="col-1 sm-1"></div>
    <div class="col-10 sm-10">

    </br>

    <vue-tablerow ></vue-tablerow>



    

    </div>
  </div>
  <div class="col-1 sm-1"></div>

</div>

 


@endsection

