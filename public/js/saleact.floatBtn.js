var options =
        [
            {
                icon: '<i class="fa fa-floppy-o" aria-hidden="true" style="position: relative; top: 10px;"></i>',
                label: 'Salva',
                callback: function () {
                    $("#pdf").submit();
                }
            },
            {
                icon: '<i class="fa fa-print" aria-hidden="true" style="position: relative; top: 10px;"></i>',
                label: 'Stampa',
                callback: function () {
		    $("#toPrint").val("true");
		    $("#pdf").submit();
//                    window.print();
                }
            },
//	{
//		icon:'3',
//		label: 'Test Element 3',
//		display: {
//			color: 'blue',
//			background: 'red'
//		}
//	}
        ];

var context = new Bubbler(options);
