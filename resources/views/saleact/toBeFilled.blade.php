<?php
$user = Auth::user();
if(isset($_COOKIE["identityDocuments"])) {
    $identityDocumentsJson = $_COOKIE["identityDocuments"];
    $customerList = $data["customerList"];
    $newSaleActId = $data["newSaleActId"];
} else {
    $identityDocumentsJson = "";
}
//INSERIRE QUI IL CONTROLLO SUI PERMESSI
?>

{{ Debugbar::info($identityDocumentsJson) }}

<html lang="en">
    <head>
        <title>Tentazioni in Oro - @yield('title')</title>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <link rel="stylesheet" href="{{ asset('vendor/bootstrap/3.3.7/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/jquery-bootgrid/1.3.1/jquery.bootgrid.min.css') }}">

        <link rel="stylesheet" href="{{ asset('css/main.css') }}">

        <script src="{{ asset('vendor/jquery/3.2.1/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/3.3.7/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('vendor/jquery-bootgrid/1.3.1/jquery.bootgrid.min.js') }}"></script>
        <script src="{{ asset('vendor/jquery-cookie/2.1.4/js.cookie.js') }}"></script>

        <script src="{{ asset('js/manager.memory.js') }}"></script>
        <script src="{{ asset('js/utilities.common.js') }}"></script>
        <script src="{{ asset('js/functions.home.js') }}"></script>

        <style>
            p,span, table {
                font-size: 14px;
            }
            span {
                text-decoration: underline;
            }
        </style>
    </head>
    <body style="margin: 2em 25em;">
        @if(!empty($identityDocumentsJson))
            <div id="header" style="position: relative; text-align: center; text-decoration: underline;">
                <h1>ATTO DI VENDITA</h1> 
                <h4>(regolamento di PUBBLICA SICUREZZA, 6 maggio 1940, n635)</h4>
                <h4>(decreto legislativo n92 del 25 maggio 2017)</h4>
                <br>
            </div>
            <div style="position: relative; top: 0px;">
                <div id="date" style="position: absolute;">
                    <p>Data <span id="today"></span> ora <span id="hour"></span></p>
                </div>
                <div id="idNumber" style="position: absolute; right: 15px;">
                    <p>N&#176;. <span id="idNumber">{{ $newSaleActId }}</span></p>
                </div>
            </div>
            <div id="body" style="position: relative; top: 40px;">
                <table class='table'>
                    {!! Form::label('customers', 'Seleziona cliente', ['class' => '']) !!}{!! Form::select('customers', array_merge(["0" => ""], $customerList), null, ['class' => 'form-control', 'required' => true]); !!}
                    <thead>
                        <tr>
                            <th>Il/La Sottoscritto/a:</th><th></th><th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{!! Form::label('surname', 'Cognome', ['class' => '']) !!}{!! Form::text('surname', '', ['class' => 'form-control', 'required' => true]) !!}</td>
                            <td>{!! Form::label('name', 'Nome', ['class' => '']) !!}{!! Form::text('name', '', ['class' => 'form-control', 'required' => true]) !!}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>{!! Form::label('birthResidence', 'Nato/a a ', ['class' => '']) !!}{!! Form::text('birthResidence', '', ['class' => 'form-control', 'required' => true]) !!}</td>
                            <td>{!! Form::label('birthProvince', 'Prov.', ['class' => '']) !!}{!! Form::text('birthProvince', '', ['class' => 'form-control', 'required' => true]) !!}</td>
                            <td>{!! Form::label('birthDate', 'il', ['class' => '']) !!}{!! Form::text('birthDate', '', ['class' => 'form-control', 'required' => true]) !!}</td>
                        </tr>
                        <tr>
                            <td>{!! Form::label('residence', 'Residente a ', ['class' => '']) !!}{!! Form::text('residence', '', ['class' => 'form-control', 'required' => true]) !!}</td>
                            <td>{!! Form::label('street', 'via', ['class' => '']) !!}{!! Form::text('street', '', ['class' => 'form-control', 'required' => true]) !!}</td>
                            <td>{!! Form::label('streetNumber', 'N&#176;.', ['class' => '']) !!}{!! Form::text('streetNumber', '', ['class' => 'form-control', 'required' => true]) !!}</td>
                        </tr>
                        <tr>
                            <td>{!! Form::label('identityDocument', 'Doc. Identit&agrave; ', ['class' => '']) !!}{!! Form::select('identityDocument', ['' => '', 'C.C.' => 'Carta d\'identit&agrave;', 'P' => 'Patente'], null, ['class' => 'form-control', 'required' => true]); !!}</td>
                            <td>{!! Form::label('releaseDate', 'Ril. il', ['class' => '']) !!}{!! Form::text('releaseDate', '', ['class' => 'form-control', 'required' => true]) !!}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>{!! Form::label('fiscalCode', 'Codice Fiscale ', ['class' => '']) !!}{!! Form::text('fiscalCode', '', ['class' => 'form-control', 'required' => true]) !!}</td>
                            <td></td>
                            <td></td>
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
                <div style="text-decoration: underline; margin-bottom: 50px;">
                    <h3 style="text-align: center; ">I SOTTOELENCATI OGGETTI:</h3>
                    <hr style="margin-top: 50px; border-style: inset;">
                    <hr style="margin-top: 40px; border-style: inset;">
                    <hr style="margin-top: 40px; border-style: inset;">
                    <div id='photos'></div>
                </div>
                <div style="">
                    <p id=''>Peso materiale AU gr. {!! Form::label('weight', '', ['class' => '']) !!}{!! Form::text('weight', '', ['class' => 'form-control', 'required' => true]) !!} (750/1000)</p>
                    <p id=''>A Euro {!! Form::label('price', '', ['class' => '']) !!}{!! Form::text('price', '', ['class' => 'form-control', 'required' => true]) !!}</p>
                    <p id='' style="text-decoration: underline;">Oro e Argento nuovo da investimento QUOTAZIONE NON OPERATIVA AU 999,9 {!! Form::label('gold', '', ['class' => '']) !!}{!! Form::text('gold', '', ['class' => 'form-control', 'required' => true]) !!} ARG999 {!! Form::label('silver', '', ['class' => '']) !!}{!! Form::text('silver', '', ['class' => 'form-control', 'required' => true]) !!}</p>
                    <p id='' style="">Al prezzo concordato di EURO {!! Form::label('agreedPrice', '', ['class' => '']) !!}{!! Form::text('agreedPrice', '', ['class' => 'form-control', 'required' => true]) !!} modalit&agrave; di pagamento {!! Form::label('termsOfPayment', '', ['class' => '']) !!}{!! Form::text('termsOfPayment', '', ['class' => 'form-control', 'required' => true]) !!}</p>
                    Destinazione Materiale:
                    <ol type="A">
                        <li>destinata alla fusione presso Azienda autorizzata nel recupero metalli preziosi.</li>
                        <li>destinata alla vendita al dettaglio.</li>
                        <li>destinata alla vendita al dettaglio ed in caso di mancata vendita destinata alla fusione presso azienda autorizzata di recupero metalli preziosi.</li>
                    </ol>
                </div>
                <div style="position: relative; top: 0px;">
                    <h4 id='' style="position: absolute; right: 0px;"><b>Firma</b></h4>
                    <hr style="position: absolute; margin-top: 70px; right: 0px; width: 30%; border-style: inset;">
                </div>
                <div style="margin-top: 100px;">
                    <p>Il/La Sottoscritto/a Nome {!! Form::label('name', '', ['class' => '']) !!}{!! Form::text('name', '', ['class' => 'form-control', 'required' => true]) !!} Cognome {!! Form::label('surname', '', ['class' => '']) !!}{!! Form::text('surname', '', ['class' => 'form-control', 'required' => true]) !!}</p>
                    <p>Dichiara che tutti gli oggetti sopravenduti non sono di illecita provenienza e di essere in possesso di tutti i diritti atti alla vendita degli stessi.</p>
                    <p>La presente vale anche come ricevuta a saldo per la somma riportata "prezzo complessivo".</p>
                    <p>Garanzia dati personali: in conformit&agrave; alla legge 196/03 sulla tutela della privacy, la &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        garantisce la massima riservatezza dei dati da Lei forniti; in ogni momento potr&agrave; richiedere gratuitamente la modifica e/o l'aggiornamento degli stessi.</p>
                    <p>Dichiara inoltre che i proventi di tale operazione non finanzieranno alcuna attivit&agrave; di riciclaggio, finanziamento al terrorismo o attivit&a&agrave; criminose nel rispetto del Dlgs 90 del 24/05/2017 ed il Dlgs 92 del 25/05/2017 e saranno utilizzati a scopo privato.</p>
                </div>
                {!! Form::close() !!}
                <div style="margin: 0 10em;">
                    <div style="position: relative;">
                        <h4 id='' style="position: absolute;"><b>Per Accettazione</b></h4>
                        <hr style="position: absolute; margin-top: 70px; width: 40%; border-style: inset;">
                        <h4 id='' style="position: absolute; right: 0px;"><b>Firma</b></h4>
                        <hr style="position: absolute; margin-top: 70px; right: 0px; width: 40%; border-style: inset;">
                    </div>
                    <div style="position: relative; top: 80px;">
                        <p style="">Trattasi di vendita da privato fuori campo I.V.A. ai sensi degli ART. 1,2,4 e 5 D.P.R. 26.10.1972, n.633 e successive modificazioni.</p>
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

                    function setInputValueAndText(elementId, value) {
                        $(elementId).val(value);
                        $(elementId).text(value);
                    }

                    var customerJson = JSON.parse('<?php echo $identityDocumentsJson ?>');
                    $("#customers").on("change", function () {
                        var index = $(this).val();
                        setInputValueAndText("#name", customerJson[index].name);
                        setInputValueAndText("#surname", customerJson[index].surname);
                        setInputValueAndText("#birthResidence", customerJson[index].birth_residence);
                        setInputValueAndText("#birthProvince", customerJson[index].birth_province);
                        setInputValueAndText("#birthDate", customerJson[index].birth_date);
                        setInputValueAndText("#residence", customerJson[index].residence);
                        setInputValueAndText("#street", customerJson[index].street);
                        setInputValueAndText("#streetNumber", customerJson[index].street_number);
                        setInputValueAndText("#identityDocument", customerJson[index].identity_document);
                        setInputValueAndText("#releaseDate", customerJson[index].release_date);
                        setInputValueAndText("#fiscalCode", customerJson[index].fiscal_code);
                    });
                });
            </script>
        @else
            <h1>Ricaricare la pagina</h1>
        @endif
    </body>
</html>