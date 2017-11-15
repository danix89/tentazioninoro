<?php
$customer = $data["customer"];
$fixing = $data["fixing"];
$user = $data["user"];
?>

@extends('layouts.base')

@section('title', 'Nuova riparazione')

{{ Debugbar::info($fixing) }}
{{ Debugbar::info($user) }}

@section('navbar-li-left')
@parent
@section('home_class', '')
<li class="active"><a href="{{ route('newfixing', $user->id) }}">Nuova Riparazione</a></li>
@endsection

@section('modal-id', 'add-customer')
@section('modal-title', 'Dati riparazione')
@section('modal-body')
<!--<form class="form-horizontal" action="" method="post">-->
{!! Form::model($customer, ['route' => ['customer.store', $fixing->id], 'class' => 'form-horizontal']) !!}
    <div class="form-group">
        {!! Form::label('fiscalcode', 'Codice fiscale:', ['class' => 'control-label col-md-4']) !!}
        <!--<label class="control-label col-md-4" for="customer-fiscalcode">Codice Fiscale:</label>-->
        <div class="col-md-4">
            {!! Form::text('fiscalcode', '', ['class' => 'form-control', 'autofocus' => true, 'required' => true]) !!}
            <!--<input type="text" class="form-control" id="customer-fiscalcode" placeholder="" name="customer-fiscalcode" autofocus required>-->
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('name', 'Nome:', ['class' => 'control-label col-md-4']) !!}
        <!--<label class="control-label col-md-4" for="customer-name">Nome:</label>-->
        <div class="col-md-4">
            {!! Form::text('name', '', ['class' => 'form-control', 'required' => true]) !!}
            <!--<input type="text" class="form-control" id="customer-name" placeholder="" name="customer-name" required>-->
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('surname', 'Cognome:', ['class' => 'control-label col-md-4']) !!}
        <!--<label class="control-label col-md-4" for="customer-surname">Cognome:</label>-->
        <div class="col-md-5">
            {!! Form::text('surname', '', ['class' => 'form-control', 'required' => true]) !!}
            <!--<input type="text" class="form-control" id="customer-surname" placeholder="" name="customer-surname" required>-->
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('phone_number', 'Telefono:', ['class' => 'control-label col-md-4']) !!}
        <!--<label class="control-label col-md-4" for="customer-phonenumber">Telefono:</label>-->
        <div class="col-md-5">
            {!! Form::text('phone_number', '', ['class' => 'form-control', 'required' => true]) !!}
            <!--<input type="text" class="form-control" id="customer-phonenumber" placeholder="" name="customer-phonenumber" required>-->
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('mobile_phone', 'Cellulare:', ['class' => 'control-label col-md-4']) !!}
        <!--<label class="control-label col-md-4" for="customer-mobilephone">Cellulare:</label>-->
        <div class="col-md-5">
            {!! Form::text('mobile_phone', '', ['class' => 'form-control', 'required' => true]) !!}
            <!--<input type="text" class="form-control" id="customer-mobilephone" placeholder="" name="customer-mobilephone" required>-->
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('email', 'Email:', ['class' => 'control-label col-md-4']) !!}
        <!--<label class="control-label col-md-4" for="customer-email">Email:</label>-->
        <div class="col-md-5">
            {!! Form::text('email', '', ['class' => 'form-control', 'required' => true]) !!}
            <!--<input type="text" class="form-control" id="customer-email" placeholder="" name="customer-email" required>-->
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('description', 'Descrizione:', ['class' => 'control-label col-md-4']) !!}
        <!--<label class="control-label col-md-4" for="customer-description">Descrizione:</label>-->
        <div class="col-md-5">
            {!! Form::textarea('description', '', ['class' => 'form-control', 'required' => true]) !!}
            <!--<textarea type="text" class="form-control" id="customer-description" placeholder="" name="customer-description"></textarea>-->
        </div>
    </div>
{!! Form::close() !!}
<!--</form>-->
@endsection

@section('content')
{!! Form::model($fixing, ['route' => ['fixing.store', $fixing->id], 'class' => 'form-horizontal']) !!}
<fieldset>
    <legend class="fieldset-border">Dati cliente</legend>
    <div class="form-group">
        {!! Form::label('customer', 'Cliente:', ['class' => 'control-label col-md-4']) !!}
        <div class="col-md-5">
            <!--<input type="text" class="form-control" id="customer" placeholder="" name="customer" autofocus required>-->
            {!! Form::text('customer', '', ['class' => 'form-control', 'autofocus' => true, 'required' => true]) !!}
        </div>
        <div class="col-md-1">
            <input type="button" class="btn btn-info btn-default" data-toggle="modal" data-target="#add-customer-modal" value="Aggiungi">
        </div>
    </div>
</fieldset>
<fieldset>
    <legend class="fieldset-border">Dati gioiello</legend>
    <div class="form-group">
        {!! Form::label('typology', 'Tipologia:', ['class' => 'control-label col-md-4']) !!}
        <!--<label class="control-label col-md-4" for="tipologia">Tipologia:</label>-->
        <div class="col-md-5">
            {!! Form::text('typology', '', ['class' => 'form-control', 'autofocus' => true, 'required' => true]) !!}
            <!--<input type="text" class="form-control" id="tipologia" placeholder="" name="tipologia" required>-->
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('wheight', 'Peso:', ['class' => 'control-label col-md-4']) !!}
        <!--<label class="control-label col-md-4" for="peso">Peso:</label>-->
        <div class="col-md-5">
            {!! Form::text('wheight', '', ['class' => 'form-control', 'autofocus' => true, 'required' => true]) !!}
            <!--<input type="text" class="form-control" id="peso" placeholder="" name="peso" required>-->
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('metal', 'Metallo:', ['class' => 'control-label col-md-4']) !!}
        <!--<label class="control-label col-md-4" for="metallo">Metallo:</label>-->
        <div class="col-md-5">
            {!! Form::text('metal', '', ['class' => 'form-control', 'autofocus' => true, 'required' => true]) !!}
            <!--<input type="text" class="form-control" id="metallo" placeholder="" name="metallo" required>-->
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('photo_url', 'Foto:', ['class' => 'control-label col-md-4']) !!}
        <!--<label class="control-label col-md-4" for="foto">Foto:</label>-->
        <div class="col-md-5">
            {!! Form::text('photo_url', '', ['class' => 'form-control', 'autofocus' => true, 'required' => true]) !!}
            <!--<input type="file" class="form-control-file" id="foto" name="foto" aria-describedby="fileHelp">-->
        </div>
    </div>
</fieldset>
<fieldset>
    <legend class="fieldset-border">Dettagli guasto</legend>
    <div class="form-group">
        {!! Form::label('description', 'Descrizione:', ['class' => 'control-label col-md-4']) !!}
        <!--<label class="control-label col-md-4" for="fault-description">Descrizione:</label>-->
        <div class="col-md-5">
            {!! Form::textarea('description', '', ['class' => 'form-control', 'autofocus' => true, 'required' => true]) !!}
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
            {!! Form::text('deposit', '', ['class' => 'form-control', 'autofocus' => true, 'required' => true]) !!}
            <!--<input type="text" class="form-control" id="deposit" placeholder="" name="deposit" required>-->
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('estimate', 'Preventivo:', ['class' => 'control-label col-md-4']) !!}
        <!--<label class="control-label col-md-4" for="estimate">Preventivo:</label>-->
        <div class="col-md-5">
            {!! Form::text('estimate', '', ['class' => 'form-control', 'autofocus' => true, 'required' => true]) !!}
            <!--<input type="text" class="form-control" id="estimate" placeholder="" name="estimate" required>-->
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('notes', 'Appunti:', ['class' => 'control-label col-md-4']) !!}
        <!--<label class="control-label col-md-4" for="notes">Appunti:</label>-->
        <div class="col-md-5">
            {!! Form::textarea('notes', '', ['class' => 'form-control', 'autofocus' => true, 'required' => true]) !!}
            <!--<textarea class="form-control" id="notes" rows="3" name="notes"></textarea>-->
        </div>
    </div>
</fieldset>
<div class="form-group">        
    <div class="col-md-offset-4 col-md-5">
        <button type="submit" class="btn btn-primary">Salva</button>
    </div>
</div>
</fieldset>
{!! Form::close() !!}

<!--<form class="form-horizontal" action="" method="post">
    <fieldset>
        <legend class="fieldset-border">Dati cliente</legend>
        <div class="form-group">
            <label class="control-label col-md-4" for="customer">Cliente:</label>
            <div class="col-md-4">
                <input type="text" class="form-control" id="customer" placeholder="" name="customer" autofocus required>
            </div>
            <div class="col-md-1">
                <input type="button" class="btn btn-info btn-default" data-toggle="modal" data-target="#add-customer-modal" value="Aggiungi">
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
    <div class="form-group">        
        <div class="col-md-offset-4 col-md-5">
            <button type="submit" class="btn btn-primary">Salva</button>
        </div>
    </div>
</form>-->
@endsection