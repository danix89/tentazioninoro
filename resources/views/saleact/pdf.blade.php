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

    </head>
    <body style="margin: 15px;">
        <div id="header" style="position: relative; text-align: center; text-decoration: underline;">
            <h1>ATTO DI VENDITA</h1> 
            <h4>(regolamento di PUBBLICA SICUREZZA, 6 maggio 1940, n635)</h4>
            <h4>(decreto legislativo n92 del 25 maggio 2017)</h4>
            <br>
        </div>
        <div style="position: relative; top: 0px;">
            <div id="date" style="position: absolute;">
                <p>Data <span id="toCompileDate">12/12/2017</span> ora <span id="toCompileHour">15:20</span></p>
            </div>
            <div id="idNumber" style="position: absolute; right: 15px;">
                <p>N&#176;. <span id="toCompileIdNumber">1056</span></p>
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
                        <td>Cognome <span id="toCompileSurname">Iannone</span></td><td>Nome <span id="toCompileName">Daniele</span></td><td></td>
                    </tr>
                    <tr>
                        <td>Nato/a a <span id="toCompileBirthResidence">Avellino</span></td><td>Prov. <span id="toCompileBirthProvince">SA</span></td><td>il <span id="toCompileBirthDate">22/02/1990</span></td>
                    </tr>
                    <tr>
                        <td>Residente a <span id="toCompileResidence">Avellino</span></td><td>via <span id="toCompileResidenceAddress">Pal</span></td><td>N&#176;. <span id="toCompileResidenceStreetNumber">13</span></td>
                    </tr>
                    <tr>
                        <td>Doc. Identit&agrave; <span id="toCompileIdentityDocument">Carta d'identit&agrave;</span></td><td>Ril. il <span id="toCompileReleaseDate">12/12/2017</span></td><td></td>
                    </tr>
                    <tr>
                        <td>Codice Fiscale <span id="toCompileFiscalCode">NNNDNL90H04058AY</span></td><td></td><td></td>
                    </tr>
                </tbody>
            </table>
            <div style="text-align: center; text-decoration: underline;">
                <h3 style="text-decoration: underline;">VENDE A:</h3>
                <p>Tentazioni in oro S.n.c.</p>
                <p>di Penna M. e S.</p>
                <p>via Roma, 67 Montoro (Av)</p>
                <p></p>
            </div>
            
        </div>
    </body>
</html>