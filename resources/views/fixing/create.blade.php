<?php
$canBeUpdated = $data["canBeUpdated"];
$customerList = $data["customerList"];
$fixing = $data["fixing"];
$customer = $data["customer"];
$user = Auth::user();
if(!$canBeUpdated) {
    $customerId = 0;
    $route = ["fixing.store"];
    $method = "POST";
    $fixingId = $data["fixingId"];
    $new = "Nuova";
    $disabled = false;
//    $typology = "Orologio";
//    $weight = "220";
//    $metal = "Acciaio";
//    $description = "";
//    $deposit = "20";
//    $estimate = "200";
    $typology = "";
    $weight = "";
    $metal = "";
    $description = "";
    $deposit = "";
    $estimate = "";
    $notes = "";
    $toPrint = "false";
} else {
    $new = "";
    $method = "PUT";
    $route = ["fixing.update", $fixing->id];
    $fixingId = $fixing->id;
    $customerId = $fixing->customer_id;
    $stateList = [
	Config::get('constants.fixing.state.NOT_YET_STARTED') => Config::get('constants.fixing.state.NOT_YET_STARTED'),
	Config::get('constants.fixing.state.IN_PROGRESS') => Config::get('constants.fixing.state.IN_PROGRESS'),
	Config::get('constants.fixing.state.COMPLETED') => Config::get('constants.fixing.state.COMPLETED'),
	Config::get('constants.fixing.state.DELIVERED') => Config::get('constants.fixing.state.DELIVERED')
    ];
    $identityDocument = $data["identityDocument"];
    $jewel = $data["jewel"];
    $disabled = false;
    $typology = $jewel->typology;
    $weight = $jewel->weight;
    $metal = $jewel->metal;
    if (!empty($jewel->path_photo)) {
        $photo_paths = explode("~", $jewel->path_photo);
    } else {
        $photo_paths = [];
    }
//    $photo_paths = explode("~", Storage::url($jewel->path_photo));
    $description = $fixing->description;
    $deposit = $fixing->deposit;
    $estimate = $fixing->estimate;
    $notes = $fixing->notes;
    $toPrint = "true";
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
    <li class=""><a href="{{ route('showCustomerList') }}">Clienti</a></li>
    <li class="active"><a href="{{ route('newFixing') }}">{{ $new }} Riparazione</a></li>
@endsection

@section('anchor-backup-href', route('photoBackup', Config::get('constants.folders.FIXINGS')) )
@section('anchor-delete-photos-href', route('photoDelete', Config::get('constants.folders.FIXINGS')) )

@section('modal-id', 'add-customer')
@section('modal-title', 'Dati riparazione')

@section('modal-form-start')
    {!! Form::model($customer, ['route' => ['customer.store'], 'class' => 'form-horizontal']) !!}
@endsection
    @section('modal-body')
        <div class="form-group">
            {!! Form::label('name', 'Nome:', ['class' => 'control-label col-md-4']) !!}
            <div class="col-md-4">
                {!! Form::text('name', '', ['class' => 'form-control', 'required' => true]) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('surname', 'Cognome:', ['class' => 'control-label col-md-4']) !!}
            <div class="col-md-5">
                {!! Form::text('surname', '', ['class' => 'form-control', 'required' => true]) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('aka', 'Soprannome:', ['class' => 'control-label col-md-4']) !!}
            <div class="col-md-5">
                {!! Form::text('aka', '', ['class' => 'form-control', 'required' => true]) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('fiscalCode', 'Codice fiscale:', ['class' => 'control-label col-md-4']) !!}
            <div class="col-md-4">
                {!! Form::text('fiscalCode', '', ['class' => 'form-control', 'autofocus' => true, 'required' => false]) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('birthDate', 'Data di nascita:', ['class' => 'control-label col-md-4']) !!}
            <div class="col-md-4">
                {!! Form::date('birthDate', '', ['class' => 'form-control', 'autofocus' => true, 'required' => true]) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('phoneNumber', 'Telefono:', ['class' => 'control-label col-md-4']) !!}
            <div class="col-md-5">
                {!! Form::text('phoneNumber', '', ['class' => 'form-control', 'required' => true]) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('mobilePhone', 'Cellulare:', ['class' => 'control-label col-md-4']) !!}
            <div class="col-md-5">
                {!! Form::text('mobilePhone', '', ['class' => 'form-control', 'required' => true]) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('email', 'Email:', ['class' => 'control-label col-md-4']) !!}
            <div class="col-md-5">
                {!! Form::text('email', '', ['class' => 'form-control', 'required' => false]) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('description', 'Descrizione:', ['class' => 'control-label col-md-4']) !!}
            <div class="col-md-5">
                {!! Form::textarea('description', '', ['class' => 'form-control', 'required' => false]) !!}
            </div>
        </div>
    @endsection

@section('modal-form-stop')
    {!! Form::close() !!}
@endsection

@section('content')

{!! Form::model($fixing, ['route' => $route, 'method' => $method, 'id' => 'fixing', 'class' => 'form-horizontal', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
    {!! Form::hidden('toPrint', $toPrint, ['id' => 'toPrint']) !!}
    @if($canBeUpdated)
        <fieldset>
            <legend class="fieldset-border">Stato riparazione</legend>
            <div class="form-group">
                {!! Form::label('state', 'Stato:', ['class' => 'control-label col-md-4']) !!}
                <div class="col-md-5">
                    {!! Form::select('state', $stateList, null, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Selezionare uno stato...']); !!}
                </div>
            </div>
        </fieldset>
    @endif
    <fieldset>
	<legend class="fieldset-border">Dati cliente</legend>
	<div class="form-group">
	    {!! Form::label('customer_id', 'Cliente:', ['class' => 'control-label col-md-4']) !!}
            <div class="col-md-5">
                {!! Form::select('customer_id', $customerList, $customerId, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Selezionare un cliente...']); !!}
            </div>
            <div id="add-customer-btn-div" class="col-md-1">
                <input type="button" class="btn btn-info btn-default" data-toggle="modal" data-target="#add-customer-modal" value="Aggiungi">
            </div>
	</div>
    </fieldset>
    <fieldset>
	<legend class="fieldset-border">Dati gioiello</legend>
	<div class="form-group">
	    {!! Form::label('typology', 'Tipologia:', ['class' => 'control-label col-md-4']) !!}
	    <div class="col-md-5">
		{!! Form::text('typology', $typology, ['class' => 'form-control', 'autofocus' => true, 'required' => true]) !!}
	    </div>
	</div>
	<div class="form-group">
	    {!! Form::label('weight', 'Peso:', ['class' => 'control-label col-md-4']) !!}
	    <div class="col-md-5">
		{!! Form::text('weight', $weight, ['class' => 'form-control', 'autofocus' => true, 'required' => true]) !!}
	    </div>
	</div>
	<div class="form-group">
	    {!! Form::label('metal', 'Metallo:', ['class' => 'control-label col-md-4']) !!}
	    <div class="col-md-5">
		{!! Form::text('metal', $metal, ['class' => 'form-control', 'autofocus' => true, 'required' => true]) !!}
	    </div>
	</div>
	<div class="form-group">
	    {!! Form::label('path_photo', 'Foto:', ['class' => 'control-label col-md-4']) !!}
            <div class="col-md-5" style="/*margin-bottom: -60px;*/">
                <?php 
                $showCarousel = (isset($photo_paths) && count($photo_paths) > 0);
                if($showCarousel) {
                    $alert = true;
                    $hidden = "";
                } else {
                    $alert = false;
                    $hidden = "hidden";
                }
                ?>
                <div id="myCarousel" {{ $hidden }} class="carousel" data-ride="carousel" style="margin-bottom: 8px;">
                    <?php $i = 0; ?>
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        @if($showCarousel)
                            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                            @for ($i = 1; $i < count($photo_paths); $i++)
                                <li data-target="#myCarousel" data-slide-to="{{ $i }}"></li>
                            @endfor
                        @endif
                    </ol>
                    <?php $i = 0; ?>
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        @if($showCarousel)
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
                        @endif
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
                    
                <div id="fileContainer" style="margin-bottom: 5px;"></div>

                {!! Form::hidden('deletePhotos', '', ['id' => 'deletePhotos']) !!}
                <button id="add-photo-paths-btn" type="button" class="btn btn-default btn-info" onclick="" style="">Aggiungi campo</button>
                <button id="remove-photo-paths-btn" type="button" class="btn btn-default btn-warning" onclick="removeFileInput()" style="">Rimuovi campo</button>
	    </div>
	</div>
    </fieldset>
    <fieldset>
	<legend class="fieldset-border">Dettagli guasto</legend>
	<div class="form-group">
	    {!! Form::label('description', 'Descrizione:', ['class' => 'control-label col-md-4']) !!}
	    <div class="col-md-5">
		{!! Form::textarea('description', $description, ['class' => 'form-control', 'autofocus' => true]) !!}
	    </div>
	</div>
    </fieldset>
    <fieldset>
	<legend class="fieldset-border">Dettagli pagamento</legend>
	<div class="form-group">
	    {!! Form::label('deposit', 'Acconto:', ['class' => 'control-label col-md-4']) !!}
	    <div class="col-md-5">
		{!! Form::text('deposit', $deposit, ['class' => 'form-control', 'autofocus' => true, 'required' => true]) !!}
	    </div>
	</div>
	<div class="form-group">
	    {!! Form::label('estimate', 'Preventivo:', ['class' => 'control-label col-md-4']) !!}
	    <div class="col-md-5">
		{!! Form::text('estimate', $estimate, ['class' => 'form-control', 'autofocus' => true, 'required' => true]) !!}
	    </div>
	</div>
	<div class="form-group">
	    {!! Form::label('notes', 'Appunti:', ['class' => 'control-label col-md-4']) !!}
	    <div class="col-md-5">
		{!! Form::textarea('notes', $notes, ['class' => 'form-control', 'autofocus' => true, 'required' => false]) !!}
	    </div>
	</div>
    </fieldset>
    <!-- Questo pulsante serve per permettere di riprodurre correttamente l'operazione di submit del form, in modo da consentire di controllare in automatico se i campi input richiesti sono vuoti. -->
    <button id="save-btn" type="submit" class="btn btn-primary" style="display: none;">Salva</button>
{!! Form::close() !!}
@endsection

@section('footer-javascript')
    @parent
    <script src="{{ asset('vendor/bubbler.min.js') }}"></script>
    <script src="{{ asset('vendor/use.fontawesome.min.js') }}"></script>
    <script src="{{ asset('js/fixing.create.floatBtn.js') }}"></script>
    <script>
	setHomeRoute("{{ route('home') }}");
	@if(!empty($new))
            //E' necessario definire qui il comportamento del pulsante "Salva", in quanto se definito direttamente in fixing.create.floatBtn.js, non viene associato correttamente.
	    setSaveButton("Salva", function() {
		$("#save-btn").click();
	    });
	@else
            setPrintRoute("{{ route('printFixing', $fixingId) }}");
	    setSaveButton("Aggiorna", function() {
//		$("#update-fixing").submit();
                $("#save-btn").click();
	    });
	    
	@endif
    </script>
@endsection