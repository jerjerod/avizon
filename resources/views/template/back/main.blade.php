@include('template.back.header')
	<body class="">
@include('template.back.nav')		

				@yield('wrapper')
				<div class="container">
					<!-- Content -->
					@yield('content')
					<!-- ./ content -->
				</div>
@include('template.back.footer')
	</body>
</html>
