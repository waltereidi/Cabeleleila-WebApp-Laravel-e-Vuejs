
@extends('layouts.app')

@section('css')
@vite(['resources/js/gerenciamento/gerenciamento.js' , 'resources/css/gerenciamento/gerenciamento.css'])

@endsection


@section('content')

<div id="vueGerenciamentos">
    <div class="row">
      <div class="col-1 sm-1"></div>
      <div class="col-4">
  
        <div class="container">
          <div class="row">
  
         
              @csrf
              <vue-gerenciamentos email="{{ session()->get('email') }}" tipousuario="{{session()->get('tipousuario')}}"> </vue-gerenciamentos>
              @if (session('mensagem'))
                <div class="alert alert-danger">
                    {{ session('mensagem') }}
                </div>
              @endif
          
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

