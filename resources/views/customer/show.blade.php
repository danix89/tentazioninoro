<?php
if(preg_match("/" . Auth::user()->permissions . "/", Config::get('constants.permission.FIXINGS'))) {
    $required = false;
    $extendFileds = false;
} else if (preg_match("/" . Auth::user()->permissions . "/", Config::get('constants.permission.SALES_ACTS'))) {
    $required = true;
    $extendFileds = true;
}

$name = $identityDocument->name;
$surname = $identityDocument->surname;
$aka = $customer->aka;
$id = $customer->id;
$fiscalCode = $customer->fiscal_code;
$type = $identityDocument->type;
$releaseDate = $identityDocument->release_date;
$birthDate = $identityDocument->birth_date;
$birthResidence = $identityDocument->birth_residence;
$birthProvince = $identityDocument->birth_province;
$residence = $identityDocument->residence;
$street = $identityDocument->street;
$streetNumber = $identityDocument->street_number;
$telephone = $customer->phone_number;
$mobile = $customer->mobile_phone;
$email = $customer->email;
$description = $customer->description;
?>

@extends('layouts.base')

@section('title', 'Cliente n.' . $id)

@section('head-stylesheet')
    @parent
    
    <link rel="stylesheet" href="{{ asset('css/bubbler.min.css') }}">
@endsection

@section('head-javascript')
    @parent
    <!--<script src="{{ asset('js/customer.main.js') }}"></script>-->
@endsection

@section('navbar-li-left')
    @parent
    @section('home_class', '')
    <li class=""><a href="{{ route('showCustomerList') }}">Clienti</a></li>
    <li class="active"><a href="">Aggiorna Cliente</a></li>
@endsection

@section('anchor-backup-href', route('photoBackup', Config::get('constants.folders.FIXINGS')) )
@section('anchor-delete-photos-href', route('photoDelete', Config::get('constants.folders.FIXINGS')) )

@section('modal-id', 'add-customer')
@section('modal-title', 'Dati riparazione')

@section('content')
    {!! Form::model($customer, ['route' => ['customer.update', $customer->id], 'method' => 'PUT', 'id' => 'update-customer', 'class' => 'form-horizontal']) !!}
        <fieldset>
            <legend class="fieldset-border">Dati cliente</legend>
            <div class="form-group">
                {!! Form::label('name', 'Nome:', ['class' => 'control-label col-md-4']) !!}
                <div class="col-md-5">
                    {!! Form::text('name', $name, ['class' => 'form-control', 'required' => true]) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('surname', 'Cognome:', ['class' => 'control-label col-md-4']) !!}
                <div class="col-md-5">
                    {!! Form::text('surname', $surname, ['class' => 'form-control', 'required' => true]) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('aka', 'Soprannome:', ['class' => 'control-label col-md-4']) !!}
                <div class="col-md-5">
                    {!! Form::text('aka', $aka, ['class' => 'form-control', 'required' => false]) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('fiscalCode', 'Codice fiscale:', ['class' => 'control-label col-md-4']) !!}
                <div class="col-md-5">
                    {!! Form::text('fiscalCode', $fiscalCode, ['class' => 'form-control', 'required' => $required]) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('birthDate', 'Data di nascita:', ['class' => 'control-label col-md-4']) !!}
                <div class="col-md-5">
                    {!! Form::date('birthDate', $birthDate, ['class' => 'form-control', 'required' => true]) !!}
                </div>
            </div>
	    @if($extendFileds)
		<div class="form-group">
		    {!! Form::label('birthResidence', 'Luogo di nascita:', ['class' => 'control-label col-md-4']) !!}
		    <div class="col-md-5">
			{!! Form::text('birthResidence', $birthResidence, ['class' => 'form-control', 'required' => $required]) !!}
		    </div>
		</div>
		<div class="form-group">
		    {!! Form::label('birthProvince', 'Provincia di nascita:', ['class' => 'control-label col-md-4']) !!}
		    <div class="col-md-5">
			{!! Form::text('birthProvince', $birthProvince, ['class' => 'form-control', 'required' => $required]) !!}
		    </div>
		</div>
		<div class="form-group">
		    {!! Form::label('residence', 'Residenza:', ['class' => 'control-label col-md-4']) !!}
		    <div class="col-md-5">
			{!! Form::text('residence', $residence, ['class' => 'form-control', 'required' => $required]) !!}
		    </div>
		</div>
		<div class="form-group">
		    {!! Form::label('street', 'Via:', ['class' => 'control-label col-md-4']) !!}
		    <div class="col-md-5">
			{!! Form::text('street', $street, ['class' => 'form-control', 'required' => $required]) !!}
		    </div>
		</div>
		<div class="form-group">
		    {!! Form::label('streetNumber', 'N. civico:', ['class' => 'control-label col-md-4']) !!}
		    <div class="col-md-5">
			{!! Form::text('streetNumber', $streetNumber, ['class' => 'form-control', 'required' => $required]) !!}
		    </div>
		</div>
		<div class="form-group">
		    {!! Form::label('type', 'Doc. Identit&agrave;', ['class' => 'control-label col-md-4']) !!}
		    <div class="col-md-5">
			{!! Form::select('type', ['' => '', 'C.I.' => 'Carta d\'identit&agrave;', 'P' => 'Patente'], $type, ['class' => 'form-control', 'required' => $required]); !!}
		    </div>
		</div>
		<div class="form-group">
		    {!! Form::label('releaseDate', 'Ril. il:', ['class' => 'control-label col-md-4']) !!}
		    <div class="col-md-5">
			{!! Form::date('releaseDate', $releaseDate, ['class' => 'form-control', 'required' => $required]) !!}
		    </div>
		</div>
	    @endif
            <div class="form-group">
                {!! Form::label('phoneNumber', 'Telefono:', ['class' => 'control-label col-md-4']) !!}
                <div class="col-md-5">
                    {!! Form::text('phoneNumber', $telephone, ['class' => 'form-control', 'required' => true]) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('mobilePhone', 'Cellulare:', ['class' => 'control-label col-md-4']) !!}
                <div class="col-md-5">
                    {!! Form::text('mobilePhone', $mobile, ['class' => 'form-control', 'required' => false]) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('email', 'Email:', ['class' => 'control-label col-md-4']) !!}
                <div class="col-md-5">
                    {!! Form::text('email', $email, ['class' => 'form-control', 'required' => true]) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('description', 'Descrizione:', ['class' => 'control-label col-md-4']) !!}
                <div class="col-md-5">
                    {!! Form::textarea('description', $description, ['class' => 'form-control', 'required' => false]) !!}
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
    <script src="{{ asset('js/customer.create.floatBtn.js') }}"></script>
    <script>
	setHomeRoute("{{ route('showCustomerList') }}");
        //E' necessario definire qui il comportamento del pulsante "Salva", in quanto se definito direttamente in customer.create.floatBtn.js, non viene associato correttamente.
        setSaveButton("Aggiorna", function() {
            $("#save-btn").click();
        });
    </script>
@endsection