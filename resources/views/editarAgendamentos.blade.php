
@extends('layouts.app')

@section('css')
@vite(['resources/js/agendamento/editarAgendamentos.js' , 'resources/css/agendamentos/editarAgendamentos.css'])


@endsection


  

@section('content')


<div id="vueEditarAgendamentos">
    <div class="row">
      <div class="col-1 sm-1"></div>
      <div class="col-4">
  
        <div class="container">
          <div class="row">
  
          
              @csrf
              <vue-editaragendamentos email="{{ session()->get('email') }}" editarAgendamentosId="{{  request('id') }}" tipousuario="{{session()->get('tipousuario')}}"> </vue-editaragendamentos>
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

