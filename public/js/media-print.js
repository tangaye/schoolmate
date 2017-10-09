function printReport (section){
    var printContent = document.getElementById(section);
    var WinPrint = window.open();

    WinPrint.document.write('<link rel="stylesheet" type="text/css" href="{{ asset("/css/app.css") }}">');
    WinPrint.document.write('<link rel="stylesheet" type="text/css" href="{{ asset("/css/media-print.css") }}" media="print">');
    WinPrint.document.write(printContent.innerHTML);
    WinPrint.document.close();
    WinPrint.setTimeout(function(){
      WinPrint.focus();
      WinPrint.print();
      WinPrint.close();
    }, 1000);
}
