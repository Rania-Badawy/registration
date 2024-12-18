<?php

$CI                  = get_instance();
$lang           = $CI->session->userdata('language');
$UID            = $CI->session->userdata('id');
?>
 <script>
 $(document).ready(function() {
    
     $(".select_2").select2({
        allowClear: true,
        width: '100%',
        height: '100%',
        placeholder: '<?=lang('select')?>'
        //data: data
    });
   
});
$(".mceEditor").click(function () {
        var userInput = input.val();
        
        
            let regex = /^[؀-ۿ ]+$/;
            if (!userInput.match(regex)) {
               // alert("Only use Arabic characters!");
                input.val('');
            }
    });
  $(function () {
    $("#print").click(function () {
        printElement('printTable');
       
    });
});
function printElement(divName)
{
			window.print();
		
}
</script>
<!-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> -->

<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script><script>
    $(document).ready(function() {
       if ($.fn.DataTable) {
        if ($.fn.DataTable.isDataTable('#myTable')) {
            $('#myTable').DataTable().destroy();
        }

        if ($.fn.DataTable.isDataTable('.data-table-ex')) {
            $('.data-table-ex').DataTable().destroy();
        }

        $('.data-table-ex').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copy',
                    className: 'btn blue-green-bg',
                    text: 'Copy'
                },
                {
                    extend: 'excel',
                    className: 'btn blue-green-bg',
                    text: 'Excel'
                },
                {
                    extend: 'print',
                    className: 'btn blue-green-bg',
                    text: 'Print'
                }
            ]
        });
    }
});
</script> 
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
  <script>
    var pusher = new Pusher('ea4bc3db1b4e7745bd8a', {
        cluster: 'mt1'
    });
 </script>

            
 
    

    </body>
</html>