<link href="<?echo base_url('/assets/new/css/style.css')?>" rel="stylesheet">
<link href="<?echo base_url('/assets/new/css/bootstrap.min.css')?>" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/dataTable/dataTables.bootstrap.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<!-- tornado-rtl.css -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets_emp/bank/css/tornado-rtl.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets_emp/bank/css/fontawsome.css">

<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/dataTable/jquery.dataTables.js"></script>
<style>
.modal-box.active {
    /* visibility: visible;
    opacity: 1;
    transition: all 0.5s; */
    position: absolute;
    z-index: 9999999;
}
</style>
<script type="text/javascript" language="javascript" class="init">
    $(function() {
        $('#example').dataTable();

    });
</script>

</script>
<script type="text/javascript" src="<?php echo base_url(); ?>datepicker/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>datepicker/css/datepicker.css" type="text/css" />
<div class="clearfix"></div>
<div class="clearfix"></div>

<div class="content margin-top-none container-page">
    <div class="col-lg-12">
     
    <?
    // include(APPPATH . 'views/admin/questionBank/layout/viewBankFilter.php'); 
    include(APPPATH . 'views/admin/questionBank/layout/viewBankTable.php'); 
    ?>
    
         
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>
<?php

?>
<? include(APPPATH . 'views/admin/questionBank/layout/viewBank.php'); ?>

<script src="<?php echo base_url(); ?>assets_emp/bank/js/index.js"></script>
<script src="<?php echo base_url(); ?>assets_emp/bank/js/tornado.min.js"></script>

<script>
    $(document).ready(function() {
    $(".open-modal").click(function() {
        var bankId = $(this).data("id");
        
        $.ajax({
            url: "<? echo base_url("admin/Question_bank/bankData")?>",
            type: "POST",
            data: { bankId: bankId },
            success: function(response) {
                $("#modal-content").html(response); 

            }
        });
    });
});

    </script>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?echo base_url('assets/dataTable/dataTables.bootstrap.css')?>">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<!-- tornado-rtl.css -->
<link rel="stylesheet" type="text/css" href="<?echo base_url('assets_emp/bank/css/tornado-rtl.css')?>">
<link rel="stylesheet" type="text/css" href="<?echo base_url('assets_emp/bank/css/fontawsome.css')?>">

<script type="text/javascript" language="javascript" src="<?echo base_url('assets/dataTable/jquery.dataTables.js')?>"></script>