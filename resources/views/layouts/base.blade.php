<?php
if (preg_match("/" . Auth::user()->permissions . "/", Config::get('constants.permission.FIXINGS'))) {
    $folder = Config::get('constants.folders.FIXINGS');
} else if (preg_match("/" . Auth::user()->permissions . "/", Config::get('constants.permission.SALES_ACTS'))) {
    $folder = Config::get('constants.folders.SALES_ACTS');
}
$photosBackupRoute = route('photoBackup', $folder);
$photosDeleteRoute = route('photoDelete', $folder);
?>

<html lang="en">
    <head>
        <title>Tentazioni in Oro - @yield('title')</title>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
	
	@section('head-stylesheet')
	    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/3.3.7/css/bootstrap.min.css') }}">
	    <link rel="stylesheet" href="{{ asset('vendor/jquery-bootgrid/1.3.1/jquery.bootgrid.min.css') }}">

	    <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
            
	    <link rel="stylesheet" href="{{ asset('vendor/jquery-bootgrid/1.3.1/jquery.bootgrid.min.css') }}">
            <link href="{{ asset('vendor/bootstrap-fileinput/4.4.5/css/fileinput.min.css') }}" media="all" rel="stylesheet" type="text/css" />
            
	    <link rel="stylesheet" href="{{ asset('vendor/select2/4.0.6-rc.0/css/select2.min.css') }}">
	    
	    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
	@show
	
	@section('head-javascript')
	    <script src="{{ asset('vendor/jquery/3.2.1/jquery.min.js') }}"></script>
	    <script src="{{ asset('vendor/bootstrap/3.3.7/js/bootstrap.min.js') }}"></script>
	    <script src="{{ asset('vendor/jquery-bootgrid/1.3.1/jquery.bootgrid.min.js') }}"></script>
	    <script src="{{ asset('vendor/jquery-cookie/2.1.4/js.cookie.js') }}"></script>
            
            <!-- popper.min.js below is needed if you use bootstrap 4.x. You can also use the bootstrap js 
            3.3.x versions without popper.min.js. -->
            <script src="{{ asset('vendor/popper.js/1.11.0/popper.min.js') }}"></script>
            <!-- the main fileinput plugin file -->
            <script src="{{ asset('vendor/bootstrap-fileinput/4.4.5/js/fileinput.min.js') }}"></script>

            <script src="{{ asset('vendor/select2/4.0.6-rc.0/js/select2.min.js') }}"></script>
	    
	    <script src="{{ asset('js/manager.memory.js') }}"></script>
	    <script src="{{ asset('js/utilities.common.js') }}"></script>
	    <script src="{{ asset('js/all.main.js') }}"></script>
	@show
    </head>
    <body style="margin-bottom: 15px;">
	@auth
	    <div class="jumbotron">
		<div class="container text-center">
		    <h1>Tentazioni in Oro</h1>      
		    <p class="title">@yield('title')</p>
		    <p class="subtitle">@yield('subtitle')</p>
		</div>
	    </div>
        
            <nav class="navbar navbar-inverse" id="headerNavbar">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="{{ route('home') }}">Tentazioni in Oro</a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        @section('navbar-ul')
                            <ul class="nav navbar-nav">
                                @section('navbar-li-left')
                                    <li class="@yield('home_class')"><a href="{{ route('home') }}">Home</a></li>
                                @show
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                @section('navbar-li-right')
                                    @guest
                                        <li><a href="{{ route('login') }}">Login</a></li>
                                        <li><a href="{{ route('register') }}">Register</a></li>
                                    @else
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                                <span class="fa fa-user fa-lg"></span>
                                                {{ Auth::user()->name }} <span class="caret"></span>
                                            </a>

                                            <ul class="dropdown-menu">
                                                @section('dropdown-menu')
                                                <li>
                                                    <a href="{{ route('logout') }}"
                                                       onclick="event.preventDefault();
                                                           document.getElementById('logout-form').submit();">
                                                        Logout
                                                    </a>

                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                        {{ csrf_field() }}
                                                    </form>
                                                </li>
                                                <li class=""><a id="anchor-backup" href="@yield('anchor-backup-href', $photosBackupRoute)">Backup</a></li>
                                                <li class=""><a id="anchor-delete" class="delete-all-file" href="" data-href="@yield('anchor-delete-photos-href', $photosDeleteRoute)">Cancella tutte le foto</a></li>
                                                @show
                                            </ul>
                                        </li>
                                    @endguest
                                @show
                            </ul>
                        @show
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
        
	    <!-- Modal -->
	    <div id="@yield('modal-id')-modal" class="modal fade" role="dialog">
		<div class="modal-dialog">
		    @section('modal-form-start')
		    @show
		    <!-- Modal content-->
		    <div class="modal-content">
			<div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal">&times;</button>
			    <h4 class="modal-title">@yield('modal-title')</h4>
			</div>
			<div class="modal-body">
			    @section('modal-body')
			    @show
			</div>
			<div class="modal-footer">
			    @section('modal-footer')
			    <button type="submit" id="save-@yield('modal-id')-btn" class="btn btn-primary" >@yield('modal-save-btn', 'Salva')</button>
			    <button type="button" id="cancel-@yield('modal-id')-btn" class="btn btn-warning" data-dismiss="modal">@yield('modal-cancel-btn', 'Annula')</button>
			    @show
			</div>
		    </div>
		    @section('modal-form-stop')
		    @show
		</div>
	    </div>

	    <div class="container-fluid">
		<h3>@yield('content-title')</h3>
		@yield('content')
	    </div>
	@endauth
	@guest
	    @section('redirect-to-login-page')
		<script>
		    window.location.replace("{{ route('login') }}");
		</script>
	    @show
	@endguest
    </body>
    @section('footer-javascript')
    <script>
        $("#input-id").fileinput({'showUpload':false, 'previewFileType':'any'});
    </script>
    @show
</html>