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

{{ Debugbar::info($customer) }}

@section('navbar-li-left')
    @parent
    @section('home_class', '')
    <li class=""><a href="{{ route('showCustomerList') }}">Clienti</a></li>
    <li class="active"><a href="{{ route('newCustomer') }}">Nuovo Cliente</a></li>
@endsection

@section('anchor-backup-href', route('photoBackup', Config::get('constants.folders.FIXINGS')) )
@section('anchor-delete-photos-href', route('photoDelete', Config::get('constants.folders.FIXINGS')) )

@section('content')
    {!! Form::model($fixing, ['route' => ['fixing.store', $fixing->id], 'id' => 'fixing', 'class' => 'form-horizontal', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
        @if($toPrint)
            {!! Form::hidden('toPrint', 'true', ['id' => 'toPrint']) !!}
        @endif
        <fieldset>
            <legend class="fieldset-border">Dati cliente</legend>
            <div class="form-group">
                {!! Form::label('customer_id', 'Cliente:', ['class' => 'control-label col-md-4']) !!}
                <div class="col-md-5">
                    {!! Form::text('customer_id', $identityDocument->name . " " . $identityDocument->surname, ['class' => 'form-control', 'autofocus' => true, 'required' => true, 'disabled' => $disabled]) !!}
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
	@if(!empty($new))
	    setSaveButton("Salva", function() {
		$("#save-btn").click();
	    });
	@else
            setPrintRoute("{{ route('printFixing', $fixingId) }}");
	    setSaveButton("Aggiorna", function() {
		$("#update-fixing").submit();
	    });
	@endif
    </script>
@endsection