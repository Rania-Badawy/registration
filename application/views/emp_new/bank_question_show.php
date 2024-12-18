<style>
  .questions .question-card {
    width: 1000px;
  }
</style>
<?php if (isset($questions)) {
      foreach($questions as $question){
               if ($question->type == 2) { ?>
                <div class="exam-box__multi-choices">
                  <?php
                  foreach ($answers as $key => $ans) {
                    $answers_ID       = $ans->answers_ID;
                    $Answer           = $ans->Answer;
                    $Answer_correct   = $ans->Answer_correct;

                  ?>
                    <div class="choice">
                      <input type="checkbox" <?php if ($Answer_correct == 1) { ?>checked <?php } ?> value="<?php echo $Answer_correct; ?>" onclick="return false" readonly>
                      <br>

                      <?php
                      $ImagePath = base_url() . 'assets/exam/' . $Answer;
                      if (file_exists('./assets/exam/' . $Answer) && $Answer != "") {
                      ?>
                        <?php
                        $imgarray =  array('gif', 'png', 'jpg', 'jpeg', 'JPEG', 'PNG');
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
                        <div style="text-align: center;margin-top: 72px;font-size: large; word-break: break-all;" class="ql-editor">
                          <span><?php echo $Answer; ?></span>
                        </div>
                      <?php } ?>

                    </div>
                  <?php } ?>
                </div>
              <?php }?> 
                <div class="question-card__answer flexbox flex-wrap">
                  <h1>iam here </h1>
                    <?php $Answer = lang("right_answer");?>
                  
                    <div class="choose-answer correct">
                      <i class="fal fa-check-circle"></i>
                      <span><?php echo $Answer; ?></span>
                    </div>
              
                </div>
              <?php              if ($questions_types_ID == 4) { ?>
                <div class="question-card__answer flexbox flex-wrap">
                  <?php
                  foreach ($answers as $key => $ans) {
                    $answers_ID       = $ans->answers_ID;
                    $Answer           = $ans->Answer;
                    $Answer_correct   = $ans->Answer_correct;

                  ?>
                    <div class="choose-answer ">
                      <input type="text" value=<?php echo $Answer; ?> style="text-align: center;font-size: inherit;" readonly>
                    </div>
                  <?php } ?>
                </div>
              <?php } elseif ($questions_types_ID == 7) { ?>
                <div class="question-card__answer match-question">

                  <div class="row">
                    <div class="col-6">
                      <label><?php echo lang('am_qus'); ?></label>
                      <?php
                      foreach ($answers as $key => $ans) {
                        $answers_ID       = $ans->answers_ID;
                        $Answer           = $ans->Answer;
                        $Answer_match     = $ans->Answer_match;
                        $Answer_correct   = $ans->Answer_correct;
                      ?>
                        <div class="item">
                          <div class="item-text" <?php if ($Answer_match != "" &&  file_exists('./assets/exam/' . $Answer_match)) { ?>style="height: 200px !important;" <?php } else { ?>style="height: 80px;overflow:scroll;" <?php } ?>>
                            <?php if (file_exists('./assets/exam/' . $Answer_match)) { ?>
                              <img height="150px" src="<?php echo base_url() ?>assets/exam/<?php echo $Answer_match; ?>" style="height: 200px !important;" /><?php } else { ?>
                            <?php echo $Answer_match;
                                                                                                                                                          } ?>
                          </div>
                        </div>
                      <?php } ?>
                    </div>
                    <div class="col-6">
                      <label><?php echo lang('am_answer'); ?></label>
                      <?php
                      foreach ($answers as $key => $ans) {
                        $answers_ID       = $ans->answers_ID;
                        $Answer           = $ans->Answer;
                        $Answer_match     = $ans->Answer_match;
                        $Answer_correct   = $ans->Answer_correct;
                      ?>
                        <div class="item">
                          <div class="item-text" <?php if ($Answer != "" && file_exists('./assets/exam/' . $Answer)) { ?>style="height: 200px !important;" <?php } else { ?>style="height: 80px;overflow:scroll;" <?php } ?>>
                            <?php if (file_exists('./assets/exam/' . $Answer_match)) { ?>
                              <img height="150px" src="<?php echo base_url() ?>assets/exam/<?php echo $Answer; ?>" style="height: 200px !important;" /><?php } else { ?>
                            <?php echo $Answer;
                                                                                                                                                    } ?>
                          </div>
                        </div>
                      <?php } ?>
                    </div>
                  </div>

                </div>
              <?php } elseif ($questions_types_ID == 8) { ?>
                <!--<div class="question-card__answer">-->
                <!--  <div class="question-card__drawer"></div>-->
                <!--</div>-->
              <?php } ?>
              <div style="text-align: end;">
                <?php
                $ImagePath = base_url() . 'assets/exam/' . $attach;
                if (file_exists('./assets/exam/' . $attach) && $attach != "") {
                ?>
                  <label for="" class="mb10 strong-weight"><?php echo lang('am_attach'); ?></label>
                  <?php
                  $imgarray =  array('gif', 'png', 'jpg', 'jpeg', 'JPEG', 'PNG');
                  $files =  array('pdf', 'doc', 'docx', 'txt', 'ppt', 'xlsx', 'pptx');
                  $video = array('mp4', 'mp3', 'wav', 'aif', 'aiff', 'ogg');
                  $fileCheck = pathinfo($attach);
                  if (in_array($fileCheck['extension'], $imgarray)) { ?>
                    <img height="150px" src="<?php echo base_url() ?>assets/exam/<?php echo $attach; ?>" style="height: 200px !important;" />
                  <?php } elseif (in_array($fileCheck['extension'], $files)) { ?>
                    <a class="btn btn-success" href="<?php echo base_url() ?>assets/exam/<?php echo $attach; ?>" download>
                      <i class="fa fa-download"></i> <?php echo lang('am_download'); ?></a>
                  <?php } elseif (in_array($fileCheck['extension'], $video)) { ?>
                    <video width="320" height="240" controls>
                      <source src="<?php echo base_url() ?>assets/exam/<?php echo $attach; ?>" type="video/mp4" style="height: 200px !important;">
                    </video>
                <?php }
                } ?>
              </div>
            </div>
            <!-- //card body -->
          </div>
        </form>
    <?php }
    } ?>