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
    <h1>Erreur 500</h1>
    <p>Désolé, une erreur interne a été détectée !</p>
  </div>
</div> 
@stop