
          
            <div class="lmsonle">
              <div class="qBank" style="text-align: left">
                <span style="font-size: 20px;display:inline-block;margin-left: 10px">
                <input type="checkbox" id="add_to_qB" name="add_to_qB">
                <?=lang('add_to_question_bank') ;    ?>
          </span>
                <div id="BANKS"  class="">
                    <div>

                      <label><?=lang('select_bank');?></label>
                      <select name="bankID">
                        <?php
                        foreach ($UserBanks['data'] as $bank) { ?>
                          <option name="bankId" value="<? echo $bank['id'] ?> "><? echo $bank['name_ar'] ?></option>?>
                        <?php } ?>


                      </select>
                    </div>
                    
                  </div>
              </div>
            </div>
          <?php

          
          