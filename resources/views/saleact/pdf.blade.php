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
        <div id="header" style="position: relative; text-align: center; text-decoration: underline;">
            <h1>ATTO DI VENDITA</h1> 
            <h4>(regolamento di PUBBLICA SICUREZZA, 6 maggio 1940, n635)</h4>
            <h4>(decreto legislativo n92 del 25 maggio 2017)</h4>
            <br>
        </div>
        <div style="position: relative; top: 0px;">
            <div id="date" style="position: absolute;">
                <p>Data <span id="date">12/12/2017</span> ora <span id="hour">15:20</span></p>
            </div>
            <div id="idNumber" style="position: absolute; right: 15px;">
                <p>N&#176;. <span id="idNumber">1056</span></p>
            </div>
        </div>
        <div id="body" style="position: relative; top: 40px;">
            <table class='table'>
                <thead>
                    <tr>
                        <th>Il/La Sottoscritto/a:</th><th></th><th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Cognome <span id="surname">Iannone</span></td><td>Nome <span id="name">Daniele</span></td><td></td>
                    </tr>
                    <tr>
                        <td>Nato/a a <span id="birthResidence">Avellino</span></td><td>Prov. <span id="birthProvince">SA</span></td><td>il <span id="birthDate">22/02/1990</span></td>
                    </tr>
                    <tr>
                        <td>Residente a <span id="residence">Avellino</span></td><td>via <span id="residenceAddress">Pal</span></td><td>N&#176;. <span id="residenceStreetNumber">13</span></td>
                    </tr>
                    <tr>
                        <td>Doc. Identit&agrave; <span id="identityDocument">Carta d'identit&agrave;</span></td><td>Ril. il <span id="releaseDate">12/12/2017</span></td><td></td>
                    </tr>
                    <tr>
                        <td>Codice Fiscale <span id="fiscalCode">NNNDNL90H04058AY</span></td><td></td><td></td>
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
                <p id=''>Peso materiale AU gr. <span id="weight">20</span> (750/1000)</p>
                <p id=''>A Euro <span id="price">100</span></p>
                <p id='' style="text-decoration: underline;">Oro e Argento nuovo da investimento QUOTAZIONE NON OPERATIVA AU 999,9 <span id="gold">10</span> ARG999<span id="silver">22</span></p>
                <p id='' style="">Al prezzo concordato di EURO <span id="agreedPrice">100</span> modalit&agrave; di pagamento <span id="termsOfPayment">C.C.</span></p>
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
                <p>Il/La Sottoscritto/a Nome <span id="name">Daniele</span> Cognome <span id="surname">Iannone</span></p>
                <p>Dichiara che tutti gli oggetti sopravenduti non sono di illecita provenienza e di essere in possesso di tutti i diritti atti alla vendita degli stessi.</p>
                <p>La presente vale anche come ricevuta a saldo per la somma riportata "prezzo complessivo".</p>
                <p>Garanzia dati personali: in conformit&agrave; alla legge 196/03 sulla tutela della privacy, la &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    garantisce la massima riservatezza dei dati da Lei forniti; in ogni momento potr&agrave; richiedere gratuitamente la modifica e/o l'aggiornamento degli stessi.</p>
                <p>Dichiara inoltre che i proventi di tale operazione non finanzieranno alcuna attivit&agrave; di riciclaggio, finanziamento al terrorismo o attivit&a&agrave; criminose nel rispetto del Dlgs 90 del 24/05/2017 ed il Dlgs 92 del 25/05/2017 e saranno utilizzati a scopo privato.</p>
            </div>
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
    </body>
</html>