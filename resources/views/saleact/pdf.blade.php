<?php
$user = Auth::user();
$saleAct = $data["saleAct"];
$customer = $data["customer"];
$identityDocument = $data["identityDocument"];
$toPrint = $data["toPrint"];

$surname = $identityDocument->surname;
$name = $identityDocument->name;
$birthResidence = $identityDocument->birth_residence;
$birthProvince = $identityDocument->birth_province;
$birthDate = \Carbon\Carbon::parse($identityDocument->birth_date);
$residence = $identityDocument->residence;
$residenceAddress = $identityDocument->street;
$residenceStreetNumber = $identityDocument->street_number;
$types = [
    '' => '',
    'C.I.' => 'Carta d\'identit&agrave;',
    'P' => 'Patente'
];
$type = $types[$identityDocument->type];
$number = $identityDocument->number;
$releaseDate = \Carbon\Carbon::parse($identityDocument->release_date);
$fiscalCode = $customer->fiscal_code;

$saleActId = $saleAct->id_number;
$objects = $saleAct->objects;
$weight = $saleAct->weight;
$price = $saleAct->price;
$gold = $saleAct->au_quotation;
$silver = $saleAct->arg_quotation;
$agreedPrice = $saleAct->agreed_price;
$stringAgreedPrice = $saleAct->string_agreed_price;
$termsOfPayment = $saleAct->terms_of_payment;
$path_photo = $saleAct->path_photo;

//INSERIRE QUI IL CONTROLLO SUI PERMESSI
?>

<html>
    <head>
        <title>Tentazioni in Oro - PDF Atto di Vendita</title>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <link rel="stylesheet" href="{{ asset('vendor/bootstrap/3.3.7/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/jquery-bootgrid/1.3.1/jquery.bootgrid.min.css') }}">
	
	<link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">

        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
	
	<link rel="stylesheet" href="{{ asset('css/bubbler.min.css') }}">
	
        <script src="{{ asset('vendor/jquery/3.2.1/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/3.3.7/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('vendor/jquery-bootgrid/1.3.1/jquery.bootgrid.min.js') }}"></script>
        <script src="{{ asset('vendor/jquery-cookie/2.1.4/js.cookie.js') }}"></script>

        <script src="{{ asset('js/manager.memory.js') }}"></script>
        <script src="{{ asset('js/utilities.common.js') }}"></script>
        <!--<script src="{{ asset('js/functions.home.js') }}"></script>-->

        <style>
            p,span, table {
                font-size: 12px;
            }
            span {
                text-decoration: underline;
            }
            
	    @media (max-width: 768px ) {
			body { 
				margin-top: 1em;
				margin-right: 25px;
				margin-bottom: 3em;
				margin-left: 25px; 
			}
			
			#signature {
				top: 0.5em !important;
			}
			
			#declaration {
				margin-top: 70px !important;
			}
	    }
	    
		@media print {
			body { 
				margin-top: 1em;
				margin-right: 1.5cm;
				margin-bottom: 3em;
				margin-left: 1.5cm; 
			}
		}
        </style>
    </head>
    <!--<body style="margin: 2em 25em;">-->
    <body>
	<div class="container">
	    <div class="row">
		<div id="header" class="col" style="position: relative; margin-top: -15px; text-align: center; text-decoration: underline;">
		    <h2>ATTO DI VENDITA</h2> 
		    <h4>(regolamento di PUBBLICA SICUREZZA, 6 maggio 1940, n635)</h4>
		    <h4>(decreto legislativo n92 del 25 maggio 2017)</h4>
		    <br>
		</div>
	    </div>
	    <div class="row">
		<div style="position: relative; top: 0px;">
		    <div id="date" style="position: absolute; left: -10px;">
			<p>Data <span id="today"></span> ora <span id="hour"></span></p>
		    </div>
		    <div id="idNumber" style="position: absolute; right: -10px;">
			<p>N&#176;. <span id="idNumber">{{ $saleActId }}</span></p>
		    </div>
		</div>
	    </div>
	    <div class="row">
		<div id="body" class="row" style="position: relative; top: 40px;">
		    <table class='table'>
			<thead>
			    <tr>
				<th class="col-md-5">Il/La Sottoscritto/a:</th><th class="col-md-5"></th><th class="col-md-2"></th>
			    </tr>
			</thead>
			<tbody>
			    <tr>
				<td>Cognome <span id="surname">{{ $surname }}</span></td><td>Nome <span id="name">{{ $name }}</span></td><td></td>
			    </tr>
			    <tr>
				<td>Nato/a a <span id="birthResidence">{{ $birthResidence }}</span></td><td>Prov. <span id="birthProvince">{{ $birthProvince }}</span></td><td>il <span id="birthDate">{{ $birthDate->day . "/" . $birthDate->month . "/" . $birthDate->year }}</span></td>
			    </tr>
			    <tr>
				<td>Residente a <span id="residence">{{ $residence }}</span></td><td>via <span id="residenceAddress">{{ $residenceAddress }}</span></td><td>N&#176;. <span id="residenceStreetNumber">{{ $residenceStreetNumber }}</span></td>
			    </tr>
			    <tr>
				<td>Doc. Identit&agrave; <span id="identityDocumentType">{{ $type }}</span></td><td>Ril. il <span id="releaseDate">{{ $releaseDate->day . "/" . $releaseDate->month . "/" . $releaseDate->year }}</span></td><td>Numero <span id="number">{{ $number }}</span></td>
			    </tr>
			    <tr>
				<td>Codice Fiscale <span id="fiscalCode">{{ $fiscalCode }}</span></td><td></td><td></td>
			    </tr>
			</tbody>
		    </table>
		    <div style="text-align: center;">
			<h3 style="text-decoration: underline;">VENDE A:</h3>
			<p>Tentazioni in oro S.n.c.</p>
			<p>di Penna M. e S.</p>
			<p>via Roma, 67 Montoro (Av)</p>
			<p>ISCRIZIONE C.C.I.A.A. D'AVELLINO N&#176;. AV192247</p>
		    </div>
		    <div style="/*margin-bottom: 50px;*/">
			<h3 style="text-align: center; text-decoration: underline;">I SOTTOELENCATI OGGETTI:</h3>
			<div class="row" style="margin: 0px 0px; margin-bottom: 0px; word-wrap: break-word;">
			    <p class="col col-lg-8s" style="margin-top: 5px; line-height: 200%; text-decoration: underline;">{{ $objects }}</p>
			    <!--<hr style="margin-top: -18px; border-style: inset;">-->
<!--			    <hr style="margin-top: 27px; border-style: inset;">
			    <hr style="margin-top: 27px; border-style: inset;">-->
			</div>
			<div id='photos'></div>
		    </div>
		    <div style="">
			<p id=''>Peso materiale AU gr. <span id="weight">{{ $weight }}</span> (750/1000)</p>
			<p id=''>A Euro <span id="price">{{ $price }}</span></p>
			<p id=''>Oro nuovo da investimento QUOTAZIONE NON OPERATIVA AU 999,9 <span id="gold" style="text-decoration: underline;">{{ $gold }}</span> <!-- ARG999 <span id="silver" style="text-decoration: underline;">{{ $silver }}</span> --></p>
			<p id='' style="">Al prezzo concordato di EURO <span id="agreedPrice">{{ $agreedPrice . " / " . $stringAgreedPrice }}</span> modalit&agrave; di pagamento <span id="termsOfPayment">{{ $termsOfPayment }}</span></p>
			Destinazione Materiale:
			<ol type="A">
			    <li>destinata alla fusione presso Azienda autorizzata nel recupero metalli preziosi.</li>
			    <li>destinata alla vendita al dettaglio.</li>
			    <li>destinata alla vendita al dettaglio ed in caso di mancata vendita destinata alla fusione presso azienda autorizzata di recupero metalli preziosi.</li>
			</ol>
		    </div>
		    <div id="signature" style="position: relative; top: -15px;">
				<h5 id='' style="position: absolute; right: 0px; top: 0px;"><b>Firma</b></h5>
				<hr style="position: absolute; margin-top: 50px; right: 0px; width: 30%; border-style: inset;">
		    </div>
		    <div id="declaration" style="margin: 60px 0;">
			<p>Il/La Sottoscritto/a Nome <span id="name">{{ $name }}</span> Cognome <span id="surname">{{ $surname }}</span></p>
			<p>Dichiara che tutti gli oggetti sopravenduti non sono di illecita provenienza e di essere in possesso di tutti i diritti atti alla vendita degli stessi.</p>
			<p>La presente vale anche come ricevuta a saldo per la somma riportata "prezzo complessivo".</p>
			<p>Garanzia dati personali: in conformit&agrave; alla legge 196/03 sulla tutela della privacy, la Ditta garantisce la massima riservatezza dei dati da Lei forniti; in ogni momento potr&agrave; richiedere gratuitamente la modifica e/o l'aggiornamento degli stessi.</p>
			<p>Dichiara inoltre che i proventi di tale operazione non finanzieranno alcuna attivit&agrave; di riciclaggio, finanziamento al terrorismo o attivit&a&agrave; criminose nel rispetto del Dlgs 90 del 24/05/2017 ed il Dlgs 92 del 25/05/2017 e saranno utilizzati a scopo privato.</p>
		    </div>
		    <div style="margin: -3em 10em;">
			<div style="position: relative;">
			    <h5 id='' style="position: absolute;"><b>Per Accettazione</b></h5>
			    <hr style="position: absolute; margin-top: 50px; width: 40%; border-style: inset;">
			    <h5 id='' style="position: absolute; right: 0px;"><b>Firma</b></h5>
			    <hr style="position: absolute; margin-top: 50px; right: 0px; width: 40%; border-style: inset;">
			</div>
			<div style="position: relative; top: 55px;">
			    <p class="fine-print" style="">Trattasi di vendita da privato fuori campo I.V.A. ai sensi degli ART. 1,2,4 e 5 D.P.R. 26.10.1972, n.633 e successive modificazioni.</p>
			</div>
		    </div>
		</div>
	    </div>
	    <script>
		$(document).ready(function () {
		    var now = getTodayDate().split(" ");
		    var today = now[0];
		    var hourAndMinutes = now[1];
		    $("#today").text(today);
		    $("#hour").text(hourAndMinutes);
		    
		    var toPrint = <?php echo $toPrint === 'true' ? 'true' : 'false'; ?>;
		    if(toPrint === true) {
			window.print();
		    }
		});
	    </script>
	</div>
    </body>
    
    <script src="{{ asset('vendor/bubbler.min.js') }}"></script>
    <script src="{{ asset('js/saleact.pdf.floatBtn.js') }}"></script>
    <script>
	setHomeRoute("{{ route('home') }}");
    </script>
</html>