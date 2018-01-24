<?php
if(preg_match("/" . Auth::user()->permissions . "/", Config::get('constants.permission.FIXINGS'))) {
    $required = false;
    $extendFileds = false;
} else if (preg_match("/" . Auth::user()->permissions . "/", Config::get('constants.permission.SALES_ACTS'))) {
    $required = true;
    $extendFileds = true;
}
?>

@extends('layouts.base')

@section('title', 'Nuovo cliente')

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
    <li class="active"><a href="">Nuovo Cliente</a></li>
@endsection

@section('anchor-backup-href', route('photoBackup', Config::get('constants.folders.FIXINGS')) )
@section('anchor-delete-photos-href', route('photoDelete', Config::get('constants.folders.FIXINGS')) )

@section('content')
    {!! Form::model($customer, ['route' => ['customer.store'], 'id' => 'customer', 'class' => 'form-horizontal']) !!}
        <fieldset>
            <legend class="fieldset-border">Dati cliente</legend>
            <div class="form-group">
                {!! Form::label('name', 'Nome:', ['class' => 'control-label col-md-4']) !!}
                <div class="col-md-5">
                    {!! Form::text('name', "", ['class' => 'form-control', 'required' => true]) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('surname', 'Cognome:', ['class' => 'control-label col-md-4']) !!}
                <div class="col-md-5">
                    {!! Form::text('surname', "", ['class' => 'form-control', 'required' => true]) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('aka', 'Soprannome:', ['class' => 'control-label col-md-4']) !!}
                <div class="col-md-5">
                    {!! Form::text('aka', "", ['class' => 'form-control', 'required' => false]) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('fiscalCode', 'Codice fiscale:', ['class' => 'control-label col-md-4']) !!}
                <div class="col-md-5">
                    {!! Form::text('fiscalCode', "", ['class' => 'form-control', 'required' => $required, 'minlength' => 16, 'maxlength' => 16,]) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('birthDate', 'Data di nascita:', ['class' => 'control-label col-md-4']) !!}
                <div class="col-md-5">
                    {!! Form::date('birthDate', "", ['class' => 'form-control', 'required' => $required]) !!}
                </div>
            </div>
	    @if($extendFileds)
		<div class="form-group">
		    {!! Form::label('birthResidence', 'Luogo di nascita:', ['class' => 'control-label col-md-4']) !!}
		    <div class="col-md-5">
			{!! Form::text('birthResidence', "", ['class' => 'form-control', 'required' => $required]) !!}
		    </div>
		</div>
		<div class="form-group">
		    {!! Form::label('birthProvince', 'Provincia di nascita:', ['class' => 'control-label col-md-4']) !!}
		    <div class="col-md-5">
			{!! Form::text('birthProvince', "", ['class' => 'form-control', 'required' => $required]) !!}
		    </div>
		</div>
		<div class="form-group">
		    {!! Form::label('residence', 'Residenza:', ['class' => 'control-label col-md-4']) !!}
		    <div class="col-md-5">
			{!! Form::text('residence', "", ['class' => 'form-control', 'required' => $required]) !!}
		    </div>
		</div>
		<div class="form-group">
		    {!! Form::label('street', 'Via:', ['class' => 'control-label col-md-4']) !!}
		    <div class="col-md-5">
			{!! Form::text('street', "", ['class' => 'form-control', 'required' => $required]) !!}
		    </div>
		</div>
		<div class="form-group">
		    {!! Form::label('streetNumber', 'N. civico:', ['class' => 'control-label col-md-4']) !!}
		    <div class="col-md-5">
			{!! Form::text('streetNumber', "", ['class' => 'form-control', 'required' => $required]) !!}
		    </div>
		</div>
		<div class="form-group">
		    {!! Form::label('type', 'Doc. Identit&agrave;', ['class' => 'control-label col-md-4']) !!}
		    <div class="col-md-5">
			{!! Form::select('type', ['' => '', 'C.I.' => 'Carta d\'identit&agrave;', 'P' => 'Patente'], '', ['class' => 'form-control', 'required' => $required]); !!}
		    </div>
		</div>
		<div class="form-group">
		    {!! Form::label('releaseDate', 'Ril. il:', ['class' => 'control-label col-md-4']) !!}
		    <div class="col-md-5">
			{!! Form::date('releaseDate', \Carbon\Carbon::now(), ['class' => 'form-control', 'required' => $required]) !!}
		    </div>
		</div>
		<div class="form-group">
		    {!! Form::label('number', 'N. Doc. Identit&agrave;:', ['class' => 'control-label col-md-4']) !!}
		    <div class="col-md-5">
			{!! Form::text('number', "", ['class' => 'form-control', 'required' => $required]); !!}
		    </div>
		</div>
	    @endif
            <div class="form-group">
                {!! Form::label('phoneNumber1', 'Telefono 1:', ['class' => 'control-label col-md-4']) !!}
                <div class="col-md-5">
                    {!! Form::text('phoneNumber1', "", ['class' => 'form-control', 'required' => true]) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('phoneNumber2', 'Telefono 2:', ['class' => 'control-label col-md-4']) !!}
                <div class="col-md-5">
                    {!! Form::text('phoneNumber2', "", ['class' => 'form-control', 'required' => false]) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('email', 'Email:', ['class' => 'control-label col-md-4']) !!}
                <div class="col-md-5">
                    {!! Form::text('email', "", ['class' => 'form-control', 'required' => false]) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('description', 'Descrizione:', ['class' => 'control-label col-md-4']) !!}
                <div class="col-md-5">
                    {!! Form::textarea('description', "", ['class' => 'form-control', 'required' => false]) !!}
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
    <script src="{{ asset('js/customer.create.floatBtn.js') }}"></script>
    <script>
	setHomeRoute("{{ route('home') }}");
        setSaveButton("Salva", function() {
            $("#save-btn").click();
        });
    </script>
@endsection