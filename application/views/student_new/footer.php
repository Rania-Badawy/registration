
 <script>
 $(document).ready(function() {
    
     $(".select_2").select2({
        allowClear: true,
        width: '100%',
        height: '100%',
        placeholder: 'select..'
        //data: data

        
    });

    
  
        
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
 
        <script src="<?php echo base_url(); ?>assets_new/js/chart.min.js"></script>
        <script src="<?php echo base_url(); ?>assets_new/js/tornado.min.js"></script>
        <script src="<?php echo base_url(); ?>assets_new/js/select2.min.js"></script>
    </body>
</html>