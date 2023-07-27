@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ URL::asset('css/paginainicial.css') }}"
type="text/css">
@endsection
@section('content')
    <h2>Add new post</h2>
    <form method="post" action="/new">
    <div class="component">
    <label for="title">Title</label>
    <input type="text" name="title"/>
    </div>
    <div class="component">
    <label>Text</label>
    <textarea rows="20" name="content"></textarea>
    </div>
    <div class="component">
    <button type="submit">Save</button>
    </div>
    </form>

    <div id="app">
        <example-component />
    </div>
@endsection
