@extends('layouts.base')

@section('title', 'Nuova riparazione')

@section('modal-id', 'cliente')
@section('modal-title', 'Dati riparazione')
@section('modal-body')
<form class="form-horizontal" action="" method="post">
    <div class="form-group">
	<label class="control-label col-md-4" for="nome-cliente">Nome:</label>
	<div class="col-md-4">
	    <input type="text" class="form-control" id="nome-cliente" placeholder="" name="nome-cliente" autofocus required>
	</div>
    </div>
    <div class="form-group">
	<label class="control-label col-md-4" for="cognome-cliente">Cognome:</label>
	<div class="col-md-5">          
	    <input type="text" class="form-control" id="cognome-cliente" placeholder="" name="cognome-cliente" required>
	</div>
    </div>
    <div class="form-group">
	<label class="control-label col-md-4" for="telefono-cliente">Telefono:</label>
	<div class="col-md-5">          
	    <input type="text" class="form-control" id="telefono-cliente" placeholder="" name="telefono-cliente-cliente" required>
	</div>
    </div>
    <div class="form-group">
	<label class="control-label col-md-4" for="cellulare-cliente">Cellulare:</label>
	<div class="col-md-5">          
	    <input type="text" class="form-control" id="cellulare-cliente" placeholder="" name="cellulare-cliente" required>
	</div>
    </div>
    <div class="form-group">
	<label class="control-label col-md-4" for="email-cliente">Email:</label>
	<div class="col-md-5">          
	    <input type="text" class="form-control" id="email-cliente" placeholder="" name="email-cliente" required>
	</div>
    </div>
</form>
@endsection

@section('content')
<form class="form-horizontal" action="" method="post">
    <fieldset>
	<legend class="fieldset-border">Dati cliente</legend>
	<div class="form-group">
	    <label class="control-label col-md-4" for="cliente">Cliente:</label>
	    <div class="col-md-4">
		<input type="text" class="form-control" id="cliente" placeholder="" name="cliente" autofocus required>
	    </div>
	    <div class="col-md-1">
		<input type="button" class="btn btn-info btn-default" data-toggle="modal" data-target="#addClienteModal" value="Aggiungi">
	    </div>
	</div>
    </fieldset>
    <fieldset>
	<legend class="fieldset-border">Dati gioiello</legend>
	<div class="form-group">
	    <label class="control-label col-md-4" for="tipologia">Tipologia:</label>
	    <div class="col-md-5">          
		<input type="text" class="form-control" id="tipologia" placeholder="" name="tipologia" required>
	    </div>
	</div>
	<div class="form-group">
	    <label class="control-label col-md-4" for="peso">Peso:</label>
	    <div class="col-md-5">          
		<input type="text" class="form-control" id="peso" placeholder="" name="peso" required>
	    </div>
	</div>
	<div class="form-group">
	    <label class="control-label col-md-4" for="metallo">Metallo:</label>
	    <div class="col-md-5">          
		<input type="text" class="form-control" id="metallo" placeholder="" name="metallo" required>
	    </div>
	</div>
	<div class="form-group">
	    <label class="control-label col-md-4" for="foto">Foto:</label>
	    <div class="col-md-5">
		<input type="file" class="form-control-file" id="foto" name="foto" aria-describedby="fileHelp">
	    </div>
	</div>
    </fieldset>
    <fieldset>
	<legend class="fieldset-border">Dettagli guasto</legend>
	<div class="form-group">
	    <label class="control-label col-md-4" for="appunti">Descrizione:</label>
	    <div class="col-md-5">
		<textarea class="form-control" id="descrizione-guasto" rows="3" name="descrizione-guasto"></textarea>
	    </div>
	</div>
    </fieldset>
    <fieldset>
	<legend class="fieldset-border">Dettagli pagamento</legend>
	<div class="form-group">
	    <label class="control-label col-md-4" for="acconto">Acconto:</label>
	    <div class="col-md-5">          
		<input type="text" class="form-control" id="acconto" placeholder="" name="acconto" required>
	    </div>
	</div>
	<div class="form-group">
	    <label class="control-label col-md-4" for="preventivo">Preventivo:</label>
	    <div class="col-md-5">          
		<input type="text" class="form-control" id="preventivo" placeholder="" name="preventivo" required>
	    </div>
	</div>
	<div class="form-group">
	    <label class="control-label col-md-4" for="appunti">Appunti:</label>
	    <div class="col-md-5">
		<textarea class="form-control" id="appunti" rows="3" name="appunti"></textarea>
	    </div>
	</div>
    </fieldset>
    <div class="form-group">        
	<div class="col-md-offset-4 col-md-5">
	    <button type="submit" class="btn btn-primary">Salva</button>
	</div>
    </div>
</form>
@endsection