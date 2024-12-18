<style>
    .saveBankQ{
        direction: rtl;
    }
    .question-card.choose-question{
        width: 96%;
        margin: 2em auto
    }
    .choice{height: 20em !important;}
    .choice [type=checkbox] {
        left: 1em;
        width: 1em !important;
        top: 1em;
    }
</style>
<!-- Page Head -->
<div class="page-head container-fluid pt30">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="<?php echo site_url('emp/cpanel'); ?>" class="ti-x fas fa-home"><?php echo lang('er_main');?></a>
    </div>
    <!-- Title -->
    <h1><?php   if($type==1) { echo lang('am_homework') ; } elseif($type==0||$type==4||$type==5){ echo lang('Exams') ; } ?>// <?php echo lang('question_bank');?></h1>
</div>
<!-- // Page Head -->

<!-- Buttons Box -->
<div class="dt-filters-btn container-fluid row flexbox form-ui">
    <!-- Button -->
    <div class="col-12 col-m-4 col-l-3 no-padding">
        <select id="question_bank" name="question_bank" onchange="chang_question_bank('<?= $rowlevelid ?>','<?= $subjectid ?>','<?= $type ?>','<?= $test_id ?>',this.value);">
            <option value="0"><?php echo lang('question_bank'); ?></option>
            <?php 
            foreach($allBank['data'] as $key=>$bank)
            {
                $ID             = $bank['id'];
                if($this->session->userdata('language') == arabic){
                $Name           = $bank['name_ar'];
                }else{
                $Name           = $bank['name_ar'];
                }
            
            ?>
            
            <option value="<?php echo $ID ?>" <?php if($ID == $bankID){echo 'selected';} ?>><?php echo $Name ?></option>
            <?php	
            }
            ?>
    </select>
    </div>
</div>
    <form  method="post" id="saveQuestions" action="<?php echo site_url('emp/exam_new/addBankQuestion/'.$test_id); ?>" class="saveBankQ">

    <input  type="hidden" id="rowlevelid"         name="rowlevelid"         value="<?= $rowlevelid ;?>"/> 
    <input type="hidden"  id="subjectid"          name="subjectid"          value="<?= $subjectid ;?>"/> 
    <input type="hidden"  id="type"               name="type"               value="<?= $type ;?>"/> 
    
        <main class="col-12 text-center">
        <!-- all quiz question -->
        <div class="questions">
        <?php if(isset($queBank)){
    $countQuestions = count($queBank['data']);
        foreach($queBank['data'] as $key=>$row){
        $key                      = $key+1;
        $questions_content_ID     = $row['id'];
        $question                 = $row['Title'];
        $Degree                   = $row->Degree;
        $attach                   = $row->Q_attach;
        $questions_types_ID       = $row['type'];
        $questions_type           = $this->db->query("select Name from questions_types where ID = ".$questions_types_ID." ")->row_array();
        $questions_type_Name      = $questions_type['Name'];
        $answers                  = $row['answers'];
        // $answers                  = $this->exam_new_model->get_answer($questions_content_ID,$questions_types_ID);

            switch($questions_types_ID)
            {
                case 2:
                    $class='success fas fa-check';
                break;
                case 3:
                    $class='success fas fa-check-double';
                break;
                case 4:
                    $class='primary fas fa-pen-alt';
                break;
                case 6:
                    $class='purple fas fa-scroll';
                break;
                case 7:
                    $class='pink fas fa-expand-arrows-alt';
                break;
                case 8:
                    $class='blue fas fa-signature';
                break;
                default:
                    $class='blue fas fa-signature';
            }
                        
        ?>

        <!-- choose question card --> 
        <div class="question-card choose-question">
        <!-- card header -->
        <div class="question-card__header flexbox align-between">
            <div class="question-card__icon exam-box__type">
            <i class="<?php echo $class;?>"></i>
            <h3><?php echo lang('question').":".$key;?> <br><span class="danger-color"><?php echo $questions_type_Name ;?></span></h3>
            </div>
            <div class="question-card__action" style="margin-right: 555px;">
                <!--<div>-->
                <label class="mb10 strong-weight"><?php echo lang('Degree'); ?></label>
                <input type="number" name="txt_Degree-<?php echo $key; ?>" value="" min="0.5" style="float:none;clear:both;width:60px;height: 34px;border: solid;color: brown;"  id="txt_Degree"  step="0.5" >
                <!--</div>-->
            </div>
            <div class="question-card__action">
                <label class="mb10 strong-weight"> حدد السؤال</label><br>
                <input type="checkbox" id="addQuestion" name="addQuestion_<?php echo $key;?>" value="1" style="width:60px;height: 20px;margin-top: -16px;">
                <input type="hidden" name="questions_content_ID_<?php echo $key;?>" value="<?php echo $questions_content_ID;?>" />
            </div>
        </div>
        <!-- //card header -->
        <!-- card body -->
        <div class="question-card__body">
            <div class="question-card__question">
            <h3><?php echo $question ;?> </h3>
            </div>
            <hr/>
            <?php 
                    if($questions_types_ID==2){ ?>
            <div class="exam-box__multi-choices">
                <?php 
                    foreach($answers as $key=>$ans){
                        $answers_ID       = $ans->answers_ID;
                        $Answer           = $ans['adetails']['text'];
                        $Answer_correct   = $ans['Q'];
                        
                ?>
                <div class="choice">
                <input type="checkbox" <?php if($Answer_correct==0){?>checked <?php } ?> value="<?php echo $Answer_correct; ?>" onclick="return false" readonly>
                <br>
                
                <?php 
                    $ImagePath =base_url().'assets/exam/'.$Answer;
                    if(file_exists('./assets/exam/'.$Answer)&&$Answer!=""){
                ?>   
                        <?php 
                    $imgarray =  array('gif','png' ,'jpg','jpeg','JPEG','PNG');
                    $files =  array('pdf','doc' ,'docx','txt','ppt','xlsx' , 'pptx');
                    $video = array('mp4','mp3' ,'wav','aif','aiff','ogg');
                    $fileCheck = pathinfo($Answer);
                    if(in_array($fileCheck['extension'],$imgarray) ) { ?>
                        <img height="150px" src="<?php echo base_url()?>assets/exam/<?php echo $Answer;?>" style="height: 200px !important;"/>
                    <?php }
                    elseif(in_array($fileCheck['extension'],$files) ){ ?>
                                <a class="btn btn-success" href="<?php echo base_url()?>assets/exam/<?php echo $Answer;?>"  download >
                            <i class="fa fa-download"></i>   <?php echo lang('am_download');?></a>
                    <?php }elseif(in_array($fileCheck['extension'],$video)){ ?>
                        <video width="200" height="240" controls>
                            <source src="<?php echo base_url()?>assets/exam/<?php echo $Answer;?>" type="video/mp4" style="height: 200px !important;">
                        </video>
                    <?php } }else{?>
                    <div style="text-align: center;margin-top: 72px;font-size: large; word-break: break-all;" class="ql-editor">
                        <span><?php echo $Answer; ?></span>
                    </div>
                    <?php } ?>
            
            </div>
            <?php } ?>
            </div>
            <?php }elseif($questions_types_ID==3){ ?>
            <div class="question-card__answer flexbox flex-wrap">
                
            <div  <?php if($answers[0]['A']==1){?>class="choose-answer correct"<?php }else{?>class="choose-answer"<?php }?>>
                <i class="fal fa-check-circle"></i>
                <span><?php echo lang("right_answer"); ?></span>
            </div>

            <div  <?php if($answers[0]['A']==1){?>class="choose-answer"<?php }else{?>class="choose-answer correct"<?php }?>>
                <i class="fal fa-check-circle"></i>
                <span><?php echo lang("wrong_answer"); ?></span>
            </div>

            </div>
            <?php }elseif($questions_types_ID==4){ ?>
            <div class="question-card__answer flexbox flex-wrap">
                <?php 
                    foreach($answers as $key=>$ans){
                        $answers_ID       = $ans->answers_ID;
                        $Answer           = $ans['adetails']['text'];
                        $Answer_correct   = $ans->Answer_correct;
                    
                ?>
            <div class="choose-answer " >
                <input type="text" value=<?php echo $Answer; ?> style="text-align: center;font-size: inherit;" readonly>
            </div>
            <?php } ?>
            </div>
            <?php }elseif($questions_types_ID==7){ ?>
            <div class="question-card__answer match-question">
                
            <div class="row">
                <div class="col-6">
                <label><?php echo lang('am_qus');?></label>
                <?php 
                    foreach($answers as $key=>$ans){
                        $answers_ID       = $ans->answers_ID;
                        $Answer           = $ans->Answer;
                        $Answer_match     = $ans['qdetails']['text'];
                        $Answer_correct   = $ans->Answer_correct;
                ?>
                <div class="item">
                    <div class="item-text"  <?php if($Answer_match!="" &&  file_exists('./assets/exam/'.$Answer_match)){ ?>style="height: 200px !important;"<?php }else{ ?>style="height: 80px;overflow:scroll;"<?php }?>>
                        <?php if(file_exists('./assets/exam/'.$Answer_match)){ ?>
                        <img height="150px" src="<?php echo base_url()?>assets/exam/<?php echo $Answer_match;?>" style="height: 200px !important;"/><?php }else{?>
                        <?php echo $Answer_match;  }?>
                    </div>
                </div>
                <?php } ?>
                </div>
                <div class="col-6">
                <label><?php echo lang('am_answer');?></label>
                    <?php 
                    foreach($answers as $key=>$ans){
                        $answers_ID       = $ans->answers_ID;
                        $Answer           = $ans['adetails']['text'];
                        $Answer_match     = $ans['adetails']['text'];
                        $Answer_correct   = $ans->Answer_correct;
                ?>
                <div class="item">
                    <div class="item-text"   <?php if($Answer!="" && file_exists('./assets/exam/'.$Answer)){ ?>style="height: 200px !important;"<?php } else { ?>style="height: 80px;overflow:scroll;"<?php }?>>
                        <?php if(file_exists('./assets/exam/'.$Answer_match)){ ?>
                        <img height="150px" src="<?php echo base_url()?>assets/exam/<?php echo $Answer;?>" style="height: 200px !important;"/><?php }else{?>
                        <?php echo $Answer;  }?>
                    </div>
                </div>
                <?php } ?>
                </div>
            </div>
            
            </div>
            <?php }elseif($questions_types_ID==8){ ?>
            <!--<div class="question-card__answer">-->
            <!--  <div class="question-card__drawer"></div>-->
            <!--</div>-->
            <?php } ?>
            <div style="text-align: end;">
                <?php 
                    $ImagePath =base_url().'assets/exam/'.$attach;
                    if(file_exists('./assets/exam/'.$attach)&&$attach!=""){
                ?>   
                    <label for="" class="mb10 strong-weight"><?php echo lang('am_attach');?></label>
                        <?php 
                    $imgarray =  array('gif','png' ,'jpg','jpeg','JPEG','PNG');
                    $files =  array('pdf','doc' ,'docx','txt','ppt','xlsx' , 'pptx');
                    $video = array('mp4','mp3' ,'wav','aif','aiff','ogg');
                    $fileCheck = pathinfo($attach);
                    if(in_array($fileCheck['extension'],$imgarray) ) { ?>
                        <img height="150px" src="<?php echo base_url()?>assets/exam/<?php echo $attach;?>" style="height: 200px !important;"/>
                    <?php }
                    elseif(in_array($fileCheck['extension'],$files) ){ ?>
                                <a class="btn btn-success" href="<?php echo base_url()?>assets/exam/<?php echo $attach;?>"  download >
                            <i class="fa fa-download"></i>   <?php echo lang('am_download');?></a>
                    <?php }elseif(in_array($fileCheck['extension'],$video)){ ?>
                        <video width="320" height="240" controls>
                            <source src="<?php echo base_url()?>assets/exam/<?php echo $attach;?>" type="video/mp4" style="height: 200px !important;">
                        </video>
                    <?php } }?>
        </div>
        </div>
        <!-- //card body -->
        </div>
        
        <?php } ?>
        <input type="hidden" name="count" value="<?php echo $countQuestions;?>" />
    

                <div style="margin-right: 1070px;">
                 
                     <button  class="submit btn blue-bg"><?php echo lang('am_save');?></button>
         
                </div>

    </form>
    <?php } ?>
    </div>
</main>



<!-- // Buttons Box -->
<script>
    function chang_question_bank(rowlevelid , subjectid ,type,test_id,bankID)
    {
       window.location = "<?= site_url('emp/exam_new/bankData') ?>/"+rowlevelid+"/"+subjectid+"/"+type+"/"+test_id+"/"+bankID ;
    }
   

</script>
<script>
$(document).ready(function(){
    $("#saveQuestions").submit(function(e){
        var isValid = true;
        $("input[name^='addQuestion_']").each(function(){
            var key = $(this).attr("name").split("_")[1];
            var isChecked = $(this).is(":checked");
            var degreeValue = $("input[name='txt_Degree-" + key + "']").val();
            if (isChecked && (degreeValue === "" || degreeValue === null)) {
                Swal.fire({
                    title: 'تنبيه',
                    text: "الرجاء إدخال درجة السؤال رقم " + key,
                    icon: 'warning',
                    confirmButtonText: 'حسنًا'
                });                isValid = false;
                return false;
            }
        });
        if (!isValid) {
            e.preventDefault();
        }
    });
});
</script>