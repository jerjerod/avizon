<!DOCTYPE html>
<html lang="fr-FR">
	<head>
		<meta charset="utf-8" />
@section('title')
		<title>@show</title>
		
		<meta name="robots" content="noindex,nofollow" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="_token" content="{!! csrf_token() !!}"/>
		{!! HTML::style('assets/css/app.css', array('media' => 'all')) !!}		
@yield('header')
	
	</head>