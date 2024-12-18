<?php
$url1 = $_SERVER['REQUEST_URI'];
header("Refresh: 120; URL=$url1");
?>
<style>
  .examclass {
    display: table
  }

  .examclass .select2 {
    display: table-caption;
  }

  .examclass p {
    display: none;
  }

  .quiz__settings label {
    margin-top: 0;
    font-size: 13px;
    text-align: center;
  }

  .quiz .header {
    height: 4em;
    margin-bottom: 12px;
  }

  .control-hint.error {
    margin-top: revert;
  }
</style>
<?php

$get_api_setting = $this->setting_model->get_api_setting();
$this->ApiDbname = $get_api_setting[0]->{'ApiDbname'};
$ApiDbname

?>
<div class="quiz row no-guuter row-reverse">
  <header class="header">
    <h3 class="heading"> <? echo lang('Add_homework'); ?> </h3>
    <a href="#" class="back far fa-arrow-left"> <?php echo lang("am_back_list"); ?> </a>
  </header>
  <div class="container-fluid">
    <div class="row">

      <main class="col-8 text-center">
        <?php if ($test_id) { ?><h6 class="quiz__heading"><?php echo lang('count_exam_questions'); ?>
            <?php if ($questions) { ?> <b class="alert success"><?php echo count($questions); ?></b> <?php } else { ?><b class="alert danger">0</b><?php } ?></h6><br><?php } ?>
        <?php if (!$questions) { ?><h2 class="quiz__heading"><?php echo lang('exam_hint'); ?></h2><?php } ?>
        <div class="quiz__types">
          <?php
          // foreach ($questions as $key => $value) {

          //   $questions_types_ID = $value->questions_types_ID;

          //   if ($questions_types_ID == 8) {
          //     $draw_found = 1;
          //     break;
          //   } else {
          //     $draw_found = 0;
          //   }
          // }
          // $abc = array(
          //   '0' => 'quiz__type success fas fa-check',
          //   '1' => 'quiz__type success fas fa-check-double',
          //   '2' => 'quiz__type primary fas fa-pen-alt',
          //   '3' => 'quiz__type purple fas fa-scroll',
          //   '4' => 'quiz__type pink fas fa-expand-arrows-alt',
          //   '5' => 'quiz__type blue fas fa-signature',
          // );
          if ($test_id) {
            $query = $this->db->query("select ID from test_student where test_id=$test_id")->result();
          }

          foreach ($Type_question as $color => $row) {
            $Type_question_ID   = $row->ID;
            $Type_question_Name = $row->Name;
            if (($draw_found == 0) || ($draw_found == 1) && ($Type_question_ID != 8)) {
          ?>
              <a <?php if ($test_id > 0 && empty($query)) { ?>href="<?php echo site_url('emp/exam_new/ques_type/' . $rowlevelid . "/" . $subjectid . "/" . $type . "/" . $test_id . "/" . $Type_question_ID); ?>" <?php } else { ?>onclick="ques_alert()" <?php } ?>class="<?php echo $abc[$color]; ?>"><?php echo $Type_question_Name; ?></a>

          <?}}?>
        </div>
      </main>
      <div id="exam_show">
        <?php include('bank_question_show.php'); ?>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  $(document).ready(function() {
    //   $("#loadingDiv").hide();
    function clearColumns(ColumnsArray) {
      $(ColumnsArray).each(function() {
        $(this).empty();
        $(this).append('<option value="0"> </option>')
      });
    }

    function drawColumn(columnID, columnString, columnName) {
      columnnameID = "#" + columnName;
      $.each(data, function(key, value) {
        $('select[name="' + columnName + '"]').append('<option value="' + columnID + '">' + columnString + '</option>');
      });
      $(columnnameID).prop("disabled", false);

    }
    $('select[name="slct_class[]"]').on('change', function() {
      var stateID = $(this).val();
      var RowLevel = $("#RowLevel").val();
      if (stateID) {
        $.ajax({
          url: '<?php echo site_url(); ?>' + '/emp/Exam_new/get_student/' + stateID + '/' + RowLevel,
          type: "GET",
          dataType: "json",
          success: function(data) {
            $('select[name="slct_student[]"]').empty();
            $.each(data, function(key, value3) {
              $('select[name="slct_student[]"]').append('<option value="' + value3.StudentID + '">' + value3.StudentName + '</option>');

            });


            $("#slct_student[]").prop("disabled", false);
          }
        });
      }
    });



  });

  function ques_alert() {
    alert("يجب ادخال وحفظ بيانات الاختبار اولا ");
  }
</script>
<script>
  function setmin_DateTo(value) {
    document.getElementById('Date_to').min = value;
    setmin_Date();


  }
</script>
<script type="text/javascript">
  function validate(txt_time) {
    if (parseFloat(txt_time.value) <= 0) {
      txt_time.value = "";
      return false;
    } else {
      return true;
    }
  }
</script>
<script>
  function setmin_Date() {

    var startDate = $('#Date_from').val();
    var endDate = $('#Date_to').val();
    const dateFormat = "YYYY-MM-DD HH:mm:ss";
    const date1 = moment(startDate).format(dateFormat);
    const date2 = moment(endDate).format(dateFormat);
    const differenceInHours = moment(endDate).diff(date1, 'minutes');


    if ((endDate == startDate) || (endDate < startDate) || (differenceInHours <= 60)) {

      Date_to.value = "";
      alert('End date should be greater than Start date by one hour at least');
    }
  }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>