<?php
$fixing = $data["fixing"];
$user = Auth::user();
$identityDocument = $data["identityDocument"];
$jewel = $data["jewel"];
$fixingId = $fixing->id;
$deposit = $fixing->deposit;
$estimate = $fixing->estimate;
Debugbar::info($identityDocument);
$name = $identityDocument->name;
$surname = $identityDocument->surname;
$typology = $jewel->typology;
?>

<html>
    <head>
	<title>Tentazioni in Oro - Ticket Riparazione</title>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}" />

	<link rel="stylesheet" href="{{ asset('vendor/bootstrap/3.3.7/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('vendor/jquery-bootgrid/1.3.1/jquery.bootgrid.min.css') }}">

	<link rel="stylesheet" href="{{ asset('css/main.css') }}">

	<link rel="stylesheet" href="{{ asset('css/bubbler.min.css') }}">

	<script src="{{ asset('vendor/jquery/3.2.1/jquery.min.js') }}"></script>
	<script src="{{ asset('vendor/bootstrap/3.3.7/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('vendor/jquery-bootgrid/1.3.1/jquery.bootgrid.min.js') }}"></script>
	<script src="{{ asset('vendor/jquery-cookie/2.1.4/js.cookie.js') }}"></script>

	<script src="{{ asset('js/manager.memory.js') }}"></script>
	<script src="{{ asset('js/utilities.common.js') }}"></script>

	<style>
	    p, span, table {
		font-size: 14px;
	    }
            
	    span {
		text-decoration: underline;
	    }
            
            table {
                margin-top: 30px;
            }
            
	    @media print {
		@page { 
		    margin: 0; 
		}

		body { 
		    margin: 0.3cm 0.3cm;
		}

		p, span, table, ol {
		    font-size: 8px !important;
		}
                
                table {
                    margin-top: 1px !important;
                }
                
                td {
                    padding: 3px !important;
                }
	    }
	</style>
    </head>
    <!--<body style="margin: 2em 25em;">-->
    <body style="height: 6.2cm;">
        <div class="container">
	    <div class="row" style="">
		<div style="position: relative;">
		    <div id="date" style="position: absolute; left: -7px;">
			<p>Data <span id="today"></span> ora <span id="hour"></span></p>
		    </div>
		    <div id="idNumber" style="position: absolute; right: -7px;">
			<p>N&#176;. <span id="idNumber">{{ $fixingId }}</span></p>
		    </div>
		</div>
	    </div>
	    <div class="row">
		<div id="body" class="row" style="position: relative; top: 15px;">
                    <table class='table' style=" z-index: 9;">
			<tbody>
			    <tr>
				<td>Cognome <span id="surname">{{ $surname }}</span></td><td>Nome <span id="name">{{ $name }}</span></td>
			    </tr>
			    <tr>
				<td>Preventivo <span id="estimate">{{ $estimate }}</span></td><td>Acconto <span id="deposit">{{ $deposit }}</span></td>
			    </tr>
			    <tr>
				<td>Gioiello <span id="typology">{{ $typology }}</span></td><td></td>
			</tbody>
		    </table>
		</div>
	    </div>
            <div id="hide-logo-div" style="width: 100%; top: -5px; position: relative; background: white; height: 60px;"></div>
            <img id=logo" style="width: 80px; margin: auto; margin-top: -80px; display: block;" src="{{ asset('images/logo.jpg') }}">
	    <script>
		$(document).ready(function () {
		    var now = getTodayDate().split(" ");
		    var today = now[0];
		    var hourAndMinutes = now[1];
		    $("#today").text(today);
		    $("#hour").text(hourAndMinutes);

		    window.print();
		});
	    </script>
	</div>
    </body>

    <script src="{{ asset('vendor/bubbler.min.js') }}"></script>
    <script src="{{ asset('vendor/use.fontawesome.min.js') }}"></script>
    <script src="{{ asset('js/fixing.print.floatBtn.js') }}"></script>
    <script>
	setHomeRoute("{{ route('home') }}");
    </script>
</html>