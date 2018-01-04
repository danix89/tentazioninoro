<?php
$showCustomerList = $data["showCustomerList"];
$fixing = $data["fixing"];
$user = Auth::user();
if($showCustomerList) {
    $new = "Nuova";
    $disabled = false;
    $customer = $data["customer"];
    $customerList = $data["customerList"];
    $typology = "";
    $weight = "";
    $metal = "";
    $description = "";
    $deposit = "";
    $estimate = "";
    $notes = "";
} else {
    $new = "";
    $stateList = [
	Config::get('constants.fixing.state.NOT_YET_STARTED') => Config::get('constants.fixing.state.NOT_YET_STARTED'),
	Config::get('constants.fixing.state.IN_PROGRESS') => Config::get('constants.fixing.state.IN_PROGRESS'),
	Config::get('constants.fixing.state.COMPLETED') => Config::get('constants.fixing.state.COMPLETED'),
	Config::get('constants.fixing.state.DELIVERED') => Config::get('constants.fixing.state.DELIVERED')
    ];
    $identityDocument = $data["identityDocument"];
    $jewel = $data["jewel"];
    $disabled = true;
    $typology = $jewel->typology;
    $weight = $jewel->weight;
    $metal = $jewel->metal;
    $photo_paths = explode("~", $jewel->path_photo);
//    $photo_paths = explode("~", Storage::url($jewel->path_photo));
    $description = $fixing->description;
    $deposit = $fixing->deposit;
    $estimate = $fixing->estimate;
    $notes = $fixing->notes;
}

?>

@extends('layouts.base')

@if(empty($new))
    @section('title', 'Riparazione')
@else
    @section('title', 'Nuova riparazione')
@endif

@section('head-stylesheet')
    @parent
    
    <link rel="stylesheet" href="{{ asset('css/bubbler.min.css') }}">
@endsection

@section('head-javascript')
    @parent
    <script src="{{ asset('js/fixing.main.js') }}"></script>
@endsection

{{-- Debugbar::info($customerList) --}}
{{ Debugbar::info($fixing) }}
{{ Debugbar::info($user) }}

@section('navbar-li-left')
@parent
@section('home_class', '')
    <li class="active"><a href="{{ route('newFixing') }}">{{ $new }} Riparazione</a></li>
@endsection

@section('anchor-backup-href', route('photoBackup', Config::get('constants.folders.FIXINGS')) )
@section('anchor-delete-photos-href', route('photoDelete', Config::get('constants.folders.FIXINGS')) )

@section('modal-id', 'add-customer')
@section('modal-title', 'Dati riparazione')

@if($showCustomerList)
    @section('modal-form-start')
    {!! Form::model($customer, ['route' => ['customer.store'], 'class' => 'form-horizontal']) !!}
    <!--<form class="form-horizontal" action="" method="post">-->
    @endsection
    @section('modal-body')
	<div class="form-group">
	    {!! Form::label('fiscal_code', 'Codice fiscale:', ['class' => 'control-label col-md-4']) !!}
	    <!--<label class="control-label col-md-4" for="customer-fiscalcode">Codice Fiscale:</label>-->
	    <div class="col-md-4">
		{!! Form::text('fiscal_code', '', ['class' => 'form-control', 'autofocus' => true, 'required' => true, 'disabled' => $disabled]) !!}
		<!--<input type="text" class="form-control" id="customer-fiscal-code" placeholder="" name="customer-fiscal-code" autofocus required>-->
	    </div>
	</div>
	<div class="form-group">
	    {!! Form::label('name', 'Nome:', ['class' => 'control-label col-md-4']) !!}
	    <!--<label class="control-label col-md-4" for="customer-name">Nome:</label>-->
	    <div class="col-md-4">
		{!! Form::text('name', '', ['class' => 'form-control', 'required' => true, 'disabled' => $disabled]) !!}
		<!--<input type="text" class="form-control" id="customer-name" placeholder="" name="customer-name" required>-->
	    </div>
	</div>
	<div class="form-group">
	    {!! Form::label('surname', 'Cognome:', ['class' => 'control-label col-md-4']) !!}
	    <!--<label class="control-label col-md-4" for="customer-surname">Cognome:</label>-->
	    <div class="col-md-5">
		{!! Form::text('surname', '', ['class' => 'form-control', 'required' => true, 'disabled' => $disabled]) !!}
		<!--<input type="text" class="form-control" id="customer-surname" placeholder="" name="customer-surname" required>-->
	    </div>
	</div>
	<div class="form-group">
	    {!! Form::label('phone_number', 'Telefono:', ['class' => 'control-label col-md-4']) !!}
	    <!--<label class="control-label col-md-4" for="customer-phonenumber">Telefono:</label>-->
	    <div class="col-md-5">
		{!! Form::text('phone_number', '', ['class' => 'form-control', 'required' => true, 'disabled' => $disabled]) !!}
		<!--<input type="text" class="form-control" id="customer-phonenumber" placeholder="" name="customer-phonenumber" required>-->
	    </div>
	</div>
	<div class="form-group">
	    {!! Form::label('mobile_phone', 'Cellulare:', ['class' => 'control-label col-md-4']) !!}
	    <!--<label class="control-label col-md-4" for="customer-mobilephone">Cellulare:</label>-->
	    <div class="col-md-5">
		{!! Form::text('mobile_phone', '', ['class' => 'form-control', 'required' => true, 'disabled' => $disabled]) !!}
		<!--<input type="text" class="form-control" id="customer-mobilephone" placeholder="" name="customer-mobilephone" required>-->
	    </div>
	</div>
	<div class="form-group">
	    {!! Form::label('email', 'Email:', ['class' => 'control-label col-md-4']) !!}
	    <!--<label class="control-label col-md-4" for="customer-email">Email:</label>-->
	    <div class="col-md-5">
		{!! Form::text('email', '', ['class' => 'form-control', 'required' => true, 'disabled' => $disabled]) !!}
		<!--<input type="text" class="form-control" id="customer-email" placeholder="" name="customer-email" required>-->
	    </div>
	</div>
	<div class="form-group">
	    {!! Form::label('description', 'Descrizione:', ['class' => 'control-label col-md-4']) !!}
	    <!--<label class="control-label col-md-4" for="customer-description">Descrizione:</label>-->
	    <div class="col-md-5">
		{!! Form::textarea('description', '', ['class' => 'form-control', 'required' => false]) !!}
		<!--<textarea type="text" class="form-control" id="customer-description" placeholder="" name="customer-description"></textarea>-->
	    </div>
	</div>
    @endsection

    @section('modal-form-stop')
	{!! Form::close() !!}
    <!--</form>-->
    @endsection
@endif

@section('content')

@if(isset($stateList))
    {!! Form::model($fixing, ['route' => ['updateStateFixing', $fixing->id], 'id' => 'update-fixing', 'class' => 'form-horizontal']) !!}
	<fieldset>
	    <legend class="fieldset-border">Stato riparazione</legend>
	    <div class="form-group">
		{!! Form::label('state', 'Stato:', ['class' => 'control-label col-md-4']) !!}
		<div class="col-md-5">
		    {!! Form::select('state', $stateList, null, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Selezionare uno stato...']); !!}
		</div>
	    </div>
	</fieldset>
    {!! Form::close() !!}
@endif

{!! Form::model($fixing, ['route' => ['fixing.store', $fixing->id], 'id' => 'fixing', 'class' => 'form-horizontal', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
    {!! Form::hidden('toPrint', 'false', ['id' => 'toPrint']) !!}
    <fieldset>
	<legend class="fieldset-border">Dati cliente</legend>
	<div class="form-group">
	    {!! Form::label('customer_id', 'Cliente:', ['class' => 'control-label col-md-4']) !!}
	    @if($showCustomerList)
		<div class="col-md-5">
		    <!--<input type="text" class="form-control" id="customer" placeholder="" name="customer" autofocus required>-->
		    {!! Form::select('customer_id', $customerList, null, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Selezionare un cliente...']); !!}
		</div>
		<div class="col-md-1">
		    <input type="button" class="btn btn-info btn-default" data-toggle="modal" data-target="#add-customer-modal" value="Aggiungi">
		</div>
	    @else
		<div class="col-md-5">
		    {!! Form::text('customer_id', $identityDocument->name . " " . $identityDocument->surname, ['class' => 'form-control', 'autofocus' => true, 'required' => true, 'disabled' => $disabled]) !!}
		</div>
	    @endif
	</div>
    </fieldset>
    <fieldset>
	<legend class="fieldset-border">Dati gioiello</legend>
	<div class="form-group">
	    {!! Form::label('typology', 'Tipologia:', ['class' => 'control-label col-md-4']) !!}
	    <!--<label class="control-label col-md-4" for="tipologia">Tipologia:</label>-->
	    <div class="col-md-5">
		{!! Form::text('typology', $typology, ['class' => 'form-control', 'autofocus' => true, 'required' => true, 'disabled' => $disabled]) !!}
		<!--<input type="text" class="form-control" id="tipologia" placeholder="" name="tipologia" required>-->
	    </div>
	</div>
	<div class="form-group">
	    {!! Form::label('weight', 'Peso:', ['class' => 'control-label col-md-4']) !!}
	    <!--<label class="control-label col-md-4" for="peso">Peso:</label>-->
	    <div class="col-md-5">
		{!! Form::text('weight', $weight, ['class' => 'form-control', 'autofocus' => true, 'required' => true, 'disabled' => $disabled]) !!}
		<!--<input type="text" class="form-control" id="peso" placeholder="" name="peso" required>-->
	    </div>
	</div>
	<div class="form-group">
	    {!! Form::label('metal', 'Metallo:', ['class' => 'control-label col-md-4']) !!}
	    <!--<label class="control-label col-md-4" for="metallo">Metallo:</label>-->
	    <div class="col-md-5">
		{!! Form::text('metal', $metal, ['class' => 'form-control', 'autofocus' => true, 'required' => true, 'disabled' => $disabled]) !!}
		<!--<input type="text" class="form-control" id="metallo" placeholder="" name="metallo" required>-->
	    </div>
	</div>
	<div class="form-group">
	    {!! Form::label('path_photo', 'Foto:', ['class' => 'control-label col-md-4']) !!}
	    <!--<label class="control-label col-md-4" for="foto">Foto:</label>-->
	    <div class="col-md-5">
		@if(isset($photo_paths) && count($photo_paths) > 0)
		    <div id="myCarousel" class="carousel slide" data-ride="carousel">
			<?php $i = 0; ?>
			<!-- Indicators -->
			<ol class="carousel-indicators">
			    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			    @for ($i = 1; $i < count($photo_paths); $i++)
				<li data-target="#myCarousel" data-slide-to="{{ $i }}"></li>
			    @endfor
			</ol>
			<?php $i = 0; ?>
			<!-- Wrapper for slides -->
			<div class="carousel-inner">
			    @foreach($photo_paths as $photo_path)
				@if(!empty($photo_path))
				    @if($i === 0)
					<div class="item active">
				    @else
					<div class="item">
				    @endif
					    <img class='photo big d-block img-fluid' style="margin: 0 auto;" src="{{ Storage::url($photo_path) }}" alt="{{ $i++ }}" />
					</div>
				@endif
			    @endforeach
			</div>

			<!-- Left and right controls -->
			<a class="left carousel-control" href="#myCarousel" data-slide="prev">
			    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			    <span class="sr-only">Precedente</span>
			</a>
			<a class="right carousel-control" href="#myCarousel" data-slide="next">
			    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			    <span class="sr-only">Successiva</span>
			</a>
		    </div>
		@else
		    {!! Form::file('path_photo[]', ['class' => 'form-control', 'autofocus' => true, 'required' => false, 'multiple' => true, 'accept' => 'image/x-png,image/jpeg', 'disabled' => $disabled]) !!}
		    <div id="preview" style="margin-top: 15px;">
			<img id="photo" hidden src="#">
		    </div>
		@endif
	    </div>
	</div>
    </fieldset>
    <fieldset>
	<legend class="fieldset-border">Dettagli guasto</legend>
	<div class="form-group">
	    {!! Form::label('description', 'Descrizione:', ['class' => 'control-label col-md-4']) !!}
	    <!--<label class="control-label col-md-4" for="fault-description">Descrizione:</label>-->
	    <div class="col-md-5">
		{!! Form::textarea('description', $description, ['class' => 'form-control', 'autofocus' => true, 'disabled' => $disabled]) !!}
		<!--<textarea class="form-control" id="fault-description" rows="3" name="fault-description"></textarea>-->
	    </div>
	</div>
    </fieldset>
    <fieldset>
	<legend class="fieldset-border">Dettagli pagamento</legend>
	<div class="form-group">
	    {!! Form::label('deposit', 'Acconto:', ['class' => 'control-label col-md-4']) !!}
	    <!--<label class="control-label col-md-4" for="deposit">Acconto:</label>-->
	    <div class="col-md-5">
		{!! Form::text('deposit', $deposit, ['class' => 'form-control', 'autofocus' => true, 'required' => true, 'disabled' => $disabled]) !!}
		<!--<input type="text" class="form-control" id="deposit" placeholder="" name="deposit" required>-->
	    </div>
	</div>
	<div class="form-group">
	    {!! Form::label('estimate', 'Preventivo:', ['class' => 'control-label col-md-4']) !!}
	    <!--<label class="control-label col-md-4" for="estimate">Preventivo:</label>-->
	    <div class="col-md-5">
		{!! Form::text('estimate', $estimate, ['class' => 'form-control', 'autofocus' => true, 'required' => true, 'disabled' => $disabled]) !!}
		<!--<input type="text" class="form-control" id="estimate" placeholder="" name="estimate" required>-->
	    </div>
	</div>
	<div class="form-group">
	    {!! Form::label('notes', 'Appunti:', ['class' => 'control-label col-md-4']) !!}
	    <!--<label class="control-label col-md-4" for="notes">Appunti:</label>-->
	    <div class="col-md-5">
		{!! Form::textarea('notes', $notes, ['class' => 'form-control', 'autofocus' => true, 'required' => false, 'disabled' => $disabled]) !!}
		<!--<textarea class="form-control" id="notes" rows="3" name="notes"></textarea>-->
	    </div>
	</div>
    </fieldset>
    @if(!$disabled)
	<button id="save-btn" type="submit" class="btn btn-primary" style="display: none;">Salva</button>
    @endif
{!! Form::close() !!}
@endsection

@section('footer-javascript')
    @parent
    <script src="{{ asset('vendor/bubbler.min.js') }}"></script>
    <script src="{{ asset('vendor/use.fontawesome.min.js') }}"></script>
    <script src="{{ asset('js/fixing.create.floatBtn.js') }}"></script>
    <script>
	setHomeRoute("{{ route('home') }}");
	setPrintRoute("{{ route('printFixing', $fixing->id) }}");
	@if(!empty($new))
	    setSaveButton("Salva", function() {
		$("#save-btn").click();
	    });
	@else
	    setSaveButton("Aggiorna", function() {
		$("#update-fixing").submit();
	    });
	@endif
    </script>
@endsection