@extends('template.front.main')
{{-- Web site Title --}}
@section('title')
@parent
Désolé, cette page n'existe pas !
@stop

{{-- Content --}}
@section('content')

<div class="jumbotron">
  <div class="container">
    <h1>Erreur 404</h1>
    <p>Désolé, cette page n'existe pas !</p>
  </div>
</div>
@stop