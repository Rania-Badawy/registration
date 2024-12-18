<link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets_emp/exam/js/quill.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets_emp/exam/js/fieldsLinker.css" />
<link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>assets_emp/exam/img/fevicon.png" />
<link rel="stylesheet" href="https://uicdn.toast.com/tui-image-editor/latest/tui-image-editor.css" />
<script src="<?php echo base_url(); ?>assets_emp/exam/js/fieldsLinker.js"></script>
<script src="<?php echo base_url(); ?>assets_emp/exam/@wiris/mathtype-generic/wirisplugin-generic.js"></script>
<script src="https://uicdn.toast.com/tui-image-editor/latest/tui-image-editor.js"></script>
<style>
  .student-quiz__question-answer-editor {
    width: 100%;
  }

  .fieldsLinker li {
    overflow: scroll;
  }

  .page-head span {
    font-size: 25px;
    color: #000
  }

  .page-head span p {
    text-align: center;
  }

  .page-head span p img {
    width: 130px;
    margin-bottom: -5px;
  }

 
  .img p {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: large;
    white-space: nowrap;
  }

  .choose-answer {
    max-height: 300px
  }
  .img h2 img {
    width: 220px;
}
.page-head span {
    font-size: 12px !important;
    color: #000;
}
.page-head span p {
    text-align: center;
    font-size: large;
}
.img h2 img {
    width: 31px;
}
.page-head span p img {
    width: 82px;
    margin-bottom: -5px;
}
.choose-question .img h2 img {
    width: unset;
}
.student-quiz__question h2 {
    /* display: flex; */
}
.student-quiz__question p {
    /* display: inline-block; */
}
.page-wraper {
    height: unset;
}
.choose-answer .ql-editor h2 p {
    width: 100%;
    word-break: break-all;
    white-space: normal;
}

</style>

<div style="display: none" id="toolbarLocation"></div>
<div style="display: none" id="toolbarLocation2"></div>
<?php if ($q_details) { ?>
  <div class="quiz student-quiz row no-guuter row-reverse">
    <header class="header">
      <h3 class="heading"><?php echo $exam_details[0]->test_Name ?></h3>
    </header>
    <div class="container-fluid">
      <div class="row">

        <div class="col-12 ">
          <div class="exam-solver pos-relative">
            <form action="<?php echo site_url('student/answer_exam/correction_exam/'); ?>" method="post" class="student-quiz__question-container  page-head success " id="my_form">
              <div class="modal-body tabs ">
                <input type="hidden" id="txt_test_ID" name="txt_test_ID" value="<?php echo $examID ?>" />
                <input type="hidden" id="type" name="type" value="<?php echo $type ?>" />
                <input type="hidden" id="task" name="task" value="<?php echo $task ?>" />
                <input type="hidden" id="subjectID" name="subjectID" value="<?php echo $exam_details[0]->subject_id ?>" />
                <ul class="tabs-menu">
                  <?php
                  $q_count = 1;
                  $match = 0;
                  $draw_c = 0;
                  $remark = 0;
                  foreach ($q_details as $item) {
                    $q_types_ID   = $item->questions_types_ID;
                    if ($q_types_ID == 7) {
                      $match++;
                    }
                    if ($q_types_ID == 8) {
                      $draw_c++;
                    }
                    if ($q_types_ID == 6) {
                      $remark++;
                    }
                  }
                  foreach ($exam_details as $row) {
                    $q_types_Name = $row->questions_types_Name;
                    $q_types_ID   = $row->questions_types_ID;
                  ?>
                    <li data-tab="tab-<?php echo $q_count ?>"><?php echo $q_types_Name; ?> <input type="hidden" id="txt_t_q_ID_<?php echo $q_count ?>" name="txt_t_q_ID_<?php echo $q_count ?>" value="<?php echo $q_types_ID ?>" /> </li>

                  <?php
                    $q_count++;
                  }
                  ?>
                </ul>
                <div class="tabs-wraper">
                  <?php
                  $q_count = 1; // type of question
                  foreach ($exam_details as $row) {
                    $qtotal = count($exam_details);
                    $q_ID         = $row->questions_content_ID;
                    $q_types_Name = $row->questions_types_Name;
                    $q_types_ID   = $row->questions_types_ID;
                    $time_count         = $row->time_count;
                  ?>
                    <!--<div class="tab-content" id="tab-<?php echo $q_count ?>" style="min-height: 345px !important;">-->
                    <div class="col-12 slide <?php if ($q_count == 1) {
                                                echo "active";
                                              } ?>">
                      <?php
                      switch ($q_types_ID) {
                        case '2':
                          $q_one_count = 1;
                          foreach ($q_details as $row) {
                            $q_one_t_ID         = $row->questions_types_ID;
                            if ($q_one_t_ID == $q_types_ID) {
                              $Question       = $row->Question;
                              $Degree         = $row->Degree;
                              $attach         = $row->Q_attach;
                              $q_one_Q_ID     = $row->ID;
                              $q_type_Name    = $row->questions_types_Name;
                              $youtube_script = $row->youtube_script;
                      ?>
                              <div class="student-quiz__question-header">
                                <h1><?php echo $q_type_Name; ?></h1>
                              </div>
                              <!-- question body  -->
                              <div class="student-quiz__question-body choose-question">
                                <div class="student-quiz__question">
                                  <input type="hidden" id="txt_q_ID_2_<?php echo $q_one_count ?>" name="txt_q_ID_2_<?php echo $q_one_count ?>" value="<?php echo $q_one_Q_ID ?>" />
                                  <div class="page-head container-fluid pt30">
                                    <span><?php echo $Question; ?></span>
                                  </div>
                                </div>
                                <?php if ($attach) { ?>
                                  <div class="img" style="">
                                    <?php
                                    $ImagePath = base_url() . 'assets/exam/' . $attach;
                                    if (file_exists('./assets/exam/' . $attach) && $attach != "") {
                                    ?>
                                      <?php
                                      $imgarray =  array('gif', 'png', 'jpg', 'jpeg', 'JPEG', 'PNG', 'JPG');
                                      $files =  array('pdf', 'doc', 'docx', 'txt', 'ppt', 'xlsx', 'pptx');
                                      $video = array('mp4', 'mp3', 'wav', 'aif', 'aiff', 'ogg', 'wmv');
                                      $fileCheck = pathinfo($attach);
                                      if (in_array($fileCheck['extension'], $imgarray)) { ?>
                                        <img src="<?php echo base_url() ?>assets/exam/<?php echo $attach; ?>" style="height: 250px !important;" />
                                      <?php } elseif (in_array($fileCheck['extension'], $files)) { ?>
                                        <a class="btn btn-success" href="<?php echo base_url() ?>assets/exam/<?php echo $attach; ?>" download>
                                          <i class="fa fa-download"></i> <?php echo lang('am_download'); ?></a>
                                      <?php } elseif (in_array($fileCheck['extension'], $video)) { ?>
                                        <video width="150px" height="250px" controls>
                                          <source src="<?php echo base_url() ?>assets/exam/<?php echo $attach; ?>" type="video/mp4" style="height: 250px !important;">
                                        </video>
                                    <?php }
                                    } ?>
                                  </div>
                                <?php } ?>

                                <div class="student-quiz__question-choose-answer flexbox">
                                  <!-- choice -->
                                  <?php
                                  $ans_one_count = 1;
                                  foreach ($q_answers as $row) {
                                    $Answer      = $row->Answer;
                                    $Answer_ID   = $row->Answer_ID;
                                    $Ans_q_ID    = $row->questions_content_ID;
                                    $Ans_correct = $row->Answer_correct;
                                    if ($Ans_q_ID == $q_one_Q_ID) {
                                  ?>
                                      <input type="hidden" id="txt_multi_choice_ID<?php echo $q_count ?>_<?php echo $q_one_count ?>_<?php echo $ans_one_count ?>" name="txt_multi_choice_ID<?php echo $q_one_count ?>[]" value="<?php echo $Answer_ID ?>" />
                                      <label class="choose-answer">
                                        <input type="checkbox" class="radio-choice<?=$Ans_q_ID?>" onchange="radioUnchoicestudent(event, <?=$Ans_q_ID?>)" value="<?php echo $Answer_ID ?>" name="check_<?php echo $q_one_count ?>[]" id="check_<?php echo $q_one_count ?>_<?php echo $ans_one_count ?>" />
                                        <div class="img" style=" word-break: break-all;">
                                          <!--<img src="https://www.victoriafalls-guide.net/images/africa-vegetation.jpg" alt=""/>-->
                                          <?php
                                          $ImagePath = base_url() . 'assets/exam/' . $Answer;
                                          if (file_exists('./assets/exam/' . $Answer) && $Answer != "") {
                                          ?>
                                            <?php
                                            $imgarray =  array('gif', 'png', 'jpg', 'jpeg', 'JPEG', 'PNG', 'JPG');
                                            $files =  array('pdf', 'doc', 'docx', 'txt', 'ppt', 'xlsx', 'pptx');
                                            $video = array('mp4', 'mp3', 'wav', 'aif', 'aiff', 'ogg');
                                            $fileCheck = pathinfo($Answer);
                                            if (in_array($fileCheck['extension'], $imgarray)) { ?>
                                              <img height="150px" src="<?php echo base_url() ?>assets/exam/<?php echo $Answer; ?>" style="height: 200px !important;" />
                                            <?php } elseif (in_array($fileCheck['extension'], $files)) { ?>
                                              <a class="btn btn-success" href="<?php echo base_url() ?>assets/exam/<?php echo $Answer; ?>" download>
                                                <i class="fa fa-download"></i> <?php echo lang('am_download'); ?></a>
                                            <?php } elseif (in_array($fileCheck['extension'], $video)) { ?>
                                              <video width="200" height="240" controls>
                                                <source src="<?php echo base_url() ?>assets/exam/<?php echo $Answer; ?>" type="video/mp4" style="height: 200px !important;">
                                              </video>
                                            <?php }
                                          } else { ?>
                                            <div style="text-align: center;overflow: hidden;position:relative;font-size: large;" class="ql-editor">
                                              <h2><?php echo $Answer; ?></span>
                                            </div>
                                          <?php } ?>
                                        </div>
                                      </label>
                                  <?php
                                      $ans_one_count++;
                                    }
                                  }
                                  ?>
                                  <!-- //choice -->
                                </div>
                              </div>
                              <input type="hidden" id="txt_q_one_count_<?php echo $q_count ?>" name="txt_q_one_count_<?php echo $q_count ?>" value="<?php echo $q_one_count ?>" />
                          <?php
                              $q_one_count++;
                            }
                          }
                          break;
                        case '3':
                          ?>
                          <?php
                          $q_one_count = 1;
                          foreach ($q_details as $row) {
                            $q_one_t_ID         = $row->questions_types_ID;
                            if ($q_one_t_ID == $q_types_ID) {
                              $Question       = $row->Question;
                              $Degree         = $row->Degree;
                              $attach         = $row->Q_attach;
                              $q_one_Q_ID     = $row->ID;
                              $q_type_Name    = $row->questions_types_Name;
                              $youtube_script = $row->youtube_script;
                          ?>

                              <div class="student-quiz__question-header">
                                <h1><?php echo $q_type_Name; ?></h1>
                              </div>
                              <!-- question body  -->
                              <div class="student-quiz__question-body">
                                <div class="student-quiz__question">
                                  <input type="hidden" id="txt_q_ID_3_<?php echo $q_one_count ?>" name="txt_q_ID_3_<?php echo $q_one_count ?>" value="<?php echo $q_one_Q_ID ?>" />
                                  <h2><?php echo $Question; ?></h2>
                                  <?php if ($attach) { ?>
                                    <div class="img" style=" width: 416px;">
                                      <?php
                                      $ImagePath = base_url() . 'assets/exam/' . $attach;
                                      if (file_exists('./assets/exam/' . $attach) && $attach != "") {
                                      ?>
                                        <?php
                                        $imgarray =  array('gif', 'png', 'jpg', 'jpeg', 'JPEG', 'PNG', 'JPG');
                                        $files =  array('pdf', 'doc', 'docx', 'txt', 'ppt', 'xlsx', 'pptx');
                                        $video = array('mp4', 'mp3', 'wav', 'aif', 'aiff', 'ogg', 'wmv');
                                        $fileCheck = pathinfo($attach);
                                        if (in_array($fileCheck['extension'], $imgarray)) { ?>
                                          <img src="<?php echo base_url() ?>assets/exam/<?php echo $attach; ?>" style="height: 250px !important;" />
                                        <?php } elseif (in_array($fileCheck['extension'], $files)) { ?>
                                          <a class="btn btn-success" href="<?php echo base_url() ?>assets/exam/<?php echo $attach; ?>" download>
                                            <i class="fa fa-download"></i> <?php echo lang('am_download'); ?></a>
                                        <?php } elseif (in_array($fileCheck['extension'], $video)) { ?>
                                          <video width="150px" height="250px" controls>
                                            <source src="<?php echo base_url() ?>assets/exam/<?php echo $attach; ?>" type="video/mp4" style="height: 250px !important;">
                                          </video>
                                      <?php }
                                      } ?>
                                    </div>
                                  <?php } ?>
                                </div>
                                <div class="student-quiz__question-choose-answer flexbox" style="min-height: 5em;">
                                  <?php foreach ($q_answers as $row) {
                                    $Answer   = $row->Answer;
                                    $Answer_ID   = $row->Answer_ID;
                                    $Ans_q_ID = $row->questions_content_ID;
                                    $Ans_correct = $row->Answer_correct;

                                    if ($Ans_q_ID == $q_one_Q_ID) {
                                      if (($Answer == 'الاجابة صحيحة ' || $Answer == 'Correct answer ')) {
                                        $Answer = lang("right_answer");
                                      } else if (($Answer == 'الاجابة خاطئة ' || $Answer == 'Wrong answer ')) {
                                        $Answer = lang("wrong_answer");
                                      } ?>

                                      <label class="radio-button display-block" for="correct_<?php echo $q_one_count ?>_<?php echo $ans_one_count ?>" style="margin: 24px;">
                                        <input type="radio" value="<?php echo $Answer_ID ?>" name="correct_<?php echo $q_one_count ?>[]" id="correct_<?php echo $q_one_count ?>_<?php echo $ans_one_count ?>" />
                                        <span><?php echo $Answer; ?></span>
                                        <input type="hidden" id="txt_correct_ID<?php echo $q_count ?>_<?php echo $q_one_count ?>_<?php echo $ans_one_count ?>" name="txt_correct_ID<?php echo $q_one_count ?>[]" value="<?php echo $Answer_ID ?>" />
                                      </label>
                                  <?php
                                      $ans_one_count++;
                                    }
                                  }
                                  ///////////////////////////////end loop for Answer//////////////
                                  ?>
                                </div>

                              </div>




                              <input type="hidden" id="txt_q_one_count_<?php echo $q_count ?>" name="txt_q_one_count_<?php echo $q_count ?>" value="<?php echo $q_one_count ?>" />
                          <?php $q_one_count++;
                            }
                          }
                          break;
                        case '4':
                          ?>
                          <?php
                          $q_one_count = 1;
                          foreach ($q_details as $row) {
                            $q_one_t_ID         = $row->questions_types_ID;
                            if ($q_one_t_ID == $q_types_ID) {
                              $Question       = $row->Question;
                              $Degree         = $row->Degree;
                              $attach         = $row->Q_attach;
                              $q_one_Q_ID     = $row->ID;
                              $q_type_Name    = $row->questions_types_Name;
                              $youtube_script = $row->youtube_script;
                              $count_answers  = count($q_answers);
                          ?>
                              <div class="student-quiz__question-header">
                                <h1><?php echo $q_type_Name; ?></h1>
                              </div>
                              <div class="student-quiz__question-body complete-question">
                                <div class="student-quiz__question ">
                                  <input type="hidden" id="txt_q_ID_4_<?php echo $q_one_count ?>" name="txt_q_ID_4_<?php echo $q_one_count ?>" value="<?php echo $q_one_Q_ID ?>" />
                                  <input type="hidden" id="answer_txt_ID_<?php echo $q_one_count ?>_<?php echo $ans_one_count ?>" name="answer_txt_ID_<?php echo $q_one_count ?>" value="<?php echo $Answer_ID ?>" />
                                  <input type="hidden" name="complete_question" id="complete_question" value="<?php echo $q_one_Q_ID ?>" />

                                  <div class="comp<?php echo $q_one_Q_ID ?>" style="display: contents;" id="<?php echo $q_one_Q_ID ?>">
                                    <h2><?php echo $Question; ?></h2>
                                    <?php if ($attach) { ?>
                                      <div class="img" style=" width: 416px;">
                                        <?php
                                        $ImagePath = base_url() . 'assets/exam/' . $attach;
                                        if (file_exists('./assets/exam/' . $attach) && $attach != "") {
                                        ?>
                                          <?php
                                          $imgarray =  array('gif', 'png', 'jpg', 'jpeg', 'JPEG', 'PNG', 'JPG');
                                          $files =  array('pdf', 'doc', 'docx', 'txt', 'ppt', 'xlsx', 'pptx');
                                          $video = array('mp4', 'mp3', 'wav', 'aif', 'aiff', 'ogg', 'wmv');
                                          $fileCheck = pathinfo($attach);
                                          if (in_array($fileCheck['extension'], $imgarray)) { ?>
                                            <img src="<?php echo base_url() ?>assets/exam/<?php echo $attach; ?>" style="height: 250px !important;" />
                                          <?php } elseif (in_array($fileCheck['extension'], $files)) { ?>
                                            <a class="btn btn-success" href="<?php echo base_url() ?>assets/exam/<?php echo $attach; ?>" download>
                                              <i class="fa fa-download"></i> <?php echo lang('am_download'); ?></a>
                                          <?php } elseif (in_array($fileCheck['extension'], $video)) { ?>
                                            <video width="150px" height="250px" controls>
                                              <source src="<?php echo base_url() ?>assets/exam/<?php echo $attach; ?>" type="video/mp4" style="height: 250px !important;">
                                            </video>
                                        <?php }
                                        } ?>
                                      </div>
                                    <?php } ?>
                                  </div>
                                </div>

                              </div>

                              <input type="hidden" id="txt_q_one_count_<?php echo $q_count ?>" name="txt_q_one_count_<?php echo $q_count ?>" value="<?php echo $q_one_count ?>" />
                          <?php $q_one_count++;
                            }
                          }
                          break;
                        case '6':
                          ?>
                          <?php
                          $q_one_count = 1;
                          foreach ($q_details as $row) {
                            $q_one_t_ID         = $row->questions_types_ID;
                            if ($q_one_t_ID == $q_types_ID) {
                              $Question       = $row->Question;
                              $Degree         = $row->Degree;
                              $attach         = $row->Q_attach;
                              $q_one_Q_ID     = $row->ID;
                              $q_type_Name    = $row->questions_types_Name;
                              $youtube_script = $row->youtube_script;
                          ?>
                              <div class="student-quiz__question-header">
                                <h1><?php echo $q_type_Name; ?></h1>
                              </div>

                              <div class="student-quiz__question-body">
                                <div class="student-quiz__question">
                                  <input type="hidden" name="upload_question" class="upload_question" value="<?php echo $q_one_Q_ID ?>" />
                                  <input type="hidden" id="txt_q_ID_6_<?php echo $q_one_count ?>" name="txt_q_ID_6_<?php echo $q_one_count ?>" value="<?php echo $q_one_Q_ID ?>" />
                                  <h2> <?php echo $Question; ?></h2>
                                  <?php if ($attach) { ?>
                                    <div class="img" style=" width: 416px;">
                                      <?php
                                      $ImagePath = base_url() . 'assets/exam/' . $attach;
                                      if (file_exists('./assets/exam/' . $attach) && $attach != "") {
                                      ?>
                                        <?php
                                        $imgarray =  array('gif', 'png', 'jpg', 'jpeg', 'JPEG', 'PNG', 'JPG');
                                        $files =  array('pdf', 'doc', 'docx', 'txt', 'ppt', 'xlsx', 'pptx');
                                        $video = array('mp4', 'mp3', 'wav', 'aif', 'aiff', 'ogg', 'wmv');
                                        $fileCheck = pathinfo($attach);
                                        if (in_array($fileCheck['extension'], $imgarray)) { ?>
                                          <img src="<?php echo base_url() ?>assets/exam/<?php echo $attach; ?>" style="height: 250px !important;" />
                                        <?php } elseif (in_array($fileCheck['extension'], $files)) { ?>
                                          <a class="btn btn-success" href="<?php echo base_url() ?>assets/exam/<?php echo $attach; ?>" download>
                                            <i class="fa fa-download"></i> <?php echo lang('am_download'); ?></a>
                                        <?php } elseif (in_array($fileCheck['extension'], $video)) { ?>
                                          <video width="150px" height="250px" controls>
                                            <source src="<?php echo base_url() ?>assets/exam/<?php echo $attach; ?>" type="video/mp4" style="height: 250px !important;">
                                          </video>
                                      <?php }
                                      } ?>
                                    </div>
                                  <?php } ?>
                                </div>
                                <div class="student-quiz__question-answer flexbox">
                                  <!-- here is the answer -->
                                  <div class="student-quiz__question-answer-editor" style="width:70%" id="essayEditor<?= $q_one_count ?>"></div>
                                  <div class="student-quiz__question-answer-action">
                                    <button type="button" class="file-btn btn btn-icon outline far fa-image">ارفاق صورة
                                      <input type="file" data-id="essayEditor" id="fileUpload<?= $q_one_count ?>" />
                                      <input name="hidImg<?= $q_one_count ?>" id="hidImg<?= $q_one_count ?>" type="hidden" value="" />
                                    </button>
                                    <button type="button" class="btn btn-icon outline fas fa-function" id="equationEditor"> ارفاق معادلة </button>
                                  </div>
                                  <!-- here is the answer -->
                                  <input type="hidden" id="answer_txt_up_<?php echo $q_one_count ?>_<?php echo $ans_one_count ?>" name="answer_txt_up_<?php echo $q_one_count ?>" value="<?php echo $Answer_ID ?>" />

                                  <script>
                                    $('#fileUpload<?= $q_one_count ?>').change(function(e) {
                                      $('#fileUpload<?= $q_one_count ?>').prop('disabled', true).parent().hide();

                                      $("#loadingDiv").show();
                                      var xhr = new XMLHttpRequest();
                                      var data = new FormData();
                                      jQuery.each($('#fileUpload<?= $q_one_count ?>')[0].files, function(i, file) {
                                        data.append('file', file);
                                      });
                                      $.ajax({
                                        url: '<?php echo site_url('emp/exam_new/up_ax') ?>',
                                        data: data,
                                        cache: false,
                                        contentType: false,
                                        processData: false,
                                        type: 'POST',
                                        beforeSend: function() {

                                        },
                                        success: function(data) {
                                          $("#loadingDiv").hide();
                                          if (data.msg_type == 0) {
                                            $("#msgUpload").html(data.msg_upload);
                                            $('#fileUpload<?= $q_one_count ?>').prop('disabled', false).parent().show();

                                          } else if (data.msg_type == 1) {
                                            var newImg = data.base + 'assets/exam/' + data.img;
                                            var hidImg = $("#hidImg<?= $q_one_count ?>").val(data.img);
                                            $("#essayEditor<?= $q_one_count ?> .ql-editor p").append('<img src="' + newImg + '" >');
                                            $('#fileUpload<?= $q_one_count ?>').prop('disabled', true).parent().hide();

                                          }
                                        }
                                      });
                                    });
                                  </script>
                                </div>
                              </div>
                              <input type="hidden" id="txt_q_one_count_<?php echo $q_count ?>" name="txt_q_one_count_<?php echo $q_count ?>" value="<?php echo $q_one_count ?>" />

                          <?php $q_one_count++;
                            }
                          }
                          break;
                        case '8':
                          ?>
                          <?php
                          $q_one_count = 1;
                          foreach ($q_details as $row) {
                            $q_one_t_ID         = $row->questions_types_ID;
                            if ($q_one_t_ID == $q_types_ID) {
                              $Question       = $row->Question;
                              $Degree         = $row->Degree;
                              $attach         = $row->Q_attach;
                              $q_one_Q_ID     = $row->ID;
                              $q_type_Name    = $row->questions_types_Name;
                              $youtube_script = $row->youtube_script;
                          ?>

                              <div class="student-quiz__question-header">
                                <h1><?php echo $q_type_Name; ?></h1>
                              </div>
                              <div class="student-quiz__question-body">
                                <div class="student-quiz__question" id="draw_<?php echo $q_one_Q_ID ?>">
                                  <input type="hidden" id="txt_q_ID_8_<?php echo $q_one_count ?>" name="txt_q_ID_8_<?php echo $q_one_count ?>" value="<?php echo $q_one_Q_ID ?>" />

                                  <h2><?php echo $Question; ?></h2>
                                  <?php if ($attach) { ?>
                                    <div class="img" style=" width: 416px;">
                                      <?php
                                      $ImagePath = base_url() . 'assets/exam/' . $attach;
                                      if (file_exists('./assets/exam/' . $attach) && $attach != "") {
                                      ?>
                                        <?php
                                        $imgarray =  array('gif', 'png', 'jpg', 'jpeg', 'JPEG', 'PNG', 'JPG');
                                        $files =  array('pdf', 'doc', 'docx', 'txt', 'ppt', 'xlsx', 'pptx');
                                        $video = array('mp4', 'mp3', 'wav', 'aif', 'aiff', 'ogg', 'wmv');
                                        $fileCheck = pathinfo($attach);
                                        if (in_array($fileCheck['extension'], $imgarray)) { ?>
                                          <img src="<?php echo base_url() ?>assets/exam/<?php echo $attach; ?>" style="height: 250px !important;" />
                                        <?php } elseif (in_array($fileCheck['extension'], $files)) { ?>
                                          <a class="btn btn-success" href="<?php echo base_url() ?>assets/exam/<?php echo $attach; ?>" download>
                                            <i class="fa fa-download"></i> <?php echo lang('am_download'); ?></a>
                                        <?php } elseif (in_array($fileCheck['extension'], $video)) { ?>
                                          <video width="150px" height="250px" controls>
                                            <source src="<?php echo base_url() ?>assets/exam/<?php echo $attach; ?>" type="video/mp4" style="height: 250px !important;">
                                          </video>
                                      <?php }
                                      } ?>
                                    </div>
                                  <?php } ?>
                                </div>
                                <div class="student-quiz__question-answer flexbox">
                                  <!-- here is the answer -->
                                  <div class="student-quiz__question-answer-editor draw">
                                    <!--<div id="drawEditor"></div>-->
                                    <!-- Drawer -->
                                    <div class="drawer" id="drawer_<?php echo $q_one_Q_ID ?>">
                                      <!-- drawer header -->
                                      <div class="drawer__header">
                                        <!-- drawer toolbar -->
                                        <div class="drawer__toolbar flexbox align-between">
                                          <a  id="pen_<?php echo $q_one_Q_ID ?>" class="item fas fa-pencil"> </a>
                                          <a  id="clear_<?php echo $q_one_Q_ID ?>" class="item fas fa-trash"> </a>
                                          <div class="item">
                                            <input id="color_<?php echo $q_one_Q_ID ?>" type="color" class="item" />
                                          </div>
                                          <a id="eraser_<?php echo $q_one_Q_ID ?>" class="item fas fa-eraser">
                                          </a>
                                          <a id="redo_<?php echo $q_one_Q_ID ?>" class="item fas fa-redo"> </a>
                                          <a id="undo_<?php echo $q_one_Q_ID ?>" class="item fas fa-undo"> </a>
                                        </div>
                                        <!-- //drawer toolbar -->
                                      </div>
                                      <!-- //drawer header -->
                                      <div class="drawer__body active" id="drawer_body_<?php echo $q_one_Q_ID ?>">
                                        <div id="tui-image-editor_<?php echo $q_one_Q_ID ?>"></div>
                                      </div>
                                      <div class="drawer__toolbar flexbox" style="align-items: center">
                                        <div class="column-flex">
                                          <div class="item">
                                            <input id="shape_fill_<?php echo $q_one_Q_ID ?>" type="color" class="color-item" value="#ffffff" />
                                          </div>
                                          <span>fill</span>
                                        </div>
                                        <div class="column-flex">
                                          <div class="item">
                                            <input id="shape_stroke_<?php echo $q_one_Q_ID ?>" type="color" class="color-item" />
                                          </div>
                                          <span>stroke</span>
                                        </div>
                                        <a data-id="circle" class="shape item far fa-circle">
                                          <span class="color-text">Circle</span>
                                        </a>
                                        <a data-id="rect" class="shape item far fa-square">
                                          <span class="color-text">Rectangle</span>
                                        </a>
                                        <a data-id="triangle" class="shape item far fa-triangle">
                                          <span class="color-text">Triangle</span>
                                        </a>
                                        <a data-id="line" class="shape item fas fa-horizontal-rule">
                                          <span class="color-text">line</span>
                                        </a>
                                      </div>
                                    </div>
                                    <!-- //Drawer -->
                                  </div>
                                  <!-- here is the answer -->
                                </div>
                              </div>
                              <input type="hidden" id="txt_q_one_count_<?php echo $q_count ?>" name="txt_q_one_count_<?php echo $q_count ?>" value="<?php echo $q_one_count ?>" />
                              <input type="hidden" id="student_draw_<?php echo $q_one_Q_ID ?>" name="student_draw_<?php echo $q_one_Q_ID ?>" value="" />

                          <?php $q_one_count++;
                            }
                          }
                          break;
                        case '7':
                          ?>
                          <?php
                          $q_one_count = 1;
                          foreach ($q_details as $row) {
                            $q_one_t_ID         = $row->questions_types_ID;
                            if ($q_one_t_ID == $q_types_ID) {
                              $Question       = $row->Question;
                              $Degree         = $row->Degree;
                              $attach         = $row->Q_attach;
                              $q_one_Q_ID     = $row->ID;
                              $q_type_Name    = $row->questions_types_Name;
                              $youtube_script = $row->youtube_script;
                          ?>
                              <div class="student-quiz__question-header">
                                <h1><?php echo $q_type_Name; ?></h1>
                              </div>
                              <div class="student-quiz__question-body match-question">
                                <input type="hidden" id="txt_q_ID_7_<?php echo $q_one_count ?>" name="txt_q_ID_7_<?php echo $q_one_count ?>" value="<?php echo $q_one_Q_ID ?>" />
                                <div class="student-quiz__question" id="match_<?php echo $q_one_count ?>">
                                  <h2><?php echo $Question; ?></h2>
                                  <?php if ($attach) { ?>
                                    <div class="img" style=" width: 416px;">
                                      <?php
                                      $ImagePath = base_url() . 'assets/exam/' . $attach;
                                      if (file_exists('./assets/exam/' . $attach) && $attach != "") {
                                      ?>
                                        <?php
                                        $imgarray =  array('gif', 'png', 'jpg', 'jpeg', 'JPEG', 'PNG', 'JPG');
                                        $files =  array('pdf', 'doc', 'docx', 'txt', 'ppt', 'xlsx', 'pptx');
                                        $video = array('mp4', 'mp3', 'wav', 'aif', 'aiff', 'ogg', 'wmv');
                                        $fileCheck = pathinfo($attach);
                                        if (in_array($fileCheck['extension'], $imgarray)) { ?>
                                          <img src="<?php echo base_url() ?>assets/exam/<?php echo $attach; ?>" style="height: 250px !important;" />
                                        <?php } elseif (in_array($fileCheck['extension'], $files)) { ?>
                                          <a class="btn btn-success" href="<?php echo base_url() ?>assets/exam/<?php echo $attach; ?>" download>
                                            <i class="fa fa-download"></i> <?php echo lang('am_download'); ?></a>
                                        <?php } elseif (in_array($fileCheck['extension'], $video)) { ?>
                                          <video width="150px" height="250px" controls>
                                            <source src="<?php echo base_url() ?>assets/exam/<?php echo $attach; ?>" type="video/mp4" style="height: 250px !important;">
                                          </video>
                                      <?php }
                                      } ?>
                                    </div>
                                  <?php } ?>
                                </div>
                                <?php
                                $match_1 = array();
                                $match_2 = array();
                                foreach ($q_answers as $ok => $option) {
                                  $Ans_q_ID    = $option->questions_content_ID;
                                  $Ans_correct = $option->Answer_correct;

                                  if ($Ans_q_ID == $q_one_Q_ID) {
                                    if (is_numeric(trim($option->Answer))) {
                                      $match_1[]   = trim($option->Answer);
                                    } else {
                                      $match_1[]   = '"' . trim($option->Answer) . '"';
                                    }
                                    if (is_numeric(trim($option->Answer_match))) {
                                      $match_2[]   = trim($option->Answer_match);
                                    } else {
                                      $match_2[]   = '"' . trim($option->Answer_match) . '"';
                                    }
                                    //	$match_1[]   = trim($option->Answer);
                                    //	$match_2[]   = trim($option->Answer_match);
                                    $Answer_ID[] = $option->Answer_ID;
                                  }
                                }

                                //	shuffle($match_1);
                                shuffle($match_1);
                                $match_1 = array_filter($match_1);
                                $match_2 = array_filter($match_2);
                                $match_1 = implode(", ", $match_1);
                                $match_2 = implode(", ", $match_2);
                                //	$match_1='"'.implode('", "', $match_1).'"';
                                //	$match_2='"'.implode('", "', $match_2).'"';
                                //	print_r($match_1);die;
                                ?>
                                <div class="student-quiz__question-answer flexbox">
                                  <!-- here is the answer -->

                                  <!-- match items -->
                                  <div class="student-quiz__question-answer-editor" id="match-drawer-<?php echo $q_one_count ?>"></div>
                                  <!-- //match items -->

                                  <!-- here is the answer -->
                                </div>
                              </div>
                              <script>
                                var input = {

                                  "options": {
                                    "associationMode": "oneToOne", // oneToMany,oneToOne,manyToMany
                                    "lineStyle": "square-ends",
                                    // "buttonErase": "Erase Links",
                                  },
                                  "Lists": [{
                                      "name": "العمود الثاني<?php echo $q_one_count ?> ",
                                      "list": [<?php
                                      $match_1 = str_replace('dir="auto"', '', $match_1);

                                       echo $match_1; ?>],
                                    },
                                    {
                                      "name": "العمود الاول<?php echo $q_one_count ?> ",
                                      "list": [<?php
                                      $match_2 = str_replace('dir="auto"', '', $match_2);

                                       echo $match_2;?>],
                                    },
                                  ],
                                };
                                fieldLinks_<?php echo $q_one_count ?> = $("#match-drawer-<?php echo $q_one_count ?>").fieldsLinker("init", input);
                              </script>
                              <input type="hidden" id="txt_q_one_count_<?php echo $q_count ?>" name="txt_q_one_count_<?php echo $q_count ?>" value="<?php echo $q_one_count ?>" />
                          <?php
                              $q_one_count++;
                            }
                          }
                          ?>
                      <?php
                          break;
                        default:
                      } //end switch
                      ?>

                      <div class="student-quiz__question-footer flexbox align-between">
                        <!-- question timer -->
                        <div class="student-quiz__question-timer">
                        </div>
                        <!-- //question timer -->
                        <div class="student-quiz__question-action">
                          <!-- paginate -->
                          <div class="paginate">
                            <?php if ($q_count != 1) { ?>
                              <a onclick="previousSlide()" class="fas fa-chevron-right"></a><?php } ?>
                            <span>(<?php echo $q_count ?>\<?php echo $qtotal ?>)</span>
                            <?php if ($q_count != $qtotal) { ?>
                              <a onclick="nextSlide()" class="fas fa-chevron-left"></a><?php } ?>
                          </div>
                          <!-- //paginate -->
                          <?php if ($q_count != $qtotal) { ?>
                            <a onclick="nextSlide()" class="skip primary-color">تخطي</a><?php } ?>
                        </div>
                      </div>
                    </div>
                  <?php
                    $q_count++;
                  } ?>



                  <div class="student-quiz__question-footer flexbox align-between">



                    <div class="modal-footer left">
                      <?php if ($this->session->userdata('type') == 'S') { ?>
                        <button class="btn miw-120 small success-bg send-btn exsub" type="submit" <?php if ($qtotal > 1) {
                                                                                                    echo "disabled";
                                                                                                  } ?>><?php echo lang('am_save'); ?></button>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php } else { ?>
  <div class="alert danger">
    <b><?php echo lang('exam_empty'); ?></b>
    <a href="#" class="ti-close remove-item"></a>
  </div>
<?php } ?>
<script>
  var essayEditors = [];
  var cn = <?php echo $remark ?>;
  for (var b = 1; b <= cn; b++) {
    var essayEditor = "essayEditor" + b;
    essayEditor = new Quill(("#essayEditor" + b), {
      placeholder: "...اكتب الإجابة هنا",

    });
    essayEditors.push(essayEditor);
  }
  $(document).ready(function() {
    $("#my_form").on("submit", function() {
      let upload_question = document.querySelectorAll(".upload_question");
      var cu = 1;
      if (upload_question) {
        upload_question.forEach((upload1, i) => {
          var upload_question1 = upload1.defaultValue;
          var essay_question = essayEditors[cu - 1].root.innerHTML;
          $(this).append(`<textarea name='txt_content_${upload_question1}' style='display:none'>"${essay_question}"</textarea>`);
          cu++;
        });
      }
      let question_draw = document.querySelectorAll(".drawer__body");
      if (question_draw) {
        question_draw.forEach((question_1, i) => {
          var draw_question = question_1.parentNode.id;
          var form = document.getElementById("my_form");
          var img = saveImage_am();
          var element1 = $('#draw_' + draw_question);
          const files1 = [];
          files1[0] = img;
          var xhr = new XMLHttpRequest();
          var data = new FormData($('#my_form')[0]);
          jQuery.each(files1, function(i, file) {
            data.append('file', file);
          });
          //data.append('file', img);
          $.ajax({
            url: "<?php echo site_url('emp/exam_new/up_ax') ?>",
            data: data, // the formData function is available in almost all new browsers.
            method: "POST",
            contentType: false,
            processData: false,
            cache: false,
            dataType: "json", // Change this according to your response from the server.
            async: false,
            success: function(data) {
              if (data.msg_type == 0) {
                $("#msgUpload").html(data.msg_upload);
              } else if (data.msg_type == 1) {
                var x = "student_draw_" + draw_question;
                var newImg = data.img;
                document.querySelector("#" + x).value = newImg;
              }
            }
          });
        });
      }
      saveResults();
    });

    let question = document.querySelectorAll(".student-quiz__question h2");
    if (question) {
      question.forEach((question_1, i) => {
        var complete_question = question_1.parentNode.id;
        if (complete_question) {
          let questionContent = question_1.innerHTML.split(" ");
          let counter = 1;
          question_1.innerHTML = questionContent
            .map((word) => {
              if (word == "*****") {
                return `<input type="text" name="answer_txt_complete_${complete_question}_${counter++}" />`;
              } else return word;
            })
            .join(" ");
        }
      });
    }
    // for match question
    // you have to put match the first question because it take the width and height at first so if it's hidden it will take height of none or 0 so you'll can't match any thing 

    function saveResults() {
      var match_count = <?php echo $match ?>;
      for (var b = 1; b <= match_count; b++) {
        var results = window['fieldLinks_' + b].fieldsLinker("getLinks");
        var y = results.links;
        var element = $('#match_' + b);
        element.empty();
        $.each(y, function(key, value) {
          element.append(`<input type="hidden"  name="answers_match_${b}[]" value="${value.to}___${value.from}"/>`);
        });
      }
    }
  })
</script>

<script src="<?php echo base_url(); ?>assets_emp/exam/js/index.js"></script>
<script src="<?php echo base_url(); ?>assets_emp/exam/js/multi_drawer.js"></script>
<script src="<?php echo base_url(); ?>assets_emp/exam/js/student-quiz.js"></script>
<script>
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
  <?php if ($draw_c > 0) { ?>
  let imageEditor;

        // Function to initialize the image editor
        function initImageEditor(qId) {
            const drawerElement = document.querySelector(`#drawer_${qId}`);
            const rect = drawerElement.getBoundingClientRect();

            imageEditor = new tui.ImageEditor(
                document.querySelector(`#tui-image-editor_${qId}`),
                {
                    cssMaxWidth: rect.width,
                    cssMaxHeight: rect.height,
                    height: rect.height,
                    width: rect.width,
                }
            );

            // Now you can load the image after initializing the imageEditor
            imageEditor.loadImageFromURL("<?php echo base_url(); ?>assets_emp/exam/img/blank.png", "image");
        }

        // Ensure to call the init function with the correct qId
        document.addEventListener("DOMContentLoaded", () => {
            const qId = <?php echo $q_one_Q_ID ?>; // Replace with the actual question ID as needed
            initImageEditor(qId);
        });
    // imageEditor.loadImageFromURL("<?php echo base_url(); ?>assets_emp/exam/img/blank.png", "image");
  <?php } ?>
  <?php if ($remark > 0) { ?>
    var cn = <?php echo $remark ?>;
    for (var b = 1; b <= cn; b++) {
      var essayEditor = "essayEditor" + b;
      generateEquationEditor(essayEditors[b - 1].root, toolbarLocation, "ar");
    }
  <?php } ?>
</script>
<script>
  const configureTimer = () => {

    const setConsumedTime = (examId, consumedTime, inOut) => {
      fetch("<?php echo site_url('student/answer_exam/save_test_time_consumed') ?>", {
        method: "POST",
        keepalive: true,
        body: JSON.stringify({
          inOut,
          examId,
          consumedTime,
        }),
        headers: {
          "Content-type": "application/json; charset=UTF-8",
        },
      });
    };
    const timeConsumedInput = document.getElementById("txt_time_consumed");
    const examTime = document.getElementById("txt_time_count").value;
    const examId = document.getElementById("txt_test_ID").value;
    const counter = document.getElementById("time_count");
    const contact_type = document.getElementById("contact_type");

    let consumedTime = timeConsumedInput.value;
    let timerLastCount = +examTime - +consumedTime;
    let formIsSubmitting = false;
    var countdownNumberEl = document.querySelector(".quiz-timer-number");
    var countdown = document.getElementById('time_count').value;
    var circle = document.querySelector(".quiz-timer circle");
    circle.style.animationDuration = countdown; //here put your time in seconds
    countdownNumberEl.textContent = countdown;
    setInterval(() => {
      if (formIsSubmitting) return;
      if (timerLastCount <= 0) {
        formIsSubmitting = true;
        if (contact_type.value == 'S') {
          $("form").submit();
        }
        return;
      }

      document.querySelector("#timecount").value = timerLastCount;
      document.querySelector("#txt_time_consumed").value = ++consumedTime;
      timerLastCount = --timerLastCount <= 0 ? 0 : timerLastCount;
      countdownNumberEl.textContent = timerLastCount;
    }, 1000);

    const isOnIOS = navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPhone/i);
    const eventName = isOnIOS ? "pagehide" : "beforeunload";

    window.addEventListener(eventName, function(event) {
      window.event.cancelBubble = true; // Don't know if this works on iOS but it might!
      setConsumedTime(examId, consumedTime, 'OUT');
    });

  };

  configureTimer();

  function nextSlide() {
  setTimeout(() => {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
    console.log("Scrolled to top"); 
  }, 100); 

  slides.forEach((slide, i) => {
    if (slide.classList.contains("active")) currentActive = i;
    slide.classList.remove("active");
  });

  if (currentActive == slides.length - 1) {
    currentActive = 0;
  } else {
    currentActive++;
  }
  slides[currentActive].classList.add("active");

  if (currentActive == slides.length - 1) {
    const but = document.querySelector('.exsub');
    but.disabled = false;
  }
}

 
</script>
<script> 
 function setDirectionForParagraphs() {
    var paragraphs = document.querySelectorAll('p');

    paragraphs.forEach(function(p) {
        if (isArabic(p.textContent)) {
            p.style.direction = 'rtl';
        } else {
            p.style.direction = 'ltr'; 
        }
    });
}

function isArabic(text) {
    var arabicRegex = /[\u0600-\u06FF]/;
    return arabicRegex.test(text);
}

const elementsH = document.querySelectorAll('.question-card__question');
    elementsH.forEach(element => {
        const paragraphs = element.querySelectorAll('p');
        if (paragraphs.length > 0) {
            let foundArabic = false;
            paragraphs.forEach(p => {
                if (/[\u0600-\u06FF\u0750-\u077F]/.test(p.textContent)) {
                    foundArabic = true;
                }
            });

            if (foundArabic) {
                element.style.textAlign = 'right';
            } else {
                element.style.textAlign = 'left';
            }
        }
    });

document.addEventListener('DOMContentLoaded', setDirectionForParagraphs);
</script>