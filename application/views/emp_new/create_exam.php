<link href="<?php echo base_url(); ?>assets/virtual-select.min.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/virtual-select.min.js"></script>

<style>
.examclass { display: table}
.examclass .select2  { display: table-caption; }
.examclass p {  display: none;
}
    .quiz__settings label{
        margin-top: 0;
        font-size: 13px;
        text-align: center;
    }
    .quiz .header {
        height: 4em;
        margin-bottom: 12px;
    }
    .control-hint.error {
        margin-top: revert;
    }
    p {
       word-break: break-word;
}
/* .question-card__question p {
    display: inline-block;
} */

.quiz__types{
    justify-content: start;
    gap: 20px
}
.vscomp-ele{max-width: 100%;}
.vscomp-option-text{text-align: right;display:inline-block;padding-right: 10px;margin-top: -3px;}
</style>

<?php

  $get_api_setting=$this->setting_model->get_api_setting(); 
  $this->ApiDbname=$get_api_setting[0]->{'ApiDbname'}; 
$ApiDbname

?>
    <div class="quiz row no-guuter row-reverse">
      <header class="header">
        <h3 class="heading"><?php if($type==1) { echo lang('Add_homework') ."_".$subjectEmp_details[0]->level_Name."_".$subjectEmp_details[0]->row_Name."_".$subjectEmp_details[0]->subject_Name; } elseif($type==0||$type==5){ echo lang('Add_Exam') ."_".$subjectEmp_details[0]->level_Name."_".$subjectEmp_details[0]->row_Name."_".$subjectEmp_details[0]->subject_Name; }elseif($type==4){ echo lang('Add_Exam') ."_".$subjectEmp_details[0]->level_Name."_".$subjectEmp_details[0]->row_Name; }  ?></h3>
        <a href="<?php echo site_url('emp/exam_new/index/'.$type); ?>" class="back far fa-arrow-left"> <?php echo lang("am_back_list");?> </a>
      </header>
      <div class="container-fluid">
        <div class="row">
          <aside class="sidebar col-4 page-head">
              <form class="form-ui quiz__settings" method="post" action="<?php echo site_url('emp/exam_new/add_exam/'.$type."/".$test_id); ?>" >
                  <input type="hidden" name="FeeStatus" id="FeeStatus" value="">  
                    <input type="hidden" name="DbName" id="DbName" value="<?php echo $this->ApiDbname; ?>">
              <div class="quiz__name">
                <label for="name"><?php echo lang('Exam_Name') ;   ?></label>
                <input type="text" name="txt_exam" id="txt_exam" value="<?= $test_data['Name'];?>" required/>
              </div>
              <?php if(!$test_id){ ?>
               <div class="quiz__select">
                <label class="mb5"><?php echo lang('class_type'); ?></label>
                <select name="ClassTypeName[]" id="ClassTypeName"  required placeholder="<?php echo lang('am_choose_select'); ?>" data-silent-initial-value-set="true">
                            <option value=""><?php echo lang('am_choose_select'); ?></option>       
                                    <?php
                                        if($ClassType)
                                        {
                                           foreach($ClassType as $Key=>$gender)
                                            {
                                                $ID = $gender->ClassTypeId ;
                                                $Name  = $gender->ClassTypeName ;
                                    ?>
                                     <option value="<?php echo $ID ; ?>"><?php echo $Name ; ?></option>
                                    <?php }} ?>
                    </select>
              </div>
             
              <div class="quiz__select">
              <label class="mb5"><?php echo lang('am_studeType'); ?></label>
                <select name="studeType[]" id="studeType"  required placeholder="<?php echo lang('am_choose_select'); ?>">
                     <option value=""><?php echo lang('am_choose_select'); ?></option>    
                                  <?php
                                    if($studeType)
                                    {
                                       foreach($studeType as $Key=>$val)
                                        {
                                            $ID    = $val->StudyTypeId ;
                                            $Name  = $val->StudyTypeName ;
                                ?>
                                 <option value="<?php echo $ID ; ?>"><?php echo $Name ; ?></option>
                                <?php }} ?>
                </select> 
              </div>
              <div class="quiz__select">
                <label class="mb5"><?php echo lang('br_school_name'); ?></label> 
                <input type="hidden" id="RowLevel" value="<?php echo $rowlevelid ;?>" />
                <select name="schoolID" id="schoolID" required placeholder="<?php echo lang('am_choose_select'); ?>" data-silent-initial-value-set="true"> 
                </select> 
              </div>
               <div class="quiz__select">
                <label class="mb5"><?php echo lang('am_level'); ?></label>
                <select name="levelID" id="levelID" required placeholder="<?php echo lang('am_choose_select'); ?>" data-silent-initial-value-set="true"> 
                                  
                </select> 
              </div>
              <div class="quiz__select">
                <label class="mb5"><?php echo lang('br_row_level'); ?></label>
                <select name="rowID" id="rowID" required  placeholder="<?php echo lang('am_choose_select'); ?>" data-silent-initial-value-set="true"> 
                                  
                </select> 
              </div>
              <div class="quiz__select" id="show_status">
                <label class="mb5"><?php echo lang('status'); ?></label>
                <select name="status[]" id="status"   data-search="false"  placeholder="<?php echo lang('am_choose_select'); ?>" data-silent-initial-value-set="true"> 
                                  
                </select> 
              </div>
              <?php } ?>
              <?php $max_sem=$check_semester[sizeof($check_semester)-1]->end_date; ?>
              <div class="quiz__select">
                                <label for="" class="mb5"><?php echo lang('am_from'); ?> </label>
                                <input type="datetime-local" name="Date_from" onchange="setmin_DateTo(this.value)" id="Date_from" <?php if($type!=4 && $type!=5 && $type!=6){?> min="<?php echo date('Y-m-d\TH:i:00',strtotime($Timezone));?>" max="<?php echo date('Y-m-d\TH:i:00',strtotime($max_sem));?>" <?php } ?> value="<?php if($test_data['date_from']){echo date("Y-m-d\TH:i:00", strtotime($test_data['date_from']));}else{echo date("Y-m-d\TH:i:00", strtotime($Timezone));}?>"   required>
               </div>
             
                <!-- Form Control -->
                <div class="quiz__select">
                                <label for="" class="mb5"><?php echo lang('am_to'); ?> </label>
                                <input type="datetime-local" name="Date_to" onchange="setmin_Date()"  id="Date_to" value="<?php if($test_data['date_to']){echo date("Y-m-d\TH:i:00", strtotime($test_data['date_to']));} ?>"<?php if($type!=4 && $type!=5 && $type!=6){?> max="<?php echo date('Y-m-d\TH:i:00',strtotime($max_sem));?>"<?php } ?>  required>
                </div>
                
              <div class="quiz__select">
                <label class="mb5"><?php echo lang('Exam_Time2'); ?></label>
                <input type="number" name="txt_time"  id="txt_time"  min="1"  max="999" onblur="return validate(this);" onkeydown="if(event.key==='.'){event.preventDefault();}"  oninput="event.target.value = event.target.value.replace(/[^0-9]*/g,'');" value="<?php  if($test_data['time_count']){echo $test_data['time_count']/60;}else { echo "";}?>" required />
              </div>

              <!--Add Exam Degree-->

              <div class="quiz__select">
                <label class="mb5"><?php echo lang('ExamDegree'); ?></label>
                <input type="number" name="examDegree"   id="examDegree"  min="1"  max="100" onblur="return validate(this);" onkeydown="if(event.key==='.'){event.preventDefault();}"  oninput="event.target.value = event.target.value.replace(/[^0-9]*/g,'');" value="<?php  if($test_data['examDegree']){echo $test_data['examDegree'];}else { echo "";}?>" />
              </div>

              <div style="display: flex;align-items: center;gap: 20px;margin-top:20px">
                  <?php if($test_id){$query=$this->db->query("select ID from test_student where test_id=$test_id")->result();}
                  if(empty($query)){
                  ?>
                <label for="" class="mb5"><?php echo lang('br_active'); ?> </label>
                <input type="checkbox"  name="IsActive"  id="IsActive"
                 <?php if ($test_data['IsActive'] == 1  )
                  {if($test_data['examDegree']){
                    if($ableToActive){echo 'checked';}
                  }else{ 
                    echo 'checked';} 
                    } 
                    if($test_data['examDegree'] ){if(!$ableToActive){echo 'disabled';}}  ?>  value="1"  >
                
                <?php 
             
              } ?>
                    <?php if($test_id>0){ ?>
                    <?php $query=$this->db->query("select ID from test_student where test_id=$test_id")->result();
                  if(empty($query) || $type == 4){
                  ?>
                  
                     <button  class="submit btn blue-bg"style="margin: auto;width: fit-content; padding: 1em 1.5em"><?php echo lang('br_edit');?></button>
                     <?php }}else { ?>
                    <button   class="submit btn blue-bg" style="margin: auto;width: fit-content; padding: 1em 1.5em"><?php echo lang('am_save');?></button>
                    <?php } ?>
                </div><?
                if(!$ableToActive && $test_data['examDegree']){
                ?>
              <div class="hint">
                  يجب ضبط درجات الأسئلة بحيث تتطابق مع درجات الاختبار الكلية.
              </div>
          <?
              }?>
            </form>
          </aside>
          
          <main class="col-8 text-center">
              <?php if($test_id){?><h6 class="quiz__heading"><?php echo lang('count_exam_questions');?>
              <?php  if($questions ){?> <b class="alert success"><?php echo count($questions); ?></b> <?php } else { ?><b class="alert danger">0</b><?php } ?></h6><br><?php }?>


            <?php  if(!$questions ){?><h2 class="quiz__heading"><?php echo lang('exam_hint');?></h2><?php } ?>
            
            <?php if($test_data['examDegree'] ){?>
              <div>
                <h2 class="quiz__heading">
                  <b> درجات الاختبار</b>
                  <b dir="auto" class=" btn danger-bg "><?php echo $test_data['examDegree'] ." / ". $TotalDegree; ?></b>
                </h2>
              </div>
              <?php } ?>
              <?if ($test_data['examDegree']) {
                        if (!$ableToActive) {
                          ?>
            <div class="quiz__types">
                <?php
                foreach ($questions as $key => $value) {

                    $questions_types_ID = $value->questions_types_ID;
                    
                    if($questions_types_ID == 8) {
                    // $draw_found=1;
                    break;
                    } else {
                        $draw_found=0;
                    }
                    
                    }
                $abc=array(
                                '0'=>'quiz__type success fas fa-check',
                                '1'=>'quiz__type success fas fa-check-double',
                                '2'=>'quiz__type primary fas fa-pen-alt',
                                '3'=>'quiz__type purple fas fa-scroll',
                                '4'=>'quiz__type pink fas fa-expand-arrows-alt',
                                '5'=>'quiz__type blue fas fa-signature',
                                );
                               if($test_id){
                                   $query=$this->db->query("select ID from test_student where test_id=$test_id")->result();
                               }
                             
					              foreach($Type_question as $color => $row){
						                   $Type_question_ID   = $row->ID;
						                   $Type_question_Name = $row->Name;
						                   if(($draw_found==0)||($draw_found==1)&&($Type_question_ID!=8)){
						              ?>
              <a <?php if($test_id>0 && empty($query)){ ?>href="<?php echo site_url('emp/exam_new/ques_type/'.$type."/".$test_id."/".$Type_question_ID); ?>" <?php }else {?>onclick="ques_alert()" <?php } ?>class="<?php echo $abc[$color];?>"><?php echo $Type_question_Name;?></a>
                 <?php  }}?>
                 
            </div>
            <?}}else{
                          ?>
            <div class="quiz__types">
                <?php
                foreach ($questions as $key => $value) {

                    $questions_types_ID = $value->questions_types_ID;
                    
                    if($questions_types_ID == 8) {
                    // $draw_found=1;
                    break;
                    } else {
                        $draw_found=0;
                    }
                    
                    }
                $abc=array(
                                '0'=>'quiz__type success fas fa-check',
                                '1'=>'quiz__type success fas fa-check-double',
                                '2'=>'quiz__type primary fas fa-pen-alt',
                                '3'=>'quiz__type purple fas fa-scroll',
                                '4'=>'quiz__type pink fas fa-expand-arrows-alt',
                                '5'=>'quiz__type blue fas fa-signature',
                                );
                               if($test_id){
                                   $query=$this->db->query("select ID from test_student where test_id=$test_id")->result();
                               }
                             
					              foreach($Type_question as $color => $row){
						                   $Type_question_ID   = $row->ID;
						                   $Type_question_Name = $row->Name;
						                   if(($draw_found==0)||($draw_found==1)&&($Type_question_ID!=8)){
						              ?>
              <a <?php if($test_id>0 && empty($query)){ ?>href="<?php echo site_url('emp/exam_new/ques_type/'.$type."/".$test_id."/".$Type_question_ID); ?>" <?php }else {?>onclick="ques_alert()" <?php } ?>class="<?php echo $abc[$color];?>"><?php echo $Type_question_Name;?></a>
                 <?php  }}?>
                
            </div>
            <?} ?>
        
          </main>
          <div id="exam_show"  >
            <?php include('exam_show.php');?>
        </div>
        </div>
      </div>
    </div>
    <input type="hidden" id="Lang" value="<?php echo $Lang ;?>" />
    
     <script type="text/javascript">
//             $(document).ready(function () {
//             //   $("#loadingDiv").hide();
//               function clearColumns(ColumnsArray){
//           $(ColumnsArray).each(function(){
//                 $(this).empty();
//                 $(this).append('<option value="0"> </option>')
//             });
//         }
        
//         function drawColumn(columnID,columnString,columnName){
//             columnnameID = "#"+columnName;
//             $.each(data, function(key, value) {
//                   $('select[name="'+columnName+'"]').append('<option value="'+ columnID +'">'+ columnString + '</option>');
//               });
//             $(columnnameID).prop("disabled", false);
                          
//         }
//           $('select[name="slct_class[]"]').on('change', function() {
//               var stateID = $(this).val();
//               var RowLevel = $("#RowLevel").val();
//               if(stateID) {
//                   $.ajax({ 
//                       url: '<?php echo site_url();?>' + '/emp/Exam_new/get_student/'+ stateID + '/' + RowLevel ,
//                       type: "GET",
//                       dataType: "json",
//                       success:function(data) {
//                           $('select[name="slct_student[]"]').empty();
//                           $.each(data, function(key, value3) {
//                               $('select[name="slct_student[]"]').append('<option value="'+ value3.StudentID +'">'+ value3.StudentName +'</option>');
                                
//                               });
                               
              
//                               $("#slct_student[]").prop("disabled", false);
//                       }
//                   });
//               }
//           });
          
          
     
// });
function ques_alert(){
    alert("يجب ادخال وحفظ بيانات الاختبار اولا ");
}
</script>
<script>

function setmin_DateTo(value){
  document.getElementById('Date_to').min=value;
    setmin_Date();
         
         
}
</script>
 <script type="text/javascript">
function validate(txt_time){
    if(parseFloat(txt_time.value)<=0){
        txt_time.value = "";
        return false;
    }
    else {
    return true;}
}
</script>
<script>
function setmin_Date(){

             var startDate = $('#Date_from').val();
             var endDate = $('#Date_to').val();
             var Lang     =$('#Lang').val();
             const dateFormat = "YYYY-MM-DD HH:mm:ss";
             const date1 = moment(startDate).format(dateFormat);
             const date2 = moment(endDate).format(dateFormat);
             const differenceInHours = moment(endDate).diff( date1, 'minutes');
        
        
             if (((endDate == startDate) || (endDate < startDate) || (differenceInHours <= 60) )&& ( endDate!= "") ){
               
                Date_to.value = "";
                if(Lang=='english'){
                  alert('End date should be greater than Start date by one hour at least');
             
               }else{
                alert('يجب أن يكون تاريخ الانتهاء أكبر من تاريخ البدء بساعة واحدة على الأقل'); 
               }
               }
             
         }
         
</script>
<!--<script>-->
<!--    $('select[name^="studeType"]').on('change', function() {-->
<!--        document.getElementById("show_status").style.display = "none";-->
<!--        var studeType = $('#studeType').val();-->
<!--        var DbName = $('#DbName').val();-->
<!--        if (studeType) {-->
<!--            $.ajax({-->
<!--                url: '<?php echo lang("api_link"); ?>' + '/api/Schools/' + DbName + '/GetSchoolsByStudyType',-->
<!--                type: "GET",-->
<!--                data: {-->
<!--                    studyTypeId: studeType-->
<!--                },-->
<!--                dataType: "json",-->
<!--                success: function(data) {-->
<!--                    var element = $('#schoolID');-->
<!--                    element.empty();-->
<!--                    element.append(-->
<!--                        '<option value="" ><?php echo lang('am_choose_select'); ?></option>');-->
<!--                    $.each(data, function(key, value) {-->
<!--                        element.append('<option value="' + value.SchoolId + '">' + value.SchoolName + '</option>');-->
                           
<!--                    });-->
<!--                }-->
<!--            });-->

<!--        } else {-->
<!--            var element = $('#schoolID');-->
<!--            element.empty();-->
<!--            element.append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');-->
<!--        }-->
        
<!--    });-->

<!--</script>-->

<!--<script type="text/javascript">-->
<!--    $('select[name^="schoolID"]').on('change', function() {-->
<!--        var studeType = $('#studeType').val();-->
<!--        var schoolID = $('#schoolID').val();-->
<!--        var ClassTypeName = $('#ClassTypeName').val();-->
<!--        var DbName = $('#DbName').val();-->
<!--        if (schoolID && studeType != "") {-->
<!--            $.ajax({-->
<!--                url: '<?php echo lang("api_link"); ?>' + '/api/RowLevels/' + DbName + '/GetLevelsBySchool',-->
<!--                type: "GET",-->
<!--                data: {-->
<!--                    schoolId: schoolID,-->
<!--                    studyTypeId: studeType,-->
<!--                    genderId: ClassTypeName-->
<!--                },-->
<!--                dataType: "json",-->
<!--                success: function(data) {-->
<!--                    var element = $('#levelID');-->
<!--                    element.empty();-->
<!--                    element.append('<option value=""><?php echo lang('am_choose_select'); ?></option>');-->
<!--                    $.each(data, function(key, value) {-->
<!--                        element.append('<option value="' + value.LevelId + '">' + value-->
<!--                            .LevelName + '</option>');-->

<!--                    });-->
<!--                }-->
<!--            });-->
<!--        } else {-->
<!--            var element = $('#levelID');-->
<!--            element.empty();-->
<!--            element.append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');-->
<!--        }-->
<!--    });-->
<!--</script>-->

<!--<script type="text/javascript">-->
<!--    $('select[name^="levelID"]').on('change', function() {-->
<!--        var levelID = $(this).val();-->
<!--        var schoolID = $('#schoolID').val();-->
<!--        var studeType = $('#studeType').val();-->
<!--        var ClassTypeName = $('#ClassTypeName').val();-->
<!--        var DbName = $('#DbName').val();-->
<!--        if (schoolID && levelID) {-->
<!--            $.ajax({-->
<!--                url: '<?php echo lang("api_link"); ?>' + '/api/RowLevels/' + DbName + '/GetRowsByLevel',-->
<!--                type: "GET",-->
<!--                data: {-->
<!--                    schoolId: schoolID,-->
<!--                    levelId: levelID,-->
<!--                    studyTypeId: studeType,-->
<!--                    genderId: ClassTypeName-->
<!--                },-->
<!--                dataType: "json",-->
<!--                success: function(data) {-->
<!--                    var element = $('#rowID');-->
<!--                    element.empty();-->
<!--                    element.append('<option value=""><?php echo lang('am_choose_select'); ?></option>');-->
<!--                    $.each(data, function(key, value) {-->

<!--                        element.append('<option value="' + value.RowId + '">' + value.RowName +-->
<!--                            '</option>');-->
<!--                        $('#FeeStatus').val(value.IsSpecialEdu);-->
<!--                        if (value.IsSpecialEdu == 1) {-->
<!--                            document.getElementById("show_status").style.display = "block";-->
<!--                        } else {-->
<!--                            document.getElementById("show_status").style.display = "none";-->
<!--                        }-->
<!--                    });-->

<!--                }-->
<!--            });-->
<!--        } else {-->
<!--            var element = $('#rowID');-->
<!--            element.empty();-->
<!--            element.append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');-->
<!--        }-->
<!--    });-->
<!--</script>-->
<!--<script type="text/javascript">-->
<!--    $('select[name^="rowID"]').on('change', function() {-->
<!--        var rowId = $(this).val();-->
<!--        var schoolID = $('#schoolID').val();-->
<!--        var studeType = $('#studeType').val();-->
<!--        var ClassTypeName = $('#ClassTypeName').val();-->
<!--        var levelID = $('#levelID').val();-->
<!--        var DbName = $('#DbName').val();-->
<!--        if (schoolID && levelID && rowId) {-->
<!--            $.ajax({-->
<!--                url: '<?php echo lang("api_link"); ?>' + '/api/RowLevels/' + DbName + '/GetFeeStatus',-->
<!--                type: "GET",-->
<!--                data: {-->
<!--                    schoolId: schoolID,-->
<!--                    levelId: levelID,-->
<!--                    rowId: rowId,-->
<!--                    studyTypeId: studeType,-->
<!--                    genderId: ClassTypeName-->
<!--                },-->
<!--                dataType: "json",-->
<!--                success: function(data) {-->
<!--                    var element = $('#status');-->
<!--                    element.empty();-->
<!--                    element.append('<option value=""><?php echo lang('am_choose_select'); ?></option>');-->
<!--                    $.each(data, function(key, value) {-->
<!--                        element.append('<option value="' + value.StatusId + '">' + value-->
<!--                            .StatusName + '</option>');-->
<!--                    });-->
<!--                }-->
<!--            });-->
<!--        } else {-->
<!--            var element = $('#status');-->
<!--            element.empty();-->
<!--            element.append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');-->
<!--        }-->
<!--    });-->
<!--</script>    -->
<script  src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script>
  
  function setDirectionForParagraphs() {
    
    const elementsH = document.querySelectorAll('.question-card__question');
    elementsH.forEach(element => {
        const paragraphs = element.querySelectorAll('p');
        if (paragraphs.length > 0) {
            let foundArabic = false;
            paragraphs.forEach(p => {
                if (/[\u0600-\u06FF\u0750-\u077F]/.test(p.textContent)) {
                    foundArabic = true;
                }
            });

            if (foundArabic) {
                element.style.textAlign = 'right';
            } else {
                element.style.textAlign = 'left';
            }
        }
    });
}

function isArabic(text) {
    var arabicRegex = /[\u0600-\u06FF]/;
    return arabicRegex.test(text);
}

window.onload = setDirectionForParagraphs;


VirtualSelect.init({
  ele: 'select',
  disableSelectAll: true,
  search: false,
});
  </script>
  
  
  
    <script>
      const studybox = document.getElementById("studeType");
      const schoolbox = document.getElementById("schoolID");
      const levelbox = document.getElementById("levelID");
      const levelRow = document.getElementById("rowID");
      const statusbox = document.getElementById("status");
      const dbName = document.getElementById("DbName").value;
     let currentValue = 1;
      studybox.addEventListener("change", (e) => {
        schoolbox.destroy();
        
        let value = e.target.value;
        let dataUrl = '<?php echo lang("api_link"); ?>' + '/api/Schools/' + dbName + '/GetSchoolsByStudyType?studyTypeId=' + value;
        VirtualSelect.init({
          ele: "#schoolID",
        });
        fetch(dataUrl).then(response => response.json()).then(data => {
            data.forEach(select => {
                schoolbox.addOption({
                    value: select.SchoolId,
                    label: select.SchoolName,
                });
                
            })
        })
      });
     
      
      schoolbox.addEventListener("change", (e) => {
    var schoolID = e.target.value;
    if (!schoolID) {
        return;  
    }
    var studeType = document.getElementById("studeType").value;
    var ClassTypeName = document.getElementById("ClassTypeName").value;
    levelbox.destroy();
    
    let dataUrl = '<?php echo lang("api_link"); ?>' + '/api/RowLevels/' + dbName + '/GetLevelsBySchool?schoolId=' + schoolID + "&studyTypeId=" + studeType + "&genderId=" + ClassTypeName;
    
    VirtualSelect.init({
        ele: "#levelID",
    });
    
    fetch(dataUrl)
        .then(response => response.json())
        .then(data => {
            data.forEach(select => {
                levelbox.addOption({
                    value: select.LevelId,
                    label: select.LevelName,
                });
            });
        });
});

      
         
      levelbox.addEventListener("change", (e) => {
        var levelID = e.target.value;
        if (!levelID) {
            return;  
        }
        var studeType = document.getElementById("studeType").value
        var schoolID = document.getElementById("schoolID").value
        var ClassTypeName = document.getElementById("ClassTypeName").value;
        
        levelRow.destroy();
        
        let dataUrl = '<?php echo lang("api_link"); ?>' + '/api/RowLevels/' + dbName + '/GetRowsByLevel?schoolId=' + schoolID + "&studyTypeId=" + studeType + "&genderId=" + ClassTypeName + "&levelId=" + levelID;
        VirtualSelect.init({
          ele: "#rowID",
        });
        
        fetch(dataUrl).then(response => response.json()).then(data => {
            data.forEach(select => {
                levelRow.addOption({
                    value: select.RowId,
                    label: select.RowName,
                });
                if(select.IsSpecialEdu === 1){
                    document.getElementById("show_status").style.display = 'block';
                }else{
                    document.getElementById("show_status").style.display = 'none';
                }
            })
        })
      });
      
               
      levelRow.addEventListener("change", (e) => {
        var rowID = e.target.value;  
        if (!rowID) {
            return;  
        }
        var studeType = document.getElementById("studeType").value
        var schoolID = document.getElementById("schoolID").value
        var ClassTypeName = document.getElementById("ClassTypeName").value;
        var levelID = document.getElementById("levelID").value;
        
        statusbox.destroy();
        let dataUrl = '<?php echo lang("api_link"); ?>' + '/api/RowLevels/' + dbName  + '/GetFeeStatus?schoolId=' + schoolID + "&studyTypeId=" + studeType + "&genderId=" + ClassTypeName + "&levelId=" + levelID + "&rowId=" + rowID;
        VirtualSelect.init({
          ele: "#status",
        disableSelectAll: false,
        });
            
        fetch(dataUrl).then(response => response.json()).then(data => {
            data.forEach(select => {
                statusbox.addOption({
                    value: select.StatusId,
                    label: select.StatusName,
                });
            })
        })
      });
      
    </script>
  