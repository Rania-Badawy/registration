<div class="exam-box__multi-choices">
              <?php if (!$question_id) { ?>
                <div class="choice">
                  <input type="checkbox" name="slct_Correct_Answer[1]" id="slct_Correct_Answer1" value="1" />
                  <div id="choice1" class="ql-container"></div>
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
                    <input type="checkbox" class="slct_Correct_Answer" name="slct_Correct_Answer[<?= $num; ?>]" <?php if ($Answer_correct == 1) { ?>checked <?php } ?> id="slct_Correct_Answer<?= $num; ?>" value="<?php echo $Answer_correct; ?>">
                    <input type="hidden" name="slct_count_Answer" class="slct_count_Answer" value="<?php echo $num; ?>">
                    <!--<input type="hidden" name="choice_count" id="choice_count" value="<?php echo $num; ?>">-->
                    <div id="choice<?= $num; ?>" class="ql-container">
                      <div class="ql-editor" data-gramm="false" contenteditable="true">
                        <p><?php if (file_exists('./assets/exam/' . $Answer) && $Answer != "") { ?><img src="<?php echo base_url() ?>assets/exam/<?php echo $Answer; ?>" /><?php } else {
                                                                                                                                                                            echo $Answer;
                                                                                                                                                                          } ?>
                        </p>
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
              <button class="add-choice fas fa-plus" id="insertChoice" type="button">
                <?php echo lang("am_add_answer") ?></button>
            </div>