<?php
$name = $identityDocument->name;
$surname = $identityDocument->surname;
$aka = $customer->aka;
$id = $customer->id;
$fiscalCode = $customer->fiscal_code;
$birthDate = $identityDocument->birth_date;
$year = $birthDate[0];
$month = $birthDate[1];
$day = $birthDate[2];
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
                    {!! Form::text('fiscalCode', $fiscalCode, ['class' => 'form-control', 'required' => false]) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('birthDate', 'Data di nascita:', ['class' => 'control-label col-md-4']) !!}
                <div class="col-md-5">
                    {!! Form::date('birthDate', $birthDate, ['class' => 'form-control', 'required' => true]) !!}
                </div>
            </div>
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