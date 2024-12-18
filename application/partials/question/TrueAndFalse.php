<div id="question-<?=$question['id']?>" class="question-card draw-question page-head">
    <!-- card header -->
    <div class="student-quiz__question-header">
        <h1>إختر الإجابة الصحيحة</h1>
        <div class="icon-container">
        <?if($this->session->userdata('type') == 'U'||$premetion['users'][0]['delete'] ==1 or ($query['jobTitleID'] != 0 and $_SERVER['REQUEST_URI'] != '/emp/question_bank')or ($GroupID != 0 and $_SERVER['REQUEST_URI'] != '/emp/question_bank')){?><i onclick="deletequestion(<?=$question['id']?>,<?=$question['pivot']['bank_id']?>)" class="fas fa-trash-alt close-btn red-color"></i><?}?>
            <div class="trash-can"></div>
        </div>
    </div>
    <!-- //card header -->
    <!-- card body -->
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
                <label class="col-12 chooseAnswer">الاختيارالمناسب</label>
                <div class="col-6">
                    <div class="item">
                        <div class="choose-answer chooseAns <? if ($question['answers'][0]['A'] == 1) {
                            echo 'green-bg-cust';
                        } ?>">
                            <i class="fa fa-check-circle" aria-hidden="true"></i>
                            <span>الإجابة صحيحة </span>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="item">
                        <div class="choose-answer chooseAns <? if ($question['answers'][0]['A'] == 0) {
                            echo 'red-bg';
                        } ?> ">
                            <i class="fa fa-window-close" aria-hidden="true"></i>
                            <span>الإجابة خاطئة </span>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="question-card__answer flexbox flex-wrap">
                <div class="row">
                    <div class="col-6">
                    </div>
                </div>
                <div class="choose-answer ">
                    <div class="col-6">
                    </div>
                </div>
            </div>
        </div>
        <div style="text-align: end;">
        </div>
    </div>
</div>