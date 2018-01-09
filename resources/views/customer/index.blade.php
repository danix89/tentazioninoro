@extends('layouts.base')

<?php
$user = Auth::user();

?>
@section('title', 'Lista clienti')
@section('head-stylesheet')
@section('head-javascript')
    @parent
    <!--<script src="{{ asset('js/customer.main.js') }}"></script>-->
@endsection

@section('navbar-li-left')
    @parent
    @section('home_class', '')
    <li class="active"><a href="{{ route('showCustomerList') }}">Clienti</a></li>
    <li class=""><a href="{{ route('newCustomer') }}">Nuovo Cliente</a></li>
@endsection

@section('anchor-backup-href', route('photoBackup', Config::get('constants.folders.FIXINGS')) )
@section('anchor-delete-photos-href', route('photoDelete', Config::get('constants.folders.FIXINGS')) )

@section('content')
    @if (!isset($customerList))
        <p>Non ci sono clienti registrati.</p>
    @else
        <table id="grid-basic" class="table">
            <thead>
                <tr>
                    <th data-column-id="customer_id" data-identifier="true" data-type="numeric" data-order="asc" data-width="5%">Id</th>
                    <th data-column-id="name" data-identifier="true" data-width="10%">Nome</th>
                    <th data-column-id="surname" data-identifier="true" data-width="10%">Cognome</th>
                    <th data-column-id="birth_date" data-order="desc" data-width="8%">Data nascita</th>
                    <th data-column-id="phone_number" data-width="10%">Telefono</th>
                    <th data-column-id="mobile_phone" data-width="10%">Cellulare</th>
                    <th data-column-id="email" data-width="15%">E-mail</th>
                    <th data-column-id="commands" data-formatter="commands" data-sortable="false" data-width="10%">Comandi</th>
                    <!--<th data-column-id="delete"></th>-->
                </tr>
            </thead>
            <tbody>
                @for($i = 0; $i < count($customerList); $i++)
                    <?php 
                    Debugbar::info($identityDocumentList[$i]);
                    $date = explode("-", $identityDocumentList[$i]["birth_date"]);
                    $year = $date[0];
                    $month = $date[1];
                    $day = $date[2];
                    ?>
                    <tr>
                        <td>{{ $customerList[$i]["id"] }}</td>
                        <td>{{ $identityDocumentList[$i]->name }}</td>
                        <td>{{ $identityDocumentList[$i]->surname }}</td>
                        <td>{{ $day . "/" . $month . "/" . $year }}</td>
                        <td>{{ $customerList[$i]["phone_number"] }}</td>
                        <td>{{ $customerList[$i]["mobile_phone"] }}</td>
                        <td>{{ $customerList[$i]["email"] }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>
    @endif
    <script>
        mm.resetAll(["toDelete"]);

        setDeleteRoute("{{ route('customer.destroyAll') }}");
        
        initializeGrid("#grid-basic");
        $(document).ready(function() {
            $("form").submit(function(e) {
//		    e.preventDefault();
                var customerId = $(this).parents("tr").data("row-id");
                $(this).attr("action", '{{ route("customer.destroy", ["customerId" => ""]) }}/' + customerId);
            });
        });
        
        function initializeGrid(gridId) {
            var grid = $(gridId).bootgrid({
                selection: true,
                multiSelect: true,
                formatters: {
                    "commands": function (column, row) {
//                        console.log(row.customer_id);
                        <?php
                            $showCustomerRoute = route("showCustomer", ["customerId" => ""]);
                            $deleteCustomerRoute = ["customer.destroy", ""];
                        ?>
                        return "<a class=\"btn btn-default\" href=\"{{ $showCustomerRoute }}/" + row.customer_id + "\"><span class=\"glyphicon glyphicon-eye-open\"></span></a> " +
                                '{!! Form::open(["method" => "delete", "route" => $deleteCustomerRoute, "class" => "deleteForm", "style" => "display: inline;"]) !!}' +
                                '<button class="btn btn-danger" type="submit"><span class=\"glyphicon glyphicon-trash\"></span></button>' +
                                '{!! Form::close() !!}';
                    }
                }
            }).on("selected.rs.jquery.bootgrid", function (e, rows) {
                var rowIds = [];
                for (var i = 0; i < rows.length; i++) {
                    rowIds.push(rows[i].customer_id);
                    mm.saveValueToArray("toDelete", rows[i].customer_id);
                }
//		    console.log("Select: " + rowIds.join(","));
            }).on("deselected.rs.jquery.bootgrid", function (e, rows) {
                var rowIds = [];
                for (var i = 0; i < rows.length; i++) {
                    rowIds.push(rows[i].customer_id);
                    mm.removeElementFromArray("toDelete", rows[i].customer_id);
                }
//		    console.log("Deselect: " + rowIds.join(","));
            }).on("loaded.rs.jquery.bootgrid", function (e, rows) {
                if($("#delete-all-div").length === 0) {
                    $(".actions.btn-group .dropdown.btn-group").last().after('<div id="delete-all-div" class="dropdown btn-group"><button id="delete-all-btn" class="btn btn-danger dropdown-toggle" onclick="deleteAll()" type="button" style="width:51px; height:34px;"><span class="glyphicon glyphicon-trash"></span></div>');
                    $('form').submit(function (e) {
                        appendIdToFormAction(e, $(this));
                    }); 
                }
            });
        }
    </script>
@endsection