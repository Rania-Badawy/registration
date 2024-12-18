
<style>
    <?php if ($this->session->userdata('language') == 'english') { ?>.indications .indication_card b {
        border-right: 5px solid var(--main-color);
        padding: 0 10px 0 0 !important;
        border-left: unset !important;
        ;
    }

    .indications .indication_card .indication_card_text {
        margin-left: 10px !important;
        margin-right: 0 !important;
    }

    .class {
        float: right;
    }

    <?php } ?>.class {
        float: left;
    }
    @media screen and (max-width: 600px) {
        .modal {
            left: 50% !important;
            width: 400px !important;
        }
        .modal-content {
            width: 100% !important;
        }
    }
</style>

<script src="<?php echo base_url() ?>assets/new/new-charts/highcharts.js"></script>
<script src="<?php echo base_url() ?>assets/new/new-charts/exporting.js"></script>

<div class="clearfix"></div>



<div class=" margin-top-none container-page">

    <div class="col-lg-12">

        <div class="row">

          
          
        </div>

    </div>



    <div class="clearfix"></div>

   

    <div class="clearfix"></div>

</div>

