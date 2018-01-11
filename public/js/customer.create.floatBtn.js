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
		icon: '<i id="save-update-btn" class="fa fa-floppy-o" aria-hidden="true" style="position: relative; top: 10px;"></i>',
		label: 'Salva',
		callback: function () {
		    $("#save-btn").click();
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
