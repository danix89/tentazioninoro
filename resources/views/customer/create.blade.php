<?php

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
                    {!! Form::text('aka', "", ['class' => 'form-control', 'required' => true]) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('fiscalCode', 'Codice fiscale:', ['class' => 'control-label col-md-4']) !!}
                <div class="col-md-5">
                    {!! Form::text('fiscalCode', "", ['class' => 'form-control', 'required' => false]) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('birthDate', 'Data di nascita:', ['class' => 'control-label col-md-4']) !!}
                <div class="col-md-5">
                    {!! Form::date('birthDate', "", ['class' => 'form-control', 'required' => true]) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('phoneNumber', 'Telefono:', ['class' => 'control-label col-md-4']) !!}
                <div class="col-md-5">
                    {!! Form::text('phoneNumber', "", ['class' => 'form-control', 'required' => true]) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('mobilePhone', 'Cellulare:', ['class' => 'control-label col-md-4']) !!}
                <div class="col-md-5">
                    {!! Form::text('mobilePhone', "", ['class' => 'form-control', 'required' => false]) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('email', 'Email:', ['class' => 'control-label col-md-4']) !!}
                <div class="col-md-5">
                    {!! Form::text('email', "", ['class' => 'form-control', 'required' => true]) !!}
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
    <script src="{{ asset('vendor/use.fontawesome.min.js') }}"></script>
    <script src="{{ asset('js/fixing.create.floatBtn.js') }}"></script>
    <script>
	setHomeRoute("{{ route('home') }}");
        setSaveButton("Salva", function() {
            $("#save-btn").click();
        });
    </script>
@endsection