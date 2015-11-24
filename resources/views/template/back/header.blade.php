<!DOCTYPE html>
<html lang="fr-FR">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
@section('title')
		<title>@show</title>
		
		<meta name="robots" content="noindex,nofollow" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		{!! HTML::style('assets/css/app.css', array('media' => 'all')) !!}
		{!! HTML::style('assets/css/admin.css', array('media' => 'all')) !!}
		{!! HTML::style('assets/css/menu.css', array('media' => 'all')) !!}		
@yield('header')
	
	</head>