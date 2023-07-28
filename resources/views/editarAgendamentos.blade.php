
@extends('layouts.app')

@section('css')
@vite(['resources/js/agendamento/editarAgendamentos.js' , 'resources/css/agendamentos/editarAgendamentos.css'])


@endsection


<div id="vueEditarAgendamentos">
    <div class="row">
      <div class="col-1 sm-1"></div>
      <div class="col-4">
  
        <div class="container">
          <div class="row">
  
          
              @csrf
              <vue-editaragendamentos email="{{ session()->get('email') }}"> </vue-editaragendamentos>
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
  

@section('content')


@endsection

