
@extends('layouts.app')

@section('css')
@vite(['resources/js/servicos/servicos.js' , 'resources/css/servicos/servicos.css'])

@endsection


@section('content')
    
<div id="vueServicos">
    <div class="row">
      <div class="col-1 sm-1"></div>
      <div class="col-4">
  
        <div class="container">
          <div class="row">
  
          
          <form action="/servicos/cadastrarServicos" method="POST">
              @csrf
              <vue-servicos> </vue-servicos>
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
  
      <vue-tablerowservicos ></vue-tablerowservicos>
  
  
  
      
  
      </div>
    </div>
    <div class="col-1 sm-1"></div>
  
  </div>

@endsection