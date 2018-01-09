var homeRoute;
var printRoute;
var formId;
var saveUpdateFunction;

function setHomeRoute(hr) {
    homeRoute = hr;
}

function setPrintRoute(pr) {
    printRoute = pr;
}

function setSaveButton(btnl, suf) {
    $("#save-update-btn").next().children("span").text(btnl);
    saveUpdateFunction = suf;
}


var options =
	[
	    {
		icon: '<i id="save-update-btn" class="fa fa-floppy-o" aria-hidden="true" style="position: relative; top: 10px;"></i>',
		label: 'Salva',
		callback: function () {
//		    window.location = updateStateRoute;
//		    console.log(buttonLabel);
		    saveUpdateFunction();
		}
	    },
	    {
		icon: '<i class="fa fa-print" aria-hidden="true" style="position: relative; top: 10px;"></i>',
		label: 'Stampa',
		callback: function () {
                    if(printRoute !== undefined) {
                        window.location = printRoute;
                    } else {
                        $("#toPrint").val("true");
                        $("#fixing").submit();
                    }
		}
	    },
	    {
		icon: '<i class="fa fa-home" aria-hidden="true" style="position: relative; top: 10px;"></i>',
		label: 'Home',
		callback: function () {
		    window.location = homeRoute;
		}
	    },
	];
var context = new Bubbler(options);
