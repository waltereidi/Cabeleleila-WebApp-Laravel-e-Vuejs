@extends('layouts.app')
@section('css')

@vite(['resources/css/login.css' , 'resources/js/login.js'])
@endsection


@section('content')

<div class="login-page">
    <div class="form">
        <form class="register-form" action="/login/authRegistrar" method="post">
            @csrf
            <label>
            <input type="text" name="registrar_nome" placeholder="Nome completo" maxlength="120" required="required"></label></br>
            <label>
            <input type="email" name="registrar_email" maxlength="60" placeholder="email" required="required"> </label></br>
            <label>
            <input type="password" name="registrar_senha" maxlength="30" onchange="validarSenha()" placeholder="Senha" required="required"> </label></br>
            <label>
            <input type="password" name="registrar_rsenha" maxlength="30" onchange="validarSenha()" placeholder="Confirmar senha" required="required"></label></br>
            
            <input type="submit" class="submit" value="Registrar">
            <p class="alternar">Já é registrado? <a href="#">Faça login</a>
        </form>

        <form class="login-form" action="/login/authLogin" method="post"> 
            @csrf
                <label>
                <input class="text" type="text" name="email" placeholder="Email" maxlength="60"  class="@error('email') is-invalid @enderror"> </label> </br>
                <label>
                <input class="text" type="password" name="senha" placeholder="Senha" maxlength="30"></label></br>

                <input class="submit" type="submit" value="Entrar">
                <p class="alternar" >Não está registrado? <a href="#">Criar conta</a></p>
                            
        </form>    
        @if (session('mensagem'))
        <div class="alert alert-danger">
            {{ session('mensagem') }}
        </div>
    @endif
    
    </div>
</div>
@endsection
