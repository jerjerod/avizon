		<!-- Javascripts
		================================================== -->
		{!! HTML::script('assets/js/app.js') !!}
		{!! HTML::script('assets/js/menu.js') !!}

		<script type="text/javascript">
			$(document).ready(function() {
		        $(".multiselect").chosen();
		    });
		</script>

@yield('footer')