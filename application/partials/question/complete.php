
<div id="question-<?=$question['id']?>" class="question-card draw-question page-head">
    <!-- card header -->
    <div class="student-quiz__question-header">
        <h1>إكمل الفراغ بالاجابة الصحيحة</h1>
        <?if($this->session->userdata('type') == 'U'||$premetion['users'][0]['delete'] ==1 or ($query['jobTitleID'] != 0 and $_SERVER['REQUEST_URI'] != '/emp/question_bank')or ($GroupID != 0 and $_SERVER['REQUEST_URI'] != '/emp/question_bank')){?><i onclick="deletequestion(<?=$question['id']?>,<?=$question['pivot']['bank_id']?>)" class="fas fa-trash-alt close-btn red-color"></i><?}?>
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
            <div class="student-quiz__question-body">
                <!-- <div class="student-quiz__question chooseQ">

                </div> -->
                <div class="student-quiz__question-body">
        
        <? $groupedTexts = [];

        foreach ($question['answers'] as $answer) {
            $qValue = $answer['Q'];

            if (!isset($groupedTexts[$qValue])) {
                $groupedTexts[$qValue] = [];
            }

            $groupedTexts[$qValue][] = $answer['adetails']['text'];
        }

        foreach ($groupedTexts as $key => $texts) {
            $k = $key + 1;
            echo '<div class="btn rounded blue-bg">إجابه النقاط رقم ' . $k . ': ';
            echo implode(' & ', $texts);
            echo "\n</div>";
        } ?>

    </div>
            </div>
        </div>
        <div style="text-align: end;">
        </div>
    </div>
</div>