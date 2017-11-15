<html lang="en">
    <head>
        <title>Tentazioni in Oro - @yield('title')</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="{{ asset('vendor/bootstrap/3.3.7/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('vendor/jquery-bootgrid/1.3.1/jquery.bootgrid.min.css') }}">

	<link rel="stylesheet" href="{{ asset('css/main.css') }}">

	<script src="{{ asset('vendor/jquery/3.2.1/jquery.min.js') }}"></script>
	<script src="{{ asset('vendor/bootstrap/3.3.7/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('vendor/jquery-bootgrid/1.3.1/jquery.bootgrid.min.js') }}"></script>
	<script src="{{ asset('vendor/jquery-cookie/2.1.4/js.cookie.js') }}"></script>

	<script src="{{ asset('js/utilities.common.js') }}"></script>
	<script src="{{ asset('js/functions.home.js') }}"></script>

    </head>
    <body>

        <div class="jumbotron">
            <div class="container text-center">
                <h1>Tentazioni in Oro</h1>      
                <p class="title">@yield('title')</p>
                <p class="subtitle">@yield('subtitle')</p>
            </div>
        </div>

        <nav class="navbar navbar-inverse">
            <div class="collapse navbar-collapse" id="headerNavbar">
		@section('navbar-ul')
                <ul class="nav navbar-nav">
		    @section('navbar-li-left')
		    <li class="@yield('home_class')"><a href="{{ route('home') }}">Home</a></li>
                    <!--<li><a href="#">Cerca riparazione</a></li>-->
		    @show
                </ul>
                <ul class="nav navbar-nav navbar-right">
		    @section('navbar-li-right')
                    <li><a href="" class="logout"><span class="glyphicon glyphicon-user"></span> <b>@yield('username')</b> [Logout]</a></li>
		    @show
                </ul>
		@show
            </div>
        </nav>

	<!-- Modal -->
	<div id="@yield('modal-id')-modal" class="modal fade" role="dialog">
	    <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		    <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">@yield('modal-title')</h4>
		    </div>
		    <div class="modal-body">
			@section('modal-body')
			<form class="form-horizontal" action="" method="post">
			    <fieldset>
				<legend class="fieldset-border">Dati cliente</legend>
				<div class="form-group">
				    <label class="control-label col-md-4" for="customer">Cliente:</label>
				    <div class="col-md-4">
					<input type="text" class="form-control" id="customer" placeholder="" name="customer" autofocus required>
				    </div>
				</div>
			    </fieldset>
			    <fieldset>
				<legend class="fieldset-border">Dati gioiello</legend>
				<div class="form-group">
				    <label class="control-label col-md-4" for="typology">Tipologia:</label>
				    <div class="col-md-5">          
					<input type="text" class="form-control" id="typology" placeholder="" name="typology" required>
				    </div>
				</div>
				<div class="form-group">
				    <label class="control-label col-md-4" for="wheight">Peso:</label>
				    <div class="col-md-5">          
					<input type="text" class="form-control" id="wheight" placeholder="" name="wheight" required>
				    </div>
				</div>
				<div class="form-group">
				    <label class="control-label col-md-4" for="metal">Metallo:</label>
				    <div class="col-md-5">          
					<input type="text" class="form-control" id="metal" placeholder="" name="metal" required>
				    </div>
				</div>
				<div class="form-group">
				    <label class="control-label col-md-4" for="path-photo">Foto:</label>
				    <div class="col-md-5">
					<input type="file" class="form-control-file" id="path-photo" name="path-photo" aria-describedby="fileHelp">
				    </div>
				</div>
			    </fieldset>
			    <fieldset>
				<legend class="fieldset-border">Dettagli guasto</legend>
				<div class="form-group">
				    <label class="control-label col-md-4" for="fault-description">Descrizione:</label>
				    <div class="col-md-5">
					<textarea class="form-control" id="fault-description" rows="3" name="fault-description"></textarea>
				    </div>
				</div>
			    </fieldset>
			    <fieldset>
				<legend class="fieldset-border">Dettagli pagamento</legend>
				<div class="form-group">
				    <label class="control-label col-md-4" for="deposit">Acconto:</label>
				    <div class="col-md-5">          
					<input type="text" class="form-control" id="deposit" placeholder="" name="deposit" required>
				    </div>
				</div>
				<div class="form-group">
				    <label class="control-label col-md-4" for="estimate">Preventivo:</label>
				    <div class="col-md-5">          
					<input type="text" class="form-control" id="estimate" placeholder="" name="estimate" required>
				    </div>
				</div>
				<div class="form-group">
				    <label class="control-label col-md-4" for="notes">Appunti:</label>
				    <div class="col-md-5">
					<textarea class="form-control" id="notes" rows="3" name="notes"></textarea>
				    </div>
				</div>
			    </fieldset>
			</form>
			@show
		    </div>
		    <div class="modal-footer">
			@section('modal-footer')
			<button type="button" id="save-{@yield('id-modal')}-btn" class="btn btn-primary" data-dismiss="modal">@yield('modal-save-btn', 'Salva')</button>
			<button type="button" id="cancel-{@yield('id-modal')}-btn" class="btn btn-warning" data-dismiss="modal">@yield('modal-cancel-btn', 'Annula')</button>
			@show
		    </div>
		</div>

	    </div>
	</div>

	<div class="container">
	    <h1>@yield('title')</h1>
	    @yield('content')
	</div>
    </body>
</html>