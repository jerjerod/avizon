@include('template.front.header')
	<body class="">
@include('template.front.nav')		
<!-- Notifications -->
@include('template.front.notifications')
<!-- ./ notifications -->
				@yield('home')
				<div class="container">
					<!-- Content -->
					@yield('content')
					<!-- ./ content -->
				</div>
@include('template.front.footer')
	</body>
</html>
