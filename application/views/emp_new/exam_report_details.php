<?php extract($data) ; ?>
        <?php
                $query = $this->db->query("SELECT exam_result,appear_exam_result_after, homework_result,appear_homework_result_after 
                                           FROM config_emp_school 
                                           WHERE schoolID = '".$this->session->userdata('SchoolID')."'  
                                           ")->row_array();
                if(sizeof($query) > 0 ){
                       $exam_result =  $query['exam_result']; 
                       $appear_exam_result_after =  $query['appear_exam_result_after']; 
                       $homework_result =  $query['homework_result']; 
                       $appear_homework_result_after =  $query['appear_homework_result_after']; 
                                       }

				foreach ($GetData as $Key => $row) { 
										$test_type    = $row->type;
										if($test_type==1){
										 $exam_result=$homework_result;
										 $appear_exam_result_after=$appear_homework_result_after;
										}}
										
                $query_type = $this->db->query("SELECT `type` FROM `test` WHERE `ID`= '".$test."'  ")->row_array();
										
                ?>
    <style>
   @media print {
   
     .breadcrumb{
        display:none;   
     }
     .flexbox{
        display:none;  
     }
     
     
   @page {
    size: A3;
    }
   }
   
     img:not([width]),
      img:not([height]) {
    display: none;

}
.thumbnail-image {
    max-width: 100px; 
    max-height: 100px; 
    transition: transform 0.3s ease-in-out;
    border-radius: 1%;

}

.thumbnail-image:hover {
    transform: scale(4);
    border-radius: 5%;
}
img {
    width: unset;
     /* //math function is displayd too large */
}
.info {
    display: inline-block; 
    color: #007bff;
    text-decoration: none; 
    font-weight: bold; 
    padding-left: 24px;
    position: relative; 
}

.info:before {
    /* content: ''; */
    position: absolute;
    left: 0; 
    top: 50%;
    transform: translateY(-50%); 
    width: 16px; 
    height: 16px; 
   
}
.tx-align-center{
    text-align: center;
}

    </style>
        <!-- Layout Wraper -->
        <div class="row no-guuter row-reverse">
            
            <!-- Page Wraper -->
            <!--<div class="page-wraper">-->

                <!-- Page Head -->
                <div class="page-head blue container-fluid pt30">
                    <!-- Breadcrumb -->
                    <div class="breadcrumb">
                        <a href="<?php echo site_url('emp/cpanel') ?>" class="ti-x fas fa-home"><?php echo lang('er_main');?></a>
                        <span><?php echo $GetData[0]->subject_Name ;?></span>
                        <span><?php echo $GetData[0]->teacherName ;?></span>
                    </div>
                    <!-- Title -->
                    <h2><?php if($query_type['type']==1){echo lang('am_homework');}else{echo lang('Exams');} ?> </h2>
                </div>
                <!-- // Page Head -->
                <!-- Divider --> <div class="keep-it-between-those-elements"></div>
          	    
                <!-- Data Table -->
                <?php
			    if (is_array($GetData)) {
				if ($show != NULL) {
			    ?>
			     <div class="flexbox table-action-btns mb0i">
                        
                        <button type="button" id="print" class="btn small pink-bg rounded btn-icon fal fa-print" >print</button>
                    </div>
                <div class="container-fluid responsive-sm-table white-bg padding-all-20 mb0">
                    <table class="table bordered-y data-table white-bg medium-spaces" data-items="12">
                        <caption style="color: red; font-size: xx-large;"><?php echo $GetData[0]->testname ;?></caption>
                        <!-- Table Head -->
                        <thead>
                            <tr class="blue-bg">
                                <th class="width-50 tx-align-center hide-sort-arrow">#</th>
                                <th class="tx-align-center hide-sort-arrow" ><?php echo lang('er_studentName');?></th>
                                <th class="tx-align-center hide-sort-arrow" ><?php echo lang('date_of_stdent_answer');?></th>
                                <!--<th class="tx-align-center hide-sort-arrow" ><?php if($query_type['type']==1){echo lang('am_homework');}else{echo lang('Exams');} ?> </th>-->
                                <th class="tx-align-center hide-sort-arrow" ><?php echo lang('Type_question');?></th>
                                <th class="tx-align-center hide-sort-arrow" ><?php echo lang('am_qus');?></th>
                                <th class="tx-align-center hide-sort-arrow" ><?php echo lang('correct answer');?></th>
                                <th class="tx-align-center hide-sort-arrow" ><?php echo lang('Student answer');?></th>
                                <th class="tx-align-center hide-sort-arrow" ><?php echo lang('degree of the question');?></th>
                                <th class="tx-align-center hide-sort-arrow" ><?php echo lang('test_student_degree');?></th>
                            </tr>
                        </thead>
                        <!-- Table Body -->
                    
                        <tbody>
                            <!-- Row -->
                             <?PHP  
                             	foreach ($GetData as $Key => $row) {
									    $faield_style_status  = 0;
										$Num                  = $Key + 1;
										$LevelName            = $row->LevelName;
										$test_type            = $row->type;
										$RowName              = $row->RowName;
										$ClassName            = $row->ClassName;
										$StudentName          = $row->FullName;
										$subject_Name         = $row->subject_Name;
										$teacherName          = $row->teacherName;
										$FullName             = $row->FullName;
										$testname             = $row->testname;
										$ques_answer          = $row->ques_answer;
										$Answer_match         = $row->Answer_match;
										$st_answer            = $row->st_answer;
										$st_answer_m          = $row->st_answer_m;
										$st_answer_complete   = $row->st_answer_complete;
										$attachment           = $row->attachment;
										$questionDegree       = $row->questionDegree;
										$Degree               = $row->Degree;
										$stu_date             = $row->stu_date;
										$stu_date_updated     = $row->stu_date_updated;
										$is_updated           = $row->is_updated;
										$questions_content_ID = $row->questions_content_ID;
										$questions_types      = $row->questions_types;
										$questions_types_Name = $row->questions_types_Name;
								    	$quesanswer_ID        =	$row->quesanswer_ID;
                                        $attach               = $row->Q_attach;
										$Question             =$row->Question;
										$Date_Stm             = $row->question_date;
										
										$query_count          = $this->db->query("SELECT COUNT(`ID`) AS cor_count 
										                                          FROM `answers` 
										                                          WHERE `Answer_correct` = '1' 
										                                          AND `Questions_Content_ID` = $questions_content_ID
										                                          ")->row_array();
										
										
										 $Answer_correct = $query_count['cor_count'];
						//	print_r((round($questionDegree / $Answer_correct,5) ));die;
						//	print_r($ques_answer);die;		 
										if($test_type==1){
										    $exam_result   =  $homework_result;
										    $appear_exam_result_after=$appear_homework_result_after;
										    
										}
								
							                
										if($Degree<($questionDegree/2)){
										    
										    $faield_style_status=1;
										}
							        
										if($questions_types==6&&$Degree==''){
										    $faield_style_status=0;
										}
										if($questions_types==6&&$Degree==0){
										    $faield_style_status=1;
										}
										if($questions_types==7 || $questions_types==2  ){
										    
										    if((round( $Degree , 5 )) < (round($questionDegree / $Answer_correct,5) )){
										        
										    $faield_style_status=1;
										    }else{
										       $faield_style_status=0; 
										    }
										   
										}
										if($questions_types==7){
										  //  $ques_answer = $ques_answer;
									//	  $Question   = $Answer_match;
										  $emp_answer=explode("___", $st_answer_m); 
										  $emp_answer=$emp_answer[0] ;
										   //print_r($emp_answer); die; 
										  $Question=$emp_answer;
										 	$query_st_answer         = $this->db->query("SELECT Answer  FROM `answers` 
                    										 	 
                    										 	                                 WHERE answers.`Answer_match` = '".$emp_answer."'
                    										 	                                 AND answers.test_id = $test
                    										 	                                 ")->row_array();
                    										 	                                
                    										 	                            	
                    						 $ques_answer = $query_st_answer['Answer'];				                                         
                    										                                        
										  
										}
										
									?>
									
                            <tr  <?php if($faield_style_status==1){?>style="background-color: #f7c6c6;" <?php }?>>
                            
                                            <td class="tx-align-center"><?php echo $Num; ?></td>
											
											<td class="tx-align-center"><?= $FullName ?></td>
											
											<td class="tx-align-center"><?php if($is_updated==0){echo $stu_date;}if($is_updated==1){echo $stu_date_updated;}?></td>
											
											<td class="tx-align-center"><?= $questions_types_Name ?></td>
									
											<td class="tx-align-center">
                                            <?
                                                echo $Question;
                                                echo"</br>";
                                                $ImagePath =base_url().'assets/exam/'.$attach; //if i wont displat image dirctle
                                                if(file_exists('./assets/exam/'.$attach)&&$attach!=""){?>
                                                <img src="<?php echo base_url()?>assets/exam/<?php echo $attach;?>" alt="<?php echo lang('am_attach');?>" width="" height="" class="thumbnail-image">
                                               <? }
                                           ?>
                                            
                                            </td>
											
											<td class="tx-align-center"><?php 
                                            if($ques_answer!=""&&file_exists('./assets/exam/'.$ques_answer)){?>
<a class="btn purble-bg" target="_blank" href="<?php echo base_url()?>assets/exam/<?php echo $ques_answer;?>" class="zoomable-image">
    <img src="<?php echo base_url()?>assets/exam/<?php echo $ques_answer;?>" alt="Question Answer"  width="" height="" class="thumbnail-image">
    <?php echo lang('am_attach');?>
</a>
                                                <?php echo lang('am_attach'); ?> </a><?php }else{echo $ques_answer; }?>
                                            </td>
											
                                            <td class="tx-align-center"><?php if($questions_types==6){
                                                    $content = $st_answer_complete;
                                                //    $content = preg_replace("/<img[^>]+\>/i", " ", $content); 
                                                      echo "<div class='ql-container'>";
                                                        echo $content;
                                                        echo "</div></br>"; 
                                               
                                                                             ?>
                                                  <?php if ($st_answer_m){ ?>   
                                 <img src="<?php echo base_url()?>assets/exam/<?php echo $st_answer_m;?>"  width="" height="" alt="Student Answer" class="thumbnail-image">
   
                       
                                            <?php }}elseif($questions_types==4){
                                            echo '<div " class="ql-container">'.$st_answer_complete.'</dive>';

                                                // echo $st_answer_complete;
                                                }elseif($questions_types==8){ ?>
    <img src="<?php echo base_url()?>assets/exam/<?php echo $st_answer_m;?>" alt="Student Answer"  width="" height="" class="thumbnail-image">
                                              <? }elseif($questions_types== 2 ){
                                               if(file_exists('./assets/exam/'.$st_answer)&&$st_answer!=""){?>
                                                <img src="<?php echo base_url()?>assets/exam/<?php echo $st_answer;?>"  width="" height="" alt="Student Answer" class="thumbnail-image">

                                               <?  }else{echo $st_answer;}} else{ echo $st_answer;} ?></td>

											<td class="tx-align-center"><?= $questionDegree ?> </td>
            
											<td class="tx-align-center"><?= $Degree ?></td>
                            </tr>
                            <!-- // Row -->
                                      <!-- // Table Body -->
                        <?php
                }
                ?>
                        </tbody>
              
                    </table>
                </div>
                <?php }} 
                else { ?>
				<div class="alert alert-danger"><?php echo lang('Not_exit'); ?> </div>
			    <?php } ?>
                <!-- // Data Table -->
            </div>
            <!-- // Page Wraper -->
            <!-- <script>
          function setDirectionForTableData() {
    var tableData = document.querySelectorAll('.table.medium-spaces tbody tr td');

    tableData.forEach(function(td) {
        if (isArabic(td.textContent)) {
            td.style.direction = 'rtl';
        } else {
            td.style.direction = 'ltr'; 
        }
    });
}

function isArabic(text) {
    var arabicRegex = /[\u0600-\u06FF]/;
    return arabicRegex.test(text);
}

window.onload = setDirectionForTableData;

            </script> -->

<script>
    function setDirection() {
    var paragraphs = $('.tx-align-center');

    paragraphs.each(function() {
        var text = $(this).text();
        $(this).attr('dir', 'auto');

       
    });
}
$(document).ready(function() {
    setDirection();

});
  </script>
