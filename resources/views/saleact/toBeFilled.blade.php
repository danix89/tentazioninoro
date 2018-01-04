<?php
$customerList = $data["customerList"];
$identityDocumentsJson = json_encode($data["identityDocuments"]);
$newSaleActId = $data["newSaleActId"];
$saleAct = $data["saleAct"];
?>

{{ Debugbar::info($identityDocumentsJson) }}

@extends('layouts.base')
@section('title', 'Atto di vendita n.' . $newSaleActId)
@section('head-stylesheet')
    @parent
    <link rel="stylesheet" href="{{ asset('css/bubbler.min.css') }}">
    
    <style>
	body {
	    margin-bottom: 5em;
	}
	
	p,span, table {
	    font-size: 14px;
	}
	span {
	    text-decoration: underline;
	}
    </style>
@endsection

@section('head-javascript')
    @parent
@endsection

@section('navbar-li-left')
    @parent
    @section('home_class', '')
    <li class="active"><a href="{{ route('newSaleAct') }}">Nuovo Atto di Vendita</a></li>
@endsection

@section('anchor-backup-href', route('photoBackup', Config::get('constants.folders.SALES_ACTS')) )
@section('anchor-delete-photos-href', route('photoDelete', Config::get('constants.folders.SALES_ACTS')) )

@section('content')
    @if(!empty($identityDocumentsJson))
	<div class="row">
	    {!! Form::model($saleAct, ['route' => ['sale-act.store'], 'id' => 'pdf', 'class' => 'form-horizontal', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
		{!! Form::hidden('toPrint', 'false', ['id' => 'toPrint']) !!}

		<div id="body" class="row" style="position: relative; top: 40px;">
		    <table class='table'>
			{!! Form::label('customerSelect', 'Seleziona cliente', ['class' => '']) !!}{!! Form::select('customerSelect', array_merge([0 => ""], $customerList), 0, ['class' => 'form-control', 'required' => true, 'autofocus' => true]); !!}
			<thead>
			    <tr>
				<th>Il/La Sottoscritto/a:</th><th></th><th></th>
			    </tr>
			</thead>
			<tbody>
			    <tr>
				<td>{!! Form::label('surname', 'Cognome', ['class' => '']) !!}{!! Form::text('surname', '', ['class' => 'surname form-control', 'required' => true]) !!}</td>
				<td>{!! Form::label('name', 'Nome', ['class' => '']) !!}{!! Form::text('name', '', ['class' => 'name form-control', 'required' => true]) !!}</td>
				<td></td>
			    </tr>
			    <tr>
				<td>{!! Form::label('birthResidence', 'Nato/a a ', ['class' => '']) !!}{!! Form::text('birthResidence', '', ['class' => 'form-control', 'required' => true]) !!}</td>
				<td>{!! Form::label('birthProvince', 'Prov.', ['class' => '']) !!}{!! Form::text('birthProvince', '', ['class' => 'form-control', 'required' => true]) !!}</td>
				<td>{!! Form::label('birthDate', 'il', ['class' => '']) !!}{!! Form::date('birthDate', '', ['class' => 'form-control', 'required' => true]) !!}</td>
			    </tr>
			    <tr>
				<td>{!! Form::label('residence', 'Residente a ', ['class' => '']) !!}{!! Form::text('residence', '', ['class' => 'form-control', 'required' => true]) !!}</td>
				<td>{!! Form::label('street', 'via', ['class' => '']) !!}{!! Form::text('street', '', ['class' => 'form-control', 'required' => true]) !!}</td>
				<td>{!! Form::label('streetNumber', 'N&#176;.', ['class' => '']) !!}{!! Form::text('streetNumber', '', ['class' => 'form-control', 'required' => true]) !!}</td>
			    </tr>
			    <tr>
				<td>{!! Form::label('type', 'Doc. Identit&agrave; ', ['class' => '']) !!}{!! Form::select('type', ['' => '', 'C.C.' => 'Carta d\'identit&agrave;', 'P' => 'Patente'], null, ['class' => 'form-control', 'required' => true]); !!}</td>
				<td>{!! Form::label('releaseDate', 'Ril. il', ['class' => '']) !!}{!! Form::date('releaseDate', "", ['class' => 'form-control', 'required' => true]) !!}</td>
				<td></td>
			    </tr>
			    <tr>
				<td>{!! Form::label('fiscalCode', 'Codice Fiscale ', ['class' => '']) !!}{!! Form::text('fiscalCode', '', ['class' => 'form-control', 'required' => true]) !!}</td>
				<td></td>
				<td></td>
			    </tr>
			</tbody>
		    </table>
		    <div style="margin-bottom: 50px;">
			<p>{!! Form::label('objects', 'Oggetti:', ['class' => 'control-label']) !!}{!! Form::text('objects', 'Bracciale', ['class' => 'form-control', 'autofocus' => true, 'required' => true,]) !!}</p>

			<div id='photos' class="">
			    {!! Form::label('path_photo', 'Foto:', ['class' => 'control-label']) !!}
			    {!! Form::file('path_photo[]', ['class' => 'form-control', 'required' => false, 'multiple' => true, 'accept' => 'image/x-png,image/jpeg']) !!}
			    <div id="preview" style="margin-top: 15px;">
				<img id="photo" hidden src="#">
			    </div>
			</div>
		    </div>
		    <div style="">
			<p id=''>{!! Form::label('weight', 'Peso materiale AU gr. (750/1000)', ['class' => '']) !!}{!! Form::text('weight', '', ['class' => 'form-control', 'required' => true]) !!}</p>
			<p id=''>{!! Form::label('price', 'A Euro', ['class' => '']) !!}{!! Form::text('price', '', ['class' => 'form-control', 'required' => true]) !!}</p>
			<p id=''>{!! Form::label('gold', 'Oro nuovo da investimento QUOTAZIONE NON OPERATIVA AU 999,9', ['class' => '']) !!}{!! Form::text('gold', '', ['class' => 'form-control', 'required' => true]) !!}</p>
    <!--		    <p id=''>{!! Form::label('weight', 'ARG999', ['class' => '']) !!}{!! Form::text('silver', '2', ['class' => 'form-control', 'required' => true]) !!}</p>-->
			<p id='' style="">{!! Form::label('agreedPrice', 'Al prezzo concordato di EURO', ['class' => '']) !!}{!! Form::text('agreedPrice', '', ['class' => 'form-control', 'required' => true]) !!}</p>
			<div></div>
			<p id='' style="">{!! Form::label('termsOfPayment', 'Modalit&agrave; di pagamento', ['class' => '']) !!}{!! Form::text('termsOfPayment', '', ['class' => 'form-control', 'required' => true]) !!}</p>
		    </div>
		</div>
	    </div>
	{!! Form::close() !!}

	<script>
	    $(document).ready(function () {
		var now = getTodayDate().split(" ");
		var today = now[0];
		var hourAndMinutes = now[1];
		$("#today").text(today);
		$("#hour").text(hourAndMinutes);
		
		var customerJson = JSON.parse('<?php echo $identityDocumentsJson ?>');
		fillCustomerInputs(customerJson[$("#customerSelect").val()]);
		$("#customerSelect").on("change", function () {
		    var index = $(this).val();
		    console.log(index);
		    if(index > 0) {
			fillCustomerInputs(customerJson[index]);
		    } else {
			resetCustomerInputs();
		    }
		});

		function setInputValueAndText(elementId, value, attr = {}) {
		    if (value !== undefined) {
			$(elementId).val(value);
			$(elementId).text(value);
			$(elementId).attr(attr);
		    }
		}

		function fillCustomerInputs(data) {
		    setInputValueAndText(".name", data.name, {"readOnly": "true"});
		    setInputValueAndText(".surname", data.surname, {"readOnly": "true"});
		    setInputValueAndText("#birthResidence", data.birth_residence, {"readOnly": "true"});
		    setInputValueAndText("#birthProvince", data.birth_province, {"readOnly": "true"});
		    setInputValueAndText("#birthDate", data.birth_date, {"readOnly": "true"});
		    setInputValueAndText("#residence", data.residence, {});
		    setInputValueAndText("#street", data.street, {});
		    setInputValueAndText("#streetNumber", data.street_number, {});
		    setInputValueAndText("#identityDocument", data.identity_document);
		    setInputValueAndText("#releaseDate", data.release_date);
		    setInputValueAndText("#fiscalCode", data.fiscal_code, {"readOnly": "true"});
		}

		function resetCustomerInputs() {
		    $('input').map(function() {
			setInputValueAndText(this, "");
			$(this).removeAttr("readOnly");
		    });
		}
		
	    });
	</script>
    @else
	<p>Caricamento in corso...</p>
    @endif
@endsection

@section('footer-javascript')
    @parent
    <script src="{{ asset('vendor/bubbler.min.js') }}"></script>
    <script src="{{ asset('vendor/use.fontawesome.min.js') }}"></script>
    <script src="{{ asset('js/saleact.toBeFilled.floatBtn.js') }}"></script>
@endsection