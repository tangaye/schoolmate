

require('bootstrap-notify');

// swal alert function to delete records
window.swal_delete = function(message, route, row) {
    swal({
      title: "Are you sure?",
      text: message,
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "No, cancel!",
      closeOnConfirm: false,
      closeOnCancel: false
    },
    function(isConfirm){
        if (isConfirm) {
            $.ajax({
                type: 'DELETE',
                url: route
            }).done(function (data) {
                if (data.message) {
                    swal("Deleted!", data.message, "success");
                    jQuery(row).fadeOut('slow');

                } else if (data.error){
                    swal("Oops...", data.error, "error");
                }

            }).fail(function () {
                swal("Oops...", "Something Went Wrong .... Please contact administrator :)", "error");
            });
        } else {
            swal("Cancelled", "Item is safe :)", "error");
        }
    });
}
// function that displays notification
window.notify = function(message) {
    // body...
    $.notify({
        icon: 'fa fa-check',
        message: message
    },{
        type: 'success',

        placement: {
            from: "bottom"
        },

        animate: {
            enter: 'animated fadeInRight',
            exit: 'animated fadeOutRight'
        },
        template:
            '<div data-notify="container" role="alert" class="col-xs-11 col-sm-2 alert alert-{0}" style="margin: 15px 0 15px 0; width: 250px;">\
                <button type="button" class="close" data-notify="dismiss" style="top:7px;">\
                    <span aria-hidden="true">×</span>\
                    <span class="sr-only">Close</span>\
                </button>\
                <span data-notify="icon"></span>\
                <span data-notify="message" style="padding-right:15px">{2}</span>\
            </div>'
    });
}

// function that displays notification
window.welcome = function(message) {
    // body...
    $.notify({
        icon: 'glyphicon glyphicon-gift',
        message: message
    },{
        offset: 50,
        template:
            '<div data-notify="container" role="alert" class="col-xs-11 col-sm-2 alert alert-{0}" style="margin: 15px 0 15px 0; width: 250px;">\
                <button type="button" class="close" data-notify="dismiss" style="top:7px;">\
                    <span aria-hidden="true">×</span>\
                    <span class="sr-only">Close</span>\
                </button>\
                <span data-notify="icon"></span>\
                <span data-notify="message" style="padding-right:15px">{2}</span>\
            </div>'
    });
}

// function that displays notification
window.big_notify = function(message) {
    // body...
    $.notify({
        icon: 'fa fa-check',
        message: message
    },{
        type: 'success',

        placement: {
            from: "bottom"
        },

        animate: {
            enter: 'animated fadeInRight',
            exit: 'animated fadeOutRight'
        },
        template:
            '<div data-notify="container" role="alert" class="col-xs-11 col-sm-2 alert alert-{0}" style="margin: 15px 0 15px 0; width: 350px;">\
                <button type="button" class="close" data-notify="dismiss" style="top:7px;">\
                    <span aria-hidden="true">×</span>\
                    <span class="sr-only">Close</span>\
                </button>\
                <span data-notify="icon"></span>\
                <span data-notify="message" style="padding-right:15px">{2}</span>\
            </div>'
    });
}

window.printReport = function(section, title){
    var printContent = document.getElementById(section);
    var WinPrint = window.open();

    WinPrint.document.write('<head>');
    WinPrint.document.write('<link rel="stylesheet" type="text/css" href="/css/app.css">');
    WinPrint.document.write('<link rel="stylesheet" type="text/css" href="/css/media-print.css" media="print">');
    WinPrint.document.write('<title>'+title+'</title>');
    WinPrint.document.write('</head>');
    WinPrint.document.write('<body>');
    WinPrint.document.write(printContent.innerHTML);
    WinPrint.document.write('</body>');
    WinPrint.document.close();
    WinPrint.setTimeout(function(){
      WinPrint.focus();
      WinPrint.print();
      WinPrint.close();
    }, 1000);
}