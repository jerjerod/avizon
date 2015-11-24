		<!-- Javascripts
		================================================== -->
		{!! HTML::script('assets/js/app.js') !!}
		<script type="text/javascript">
		$.ajaxSetup({
		   headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
		});
		$(document).ready(function() {
	        $(".multiselect").chosen();
	    });
		</script>

@yield('footer')