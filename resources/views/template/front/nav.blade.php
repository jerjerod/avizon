<!-- Navbar -->
		<div class="navbar navbar-default navbar-fixed-top">
			<div class="container-fluid">
		        <div class="navbar-header">
		          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		          </button>
		          @if(Route::current()->getName() != 'home')
			        <a class="navbar-brand" rel="home" title="AVIZON" href="/">
						<img class="img-responsive" src="/images/logo_avizon.png">
					</a>
				  @endif
		        </div>
		        <ul class="nav navbar-nav navbar-right">
		        	@if (Auth::check())
			        	<li class="dropdown">
		                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
		                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
		                    </a>
		                    <ul class="dropdown-menu dropdown-user">
		                        <li><a href="#"><i class="fa fa-user fa-fw"></i> Profil</a>
		                        </li>
		                        @if (Auth::user()->isAdmin())
		                        <li><a href="/admin"><i class="fa fa-gear fa-fw"></i> Tableau de bord</a>
		                        </li>
		                        @endif
		                        <li class="divider"></li>
		                        <li><a href="/logout"><i class="fa fa-sign-out fa-fw"></i> Déconnexion</a>
		                        </li>
		                    </ul>
		                    <!-- /.dropdown-user -->
		                </li>
					@else
						<li {!! (Request::is('login') ? 'class="active"' : '') !!}>{!! HTML::link(route('login'),'Login') !!}</li>
					@endif
		        </ul><!--/.nav-collapse -->
		        @yield('searchbar')
		    </div>
	    </div>
	    
		<!-- ./ navbar -->