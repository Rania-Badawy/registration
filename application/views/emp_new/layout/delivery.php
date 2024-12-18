<div class="match-items">
              <?php if (!$question_id) { ?>
                <div class="row">
                  <div class="col-6" id="match-base">
                    <label><?php echo lang('am_qus'); ?></label>
                    <div class="match-item">
                      <div id="base1"></div>
                      <div class="match-item__action">
                        <button type="button" class="editor-image" style="display:none">
                          <input type="file" onchange="uploadImage_match(this)" data-id="1" data-type="base" />
                          <input name="hidImg_base_1" id="hidImg_base_1" type="hidden" value="" />
                          <i class="fas fa-image"></i>
                        </button>
                        <button onclick="removeMatchChoice(this)" data-id="base1" data-type="base" type="button">
                          <i class="fas fa-trash"></i>
                        </button>
                        <button class="card-toolbar__btn" data-id="base1_toolbar" onclick="showCardToolbar(this)" type="button" style="display:none">
                          <i class="fas fa-font"></i>
                        </button>
                        <div class="equation-toolbar" style="display: none"> </div>
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
                          <button type="button" class="equation-btn">
                            <i class="fas fa-function"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-6" id="match-opp">
                    <label><?php echo lang('answer'); ?> </label>
                    <div class="match-item">
                      <div id="opp1"></div>
                      <div class="match-item__action">
                        <button class="editor-image" style="display:none">
                          <input type="file" onchange="uploadImage_match(this)" data-id="1" data-type="opp" />
                          <input name="hidImg_opp_1" id="hidImg_opp_1" type="hidden" value="" />
                          <i class="fas fa-image"></i>
                        </button>
                        <button onclick="removeMatchChoice(this)" data-id="opp1" data-type="opp">
                          <i class="fas fa-trash"></i>
                        </button>
                        <button class="card-toolbar__btn" data-id="opp1_toolbar" onclick="showCardToolbar(this)" style="display:none">
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
                        <div id="base<?php echo $n; ?>" class="ql-editor ql-container">
                          <div class="ql-editor" data-gramm="false" contenteditable="true">
                            <?php if ($Answer != "" && file_exists('./assets/exam/' . $Answer)) { ?>
                              <img height="150px" src="<?php echo base_url() ?>assets/exam/<?php echo $Answer; ?>" style="height: 200px !important;" /><?php } else { ?>
                              <p><?php echo $Answer; ?></p><?php } ?>
                          </div>
                          <div class="ql-clipboard" contenteditable="true" tabindex="-1"></div>
                        </div>
                        <div class="match-item__action">
                          <button type="button" class="editor-image" style="display:none">
                            <input type="file" onchange="uploadImage_match(this)" data-id="<?php echo $n; ?>" data-type="base">
                            <input name="hidImg_base_<?php echo $n; ?>" id="hidImg_base_<?php echo $n; ?>" type="hidden" value="" />
                            <i class="fas fa-image"></i>
                          </button>
                          <button onclick=" return removeMatchChoice(this)" data-id="base<?php echo $n; ?>" data-type="base" type="button">
                            <i class="fas fa-trash"></i>
                          </button>
                          <button class="card-toolbar__btn" data-id="base<?php echo $n; ?>_toolbar" onclick="showCardToolbar(this)" type="button" style="display:none">
                            <i class="fas fa-font"></i>
                          </button>
                          <div class="equation-toolbar" style="display: none"> </div>
                          <div id="base<?php echo $n; ?>_toolbar" class="card-toolbar collapsed">
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
                            <button type="button" class="equation-btn">
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
                        <div id="opp<?php echo $n; ?>" class="ql-editor ql-container">
                          <div class="ql-editor" data-gramm="false" contenteditable="true">
                            <?php if ($Answer_match != "" &&  file_exists('./assets/exam/' . $Answer_match)) { ?>
                              <img height="150px" src="<?php echo base_url() ?>assets/exam/<?php echo $Answer_match; ?>" style="height: 200px !important;" /><?php } else { ?>
                              <p><?php echo $Answer_match; ?></p><?php } ?>
                          </div>
                          <div class="ql-clipboard" contenteditable="true" tabindex="-1"></div>
                        </div>
                        <div class="match-item__action">
                          <button class="editor-image" type="button" style="display:none">
                            <input type="file" onchange="uploadImage_match(this)" data-id="<?php echo $n; ?>" data-type="opp" />
                            <input name="hidImg_opp_<?php echo $n; ?>" id="hidImg_opp_<?php echo $n; ?>" type="hidden" value="" />
                            <i class="fas fa-image"></i>
                          </button>
                          <button onclick="removeMatchChoice(this)" data-id="opp<?php echo $n; ?>" data-type="opp" type="button">
                            <i class="fas fa-trash"></i>
                          </button>
                          <button class="card-toolbar__btn" data-id="opp<?php echo $n; ?>_toolbar" onclick="showCardToolbar(this)" type="button" style="display:none">
                            <i class="fas fa-font"></i>
                          </button>
                          <div class="equation-toolbar" style="display: none"></div>
                          <div id="opp<?php echo $n; ?>_toolbar" class="card-toolbar collapsed">
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