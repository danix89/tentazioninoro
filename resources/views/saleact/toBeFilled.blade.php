<?php
$customerList = $data["customerList"];
$canBeUpdated = false;
$identityDocumentsJson = json_encode($data["identityDocuments"]);
$newSaleActId = $data["newSaleActId"];
$saleAct = $data["saleAct"];

$types = [
    '' => '',
    'C.I.' => 'Carta d\'identit&agrave;',
    'P' => 'Patente'
];
?>

{{ Debugbar::info($identityDocumentsJson) }}

@extends('layouts.base')
@section('title', 'Atto di vendita n.' . $newSaleActId)
@section('head-stylesheet')
    @parent
    <link rel="stylesheet" href="{{ asset('css/bubbler.min.css') }}">
    
    <style>
	body {
	    margin-bottom: 100px !important;
	}
	
	p,span, table {
	    font-size: 14px;
	}
	
        span {
	    text-decoration: underline;
	}
        
        #fileContainer * {
            margin-bottom: 5px;
        }
    </style>
@endsection

@section('head-javascript')
    @parent
@endsection

@section('navbar-li-left')
    @parent
    @section('home_class', '')
    <li class=""><a href="{{ route('showCustomerList') }}">Clienti</a></li>
    <li class="active"><a href="{{ route('newSaleAct') }}">Nuovo Atto di Vendita</a></li>
@endsection

@section('anchor-backup-href', route('photoBackup', Config::get('constants.folders.SALES_ACTS')) )
@section('anchor-delete-photos-href', route('photoDelete', Config::get('constants.folders.SALES_ACTS')) )

@section('content')
    @if(!empty($identityDocumentsJson))
        {!! Form::model($saleAct, ['route' => ['sale-act.store'], 'id' => 'pdf', 'class' => 'form-horizontal', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
            {!! Form::hidden('toPrint', 'false', ['id' => 'toPrint']) !!}
	    <div id='idNumberDiv' class="form-group has-feedback" style="margin: 15px 0px;" >
		{!! Form::label('idNumber', 'Numero id.:', ['class' => '']) !!}
		{!! Form::text('idNumber', '', ['class' => 'form-control', 'required' => true]) !!}
			
		<div class="alert alert-warning" hidden role="alert">
		    <strong>Id già presente nel Database!</strong>
		</div>
	    </div>
            {!! Form::label('customerSelect', 'Seleziona cliente', ['class' => '']) !!}{!! Form::select('customerSelect', $customerList, 0, ['class' => 'form-control select2', 'required' => false, 'autofocus' => true]); !!}
            <div id="body" class="" style="">
                <div style="overflow-x: auto;">
                    <table class='table' style="margin-top: 15px;">
                        <thead>
                            <tr>
                                <th>Il/La Sottoscritto/a:</th><th></th><th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{!! Form::label('name', 'Nome', ['class' => '']) !!}{!! Form::text('name', '', ['class' => 'name form-control', 'required' => true]) !!}</td>
                                <td>{!! Form::label('surname', 'Cognome', ['class' => '']) !!}{!! Form::text('surname', '', ['class' => 'surname form-control', 'required' => true]) !!}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>{!! Form::label('birthResidence', 'Nato/a a:', ['class' => '']) !!}{!! Form::text('birthResidence', '', ['class' => 'form-control', 'required' => true]) !!}</td>
                                <td>{!! Form::label('birthProvince', 'Prov.:', ['class' => '']) !!}{!! Form::text('birthProvince', '', ['class' => 'form-control', 'required' => true]) !!}</td>
                                <td>{!! Form::label('birthDate', 'il', ['class' => '']) !!}{!! Form::date('birthDate', '', ['class' => 'form-control', 'required' => true]) !!}</td>
                                <!--\Carbon\Carbon::now()-->
                            </tr>
                            <tr>
                                <td>{!! Form::label('residence', 'Residente a:', ['class' => '']) !!}{!! Form::text('residence', '', ['class' => 'form-control', 'required' => true]) !!}</td>
                                <td>{!! Form::label('street', 'via', ['class' => '']) !!}{!! Form::text('street', '', ['class' => 'form-control', 'required' => true]) !!}</td>
                                <td>{!! Form::label('streetNumber', 'N&#176;.:', ['class' => '']) !!}{!! Form::text('streetNumber', '', ['class' => 'form-control', 'required' => true]) !!}</td>
                            </tr>
                            <tr>
                                <td>{!! Form::label('type', 'Doc. Identit&agrave;:', ['class' => '']) !!}{!! Form::select('type', $types, '', ['class' => 'form-control', 'required' => true]); !!}</td>
                                <td>{!! Form::label('releaseDate', 'Ril. il:', ['class' => '']) !!}{!! Form::date('releaseDate', '', ['class' => 'form-control', 'required' => true]) !!}</td>
                                <td>{!! Form::label('number', 'N. Doc.:', ['class' => '']) !!}{!! Form::text('number', '', ['class' => 'form-control', 'required' => true]) !!}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>{!! Form::label('fiscalCode', 'Codice Fiscale:', ['class' => '']) !!}{!! Form::text('fiscalCode', '', ['class' => 'form-control', 'required' => true]) !!}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                    
                <div style="margin-bottom: 0px;">
                    <p>{!! Form::label('objects', 'Oggetti:', ['class' => 'control-label']) !!}{!! Form::text('objects', '', ['class' => 'form-control', 'autofocus' => true, 'required' => true,]) !!}</p>

                    <div id='photos' class="">
                        <div id="fileContainer" style="margin-bottom: 5px;"></div>
                        
                        {!! Form::hidden('deletePhotos', '', ['id' => 'deletePhotos']) !!}
                        <button id="add-photo-paths-btn" type="button" class="btn btn-default btn-info" onclick="" style="">Aggiungi campo</button>
                        <button id="remove-photo-paths-btn" type="button" class="btn btn-default btn-warning" onclick="removeFileInput()" style="">Rimuovi campo</button>
                    </div>
                </div>
                    
                <div style="margin-top: 15px;">
                    <p id=''>{!! Form::label('weight', 'Peso materiale AU gr. (750/1000)', ['class' => '']) !!}{!! Form::number('weight', '', ['class' => 'form-control', 'required' => true, 'min' => 0, 'step' => 0.01]) !!}</p>
                    <p id=''>{!! Form::label('price', 'A Euro', ['class' => '']) !!}{!! Form::number('price', '', ['class' => 'form-control', 'required' => true, 'min' => 0, 'step' => 0.01]) !!}</p>
                    <p id=''>{!! Form::label('gold', 'Oro nuovo da investimento QUOTAZIONE NON OPERATIVA AU 999,9', ['class' => '']) !!}{!! Form::number('gold', '', ['class' => 'form-control', 'required' => true, 'min' => 0, 'step' => 0.01]) !!}</p>
<!--		    <p id=''>{!! Form::label('weight', 'ARG999', ['class' => '']) !!}{!! Form::text('silver', '2', ['class' => 'form-control', 'required' => true]) !!}</p>-->
                    <p id='' style="">{!! Form::label('agreedPrice', 'Al prezzo concordato di EURO', ['class' => '']) !!}{!! Form::number('agreedPrice', '', ['class' => 'form-control', 'required' => true, 'min' => 0, 'step' => 0.01]) !!}</p>
                    <p id='' style="">{!! Form::label('stringAgreedPrice', 'Prezzo concordato in lettere', ['class' => '']) !!}{!! Form::text('stringAgreedPrice', '', ['class' => 'form-control', 'required' => true]) !!}</p>
                    <p id='' style="">{!! Form::label('termsOfPayment', 'Modalit&agrave; di pagamento', ['class' => '']) !!}{!! Form::select('termsOfPayment', ['' => '', 'Contanti' => 'Contanti', 'Assegno' => 'Assegno', 'C.C.' => 'Carta di credito'], '', ['class' => 'form-control', 'required' => true]); !!}</p>
                </div>
	    </div>
            <!-- Questo pulsante serve per permettere di riprodurre correttamente l'operazione di submit del form, in modo da consentire di controllare in automatico se i campi input richiesti sono vuoti. -->
            <button id="save-btn" type="submit" class="btn btn-primary" style="display: none;">Salva</button>
	{!! Form::close() !!}

	<script>
	    $(document).ready(function () {
		var now = getTodayDate().split(" ");
		var today = now[0];
		var hourAndMinutes = now[1];
		$("#today").text(today);
		$("#hour").text(hourAndMinutes);
		
		var customerJson = JSON.parse('<?php echo $identityDocumentsJson ?>');
//		console.log(customerJson);
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

		function setInputValueAndText(elementId, value, attr = {}, type = "input") {
		    if (value !== undefined) {
			$(elementId).val(value);
			if(type !== "select") {
			    $(elementId).text(value);
			}
			$(elementId).attr(attr);
		    }
		}

		function fillCustomerInputs(data) {
//		    console.log(data);
		    setInputValueAndText("#name", data.name, {"readOnly": "true"});
		    setInputValueAndText("#surname", data.surname, {"readOnly": "true"});
		    setInputValueAndText("#birthResidence", data.birth_residence, {"readOnly": "true"});
		    setInputValueAndText("#birthProvince", data.birth_province, {"readOnly": "true"});
		    setInputValueAndText("#birthDate", data.birth_date, {"readOnly": "true"});
		    setInputValueAndText("#residence", data.residence, {});
		    setInputValueAndText("#street", data.street, {});
		    setInputValueAndText("#streetNumber", data.street_number, {});
		    setInputValueAndText("#identityDocument", data.identity_document);
		    setInputValueAndText("#type", data.type, {}, "select");
		    setInputValueAndText("#releaseDate", data.release_date);
		    setInputValueAndText("#number", data.number);
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
    <script src="{{ asset('js/saleact.toBeFilled.floatBtn.js') }}"></script>
    <script>
	setHomeRoute("{{ route('home') }}");
        //E' necessario definire qui il comportamento del pulsante "Salva", in quanto se definito direttamente in fixing.create.floatBtn.js, non viene associato correttamente.
        setSaveButton("Salva", function() {
            $("#save-btn").click();
        });
	
	var doSubmit = false;
	$("#idNumber").change(function (e) {
	    $.ajax({
		url: "{{ route('checkIdNumber') }}",
		async: false,
		type: "post",
		data: {
		    _token: $('meta[name=csrf-token]').attr('content'),
		    idNumber: $("#idNumber").val()
		}
	    }).done(function (data) {
		if(data.success) {
		    doSubmit = true;
		    $("#idNumberDiv > span").remove();
		    $(".alert").hide();
		    $("#idNumberDiv")
			    .removeClass("has-warning")
			    .addClass("has-success")
			    .append($("<span />")
				.addClass("glyphicon glyphicon-ok form-control-feedback")
			    );
		} else {
//		    doSubmit = false;
		    doSubmit = true; // Mostra solo un messaggio di alert, ma salva lo stesso l'atto di vendita. 
		    $("#idNumberDiv > span").remove();
		    $(".alert").show();
		    $("#idNumberDiv")
			    .removeClass("has-success")
			    .addClass("has-warning")
			    .append($("<span />")
				.addClass("glyphicon glyphicon-alert form-control-feedback")
			    );
		    $("#idNumberDiv > input").focus();
		}
//		console.log(doSubmit);
	    });
	});
	
	$("form").submit(function (e) {
	    if(!doSubmit) {
		e.preventDefault();
	    }
	});
    </script>
@endsection