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
    <h1>Erreur 503</h1>
    <p>Désolé, service indisponible !</p>
  </div>
</div> 
@stop