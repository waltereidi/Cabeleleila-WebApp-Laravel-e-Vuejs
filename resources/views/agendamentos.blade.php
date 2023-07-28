@extends('layouts.app')
@section('css')

@vite(['resources/css/agendamentos/agendamentos.css' , 'resources/js/agendamentos/agendamentos.js'])
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.33/moment-timezone-with-data.min.js"></script>

@endsection
@section('content')
   

    

@section('content')

<div id="vueAgendamentos">
  <div class="row">
    <div class="col-1 sm-1"></div>
    <div class="col-4">

      <div class="container">
        <div class="row">

        
            @csrf
            <vue-agendamentos email="{{ session()->get('email') }}"> </vue-agendamentos>
            @if (session('mensagem'))
              <div class="alert alert-danger">
                  {{ session('mensagem') }}
              </div>
            @endif
        
        </div>
      </div>
    </div>
  </div>
  
  <div class="row">
    </br>
    <div class="col-1 sm-1"></div>
    <div class="col-10 sm-10">
    </br>
    <vue-tablerowAgendamentos email="{{ session()->get('email') }}" tipousuario="{{ session()->get('tipousuario') }}"></vue-tablerowAgendamentos>
    </div>
  </div>
  <div class="col-1 sm-1"></div>

</div>

@endsection
