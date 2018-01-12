var homeRoute;
var saveUpdateFunction;

function setHomeRoute(hr) {
    homeRoute = hr;
}

function setSaveButton(btnl, suf) {
    $("#save-update-btn").next().children("span").text(btnl);
    saveUpdateFunction = suf;
}

var options =
        [
            {
                icon: '<i class="fa fa-floppy-o" aria-hidden="true" style="position: relative; top: 10px;"></i>',
                label: 'Salva',
                callback: function () {
                    saveUpdateFunction();
                }
            },
            {
                icon: '<i class="fa fa-print" aria-hidden="true" style="position: relative; top: 10px;"></i>',
                label: 'Stampa',
                callback: function () {
		    $("#toPrint").val("true");
		    $("#save-btn").click();
//                    window.print();
                }
            },
            {
		icon: '<i class="fa fa-home" aria-hidden="true" style="position: relative; top: 10px;"></i>',
		label: 'Home',
		callback: function () {
		    window.location = homeRoute;
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
