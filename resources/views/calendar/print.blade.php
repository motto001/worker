<!--  gomb -->

<button id="printbutton" class="btn btn-success btn-sm" title="print">
    <i class="fa fa-print" aria-hidden="true"></i> Nyomtatás
</button>

<!-- pdf script -->
<script>



$('#printbutton').on('click', function() {  
    //window.print(); 
    var DocumentContainer = document.getElementById('naptarprint');
    var WindowObject = window.open('', "PrintWindow", "width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
    WindowObject.document.writeln(DocumentContainer.innerHTML);
    WindowObject.document.close();
    WindowObject.focus();
    WindowObject.print();
    WindowObject.close();
    return false; // why false?
  });

</script>

