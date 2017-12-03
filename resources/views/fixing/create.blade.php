<?php
$showCustomerList = $data["showCustomerList"];
$fixing = $data["fixing"];
$identityDocument = $data["identityDocument"];
$jewel = $data["jewel"];
$user = $data["user"];
if($showCustomerList) {
    $disabled = false;
    $customer = $data["customer"];
    $customerList = $data["customerList"];
    $typology = "";
    $weight = "";
    $metal = "";
    $path_photo = "";
    $description = "";
    $deposit = "";
    $estimate = "";
    $notes = "";
} else {
    $disabled = true;
    $typology = $jewel->typology;
    $weight = $jewel->weight;
    $metal = $jewel->metal;
    $path_photo = asset($jewel->path_photo);
    $description = $fixing->description;
    $deposit = $fixing->deposit;
    $estimate = $fixing->estimate;
    $notes = $fixing->notes;
}

?>

@extends('layouts.base')

@section('title', 'Nuova riparazione')

{{-- Debugbar::info($customerList) --}}
{{ Debugbar::info($fixing) }}
{{ Debugbar::info($user) }}

@section('navbar-li-left')
@parent
@section('home_class', '')
<li class="active"><a href="{{ route('newfixing') }}">Nuova Riparazione</a></li>
@endsection

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
{!! Form::model($fixing, ['route' => ['fixing.store', $fixing->id], 'class' => 'form-horizontal', 'files' => true]) !!}
<fieldset>
    <legend class="fieldset-border">Dati cliente</legend>
    <div class="form-group">
        {!! Form::label('customer_id', 'Cliente:', ['class' => 'control-label col-md-4']) !!}
	@if($showCustomerList)
	    <div class="col-md-5">
		<!--<input type="text" class="form-control" id="customer" placeholder="" name="customer" autofocus required>-->
		{!! Form::select('customer_id', $customerList, null, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Scegli un cliente...']); !!}
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
            {!! Form::file('path_photo', ['class' => 'form-control', 'autofocus' => true, 'required' => false, 'accept' => 'image/x-png,image/jpeg', 'disabled' => $disabled]) !!}
            <!--<input type="file" class="form-control-file" id="foto" name="foto" aria-describedby="fileHelp">-->
	    @if(isset($path_photo) && $path_photo != "")
		<img src="{{ $path_photo }}" />
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