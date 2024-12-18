<div id="question-<?=$question['id']?>" class="question-card match-question">
        <!-- card header -->
        <div class="student-quiz__question-header">
        <h1>صل الإجابة الصحيحة
        
        </h1>
        <?if($this->session->userdata('type') == 'U'||$premetion['users'][0]['delete'] ==1 or ($query['jobTitleID'] != 0 and $_SERVER['REQUEST_URI'] != '/emp/question_bank')or ($GroupID != 0 and $_SERVER['REQUEST_URI'] != '/emp/question_bank')){?><i onclick="deletequestion(<?=$question['id']?>,<?=$question['pivot']['bank_id']?>)" class="fas fa-trash-alt close-btn red-color"></i><?}?>
    </div>
    <!-- //card header -->
    <div class="question-card__body">
        <div class="question-card__question">
            <h3>
            <li class="fa-solid fa-clipboard-question qIcon"></li>
                <span>س
                    <?= $key + 1 ?>
                </span>
                <? echo $question['Title'] ?>
            </h3>
        </div>
        <hr />
        <div class="question-card__answer">
            <div class="row">
                <div class="col-6">
                    <label>الاساس</label>
                    <? foreach ($question['answers'] as $key => $answer) {
                        echo '<div class="item">
                                        <span class="item-number">(' . ($key + 1) . ')</span>
                                        <div class="item-text">' . $answer['qdetails']['text'] . '</div>
                                    </div>';
                    }


                    echo '                                </div>
                                <div class="col-6">
                                    <label>الاختيارالمناسب</label>';
                    foreach ($question['answers'] as $key => $answer) {
                        echo '<div class="item">
                                        <div class="item-text">' .
                            $answer['qdetails']['text'] . '
                                                                                    <span class="answer">' . ($key + 1) . '</span>
                                        </div>
                                    </div>';
                    } ?>

                </div>
            </div>
        </div>
    </div>
</div>