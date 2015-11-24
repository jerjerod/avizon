@extends('template.front.main')
@include('coprosmetro::search')

@section('title')
@parent Carte @stop

@section('header')
		{!! HTML::style('/assets/css/map.css', array('media' => 'all')) !!}
		{!! HTML::style('https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/MarkerCluster.css', array('media' => 'all')) !!}
		{!! HTML::style('https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/MarkerCluster.Default.css', array('media' => 'all')) !!}
@stop


@section('content')
<div class="container-full">
  
	<div class="alert alert-success alert-dismissable">
  		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  		<p class="results"></p>
	</div>
	<ul id='map-ui'></ul>
  <div id="loading"><i class="fa fa-cog fa-spin fa-4x"></i></div>
	<div id="map"></div>
  <pre id='output' class='ui-output'></pre>
</div>
@stop
@section('footer')
        {!! HTML::script('/assets/js/mapbox.js') !!}
        {!! HTML::script('http://maps.google.com/maps/api/js?v=3') !!}
        {!! HTML::script('https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/leaflet.markercluster.js') !!}
        {!! HTML::script('https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-omnivore/v0.2.0/leaflet-omnivore.min.js') !!}
        {!! HTML::script('/assets/js/map.js') !!}
@stop