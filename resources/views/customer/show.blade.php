<?php
$name = $identityDocument->name;
$surname = $identityDocument->surname;
$id = $customer->id;
$fiscalCode = $customer->fiscal_code;
$birthDate = explode("-", $identityDocument->birth_date);
$year = $birthDate[0];
$month = $birthDate[1];
$day = $birthDate[2];
$telephone = $customer->phone_number;
$mobile = $customer->mobile_phone;
$mobile = $customer->email;
$description = $customer->description;
$deposit = $customer->deposit;
$estimate = $customer->estimate;
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
    <li class="active"><a href="{{ route('newCustomer') }}">Cliente</a></li>
@endsection

@section('anchor-backup-href', route('photoBackup', Config::get('constants.folders.FIXINGS')) )
@section('anchor-delete-photos-href', route('photoDelete', Config::get('constants.folders.FIXINGS')) )

@section('modal-id', 'add-customer')
@section('modal-title', 'Dati riparazione')

@section('content')
    {!! Form::model($customer, ['route' => ['customer.store', $customer->id], 'id' => 'customer', 'class' => 'form-horizontal']) !!}
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
                {!! Form::label('fiscalCode', 'Codice fiscale:', ['class' => 'control-label col-md-4']) !!}
                <div class="col-md-5">
                    {!! Form::text('$fiscalCode', $fiscalCode, ['class' => 'form-control', 'required' => true]) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('deposit', 'Acconto:', ['class' => 'control-label col-md-4']) !!}
                <div class="col-md-5">
                    {!! Form::text('deposit', $deposit, ['class' => 'form-control', 'required' => true]) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('estimate', 'Preventivo:', ['class' => 'control-label col-md-4']) !!}
                <div class="col-md-5">
                    {!! Form::text('estimate', $estimate, ['class' => 'form-control', 'required' => true]) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('notes', 'Appunti:', ['class' => 'control-label col-md-4']) !!}
                <div class="col-md-5">
                    {!! Form::textarea('notes', $notes, ['class' => 'form-control', 'required' => false]) !!}
                </div>
            </div>
        </fieldset>
    {!! Form::close() !!}
@endsection

@section('footer-javascript')
    @parent
    <script src="{{ asset('vendor/bubbler.min.js') }}"></script>
    <script src="{{ asset('vendor/use.fontawesome.min.js') }}"></script>
    <script src="{{ asset('js/customer.create.floatBtn.js') }}"></script>
    <script>
	setHomeRoute("{{ route('showCustomerList') }}");
        setSaveButton("Aggiorna", function() {
            $("#update-customer").submit();
        });
    </script>
@endsection