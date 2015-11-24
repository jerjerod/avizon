@if (Sentry::check())
	<div class="search navbar-right">
		<button class="btn" data-target="#recherche" data-toggle="modal">
			<span class="glyphicon glyphicon-search"></span>
			<span class="search-title visible-lg">Recherche</span>
		</button>
	</div>
@endif

{{ Form::open(array('action' => isset($post_type)? $post_type.'Controller@Search' : 'SearchController@Search','class' => 'navbar-form navbar-right')) }}
	<input class="form-control s" name="s" type="text" placeholder="Recherche...">
{{ Form::close() }}