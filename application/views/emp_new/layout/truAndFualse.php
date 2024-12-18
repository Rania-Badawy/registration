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