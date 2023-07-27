
@extends('layouts.app')

@section('css')
@vite(['resources/js/clientes/clientes.js' , 'resources/css/clientes/clientes.css'])

@endsection



@section('content')

    <div id="vueClientes">
      <div class="row">
      <div class="col-1 sm-1"></div>
      <div class="col-4">
        <vue-clientes> </vue-clientes>  
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

