
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
  
<!-- tornado-rtl.css -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets_emp/bank/css/tornado-rtl.css">
<!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets_emp/bank/css/fontawsome.css"> -->

<!-- <script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/dataTable/jquery.dataTables.js"></script> -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<link href="<?php echo base_url(); ?>assets_new/css/fontawsome.css" rel="stylesheet" crossorigin="anonymous" />

<script type="text/javascript" language="javascript" class="init">
    $(function() {
        $('#example').dataTable();

    });
</script>
<script src="<?php echo base_url(); ?>assets_emp/bank/js/sweetalert2.all.js"></script>

</script>
<script type="text/javascript" src="<?php echo base_url(); ?>datepicker/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>datepicker/css/datepicker.css" type="text/css" />
<div class="clearfix"></div>
<div class="clearfix"></div>

<div class="content margin-top-none container-page">
    <div class="col-lg-12">
       <? 
        include 'layout/viewBankFilter.php';
        include 'layout/viewBankTable.php';
       ?>
         
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>
<?php

?>
<? include 'layout/viewBank.php'; ?>

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

<script>
    function deleteBankData(bankId) {
    $.ajax({
        url: '<?php echo site_url('admin/question_bank/delete_question_bank/'); ?>' + bankId,
        type: 'GET',
        success: function (response) {
            if (response.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1500
                });

                // يمكنك هنا تحديث واجهة المستخدم بإزالة الصف من الجدول أو ما شابه
                // ...
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ',
                    text: response.message
                });
            }
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'حدث خطأ أثناء محاولة الحذف',
                text: 'يرجى المحاولة مرة أخرى في وقت لاحق',
            });
        }
    });
}


document.addEventListener("DOMContentLoaded", function () {
    const deleteButtons = document.querySelectorAll(".delete-button");

    deleteButtons.forEach(button => {
        button.addEventListener("click", function (event) {
            event.preventDefault();

            const bankId = button.getAttribute("data-id");

            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "لن يمكنك التراجع عن هذا الإجراء!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'نعم، احذفه!',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteBankData(bankId);
                }
            });
        });
    });
});



</script>