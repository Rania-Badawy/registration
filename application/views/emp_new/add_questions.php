<style>
  .complete1 .repeater-item:first-child {
    display: none !important;
  }
  .ql-editor{
      width: 100% !important;
      text-align: center !important;
  }
  .complete2 .repeater-item .add-item {
    display: none !important;
  }

  .complete2 .repeater-item .remove-item {
    display: none !important;
  }

  .quiz .header {
    margin-bottom: 0;
  }

  .match-item {
    margin-bottom: 2rem;
    margin-top: 70px;
  }

  .tui-image-editor-canvas-container,
  .lower-canvas,
  .upper-canvas {
    width: 100% !important;
    height: 100% !important;
    max-width: 100% !important;
    max-height: 100% !important;
  }

  .qBank .content {
    display: none;
    width: 100%;
    box-shadow: 0 0 2px 2px #eaeaea;
    text-align: center;
    direction: rtl;
    padding: 10px 0;
  }

  .qBank input[type=checkbox] {
    width: 25px !important;
    height: 25px;
    display: inline-block;
    margin-bottom: 0
  }

  .qBank .selectCon {
    display: flex;
    justify-content: space-around;
    margin-bottom: 30px
  }

  .qBank label {
    display: block;
    text-align: right;
    margin-bottom: 5px;
    font-size: 17px;
    font-weight: bold;
  }

  .qBank select {
    width: 200px;
    padding: 5px;
    border: 1px solid #ddd;
    line-height: unset
  }

  /*Use + to target only one .content*/
  .qBank input[type=checkbox]:checked+.content {
    display: block;
    height: 100px;
    margin-top: 10px
  }

  .quiz .form-action {
    margin: 2em 0 -25px
  }
  .quiz .form-action .btn {
 
    width: 120px;
}

  /*.ql-container {*/
  /*  height: unset !important;*/
  /*}*/

  .quiz .exam-box__text-area #editor {
    min-height: 10em
  }

  .container {
    width: 1200px !important;
    max-width: 1200px !important;
  }

  .match-item .ql-editor {
    height: 50px !important;
    line-height: 25px !important;
  }

  .choice .ql-container {
    display: block !important;
  }

  .direction-ltr {
    direction: ltr !important;
}

.direction-rtl {
    direction: rtl !important;
}
.qBank{
  text-align: left;
    padding-top: 40px;
    padding-left: 17px;
}

.hint.danger {
    color: red;
}
</style>
<div class="loading_div" id="loadingDiv"></div>
<div style="display: none" id="toolbarLocation"></div>
<div style="display: none" id="exampleEditor"></div>
<div class="quiz row no-guuter row-reverse">
  <header class="header">
  </header>
  <div class="exam-toolbar">
    <div class="exam-name"><?php echo $test_data['Name']; ?> </div>
    <div class="vr"></div>
    <div id="toolbar">
      <input type="color" class="ql-color" />
      <div class="vr"></div>
      <button class="ql-bold">
        <i class="fas fa-bold"></i>
      </button>
      <button class="ql-italic">
        <i class="fas fa-italic"></i>
      </button>
      <button class="ql-underline">
        <i class="fas fa-underline"></i>
      </button>
      <button class="ql-strike">
        <i class="fas fa-strikethrough"></i>
      </button>
      <button class="ql-script" value="sub">
        <i class="fas fa-subscript"></i>
      </button>
      <button class="ql-script" value="super">
        <i class="fas fa-superscript"></i>
      </button>
      <button class="ql-link" type="button">
        <i class="fas fa-link"></i>
      </button>
    </div>
    <div class="vr"></div>
    <button class="equitions-modal-button" id="equationEditor"><?php echo lang("Equation_Editor"); ?></button>
  </div>
  <?php $question_id = $answers[0]->ID; ?>
  <div class="container">
    <div class="row">
      <!-- exam box  -->
      <main class="col-12 exam-box" style="padding: 30px;">
        <form class="form-ui" action="<?php echo site_url('emp/exam_new/add_exam_question/' . $Type_question_ID . "/" . $test_id . "/" . $question_id); ?>" method="post" id="my_form">
          <div class="exam-box__header">
            <div class="page-head success">
              <h1><?php echo $question_type['Name']; ?></h1>
            </div>
            <div class="exam-box__type">
              <label class="mb5"><?php echo lang('am_qus'); ?></label>

              <button id="question_type_dropbtn" class="dropbtn">
                <div class="dropbtn-label">
                  <i class="success fas fa-check-double"></i>
                  <?php echo $question_type['Name']; ?>
                </div>
                <i class="far fa-chevron-down"></i>
              </button>
              <div id="myDropdown" class="dropdown-content">
                <?php
                foreach ($questions as $key => $value) {

                  $questions_types_ID = $value->questions_types_ID;

                  if ($questions_types_ID == 8) {
                    $draw_found = 1;
                    break;
                  } else {
                    $draw_found = 0;
                  }
                }
                $abc = array(
                  '0' => 'success fas fa-check',
                  '1' => 'success fas fa-check-double',
                  '2' => 'primary fas fa-pen-alt',
                  '3' => 'purple fas fa-scroll',
                  '4' => 'pink fas fa-expand-arrows-alt',
                  '5' => 'blue fas fa-signature'
                );


                foreach ($Type_question as $color => $row) {
                  $Type_questionID   = $row->ID;
                  $Type_question_Name = $row->Name;
                  if ($Type_questionID != $Type_question_ID) {
                    if (($draw_found == 0) || ($draw_found == 1) && ($Type_questionID != 8)) {
                ?>
                      <a href="<?php echo site_url('emp/exam_new/ques_type/' . $rowlevelid  . "/" . $type . "/" . $test_id . "/" . $Type_questionID); ?>" class="<?php echo $abc[$color]; ?>"><?php echo $Type_question_Name; ?></a>
                <?php }
                  }
                } ?>


              </div>
            </div>
          </div>
          <input type="hidden" id="rowlevelid" name="rowlevelid" value="<?= $rowlevelid; ?>" />
          <input type="hidden" id="subjectid" name="subjectid" value="<?= $subjectid; ?>" />
          <input type="hidden" id="type" name="type" value="<?= $type; ?>" />
          <input type="hidden" id="Type_question_ID" name="Type_question_ID" value="<?= $Type_question_ID; ?>" />

          <div class="exam-box__text-area">
            <div id="editor" class="ql-container" dir="auto">
              <div class="ql-editor" data-gramm="false" contenteditable="true">
                <p><?php echo $answers[0]->Question; ?></p>
              </div>
              <div class="ql-clipboard" contenteditable="true" tabindex="-1"></div>
            </div>
            <?php if ($Type_question_ID == 4 && (!$question_id)) { ?>
              <button type="button" onclick="insertAnswerSpace()" class="btn btn-icon fas fa-bring-front"><?=lang('add_space');?></button>
            <?php } ?>
          </div>
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
          </script>

          <script>
            function resetFile() {
              //	document.getElementById('fileUpload').value= null;
              $("#hidImg").val('');
            }

            function resetFile2() {

              $(document).on("click", ".remove", function() {
                $(this).parent(".parent-span").remove();


                $("#hidImg").val('');
                $("#img_ed").val('');
              });
            }
          </script>

          <div class="exam__files">

            <div style="width: fit-content; width: 330px !important;" data-text="<?php echo lang('am_attach'); ?>">
              <label for="" class="mb10 strong-weight"><?php echo lang('am_attach'); ?></label>
              <input type="file" id="fileUpload">
              <input name="hidImg" id="hidImg" type="hidden" value="<?php echo $answers[0]->Q_attach; ?>" />
              <a class="btn green-bg" style="display: none" id="uploadButton">حفظ الملف</a>
              <span id="saveing" style="display: none" class="badge blue-bg">جاري رفع الملف يرجى الانتظار .....</span>
              <span id="saved" style="display: none" class="badge green-bg">تم حفظ الملف بنجاح .</span>
            </div>
            <div id="preview" class="my-3 "></div>

            <!--<?php //if($answers[0]->Q_attach){
                ?>-->
            <?php if (($answers[0]->Q_attach)) { ?>
              <span class="parent-span" style="position: relative">
                <?
                $ext = pathinfo(($answers[0]->Q_attach), PATHINFO_EXTENSION);
                if ($ext == 'xlsx' || $ext == 'xls') {
                ?>
                  <iframe src='https://view.officeapps.live.com/op/embed.aspx?src=<?php echo base_url() ?>assets/exam/<?php echo ($answers[0]->Q_attach); ?>' width="300px" height="300px"></iframe>

                <?php
                } elseif ($ext == 'pdf' || $ext == 'txt') { ?>
                  <a href="<?php echo base_url() ?>assets/exam/<?php echo ($answers[0]->Q_attach); ?>" style="margin-right: 99px;"><?php echo lang('am_attach'); ?></a>

                <? } else {
                ?>
                  <img id="img_ed" height="150px" src="<?php echo base_url() ?>assets/exam/<?php echo $answers[0]->Q_attach; ?>" style="height: 150px !important"/>
                <?php } ?>
                <br /><a class="remove fas fa-trash-alt danger-color" style="color: red;position: absolute;top: 40px;left: -30px;font-size: 20px;cursor:pointer" onclick="return resetFile2()"></a>

              </span>
            <?php } ?>
            <div <?php if ($this->session->userdata('language') == 'english') { ?> style="margin-left: 222px;" <?php } else { ?> style="margin-right: 222px;" <?php } ?>>
              <label class="control-radio" style="font-size: large;">
                <?php echo lang('Degree'); ?>
                <?  if($AbleDegree){?><div class="hint danger"><?=lang('AvailableMarks');?>: <?=$AbleDegree?></div><?}?>
                <input type="number" name="txt_Degree" value="<?php if (!$question_id) {
                                                                echo 0.5;
                                                              } else {
                                                                echo $answers[0]->Degree;
                                                              } ?>" min="0.5" style="float:none;clear:both;width: -webkit-fill-available;" id="txt_Degree" step="0.5"  max="<?php  $AbleDegree ? $AbleDegree:20 ?>" required>
              </label>
           
            </div>
          </div>
          <?php if ($Type_question_ID == 2) { ?>
            <div class="exam-box__multi-choices">
              <?php if (!$question_id) { ?>
                <div class="choice">
                  <input type="checkbox" class="radio-choice" onchange="radioUnchoice(event)" name="slct_Correct_Answer[1]" id="slct_Correct_Answer1" value="1" />
                  <div id="choice1" onchange="setDirection(this)" class="ql-container" dir="auto"></div>
                  <div class="choice__action">
                    <button type="button" class="editor-image">
                      <input type="file" id="fileUpload_new" onchange="uploadImage(this)" data-id="1" />
                      <input name="hidImg1" id="hidImg1" type="hidden" value="" />
                      <i class="fas fa-image"></i>
                    </button>
                    <button onclick=" return removeChoice(this)" data-id="1">
                      <i class="fas fa-trash"></i>
                    </button>
                    <button class="card-toolbar__btn" data-id="choice1_toolbar" onclick="showCardToolbar(this)" type="button">
                      <i class="fas fa-font"></i>
                    </button>
                    <div class="equation-toolbar" style="display: none"></div>
                    <!-- choice hidden toolbar -->
                    <div id="choice1_toolbar" class="card-toolbar collapsed">
                      <button type="button" class="card-toolbar__color">
                        <input type="color" class="ql-color" />
                      </button>
                      <button type="button" class="ql-bold">
                        <i class="fas fa-bold"></i>
                      </button>
                      <button type="button" class="ql-italic">
                        <i class="fas fa-italic"></i>
                      </button>
                      <button type="button" class="ql-underline">
                        <i class="fas fa-underline"></i>
                      </button>
                      <button type="button" class="ql-strike">
                        <i class="fas fa-strikethrough"></i>
                      </button>
                      <button type="button" class="ql-script" value="sub">
                        <i class="fas fa-subscript"></i>
                      </button>
                      <button type="button" class="ql-script" value="super">
                        <i class="fas fa-superscript"></i>
                      </button>
                      <button type="button" class="ql-link" type="button">
                        <i class="fas fa-link"></i>
                      </button>
                      <button type="button" type="button" class="equation-btn">
                        <i class="fas fa-function"></i>
                      </button>
                    </div>
                  </div>
                </div>
              <?php } else { ?>
                <?php
                foreach ($answers as $key => $ans) {
                  $num              = $key + 1;
                  $answers_ID       = $ans->answers_ID;
                  $Answer           = $ans->Answer;
                  $Answer_correct   = $ans->Answer_correct;
                ?>
                  <div class="choice">
                    <input type="checkbox"  class="radio-choice" onchange="radioUnchoice(event)" class="slct_Correct_Answer" name="slct_Correct_Answer[<?= $num; ?>]" <?php if ($Answer_correct == 1) { ?>checked <?php } ?> id="slct_Correct_Answer<?= $num; ?>" value="<?php echo $Answer_correct; ?>">
                    <input type="hidden" name="slct_count_Answer" class="slct_count_Answer" value="<?php echo $num; ?>">
                    <!--<input type="hidden" name="choice_count" id="choice_count" value="<?php echo $num; ?>">-->
                    <div id="choice<?= $num; ?>" class="ql-container" onchange="setDirection(this)" dir="auto">
                      <div class="ql-editor" data-gramm="false" contenteditable="true">
                        <p><?php if (file_exists('./assets/exam/' . $Answer) && $Answer != "") { ?><img src="<?php echo base_url() ?>assets/exam/<?php echo $Answer; ?>" /><?php } else {
                                                                                                                                                                            echo $Answer;
                                                                                                                                                                          } ?></p>
                      </div>
                    </div>
                    <div class="ql-clipboard" contenteditable="true" tabindex="-1"></div>
                    <div class="choice__action">
                      <button class="editor-image">
                        <input type="file" id="fileUpload_new" onchange="uploadImage(this)" data-id="<?= $num; ?>" />
                        <input name="hidImg<?= $num; ?>" id="hidImg<?= $num; ?>" type="hidden" value="<?php if (file_exists('./assets/exam/' . $Answer) && $Answer != "") {
                                                                                                        echo $Answer;
                                                                                                      } ?>" />
                        <i class="fas fa-image"></i>
                      </button>
                      <button onclick=" return removeChoice(this)" data-id="<?= $num; ?>">
                        <i class="fas fa-trash"></i>
                      </button>
                      <button class="card-toolbar__btn" data-id="choice<?= $num; ?>_toolbar" onclick="showCardToolbar(this)" type="button">
                        <i class="fas fa-font"></i>
                      </button>
                      <div class="equation-toolbar" style="display: none"></div>
                      <!-- choice hidden toolbar -->
                      <div id="choice<?= $num; ?>_toolbar" class="card-toolbar collapsed">
                        <button type="button" class="card-toolbar__color">
                          <input type="color" class="ql-color" />
                        </button>
                        <button type="button" class="ql-bold">
                          <i class="fas fa-bold"></i>
                        </button>
                        <button type="button" class="ql-italic">
                          <i class="fas fa-italic"></i>
                        </button>
                        <button type="button" class="ql-underline">
                          <i class="fas fa-underline"></i>
                        </button>
                        <button type="button" class="ql-strike">
                          <i class="fas fa-strikethrough"></i>
                        </button>
                        <button type="button" class="ql-script" value="sub">
                          <i class="fas fa-subscript"></i>
                        </button>
                        <button type="button" class="ql-script" value="super">
                          <i class="fas fa-superscript"></i>
                        </button>
                        <button type="button" class="ql-link" type="button">
                          <i class="fas fa-link"></i>
                        </button>
                        <button type="button" type="button" class="equation-btn">
                          <i class="fas fa-function"></i>
                        </button>
                      </div>
                    </div>
                  </div>

              <?php }
              } ?>
              <input type="hidden" id="for_count_choice" name="for_count_choice" value="<?php echo $num; ?>">
              <button class="add-choice fas fa-plus" id="insertChoice" type="button"> <?php echo lang("am_add_answer") ?></button>
            </div>

          <?php } elseif ($Type_question_ID == 3) { ?>

            <div>
              <a type="button" <?php if ($answers[0]->Answer_correct == 1 || !$question_id) { ?>class="btn default" <?php } else { ?> class="btn default" <?php } ?> id="right_answer"><?php echo lang("right_answer"); ?></a>
              <a type="button" <?php if ($answers[1]->Answer_correct == 1) { ?>class="btn danger" <?php } else { ?> class="btn default" <?php } ?> id="wrong_answer"><?php echo lang("wrong_answer"); ?></a>
              <input type="hidden" name="true_txt" id="true_txt" value="<?php if (!$question_id) {
                                                                          echo 0;
                                                                        } else {
                                                                          echo $answers[0]->Answer_correct;
                                                                        } ?>" />
              <input type="hidden" name="false_txt" id="false_txt" value="<?php if (!$question_id) {
                                                                            echo 0;
                                                                          } else {
                                                                            echo $answers[1]->Answer_correct;
                                                                          } ?>" />
            </div>
          <?php } elseif ($Type_question_ID == 4) { ?>
            <label class="control-radio" style="font-size: large; color:red"><?php echo lang('am_notes') . " :  " . lang('complete_answer_format1'); ?></label>
            <div class="answers">
              <?php if (!$question_id) { ?>
                <div class="answers__container complete1">
                  <div class="form-repeater">
                    <div class="repeater-item">
                      <button class="add-item btn-icon fas fa-plus" style="display:none;"><?php echo lang("am_add_answer") ?></button>
                      <div class="controls-wrap">
                        <div class="answer">
                          <input type="text" name="txt_answer[]" id="txt_answer" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- success model -->
              <?php } else { ?>
                <div class="answers__container complete2">
                  <div class="form-repeater">
                    <div class="repeater-item">
                      <button class="add-item btn-icon fas fa-plus"><?php echo lang("am_add_answer") ?></button>
                      <?php

                      foreach ($answers as $key => $ans) {
                        $answers_ID       = $ans->answers_ID;
                        $Answer           = $ans->Answer;
                        $Answer_correct   = $ans->Answer_correct;
                      ?>
                        <div class="controls-wrap">
                          <div class="answer">
                            <input type="text" name="txt_answer[]" value="<?php echo $Answer; ?>" />
                          </div>
                        </div>
                    </div>
                  <?php } ?>
                  </div>
                </div>

              <?php } ?>
            </div>

          <?php }  elseif ($Type_question_ID == 7) { ?>
            <div class="match-items">
              <?php if (!$question_id) { ?>
                <div class="row">
                  <div class="col-6" id="match-base">
                    <label><?php echo lang('am_qus'); ?></label>
                    <div class="match-item">
                      <div id="base1" class="ql-container"></div>
                      <div class="match-item__action">
                        <button class="editor-image" style="display:none">
                          <input type="file" onchange="uploadImage_match(this)" data-id="1" data-type="base" />
                          <input name="hidImg_base_1" id="hidImg_base_1" type="hidden" value="" />
                          <i class="fas fa-image"></i>
                        </button>
                        <button onclick="removeMatchChoice(this)" data-id="base1" data-type="base">
                          <i class="fas fa-trash"></i>
                        </button>
                        <button class="card-toolbar__btn" data-id="base1_toolbar" onclick="showCardToolbar(this)" >
                          <i class="fas fa-font"></i>
                        </button>
                        <div class="equation-toolbar" style="display: none"></div>
                        <div id="base1_toolbar" class="card-toolbar collapsed">
                          <button type="button" class="card-toolbar__color">
                            <input type="color" class="ql-color" />
                          </button>
                          <button type="button" class="ql-bold">
                            <i class="fas fa-bold"></i>
                          </button>
                          <button type="button" class="ql-italic">
                            <i class="fas fa-italic"></i>
                          </button>
                          <button type="button" class="ql-underline">
                            <i class="fas fa-underline"></i>
                          </button>
                          <button type="button" class="ql-strike">
                            <i class="fas fa-strikethrough"></i>
                          </button>
                          <button type="button" class="ql-script" value="sub">
                            <i class="fas fa-subscript"></i>
                          </button>
                          <button type="button" class="ql-script" value="super">
                            <i class="fas fa-superscript"></i>
                          </button>
                          <button type="button" class="ql-link" type="button">
                            <i class="fas fa-link"></i>
                          </button>
                          <button type="button" type="button" class="equation-btn">
                            <i class="fas fa-function"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-6" id="match-opp">
                    <label><?php echo lang('answer'); ?> </label>
                    <div class="match-item">
                      <div id="opp1" class="ql-container"></div>
                      <div class="match-item__action">
                        <button class="editor-image" style="display:none">
                          <input type="file" onchange="uploadImage_match(this)" data-id="1" data-type="opp" />
                          <input name="hidImg_opp_1" id="hidImg_opp_1" type="hidden" value="" />
                          <i class="fas fa-image"></i>
                        </button>
                        <button onclick="removeMatchChoice(this)" data-id="opp1" data-type="opp">
                          <i class="fas fa-trash"></i>
                        </button>
                        <button class="card-toolbar__btn" data-id="opp1_toolbar" onclick="showCardToolbar(this)" >
                          <i class="fas fa-font"></i>
                        </button>
                        <div class="equation-toolbar" style="display: none"></div>
                        <div id="opp1_toolbar" class="card-toolbar collapsed">
                          <button type="button" class="card-toolbar__color">
                            <input type="color" class="ql-color" />
                          </button>
                          <button type="button" class="ql-bold">
                            <i class="fas fa-bold"></i>
                          </button>
                          <button type="button" class="ql-italic">
                            <i class="fas fa-italic"></i>
                          </button>
                          <button type="button" class="ql-underline">
                            <i class="fas fa-underline"></i>
                          </button>
                          <button type="button" class="ql-strike">
                            <i class="fas fa-strikethrough"></i>
                          </button>
                          <button type="button" class="ql-script" value="sub">
                            <i class="fas fa-subscript"></i>
                          </button>
                          <button type="button" class="ql-script" value="super">
                            <i class="fas fa-superscript"></i>
                          </button>
                          <button type="button" class="ql-link" type="button">
                            <i class="fas fa-link"></i>
                          </button>
                          <button type="button" type="button" class="equation-btn">
                            <i class="fas fa-function"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } else { ?>

                <div class="row">
                  <div class="col-6" id="match-base">
                    <label><?php echo lang('am_qus'); ?></label>
                    <?php
                    foreach ($answers as $key => $ans) {
                      $n                = $key + 1;
                      $answers_ID       = $ans->answers_ID;
                      $Answer           = $ans->Answer;
                      $Answer_match     = $ans->Answer_match;
                      $Answer_correct   = $ans->Answer_correct;
                    ?>
                    <div class="match-item">
                      <div id="base<?=$n;?>"><?=$Answer_match?></div>
                      <div class="match-item__action">
                        <button class="editor-image" style="display:none">
                          <input type="file" onchange="uploadImage_match(this)" data-id="1" data-type="base" />
                          <input name="hidImg_base_1" id="hidImg_base_1" type="hidden" value="" />
                          <i class="fas fa-image"></i>
                        </button>
                        <button onclick="removeMatchChoice(this)" data-id="base<?=$n;?>" data-type="base">
                          <i class="fas fa-trash"></i>
                        </button>
                        <button class="card-toolbar__btn" data-id="base<?=$n;?>_toolbar" onclick="showCardToolbar(this)" >
                          <i class="fas fa-font"></i>
                        </button>
                        <div class="equation-toolbar" style="display: none"></div>
                        <div id="base<?=$n;?>_toolbar" class="card-toolbar collapsed">
                          <button type="button" class="card-toolbar__color">
                            <input type="color" class="ql-color" />
                          </button>
                          <button type="button" class="ql-bold">
                            <i class="fas fa-bold"></i>
                          </button>
                          <button type="button" class="ql-italic">
                            <i class="fas fa-italic"></i>
                          </button>
                          <button type="button" class="ql-underline">
                            <i class="fas fa-underline"></i>
                          </button>
                          <button type="button" class="ql-strike">
                            <i class="fas fa-strikethrough"></i>
                          </button>
                          <button type="button" class="ql-script" value="sub">
                            <i class="fas fa-subscript"></i>
                          </button>
                          <button type="button" class="ql-script" value="super">
                            <i class="fas fa-superscript"></i>
                          </button>
                          <button type="button" class="ql-link" type="button">
                            <i class="fas fa-link"></i>
                          </button>
                          <button type="button" type="button" class="equation-btn">
                            <i class="fas fa-function"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                    <?php } ?>
                  </div>
                  <div class="col-6" id="match-opp">
                    <label><?php echo lang('answer'); ?> </label>
                    <?php
                    foreach ($answers as $key => $ans) {
                      $n                = $key + 1;
                      $answers_ID       = $ans->answers_ID;
                      $Answer           = $ans->Answer;
                      $Answer_match     = $ans->Answer_match;
                      $Answer_correct   = $ans->Answer_correct;
                    ?>
                       <div class="match-item">
                      <div id="opp<?=$n;?>"><?=$Answer?></div>
                      <div class="match-item__action">
                        <button class="editor-image" style="display:none">
                          <input type="file" onchange="uploadImage_match(this)" data-id="1" data-type="opp" />
                          <input name="hidImg_opp_1" id="hidImg_opp_1" type="hidden" value="" />
                          <i class="fas fa-image"></i>
                        </button>
                        <button onclick="removeMatchChoice(this)" data-id="opp<?=$n;?>" data-type="opp">
                          <i class="fas fa-trash"></i>
                        </button>
                        <button class="card-toolbar__btn" data-id="opp<?=$n;?>_toolbar" onclick="showCardToolbar(this)" >
                          <i class="fas fa-font"></i>
                        </button>
                        <div class="equation-toolbar" style="display: none"></div>
                        <div id="opp<?=$n;?>_toolbar" class="card-toolbar collapsed">
                          <button type="button" class="card-toolbar__color">
                            <input type="color" class="ql-color" />
                          </button>
                          <button type="button" class="ql-bold">
                            <i class="fas fa-bold"></i>
                          </button>
                          <button type="button" class="ql-italic">
                            <i class="fas fa-italic"></i>
                          </button>
                          <button type="button" class="ql-underline">
                            <i class="fas fa-underline"></i>
                          </button>
                          <button type="button" class="ql-strike">
                            <i class="fas fa-strikethrough"></i>
                          </button>
                          <button type="button" class="ql-script" value="sub">
                            <i class="fas fa-subscript"></i>
                          </button>
                          <button type="button" class="ql-script" value="super">
                            <i class="fas fa-superscript"></i>
                          </button>
                          <button type="button" class="ql-link" type="button">
                            <i class="fas fa-link"></i>
                          </button>
                          <button type="button" type="button" class="equation-btn">
                            <i class="fas fa-function"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                    <?php } ?>
                  </div>
                </div>
                <input type="hidden" id="for_count" name="for_count" value="<?php echo $n; ?>">
              <?php } ?>

              <button type="button" class="add-row btn outline btn-icon fas fa-plus" onclick="insertMatchRow()"><?php echo lang("am_add_answer") ?> </button>
            </div>
            <div class="match-hint fas fa-info-circle">
              <?php echo lang("match_hint"); ?>
            </div>
          <?php } elseif  ($Type_question_ID == 8) { ?>
            <div class="drawer">
              <div class="drawer__header">
                <div class="drawer__toolbar flexbox align-between">
                  <div>
                    <a class="item item-image-btn far fa-image">
                      <?php echo lang("image"); ?>
                      <input type="file" name="draw-image" />
                    </a>
                    <a href="#" class="item item-blank-btn far fa-rectangle-landscape"> <?php echo lang("emptiness"); ?></a>
                    <!--<a href="#" class="item item-graph-btn fas fa-analytics"><?php echo lang("Graph"); ?></a>-->
                  </div>
                  <div class="flexbox">
                    <a href="#" id="pen" class="item fas fa-pencil"> </a>
                    <a href="#" id="clear" class="item fas fa-trash"> </a>
                    <div class="item">
                      <input id="color" type="color" class="item" />
                    </div>
                    <a href="#" id="eraser" class="item fas fa-eraser"> </a>
                    <a href="#" id="redo" class="item fas fa-redo"> </a>
                    <a href="#" id="undo" class="item fas fa-undo"> </a>
                  </div>
                </div>
              </div>
              <div class="drawer__body" id="drawer">
                <div id="tui-image-editor"></div>
                <!--<div class="cursor"></div> -->
                <div class="drawer__placeholder">
                  <?php echo lang("draw_hint"); ?>
                </div>
                <a href="#" class="btn primary outline" id="try_blank"> <?php echo lang("try_yourself"); ?> </a>
              </div>
            </div>
          <?php } ?>
          <div class="form-action">
            <?php if ($question_id) { ?>
              <button type="submit" id="submitBtn" class="btn outline success"><?php echo lang("br_save_edit"); ?></button>
            <?php } else { ?>
              <button type="submit"  id="submitBtn" class="btn outline success"><?php echo lang("am_save"); ?></button>
            <?php } ?>
            <a type="button" href="<?php echo site_url('emp/exam_new/create_exam/' . $rowlevelid . "/" . $subjectid . "/" . $type . "/" . $test_id); ?>" class="btn outline danger"><?php echo lang("cancel"); ?></a>
          </div>
          <!-- //form .actions -->
         
        </form>
      </main>
      <!-- exam box  -->
    </div>
  </div>
</div>

<script>
  <?php if (!$question_id) { ?>
    var quill = new Quill("#editor", {
      modules: {
        toolbar: "#toolbar",
        
      },
      placeholder: "<?php echo lang('Write_question'); ?>  ",
      direction: "auto",
    });
    var choice1 = new Quill("#choice1", {
      modules: {
        toolbar: "#choice1_toolbar",
      },
      placeholder: "<?php echo lang('Write_answer'); ?>  ",
    });
    const spaces = [];
    const addItemBtn = document.querySelector(".add-item");

    function insertAnswerSpace() {
      let selection = quill.getSelection(true);
      quill.insertText(selection, " ***** ");
      const result = spaces.length;
      const space = {
        from: selection.index,
        to: selection.index + 7,
      };
      spaces.push(space);
      addItemBtn.click();
      const repeaterItems = document.querySelectorAll(".repeater-item");
      const repeaterItem = repeaterItems[repeaterItems.length - 1];
      repeaterItem.setAttribute("data-from", "from-" + space.from);
      const removeButton = repeaterItem.querySelector(".remove-item");
      removeButton.addEventListener("click", (e) => {
        quill.deleteText(space.from, 7);
      });
    }
    quill.on("text-change", function(delta, oldDelta, source) {
      if (delta.ops[1] && delta.ops[1].delete) {
        spaces.forEach(({
          from,
          to
        }, i) => {
          if (delta.ops[0].retain > from && delta.ops[0].retain < to) {
            quill.deleteText(from, 7);
            spaces.splice(i, 1);
            const resultItem = document.querySelector(
              '[data-from="from-' + from + '"]'
            );
            resultItem.querySelector(".remove-item").click();
          }
        });
      } else if (delta.ops[0].delete) {
        spaces.length = 0;
        document
          .querySelectorAll(".remove-item")
          .forEach((item) => item.click());
      }
    });
    // question type dropdown
    let dropdownBtn = document.getElementById("question_type_dropbtn");
    dropdownBtn.addEventListener("click", dropdown);

    function dropdown(e) {
      e.preventDefault();
      document.getElementById("myDropdown").classList.toggle("show");
    }

    var choicesEditors = [choice1];
    var counter = choicesEditors.length + 1;

    var base1 = new Quill("#base1", {
      modules: {
        toolbar: "#base1_toolbar",
      },
      placeholder: " <?php echo lang('Write_question'); ?>",
      direction: "auto",
    });

    var opp1 = new Quill("#opp1", {
      modules: {
        toolbar: "#opp1_toolbar",
      },
      placeholder: "<?php echo lang('Write_answer'); ?>  ",
      direction:         "auto",
    });
  <?php } else if ($Type_question_ID == 2) {
    $cn = count($answers); ?>
    var cn = <?php echo $cn ?>;
    var quill = new Quill("#editor", {
      modules: {
        toolbar: "#toolbar",
      },
      placeholder: "<?php echo lang('Write_question'); ?>  ",
      
      direction: "auto",
    });
    var choicesEditors = [];
    for (var b = 1; b <= cn; b++) {
      var choice = "choice" + b;
      choice = new Quill(("#choice" + b), {
        modules: {
          toolbar: "#toolbar"+ b+"_toolbar",
        },
        placeholder: "<?php echo lang('Write_answer'); ?>  ",
        dir:         "auto",
      });

      choicesEditors.push(choice);
    }

    const spaces = [];
    const addItemBtn = document.querySelector(".add-item");

    function insertAnswerSpace() {
      let selection = quill.getSelection(true);
      quill.insertText(selection, " ***** ");
      const result = spaces.length;
      const space = {
        from: selection.index,
        to: selection.index + 7,
      };
      spaces.push(space);
      addItemBtn.click();
      const repeaterItems = document.querySelectorAll(".repeater-item");
      const repeaterItem = repeaterItems[repeaterItems.length - 1];
      repeaterItem.setAttribute("data-from", "from-" + space.from);
      const removeButton = repeaterItem.querySelector(".remove-item");
      removeButton.addEventListener("click", (e) => {
        quill.deleteText(space.from, 7);
      });
    }
    quill.on("text-change", function(delta, oldDelta, source) {
      if (delta.ops[1] && delta.ops[1].delete) {
        spaces.forEach(({
          from,
          to
        }, i) => {
          if (delta.ops[0].retain > from && delta.ops[0].retain < to) {
            quill.deleteText(from, 7);
            spaces.splice(i, 1);
            const resultItem = document.querySelector(
              '[data-from="from-' + from + '"]'
            );
            resultItem.querySelector(".remove-item").click();
          }
        });
      } else if (delta.ops[0].delete) {
        spaces.length = 0;
        document
          .querySelectorAll(".remove-item")
          .forEach((item) => item.click());
      }
    });
    // question type dropdown
    let dropdownBtn = document.getElementById("question_type_dropbtn");
    dropdownBtn.addEventListener("click", dropdown);

    function dropdown(e) {
      e.preventDefault();
      document.getElementById("myDropdown").classList.toggle("show");
    }

    var counter = choicesEditors.length + 1;

    var base1 = new Quill("#base1", {
      modules: {
        toolbar: "#base1_toolbar",
      },
      placeholder: " <?php echo lang('Write_question'); ?>",
      direction: "auto",
    });

    var opp1 = new Quill("#opp1", {
      modules: {
        toolbar: "#opp1_toolbar",
      },
      placeholder: "<?php echo lang('Write_answer'); ?>  ",
      direction: "auto",
    });
  <?php } else if ($Type_question_ID == 4) { ?>

    var quill = new Quill("#editor", {
      modules: {
        toolbar: "#toolbar",
      },
      placeholder: "<?php echo lang('Write_question'); ?>  ",
      direction: "auto",
    });
    quill.enable(false);
  <?php } else { ?>
    var quill = new Quill("#editor", {
      modules: {
        toolbar: "#toolbar",
      },
      placeholder: "<?php echo lang('Write_question'); ?>  ",
      direction: "auto",
    });

  <?php } ?>
</script>
<script>
  $(document).ready(function() {
    $("#loadingDiv").hide();
    $("#saveing").hide();
    $("#saved").hide();
    $('#uploadButton').hide();
    $("#fileUpload").change(function(e) {
      var Type_question_ID = $('#Type_question_ID').val();
      
      if (Type_question_ID == 6) {
        var files = 'jpe?g|png|gif|pdf';
        var alert_text = 'الملف الذي تم اختياره ليس صورة صالحة. الصيغ المدعومة هي: JPEG، PNG، أو GIF ، PDF';
      } else {
        var files = 'jpe?g|png|gif';
        var alert_text = 'الملف الذي تم اختياره ليس صورة صالحة. الصيغ المدعومة هي: JPEG، PNG، أو GIF';
      }

      if (!new RegExp('\\.(' + files + ')$', 'i').test($('#fileUpload')[0].files[0].name)) {
        Swal.fire({
          icon: 'error',
          title: 'خطأ',
          text: alert_text,
        });
        return;
      }
      if ($('#fileUpload')[0].files[0].size > 200 * 1024 * 1024) {
        $("#loadingDiv").hide();
        $('#uploadButton').hide();
        $("#submitBtn").prop("disabled", true);

        Swal.fire({
          icon: 'error',
          title: 'خطأ!',
          text: 'حجم الملف يجب أن يكون أقل من 200 ميجابايت.',
        });
        $("#saveing").hide();
        $('#uploadButton').hide();

        return;
      }
      $('#uploadButton').show();
    });
    $("#uploadButton").click(function() {
           $("#saved").hide();
            $("#saveing").show();
            $("#submitBtn").prop("disabled", true);
            $('#uploadButton').hide();

      var xhr = new XMLHttpRequest();
      var data = new FormData();
      jQuery.each($('#fileUpload')[0].files, function(i, file) {
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
          $("#saveing").hide();
                    $("#saved").show();
                    $("#submitBtn").prop("disabled", false);
                    $("#saveing").hide();
                    $("#saved").show();
                    $("#submitBtn").prop("disabled", false);

          $("#loadingDiv").hide();
          if (data.msg_type == 0) {
            $("#msgUpload").html(data.msg_upload);
          } else if (data.msg_type == 1) {
            var newImg = data.base + 'upload/' + data.img;
            var hidImg = $("#hidImg").val(data.img);
            $("#div_img").append('<div id="imgcon"><a href="' + newImg + '" ><?php echo lang('am_download'); ?></a><button class="uploadclose" onClick="delImgUp();">X</button></div>');
          }
        }
      });

    })
  });



  function delImgUp() {
    $("#imgcon").remove()
  }

  function uploadImage(inputFile) {

    $("#loadingDiv").show();
    const choiceNumber = inputFile.getAttribute("data-id");
    const file = inputFile.files[0];
    var data = new FormData();
    data.append('file', file);

    $.ajax({
      url: '<?php echo site_url('emp/exam_new/up_ax') ?>',
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      type: 'POST',
      success: function(data) {

        $("#loadingDiv").hide();
        if (data.msg_type == 0) {
          $("#msgUpload").html(data.msg_upload);
        } else if (data.msg_type == 1) {
          let editor = document.getElementById(`choice${choiceNumber}`).parentElement;
          let target = editor.querySelector(".ql-editor");
          const contentAsArray = target.querySelectorAll(`p`);
          contentAsArray.forEach(content => content?.remove());
          $('#hidImg' + choiceNumber).val(data.img);
          insertChoiceImage(inputFile);
          target.removeAttribute("contenteditable");
        }
      }
    });
  }

  function uploadImage_match(inputFile) {

    $("#loadingDiv").show();
    const choiceNumber = inputFile.getAttribute("data-id");
    const choiceType = inputFile.getAttribute("data-type");
    const file = inputFile.files[0];
    var data = new FormData();
    data.append('file', file);

    $.ajax({
      url: '<?php echo site_url('emp/exam_new/up_ax') ?>',
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      type: 'POST',
      success: function(data) {

        $("#loadingDiv").hide();
        if (data.msg_type == 0) {
          $("#msgUpload").html(data.msg_upload);
        } else if (data.msg_type == 1) {

          $('#hidImg_' + choiceType + '_' + choiceNumber).val(data.img);
          insertChoiceImage(inputFile);
        }
      }
    });
  }
  /* $('#fileUpload_new').change(function(e) {
                  $("#loadingDiv").show();
					var xhr    = new XMLHttpRequest();
					var data   = new FormData();
					jQuery.each($('#fileUpload_new')[0].files, function(i, file) {data.append('file', file);});
								$.ajax({
										url: '<?php echo site_url('emp/exam_new/up_ax') ?>',
										data: data,
										cache: false,
										contentType: false,
										processData: false,
										type: 'POST',
										beforeSend : function()
										{
											
										},  
										success: function(data){
											$("#loadingDiv").hide();
											if(data.msg_type == 0 )
											{
											   $("#msgUpload").html(data.msg_upload) ;
											}
											else if(data.msg_type == 1 )
											{
												var newImg = data.base+'upload/'+data.img;
												
												var choice_count    = $('#choice_count').val();
												if(choice_count){
												    var x=choice_count;
												}else{
												    var x=1;
												}
												var hidImg       = $('#hidImg'+choice_count).val(data.img);
												
												$( "#div_img" ).append('<div id="imgcon"><a href="'+newImg+'" ><?php echo lang('am_download'); ?></a><button class="uploadclose" onClick="delImgUp();">X</button></div>');
											}
										}
						});
                });
        */
  $("#my_form").on("submit", function() {
    var max = 0
    var $form = $(this);

    $(".slct_count_Answer").each(function() {
      if ($(this).val() > max) {
        max = $(this).val()
      };
    });
    var hvalue = quill.root.innerHTML;
    var js_count_match = $('#counter').val();
    var for_count_match = $('#for_count').val();
    var js_count_choice = $('#choice_count').val();
    var for_count_choice = $('#for_count_choice').val();
    var Type_question_ID = $('#Type_question_ID').val();
    var false_txt = $('#false_txt').val();
    var true_txt = $('#true_txt').val();
    <?php if (!$question_id) { ?>
      $("input[name='txt_answer[]']").eq(0).remove();
    <?php } ?>
    var txt_answer = $("input[name='txt_answer[]'").map(function() {
      return $(this).val();
    }).get();
    var count_correct_answer = 0;
    // var space              = hvalue.match(/*****/).index;
    // var b = console.log(space);
    if (Type_question_ID == 3 && false_txt == 0 && true_txt == 0) {
      alert("<?php echo lang('cheack_choose_ques_answer'); ?>");
      return false;
    }
    if (hvalue && hvalue != "<p><br></p>") {
      if ((Type_question_ID == 2 && for_count_choice === undefined) || (Type_question_ID == 4 && (txt_answer[0] === undefined || txt_answer[0] == ""))) {
        if (Type_question_ID == 2) {
          alert("<?php echo lang('cheack_choose_ques'); ?>");
        }
        if (Type_question_ID == 4) {
          alert("<?php echo lang('cheack_choose_ques_answer'); ?>");
        }
        return false;
      } else {

        if (js_count_match) {
          var count_match = js_count_match;
        } else {
          var count_match = for_count_match;
        }
        if (Type_question_ID == 7 && count_match === undefined) {
          alert("<?php echo lang('cheack_choose_ques'); ?>");
          return false;
        }
        var i = 1;
        for (i = 1; i <= count_match + 1; i++) {
          var match_question = $('#base' + i).text();
          var match_answer = $('#opp' + i).text();
          var match_question_img = $('#hidImg_base_' + i).val();
          var match_answer_img = $('#hidImg_opp_' + i).val();
          if (Type_question_ID == 7 && ((match_question == "" && match_question_img == "") || (match_answer == "" && match_answer_img == ""))) {
            alert("<?php echo lang('cheack_choose_ques_answer'); ?>");
            return false;
          }
        }
      if(Type_question_ID == 7){
        for (let i = 1; i <= 10; i++) {
    if (baseEditors[i] && oppEditors[i]) {
        var match_question = baseEditors[i].root.innerHTML;
        var match_answer = oppEditors[i].root.innerHTML;
        // var match_question_img = $('#hidImg_base_' + i).val();
        // var match_answer_img = $('#hidImg_opp_' + i).val();
        let baseId = baseEditors[i].container.id;
        let oppId = oppEditors[i].container.id;
        var mybase = document.getElementById(baseId);
        var myopp = document.getElementById(oppId);

        if (mybase && myopp) {
            $(this).append("<textarea name='txt_match_answer[" + i + "]' style='display:none'>" + match_answer + "</textarea>");
            $(this).append("<textarea name='txt_match_question[" + i + "]' style='display:none'>" + match_question + "</textarea>");
            $(this).append("<textarea name='txt_question' style='display:none'>" + hvalue + "</textarea>");
        }
    }
}
      }
        if (js_count_choice) {
          count_choice = js_count_choice;
        } else {
          count_choice = for_count_choice;
        }
        let choices = document.querySelectorAll('.ql-editor');
        var j = 1;
        for (j = 1; j <= max; j++) {
          var hidImg = $('#hidImg' + j).val();
          var myElement = document.getElementById('slct_Correct_Answer' + j);
          if (myElement) {
            var slct_Correct_Answer = document.querySelector('#slct_Correct_Answer' + j).checked;
            if (slct_Correct_Answer == true) {
              correct_answer = 1;
            } else {
              correct_answer = 0;
            }
            count_correct_answer = correct_answer + count_correct_answer;
          } else {
            /// c_choice++;
          }
          if (j != max || (j == max && count_correct_answer > 1)) {
            var choice_answer = choicesEditors[j - 1].root.innerHTML;
            if (Type_question_ID == 2 && choice_answer == "<p><br></p>" && hidImg == "") {
              alert("<?php echo lang('cheack_choose_ques_answer'); ?>");
              return false;

            }

          }
        }
        if (Type_question_ID == 2 && count_correct_answer < 1) {
          alert("<?php echo lang('cheack_correct_answer'); ?>");
          return false;
        }
        var arg = 0;
        var j = 1;
        for (j = 1; j <= max; j++) {

          var choice_answer = choicesEditors[j - 1].root.innerHTML;
          var myElement = document.getElementById('slct_Correct_Answer' + j);
          if (myElement) {
            arg++;
            var slct_Correct_Answer = document.querySelector('#slct_Correct_Answer' + j).checked;
            if (slct_Correct_Answer == true) {                                    
              correct_answer = 1;
              $(this).append('<input type="hidden" name="slct_Correct_Answer1[' + j + ']" value="' + correct_answer + '">');
            } else {
              correct_answer = 0;
            }
            $(this).append("<textarea name='txt_multi_Choices[" + j + "]' style='display:none'>" + choice_answer + "</textarea>");
            $(this).append('<input type="hidden" name="correct_answer" value=' + correct_answer + '>');
            $(this).append('<input type="hidden" name="count_correct_answer" value=' + count_correct_answer + '>');
            $(this).append("<textarea name='txt_question' style='display:none'>" + hvalue + "</textarea>");

          } else {
            //  c_choice++;
          }
        }



      }
      $(this).append("<textarea name='txt_question' style='display:none'>" + hvalue + "</textarea>");
      $form.find(":submit").attr("disabled", true);

    } else {
      alert("<?php echo lang('should_write_question'); ?>");
      return false;
    }
  });
</script>
<script>
  /*========================================== question correct*/
  $("#wrong_answer").click(function(e) {

    if (!$("#wrong_answer").hasClass('btn danger')) {

      $("#wrong_answer").removeClass('btn default');

      $("#wrong_answer").addClass('btn danger');

      $("#right_answer").removeClass('btn info');

      $("#right_answer").addClass('btn default');

      $("#false_txt").val(1);

      $("#true_txt").val(0);

    }

  });

  $("#right_answer").click(function(e) {

    if (!$("#right_answer").hasClass('btn info')) {

      $("#right_answer").removeClass('btn default');

      $("#right_answer").addClass('btn info');

      $("#wrong_answer").removeClass('btn danger');

      $("#wrong_answer").addClass('btn default');

      $("#false_txt").val(0);

      $("#true_txt").val(1);

    }

  });
</script>
<script>
  function previewImages() {

    var $preview = $('#preview').empty();
    if (this.files) $.each(this.files, readAndPreview);

    function readAndPreview(i, file) {


      var reader = new FileReader();

      $(reader).on("load", function(e) {
        $preview.append(`<span class="parent-span">
                <img class="imageThumb" src="` + e.target.result + `" title="` + file.name + `" style="height: 150px;width: 327px;"/>
                <br/><i class="remove fas fa-trash-alt danger-color" style="color: red;margin-right: 128px;" ></i>
                </span>`);
      });

      reader.readAsDataURL(file);

      $(document).on("click", ".remove", function() {
        $(this).parent(".parent-span").remove();
        document.getElementById('fileUpload').value = null;
        $("#hidImg").val('');
      });

    }


  }
</script>
<script>
  function removeMatchChoice(e) {
    let id = e.getAttribute("data-id");
    let type = e.getAttribute("data-type");
    if (eval(`${type}Editors`).length > 2) {
      let index = eval(`${type}Editors`).find((e) => e.container.id == id);
      eval(`${type}Editors`).splice(index, 1);
      document.getElementById(id).parentElement.remove();
    }
  }
</script>
<script>
  let baseEditors = [base1];
let oppEditors = [opp1];
    function initializeQuill(editorPrefix, num) {
    var editorId = editorPrefix + num;
    var editorElement = document.getElementById(editorId);
    if (!editorElement) return; 
    var quillEditor = new Quill("#" + editorId, {
        theme: 'snow',
        modules: {
            toolbar: "#" + editorId + "_toolbar"
        }
    });

    var colorinput = document.querySelector('#' + editorId + '_toolbar .ql-color');
    if (colorinput) {
        colorinput.addEventListener("change", function(e) {
            quillEditor.format('color', e.target.value);
        });
    }

    let editorContainer = editorElement.parentElement;
    let target = editorContainer.querySelector(".ql-editor");
    let toolbar = editorContainer.querySelector(".equation-toolbar");
    let btn = editorContainer.querySelector(".equation-btn");
    let dynamic = editorContainer.querySelector(".ql-container").getAttribute("id");
    generateEquationEditor(target, toolbar, "ar", dynamic);
    btn.addEventListener("click", function(e) {
        toggleBtns(btn, "#equation-choice .equation-toolbar", editorContainer);
    });

   if (editorPrefix === 'base') {
        baseEditors.push(quillEditor);
    } else if (editorPrefix === 'opp') {
        oppEditors.push(quillEditor);
    }
}



function initializeBaseQuill() {
    var basequill = new Quill("#base1", {
        theme: 'snow',
        modules: {
            toolbar: "#base1_toolbar"
        }
    });

    var colorinput = document.querySelector('#base1_toolbar .ql-color');
    colorinput.addEventListener("change", function(e) {
        basequill.format('color', e.target.value);
    });

    let editor = document.getElementById('base1').parentElement;
    let target = editor.querySelector(".ql-editor");
    let toolbar = editor.querySelector(".equation-toolbar");
    let btn = editor.querySelector(".equation-btn");
    let dynamic = editor.querySelector(".ql-container").getAttribute("id");
    generateEquationEditor(target, toolbar, "ar", dynamic);
    btn.addEventListener("click", function(e) {
        toggleBtns(btn, "#equation-choice .equation-toolbar", editor);
    });
}
window.onload = function() {
  <?php if ($Type_question_ID) {
    if (!$question_id) { ?>
     
      initializeQuill('opp', 1);
      initializeQuill('base', 1);
      
      

    <?php } else {
      foreach ($answers as $key => $ans) { ?>
        initializeQuill('opp', <?php echo $key+1; ?>);
        initializeQuill('base', <?php echo $key+1; ?>);
        matchCounter++;

    <?php }
    }
  } ?>
};



$(document).ready(function() {
    

  quill.on('text-change', function() {
        var text = quill.getText();
        var editorParagraph = document.querySelector('#editor p');
        setDirection();
       
    });

});




 

// let editorbase = document.getElementById(`base1`).parentElement;
//   let target = editorbase.querySelector(".ql-editor");
//   let toolbar = editorbase.querySelector(".equation-toolbar");
//   let btn = editorbase.querySelector(".equation-btn");
//   let dynamic = editorbase.querySelector(".ql-container").getAttribute("id");
//   generateEquationEditor(target, toolbar, "ar", dynamic);
//   btn.addEventListener("click", (e) => {
//     toggleBtns(btn, "#equation-choice .equation-toolbar", editorbase);
//   });

  </script>

<script src="<?php echo base_url(); ?>assets_emp/exam/js/index.js"></script>
<script src="<?php echo base_url(); ?>assets_emp/exam/js/match.js"></script>
<script src="<?php echo base_url(); ?>assets_emp/exam/js/drawer.js"></script>
<script src="<?php echo base_url(); ?>assets_emp/exam/js/tornado.min.js"></script>

  <script>
    function setDirection() {
    var paragraphs = $('p');

    paragraphs.each(function() {
        var text = $(this).text();
        $(this).attr('dir', 'auto');

       
    });
}
$(document).ready(function() {
    setDirection();

});


  </script>
  
<script>
  var txtDegree = document.getElementById("txt_Degree");
  
  txtDegree.addEventListener("input", function() {
    if (parseFloat(txtDegree.value) > parseFloat(<?php echo $AbleDegree; ?>)) {
      txtDegree.value = <?php echo $AbleDegree; ?>;
    }
  });
</script>
