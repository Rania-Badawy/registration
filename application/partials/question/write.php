<div id="question-<?=$question['id']?>" class="question-card essay-question page-head">
  <!-- card header -->
  <div class="question-card__header flexbox align-between">
    <div class="student-quiz__question-header">
      <h1>سوال مقالي</h1>
      <div class="icon-container">
      <?if($this->session->userdata('type') == 'U'||$premetion['users'][0]['delete'] ==1 or ($query['jobTitleID'] != 0 and $_SERVER['REQUEST_URI'] != '/emp/question_bank')or ($GroupID != 0 and $_SERVER['REQUEST_URI'] != '/emp/question_bank')){?><i onclick="deletequestion(<?=$question['id']?>,<?=$question['pivot']['bank_id']?>)" class="fas fa-trash-alt close-btn red-color"></i><?}?>
        <div class="trash-can"></div>
      </div>
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
    <div class="question-card__answer"></div>
  </div>
  <!-- //card body -->
</div>