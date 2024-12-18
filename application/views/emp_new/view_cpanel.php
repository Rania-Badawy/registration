<style>    
@media print {
    html , body{
        margin: 0 !important;
        padding: 0 !important;
        اheight: 100%;
        overflow: hidden
    }
  body *{
    visibility: hidden;
  }
  #printTable, #printTable * {
    visibility: visible;
  }
  #printTable{
      position: absolute;
      top: -350px;
      right: 0;
  }
  .LessonsTable .table{
    border-collapse: separate !important;
    border-spacing: 8px !important;;
    margin-top: 10px !important;;
  }
  .lessonsDateDay,
  .lessonteacherDateEven{
      background-image:none !important;
      background:linear-gradient(#d5f4ff, #84ceff) !important;
      -webkit-print-color-adjust: exact;
      border-radius: 8px !important;
      height: 25px !important; 
      line-height: 25px !important;
  }
  .lessonteacherDateEven{
      background:linear-gradient(#ffd6d6, #fb9f9f) !important;
  }
}
.lessonsDateDay,
.lessonteacherDateEven{
      background-image:none !important;
      background:linear-gradient(#d5f4ff, #84ceff) !important;
      border-radius: 8px !important;
      height: 25px !important; 
      line-height: 25px !important;
      width: 100% !important;
      right:0 !important;
  }
  .lessonteacherDateEven{
      background:linear-gradient(#ffd6d6, #fb9f9f) !important;
  }
  .modal-head{text-align: right;
    margin-top: 0;
}
  </style> 
  <?php

  $get_api_setting=$this->setting_model->get_api_setting(); 
  $this->ApiDbname=$get_api_setting[0]->{'ApiDbname'}; 
$query_setting=$this->db->query("select * from setting")->row_array();
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets_new/css/table_style.css">
 <?php  $query = $this->db->query("SELECT jobTitleID FROM employee	WHERE Contact_ID = '".$this->session->userdata('id')."' ")->row_array();
    if( $query['jobTitleID'] != 0){ ?>
<div style="display: flex;justify-content: space-around;flex-wrap: wrap;direction: rtl;">
        <div class="indications">  
            <div class="indication_card">
                <img src="<?php echo base_url(); ?>assets/upload_home/Group 408.svg" class="ficon" />
                   <?php if($this->ApiDbname=="ksiscs" ){ ?>
                <span><b class="count"><?php echo $count_student['count_student'];?></b><span class="indication_card_text"><?php echo lang('num_trainees');?></span></span>
                 <?php }else{ ?>
                 <span><b class="count"><?php echo $count_student['count_student'];?></b><span class="indication_card_text"><?php echo lang('am_num_student');?></span></span>
                 <?php } ?>
                <img src="<?php echo base_url(); ?>assets/upload_home/Group 408.svg"  class="sicon"/>
            </div>
        </div>
        <div class="indications">  
            <div class="indication_card">
                <img src="<?php echo base_url(); ?>assets/upload_home/Group 354.svg" class="ficon" />
                <span><b class="count"><?php echo $visitor;?></b><span class="indication_card_text"><?php echo lang('visitor_all');?></span></span>
                <img src="<?php echo base_url(); ?>assets/upload_home/Group 354.svg"  class="sicon"/>
            </div>
        </div> 
        <div class="indications">  
            <div class="indication_card">
                <img src="<?php echo base_url(); ?>assets/upload_home/Group 409.svg" class="ficon" />
                <span><b class="count" ><?php echo $get_visitors_day;?></b><span class="indication_card_text"><?php echo lang('visitor_day'); ?> </span></span>
                <img src="<?php echo base_url(); ?>assets/upload_home/Group 409.svg"  class="sicon"/>
            </div>
        </div>
        <div class="indications">  
            <div class="indication_card">
                <img src="<?php echo base_url(); ?>assets/upload_home/Group 407.svg" class="ficon" />
                   <?php if($this->ApiDbname=="ksiscs" ){ ?>
                 <span><b class="count"><?php echo $count_emp['count_emp'];?></b><span class="indication_card_text"><?php echo lang('Num_trainers');?></span></span>
                 <?php }else{ ?>
                 <span><b class="count"><?php echo $count_emp['count_emp'];?></b><span class="indication_card_text"><?php echo lang('am_num_emp');?></span></span>
                 <?php } ?>
               
                <img src="<?php echo base_url(); ?>assets/upload_home/Group 407.svg"  class="sicon"/>
            </div>
        </div>
    </div>
    <div class="new_div col-12">
                            
                            <?php  foreach($get_advertisment as $keyy=>$item){
                                    $ID              = $item->ID;
                                    $ImagePath=explode(",",$item->ImagePath);
                                    array_pop($ImagePath);
                                    foreach($ImagePath as $key=>$Image)
                                    $Title           = $item->Title;
                                    $Content         = filter_var($item->Content, FILTER_SANITIZE_STRING);
                                    $Date            = $item->Date;
                                 
                                
                                ?>
                                <div id="modal<?=$keyy?>" class="modal">
                                    <div class="modal-content">
                                        <span class="close">&times;</span>
                                        <h2 class=" textToSpeak modal-head"><?php echo $Title ?></h2>
                                        <div id="carousel<?=$keyy?>" class="carouselM">
                                            <?php foreach($ImagePath as $key=>$Image){?>
                                                <div class='carouselM-item<?=$keyy?> carousel-item'>
                                                    <img src="<?php echo base_url().'upload/'.$Image ?>" width="100%" style="height:400px;">
                                                </div>
                                            <?php }?>
                                            <button id="next-btn<?=$keyy?>" class="carBtn next"><</button>
                                            <button id="prev-btn<?=$keyy?>" class="carBtn prev">></button>
                                            </div>
                                        <p class="textToSpeak"><?= $Content ?></p> 
                                    </div>
                                </div>
    
                                <script>
                                                                        
                                        var carousel<?=$keyy?> = document.getElementById('carousel<?=$keyy?>');
                                        var carouselItems<?=$keyy?> = carousel<?=$keyy?>.querySelectorAll('.carouselM-item<?=$keyy?>');
                                        var prevButton<?=$keyy?> = document.getElementById('prev-btn<?=$keyy?>');
                                        var nextButton<?=$keyy?> = document.getElementById('next-btn<?=$keyy?>');
    
                                        let currentIndex = 0;
                                        if (carouselItems<?=$keyy?>.length === 1) {
                                            nextButton<?=$keyy?>.style.display = 'none';
                                            prevButton<?=$keyy?>.style.display = 'none';
                                        }
                                        function showNextItem() {
                                            
                                            carouselItems<?=$keyy?>[currentIndex].style.display = 'none';
                                            if (currentIndex < carouselItems<?=$keyy?>.length - 1) {
                                                nextButton<?=$keyy?>.disabled = false;
                                                currentIndex++;
                                            }
                                            carouselItems<?=$keyy?>[currentIndex].style.display = 'block'
                                            if (currentIndex === carouselItems<?=$keyy?>.length - 1) {
                                            nextButton<?=$keyy?>.disabled = true;
                                            }
                                            prevButton<?=$keyy?>.disabled = false;
                                        }
                                        function showPreviousItem() {
                                            carouselItems<?=$keyy?>[currentIndex].style.display = 'none';
                                            if (currentIndex > 0) {
                                            currentIndex--;
                                            }
                                            carouselItems<?=$keyy?>[currentIndex].style.display = 'block';
                                            if (currentIndex === 0) {
                                            prevButton<?=$keyy?>.disabled = true;
                                            }
                                            nextButton<?=$keyy?>.disabled = false;
                                        }
                                        carouselItems<?=$keyy?>[currentIndex].style.display = 'block';
                                        prevButton<?=$keyy?>.disabled = true;
                                        prevButton<?=$keyy?>.addEventListener('click', showPreviousItem);
                                        nextButton<?=$keyy?>.addEventListener('click', showNextItem);
                                </script>
                                <div id="overlay"></div> 
                        <?php } ?>
                        
                        <?php  foreach($latest_news as $keyy=>$item){
                                    $ID              = $item->ID;
                                    
                                    $TitleNews           = $item->Title;
                                    $ContentNews         = filter_var($item->Content, FILTER_SANITIZE_STRING);
                                    $Date            = $item->Date;
                                    $ImagePathNews=explode(",",$item->ImagePath);
                                    array_pop($ImagePathNews);
                                    foreach($ImagePathNews as $key=>$ImageNews);
                                                                    
                                ?>
                                <div id="modal-news<?=$keyy?>" class="modal">
                                    <div class="modal-content">
                                        <span class="close">&times;</span>
                                        <h2 class=" textToSpeak modal-head"><?php echo $TitleNews ?></h2>
                                        <div id="carouseln<?=$keyy?>" class="carouselM">
                                            <?php foreach($ImagePathNews as $key=>$ImageNews){?>
                                                <div class='carouselM-itemn<?=$keyy?> carousel-item'>
                                                    <img src="<?php echo base_url().'upload/'.$ImageNews ?>" width="100%" style="height:400px;">
                                                </div>
                                            <?php }?>
                                            <button id="next-btnn<?=$keyy?>" class="carBtn next"><</button>
                                            <button id="prev-btnn<?=$keyy?>" class="carBtn prev ">></button>
                                            </div>
                                        <p class="textToSpeak"><?= $ContentNews ?></p> 
                                    </div>
                                </div>  
                                <script>
                                    debugger;
                                    var carouseln<?=$keyy?> = document.getElementById('carouseln<?=$keyy?>');
                                    var carouselItemsn<?=$keyy?> = carouseln<?=$keyy?>.querySelectorAll('.carouselM-itemn<?=$keyy?>');
                                    var prevButtonn<?=$keyy?> = document.getElementById('prev-btnn<?=$keyy?>');
                                    var nextButtonn<?=$keyy?> = document.getElementById('next-btnn<?=$keyy?>');
                                    var CarButtonn = document.querySelector('.carBtn');
    
                                    let currentIndexn = 0;
                                    if (carouselItemsn<?=$keyy?>.length === 1) {
                                        nextCarButtonn.style.display = 'none';
                                    }
                                    function showNextItem() {
                                        
                                        carouselItemsn<?=$keyy?>[currentIndexn].style.display = 'none';
                                        if (currentIndexn < carouselItemsn<?=$keyy?>.length - 1) {
                                            currentIndexn++;
                                        }
                                        carouselItemsn<?=$keyy?>[currentIndexn].style.display = 'block'
                                        if (currentIndexn === carouselItemsn<?=$keyy?>.length - 1) {
                                        nextButtonn<?=$keyy?>.disabled = true;
                                        }
                                        prevButtonn<?=$keyy?>.disabled = false;
                                    }
                                    function showPreviousItem() {
                                        carouselItemsn<?=$keyy?>[currentIndexn].style.display = 'none';
                                        if (currentIndexn > 0) {
                                        currentIndexn--;
                                        }
                                        carouselItemsn<?=$keyy?>[currentIndexn].style.display = 'block';
                                        if (currentIndexn === 0) {
                                        prevButtonn<?=$keyy?>.disabled = true;
                                        }
                                        nextButtonn<?=$keyy?>.disabled = false;
                                    }
                                    carouselItemsn<?=$keyy?>[currentIndexn].style.display = 'block';
                                    prevButtonn<?=$keyy?>.disabled = true;
                                    prevButtonn<?=$keyy?>.addEventListener('click', showPreviousItem);
                                    nextButtonn<?=$keyy?>.addEventListener('click', showNextItem);
                                </script>
                        <?php } ?>
    
                        
                        <?php $rootDir = realpath($_SERVER["DOCUMENT_ROOT"]); ?>
                            <?php include("$rootDir/application/views/admin/admin_main_view.php"); ?>
                        </div>
<?php } ?>
                       
                <!-- Page Content -->
                <div class="container page-content">
                    <!-- Grid -->
                    <div class="row">
                        <!-- Welcome Card -->
                        <?php 
                        $id = $this->session->userdata('id');
                        $teacher_name = $this->db->query("select Name from contact where ID = ".$id." ")->row_array();
                        ?>
                        <div class="welcome-card col-12 col-m-4 col-auto mxw-480">
                            <div class="content-box">
                                <h2><?php echo lang('ra_hello');?><?php echo $teacher_name['Name'];?></h2>
                                <p><?php echo lang('na_message_of_proud');?></p>
                                <img src="../img/illistration@2x.png" alt="" class="floating">
                            </div>
                        </div>
                        <?php if( $query['jobTitleID'] == 0 && $query_setting['platform']=="1"){  ?>
                        <!-- Statistic Card -->
                        <?php
                        $cast_date  = date('Y-m-d', strtotime($date));
                        $sem_date = $this->db->query("SELECT ID,start_date,end_date  FROM config_semester WHERE '".$cast_date."' BETWEEN config_semester.start_date AND config_semester.end_date ")->row_array();
                    //   print_r($sem_date);die;
                        $homework_to_correct = $this->db->query("SELECT * FROM `clerical_homework` 
                                                                 INNER JOIN clerical_homework_answer ON clerical_homework_answer.homework_id = clerical_homework.ID
                                                                 WHERE clerical_homework.type = 0 
                                                                 AND clerical_homework.Emp_ID = ".$id." 
                                                                 AND clerical_homework.is_deleted = 0 
                                                                 AND clerical_homework_answer.student_result IS NULL 
                                                                 AND clerical_homework.date_from BETWEEN '".$sem_date['start_date']."' AND '".$sem_date['end_date']."'
                                                                ")->num_rows();
                                                        //   print_r(date($date));die;
                        ?>
                        <?php  if(($this->ApiDbname  != "ksiscs")){ ?>
                        <div class="statistic-card col-12 col-m-4 col-l-2 col-auto">
                            <div class="content-box">
                                <i class="icon fal fa-download"></i>
                                <h3 data-counter="<?php echo $homework_to_correct; ?>"></h3>
                                <p><?php echo lang('homework_to_correct');?></p>
                                <!--<a href="#" class="more-btn fal fa-arrow-right btn small circle"></a>-->
                            </div>
                        </div>
                        <!-- Statistic Card -->
                        <?php $ask_total = $this->db->query("SELECT * FROM `ask_teacher` 
                        						              inner join student on ask_teacher.studentID=student.Contact_ID
                        						              inner join class_table on student.R_L_ID=class_table.RowLevelID and student.Class_ID=class_table.ClassID
                        						              inner join config_subject on config_subject.ID = ask_teacher.config_subjectID
                        						              inner join contact on contact.ID = ask_teacher.studentID and contact.SchoolID IN(".$this->session->userdata('SchoolID').")
                        						              inner join subject on subject.ID = class_table.SubjectID and subject.ID =config_subject.SubjectID
                                                              WHERE class_table.EmpID='".$this->session->userdata('id')."' AND ask_teacher.teacherID IS NULL
                                                              GROUP BY ask_teacher.ID ")->num_rows();?>
                        <div class="statistic-card col-12 col-m-4 col-l-2 col-auto">
                            <div class="content-box">
                               <i class="icon fal fa-download"></i> 
                                <h3 data-counter="<?php echo $ask_total; ?>"></h3>
                                <p><?php echo lang('ques_from_stu');?></p>
                              <!-----  <a href="" class="more-btn fal fa-arrow-right btn small circle"></a> -------------->
                            </div>
                        </div>
                        <?php } ?>
                        <!-- Statistic Card -->
                        <?php 
                        $week_array          = $this->db->query("select WEEK('$date') as week_id")->row_array();
		                $WeekID              = $week_array['week_id'];
                        $chkMove                   = 0;
             
		                 if($this->ApiDbname=="SchoolAccGheras" || $this->ApiDbname=="SchoolAccExpert")
			                 {
			                    if($WeekID%2==1){
			                        $chkMove=1;
    			                 }elseif($WeekID%2==0){
    			                      $chkMove=2;
    			                 }else{
    			                     $chkMove=0;
    			                 }
			                 }
                          $num_of_class_table = $this->db->query("SELECT * FROM `class_table`
                                                                  INNER JOIN row_level ON row_level.ID = class_table.RowLevelID
                                                                  INNER JOIN subject ON subject.ID = class_table.SubjectID
                                                                  INNER JOIN class ON class.ID = class_table.ClassID
                                                                WHERE class_table.`EmpID` = ".$id." and (chkMove=0 or chkMove=$chkMove)")->num_rows();
                        ?>
                        <div class="statistic-card col-12 col-m-4 col-l-2 col-auto">
                            <div class="content-box">
                                <!--<i class="icon fal fa-download"></i>-->
                                <!--<h3 data-counter="<?php echo $num_of_class_table; ?>"></h3>-->
                               <i class="icon fal fa-download"></i>
                                <h3 data-counter="<?php echo $num_of_class_table; ?>"></h3>
                                 <?php  if(($this->ApiDbname  == "ksiscs")){ ?>
                                <p><?php echo lang('courses_week');?></p>
                                <?php }else{ ?>
                                <p><?php echo lang('class_table_for_week');?></p>
                                <?php } ?>
                             <?php   if(($this->ApiDbname  == "SchoolAccShorouqAlmamlakah")){
                        $SCHOOL_SHO=$this->db->query("SELECT contact.SchoolID  FROM contact  WHERE ID = '".$this->session->userdata('id')."' ")->row_array();
                        if($SCHOOL_SHO['SchoolID'] == 1 ) {  
                    ?> 

                                <a href="<?php echo site_url('emp/class_table/class_table_emp/1') ?>" class="more-btn fal fa-arrow-right btn small circle"></a>
                           <?php }  elseif($SCHOOL_SHO['SchoolID'] == 4 ) { ?>
                           <a href="<?php echo site_url('emp/class_table/class_table_emp/2') ?>" class="more-btn fal fa-arrow-right btn small circle"></a>
                           <?php }else{ ?>
                           <a href="<?php echo site_url('emp/class_table/class_table_emp/1') ?>" class="more-btn fal fa-arrow-right btn small circle"></a>
                           <?php }}else{
                                    $groupDay=$this->db->query("SELECT `group_day` from lesson GROUP BY `group_day`")->row_array();
                                    $group_day = $groupDay['group_day'];
                                    ?>
                           <a href="<?php echo site_url('emp/class_table/class_table_emp/'.$group_day) ?>" class="more-btn fal fa-arrow-right btn small circle"></a>
                           <?php }?>
                            </div>
                        </div>
                        <!-- // Statistic Card -->
                    </div>
                    <!-- // Grid -->
                    <?php 
                        $get_group_day = $this->db->query("SELECT group_day FROM lesson group by group_day")->result();
                            $Date       = date('Y-m-d');
                            $Date_plus  = date('Y-m-d', strtotime("+1 days"));
                            $Day        = date('D', strtotime($Date));
                            $Day_plus   = date('D', strtotime($Date_plus));
                            $dayname    = $this->db->query("select ID,Name_en,Name from day where Name_en like '%$Day%'")->row_array();
                          // print_r($dayname['Name']);die;
                            $daynameplus= $this->db->query("select ID,Name_en,Name from day where Name_en like '%$Day_plus%'")->row_array();
                            
                            if($Lang == "arabic"){ $day_name = $dayname['Name']; }else{ $day_name = $dayname['Name_en']; }
                            
                            if($Lang == "arabic"){ $day_name_plus = $daynameplus['Name']; }else{ $day_name_plus = $daynameplus['Name_en']; }
                        //  print_r($Lang);die;
                          ?>
                          
                           <?php   
                        $SCHOOL_SHO=$this->db->query("SELECT contact.SchoolID  FROM contact  WHERE ID = '".$this->session->userdata('id')."' ")->row_array();
                       
                            if((($this->ApiDbname  == "SchoolAccShorouqAlmamlakah")&& ($SCHOOL_SHO['SchoolID'] == 1)) || ($this->ApiDbname != "SchoolAccShorouqAlmamlakah") || (($this->ApiDbname  == "SchoolAccShorouqAlmamlakah")&&($SCHOOL_SHO['SchoolID'] == 8))){
                    ?> 
                     <?php if($get_group_day[0]->group_day==1 || $get_group_day[1]->group_day==1){?> 
                    <!-- Classes Table -->
                    <div class="content-card tabs mb30">
                        <!-- Head -->
                        <div class="card-head clear-after">
                            <!-- Title -->
                              <?php if($this->ApiDbname=="ksiscs" ){ ?>
                            <h3 class="inline-block"><?php echo lang('am_class_schedule')." "?></h3>
                            <?php }else{ ?>
                            <h3 class="inline-block"><?php echo lang('am_class_schedule')." "?><?php if($this->ApiDbname == 'SchoolAccShorouqAlmamlakah'){echo lang('am_Boys');}else{echo lang('morning_shift');}?></h3>
                            <?php } ?>
                            
                            <!-- Date -->
                            <!--<strong class="inline-block">الأحد : 13/01/2021</strong>-->
                            <!-- Tabs Group -->
                            <ul class="tabs-menu tabs-group flexbox">
                                <li data-tab="classes-daily"><?php echo lang('am_day');?></li>
                                <li data-tab="classes-upcoming"><?php echo lang('ra_tomorrow');?></li>
                            </ul>
                            <!-- More Button -->
                            <a href="<?php echo site_url('emp/class_table/class_table_emp/1');?>" class="float-end btn outline small secondary rounded"><?php echo lang('am_view_all');?></a>
                        </div>
                        <!-- Tabs Wraper -->
                        <div class="tabs-wraper">
                            <!-- Tab Content -->
                            
                            <div class="tab-content" id="classes-daily">
                                <!-- Classes Table -->
                                <div class="responsive-sm-table" style="overflow: auto;">
                                    <table class="virtualtable">
                                        <!-- Table Head -->
                                        <thead style = "background-color:#8fdaf5;">
                                            
                                            <tr class="tx-align-center head1">
                                                <th class="rghtcloum days" style="width: 90px;"><?php echo lang('br_day');?></th>
                                                 <?php if($get_lesson){foreach($get_lesson as $key=>$RowLesson){?>
					                                <th class="hjhj tx-align-center"><?php echo $RowLesson->LessonName;?></th>	
					                             <?php }}?>
                                            </tr>
                                        </thead>
                                        <!-- Table Body -->
                                        
                                        <tbody>
                                            
                                            <?php
                                                $Sunday = strtotime('next Sunday -1 week');
                                                $Sunday = date('w', $Sunday)==date('w') ? strtotime(date("Y-m-d",$Sunday)." +7 days") : $Sunday;
                                                $sunday = strtotime(date("Y-m-d",$Sunday)." +6 days");
                                                $this_week_sd = date("Y-m-d",$Sunday);
                                                $current_date        = date('m-d', strtotime($this_week_sd + ' days'));
                                                $tomorrow = date("m-d", time() + 86400);
                                                ?>
                                                
                                                <tr class="row-2">
                                                <th class="rghtcloum" style="height: 85px;background-color:#8fdaf5;background-image: url(<?php echo base_url(); ?>/assets/icontables/Calendar_mor.svg);background-repeat: no-repeat;background-size: 75px;background-position: center;">
					                                <div class="dateday"><?php  echo $day_name; ?> </div>
					                                <div class="datenum"><?php  echo $current_date; ?></div>
					                            </th>    
					                             <?php 
					                              $keys               = array_values($get_lesson);
                            	                  $get_max_numlesson1 = end($keys)->LessonID;
                            			          $coun               = $get_lesson[0]->LessonID ;
					                             for($count=$coun;$count<=$get_max_numlesson1;$count++){
					                                 
					                                 if($dayname['ID'] == ''){$dayname['ID'] = "NULL";}
						                                $week_array          = $this->db->query("select WEEK('$date') as week_id")->row_array();
                                		                $WeekID              = $week_array['week_id'];
                                                        $chkMove             = 0;
                                             
                                		                 if($this->ApiDbname=="SchoolAccGheras" || $this->ApiDbname=="SchoolAccExpert")
                                			                 {
                                			                    if($WeekID%2==1){
                                			                        $chkMove=1;
                                			                 
                                    			                 }elseif($WeekID%2==0){
                                    			                      $chkMove=2;
                                    			                 }
                                                             }
                                                             
                                                             $subjectName = "CASE
                                                				WHEN subject.Name_en IS NULL THEN subject.Name
                                                				ELSE subject.Name_en
                                                				END AS subjectName";
						                                $GetClassTable  = $this->db->query(" SELECT subject.icon,row_level.ID,row_level.Level_ID,row_level.Level_Name, row_level.Row_Name, $subjectName , GROUP_CONCAT(class.Name) AS className
                                                                                              FROM class_table 
                                                                                              INNER JOIN row_level ON row_level.ID = class_table.RowLevelID
                                                                                              INNER JOIN subject ON subject.ID = class_table.SubjectID
                                                                                              INNER JOIN class ON class.ID = class_table.ClassID
                                                                                              WHERE 	 BaseTableID = ".$BaseClassTableID ."
                                                                                              AND Day_ID = IFNULL(".$dayname['ID'].", Day_ID) AND Lesson = ".$count."
                                                                                              AND EmpID = ".$id." and (chkMove=0 or chkMove=$chkMove) LIMIT 1
                                                                                          ")->row_array();
                                                        if($GetClassTable['Level_ID'] == ''){$GetClassTable['Level_ID'] = "NULL";}                                                      
                                                        if($sem_date['ID'] == ''){$sem_date['ID'] = 1;}
						                                $GetLevelTime = $this->db->query("SELECT `level_id` 
						                                                                   FROM `config_lesson` 
						                                                                   WHERE `level_id`= IFNULL(".$GetClassTable['Level_ID'].", level_id) 
						                                                                   AND`semester_id`= ".$sem_date['ID']." 
						                                                                   AND `config_count` = ".$count." 
						                                                                  ")->row_array();
						    
						                               if($GetLevelTime['level_id'] == ''){$GetLevelTime['level_id'] = "NULL";}
						    
							                           $GetTime = $this->db->query("SELECT config_lesson.start_time,config_lesson.end_time FROM config_lesson 
							                                                        INNER JOIN row_level ON row_level.Level_ID=config_lesson.level_id
							                                                        INNER JOIN config_semester on config_semester.ID = config_lesson.semester_id
							                                                        WHERE row_level.Level_ID = IFNULL(".$GetLevelTime['level_id'].", row_level.Level_ID) AND config_lesson.config_count = ".$count." 
							                                                        AND '$Date' BETWEEN config_semester.start_date AND config_semester.end_date ");
							                           if($GetTime->num_rows()>0){$ResultTime = $GetTime->row_array(); $start_time = $ResultTime['start_time'];$end_time = $ResultTime['end_time'];}
				
							                ?>
					            <td class="graytd">
					                <table class="smalltable">
					                    <tbody>
					                        <tr>
					                            <td class="subtd">
					                                <div><?php echo $GetClassTable['subjectName'] ?></div>
					                 <!--<?php if($start_time){?>-->
                      <!--               <span class="lessonsDateDay tx-align-center" >-->
                      <!--               <?php echo $end_timee.'-'.$start_timee ?> </span> <br> <?php }else{}?>-->
                                                    <div><?php echo $GetClassTable['Level_Name'].' - '.$GetClassTable['Row_Name'] .'<br>'. $GetClassTable['className'] ?></div>
                                                </td>
                                            
                                                <td class="subicon">
                                                    <?php if($GetClassTable['icon']){?>
                                                    <img src="<?php echo base_url(); ?>assets/icontables/<?php echo $GetClassTable['icon']; ?>">
                                                    <?php } ?>
                                                </td>
                                            </tr>    
                                        </tbody>
                                    </table>    
                                    
                                </td>
					   
					           <?php
							
					}
					 ?>
					 </tr>
  
                                        </tbody>
                                        
                                        <!-- // Table Body -->
                                    </table>
                                    
                                </div>
                                <!-- // Classes Table -->
                            </div>
                            <!-- Tab Content -->
                            <div class="tab-content" id="classes-upcoming">
                                <!-- Classes Table -->
                                <div class="responsive-sm-table" style="overflow: auto;">
                                    <table class="virtualtable">
                                        <!-- Table Head -->
                                        <thead style = "background-color:#8fdaf5;">
                                            
                                            <tr class="tx-align-center head1">
                                                <th class="rghtcloum days" style="width: 90px;"><?php echo lang('br_day');?></th>
                                                 <?php  if($get_lesson){foreach($get_lesson as $key=>$RowLesson){?>
					                                <th class="hjhj tx-align-center"><?php echo $RowLesson->LessonName;?></th>	
					                             <?php }}?>
                                            </tr>
                                        </thead>
                        <!-- Table Body -->
                        <tbody>
                            <!-- Row -->
                                                
                                                <tr class="row-2">
                                                <th class="rghtcloum" style="height: 85px;background-color:#8fdaf5;background-image: url(<?php echo base_url(); ?>/assets/icontables/Calendar_mor.svg);background-repeat: no-repeat;background-size: 75px;background-position: center;">
					                                <div class="dateday"><?php  echo $day_name_plus; ?> </div>
					                                <div class="datenum"><?php  echo $tomorrow; ?></div>
					                            </th>    
			
					       <?php 
					       $keys               = array_values($get_lesson);
    	                  $get_max_numlesson1 = end($keys)->LessonID;
    			          $coun               = $get_lesson[0]->LessonID ;
                         for($count=$coun;$count<=$get_max_numlesson1;$count++){
					           
					              if($daynameplus['ID'] == ''){$daynameplus['ID'] = "NULL";}
						            $week_array          = $this->db->query("select WEEK('$date') as week_id")->row_array();
            		                $WeekID              = $week_array['week_id'];
                                    $chkMove             = 0;
                                             
            		                 if($this->ApiDbname=="SchoolAccGheras" || $this->ApiDbname=="SchoolAccExpert")
            			                 {
            			                    if($WeekID%2==1){
            			                        $chkMove=1;
                    			                 }elseif($WeekID%2==0){
                    			                      $chkMove=2;
                    			                 }
            			                 }
						          $GetClassTable  = $this->db->query(" SELECT row_level.ID,row_level.Level_ID,row_level.Level_Name, row_level.Row_Name, subject.Name AS subjectName, subject.icon , GROUP_CONCAT(class.Name) AS className
                                                                        FROM class_table 
                                                                        INNER JOIN row_level ON row_level.ID = class_table.RowLevelID
                                                                        INNER JOIN subject ON subject.ID = class_table.SubjectID
                                                                        INNER JOIN class ON class.ID = class_table.ClassID
                                                                        WHERE 	 BaseTableID = ".$BaseClassTableID ."
                                                                        AND Day_ID = IFNULL(".$daynameplus['ID'].", Day_ID) AND Lesson = ".$count." AND EmpID = ".$id." and (chkMove=0 or chkMove=$chkMove) LIMIT 1
                                                                    ")->row_array();
                                        if($GetClassTable['Level_ID'] == ''){$GetClassTable['Level_ID'] = "NULL";}                                                      
						
						            $GetLevelTime = $this->db->query("SELECT `level_id` FROM `config_lesson` WHERE `level_id`= IFNULL(".$GetClassTable['Level_ID'].", level_id) AND`semester_id`= ".$sem_date['ID']." AND `config_count` = ".$count." ")->row_array();
						    
						            if($GetLevelTime['level_id'] == ''){$GetLevelTime['level_id'] = "NULL";}
						    
							     $GetTime = $this->db->query("SELECT config_lesson.start_time,config_lesson.end_time FROM config_lesson 
							                                  INNER JOIN row_level ON row_level.Level_ID=config_lesson.level_id
							                                  INNER JOIN config_semester on config_semester.ID = config_lesson.semester_id
							                                  WHERE row_level.Level_ID = IFNULL(".$GetLevelTime['level_id'].", row_level.Level_ID) AND config_lesson.config_count = ".$count." 
							                                  AND '$Date' BETWEEN config_semester.start_date AND config_semester.end_date ");
							           if($GetTime->num_rows()>0){$ResultTime = $GetTime->row_array(); $start_time = $ResultTime['start_time'];$end_time = $ResultTime['end_time'];}
				// 	print_r($GetTime);die;
				
							   ?>
					             <td class="graytd">
					                <table class="smalltable">
					                    <tbody>
					                        <tr>
					                            <td class="subtd">
					                                <div><?php echo $GetClassTable['subjectName'] ?></div>
					                 <!--<?php if($start_time){?>-->
                      <!--               <span class="lessonsDateDay tx-align-center" >-->
                      <!--               <?php echo $end_timee.'-'.$start_timee ?> </span> <br> <?php }else{}?>-->
                                                    <div><?php echo $GetClassTable['Level_Name'].' - '.$GetClassTable['Row_Name'] .' <br> '. $GetClassTable['className'] ?></div>
                                                </td>
                                            
                                                <td class="subicon">
                                                    <?php if($GetClassTable['icon']){?>
                                                    <img src="<?php echo base_url(); ?>assets/icontables/<?php echo $GetClassTable['icon']; ?>">
                                                    <?php } ?>
                                                </td>
                                            </tr>    
                                        </tbody>
                                    </table>    
                                    
                                </td>
					           <?php
							
					}
					 ?>
					 </tr>
					
                            <!-- // Row -->
                        </tbody>
                        <!-- // Table Body -->
                    </table>
                                </div>
                                <!-- // Classes Table -->
                            </div>
                            <!-- // Tab Content -->
                        </div>
                        <!-- // Tabs Wraper -->
                    </div>
                    <?php } ?>
                    <!-- // Classes Table -->
                    <?php } ?>
                    <!-- Classes Table -->
                     <?php   
                        $SCHOOL_SHO=$this->db->query("SELECT contact.SchoolID  FROM contact  WHERE ID = '".$this->session->userdata('id')."' ")->row_array();
                       
                            if((($this->ApiDbname  == "SchoolAccShorouqAlmamlakah")&& ($SCHOOL_SHO['SchoolID'] == 4) )|| ($this->ApiDbname != "SchoolAccShorouqAlmamlakah")|| (($this->ApiDbname  == "SchoolAccShorouqAlmamlakah")&&($SCHOOL_SHO['SchoolID'] == 8))){
                    ?> 
                    <?php if($get_group_day[1]->group_day==2 || $get_group_day[0]->group_day==2){?>
                    <div class="content-card tabs mb30">
                        <!-- Head -->
                        <div class="card-head clear-after">
                            <!-- Title -->
                            <h3 class="inline-block"><?php echo lang('am_class_schedule')." "?><?php if($this->ApiDbname == 'SchoolAccShorouqAlmamlakah'){echo lang('am_girls');}else{echo lang('night_shift');}?></h3>
                            <!-- Date -->
                            <!--<strong class="inline-block">الأحد : 13/01/2021</strong>-->
                            <!-- Tabs Group -->
                            <ul class="tabs-menu tabs-group flexbox">
                                <li data-tab="classes-tomorrow-daily"><?php echo lang('am_day');?></li>
                                <li data-tab="classes-tomorrow-upcoming"><?php echo lang('ra_tomorrow');?></li>
                            </ul>
                            <!-- More Button -->
                            <a href="<?php echo site_url('emp/class_table/class_table_emp/2');?>" class="float-end btn outline small secondary rounded"><?php echo lang('am_view_all');?></a>
                        </div>
                        <!-- Tabs Wraper -->
                        <div class="tabs-wraper">
                            <!-- Tab Content -->
                            <div class="tab-content" id="classes-tomorrow-daily">
                                <!-- Classes Table -->
                                <div class="responsive-sm-table" style="overflow: auto;">
                                    <table class="virtualtable">
                                        <!-- Table Head -->
                                        <thead style = "background-color:#fac2c5;">
                                            
                                            <tr class="tx-align-center head1">
                                                <th class="rghtcloum days" style="width: 90px;"><?php echo lang('br_day');?></th>
                                                 <?php  if($get_lesson_night){foreach($get_lesson_night as $key=>$RowLesson){?>
					                                <th class="hjhj tx-align-center"><?php echo $RowLesson->LessonName;?></th>	
					                             <?php }}?>
                                            </tr>
                                        </thead>
                                        <!-- Table Body -->
                                        
                                        <tbody>
                                                
                                                <tr class="row-2">
                                                <th class="rghtcloum" style="height: 85px;background-color:#fac2c5;background-image: url(<?php echo base_url(); ?>/assets/icontables/Calendar_nai2.svg);background-repeat: no-repeat;background-size: 75px;background-position: center;">
					                                <div class="dateday"><?php  echo $day_name; ?> </div>
					                                <div class="datenum"><?php  echo $current_date; ?></div>
					                            </th>    
                                                
                                                <?php 
                                                $keys               = array_values($get_lesson_night);
                            	                  $get_max_numlesson1 = end($keys)->LessonID;
                            			          $coun               = $get_lesson_night[0]->LessonID ;
					                             for($count=$coun;$count<=$get_max_numlesson1;$count++){
                                                    
                                                    if($dayname['ID'] == ''){$dayname['ID'] = "NULL";}
                                                    $week_array          = $this->db->query("select WEEK('$date') as week_id")->row_array();
                                                    $WeekID              = $week_array['week_id'];
                                                    $chkMove             = 0;
                                                            
                                                    if($this->ApiDbname=="SchoolAccGheras" || $this->ApiDbname=="SchoolAccExpert")
                                                        {
                                                            if($WeekID%2==1){
                                                                $chkMove=1;
                                                                }elseif($WeekID%2==0){
                                                                    $chkMove=2;
                                                                }
                                                        }
						
						                                $GetClassTable  = $this->db->query(" SELECT row_level.ID,row_level.Level_ID,row_level.Level_Name, row_level.Row_Name,subject.icon, subject.Name AS subjectName , GROUP_CONCAT(class.Name) AS className
                                                                                              FROM class_table 
                                                                                              INNER JOIN row_level ON row_level.ID = class_table.RowLevelID
                                                                                              INNER JOIN subject ON subject.ID = class_table.SubjectID
                                                                                              INNER JOIN class ON class.ID = class_table.ClassID
                                                                                              WHERE 	 BaseTableID = ".$BaseClassTableID ."
                                                                                              AND Day_ID = IFNULL(".$dayname['ID'].", Day_ID) AND Lesson = ".$count." AND EmpID = ".$id." and (chkMove=0 or chkMove=$chkMove) LIMIT 1
                                                                                          ")->row_array();
                                                        if($GetClassTable['Level_ID'] == ''){$GetClassTable['Level_ID'] = "NULL";}                                                      
						
						                                $GetLevelTime = $this->db->query("SELECT `level_id` 
						                                                                   FROM `config_lesson` 
						                                                                   WHERE `level_id`= IFNULL(".$GetClassTable['Level_ID'].", level_id) 
						                                                                   AND`semester_id`= ".$sem_date['ID']." 
						                                                                   AND `config_count` = ".$count." 
						                                                                  ")->row_array();
						    
						                               if($GetLevelTime['level_id'] == ''){$GetLevelTime['level_id'] = "NULL";}
						    
							                           $GetTime = $this->db->query("SELECT config_lesson.start_time,config_lesson.end_time FROM config_lesson 
							                                                        INNER JOIN row_level ON row_level.Level_ID=config_lesson.level_id
							                                                        INNER JOIN config_semester on config_semester.ID = config_lesson.semester_id
							                                                        WHERE row_level.Level_ID = IFNULL(".$GetLevelTime['level_id'].", row_level.Level_ID) AND config_lesson.config_count = ".$count." 
							                                                        AND '$Date' BETWEEN config_semester.start_date AND config_semester.end_date ");
							                           if($GetTime->num_rows()>0){$ResultTime = $GetTime->row_array(); $start_time = $ResultTime['start_time'];$end_time = $ResultTime['end_time'];}
				
							                ?>
					            <td class="graytd">
					                <table class="smalltable">
					                    <tbody>
					                        <tr>
					                            <td class="subtd">
					                                <div><?php echo $GetClassTable['subjectName'] ?></div>
					                 <!--<?php if($start_time){?>-->
                      <!--               <span class="lessonsDateDay tx-align-center" >-->
                      <!--               <?php echo $end_timee.'-'.$start_timee ?> </span> <br> <?php }else{}?>-->
                                                    <div><?php echo $GetClassTable['Level_Name'].' - '.$GetClassTable['Row_Name'] .' - '. $GetClassTable['className'] ?></div>
                                                </td>
                                            
                                                <td class="subicon">
                                                    <?php if($GetClassTable['icon']){?>
                                                    <img src="<?php echo base_url(); ?>assets/icontables/<?php echo $GetClassTable['icon']; ?>">
                                                    <?php } ?>
                                                </td>
                                            </tr>    
                                        </tbody>
                                    </table>    
                                    
                                </td>
					   
					           <?php
							
					}
					 ?>
                                                
                                            </tr>
                                        </tbody>
                                        <!-- // Table Body -->
                                    </table>
                                </div>
                                <!-- // Classes Table -->
                            </div>
                            <!-- Tab Content -->
                            <div class="tab-content" id="classes-tomorrow-upcoming">
                                <!-- Classes Table -->
                                <div class="responsive-sm-table" style="overflow: auto;">
                                    <table class="virtualtable">
                                        <!-- Table Head -->
                                        <thead style = "background-color:#fac2c5;">
                                            
                                            <tr class="tx-align-center head1">
                                                <th class="rghtcloum days" style="width: 90px;"><?php echo lang('br_day');?></th>
                                                 <?php  if($get_lesson_night){foreach($get_lesson_night as $key=>$RowLesson){?>
					                                <th class="hjhj tx-align-center"><?php echo $RowLesson->LessonName;?></th>	
					                             <?php }}?>
                                            </tr>
                                        </thead>
                                        <!-- Table Body -->
                                        
                                        <tbody>
                                            
                                            <tr class="row-2">
                                                <th class="rghtcloum" style="height: 85px;background-color:#fac2c5;background-image: url(<?php echo base_url(); ?>/assets/icontables/Calendar_nai2.svg);background-repeat: no-repeat;background-size: 75px;background-position: center;">
					                                <div class="dateday"><?php  echo $day_name_plus; ?> </div>
					                                <div class="datenum"><?php  echo $tomorrow; ?></div>
					                            </th>    
                                                <?php 
                                                  $keys               = array_values($get_lesson_night);
                            	                  $get_max_numlesson1 = end($keys)->LessonID;
                            			          $coun               = $get_lesson_night[0]->LessonID ;
					                             for($count=$coun;$count<=$get_max_numlesson1;$count++){
                                                    
                                                    if($daynameplus['ID'] == ''){$daynameplus['ID'] = "NULL";}
						
						          $GetClassTable  = $this->db->query(" SELECT row_level.ID,row_level.Level_ID,row_level.Level_Name, row_level.Row_Name,subject.icon , subject.Name AS subjectName , class.Name AS className
                                                                        FROM class_table 
                                                                        INNER JOIN row_level ON row_level.ID = class_table.RowLevelID
                                                                        INNER JOIN subject ON subject.ID = class_table.SubjectID
                                                                        INNER JOIN class ON class.ID = class_table.ClassID
                                                                        WHERE 	 BaseTableID = ".$BaseClassTableID ."
                                                                        AND Day_ID = IFNULL(".$daynameplus['ID'].", Day_ID) AND Lesson = ".$count." AND EmpID = ".$id." LIMIT 1
                                                                    ")->row_array();
                                        if($GetClassTable['Level_ID'] == ''){$GetClassTable['Level_ID'] = "NULL";}                                                      
						
						            $GetLevelTime = $this->db->query("SELECT `level_id` FROM `config_lesson` WHERE `level_id`= IFNULL(".$GetClassTable['Level_ID'].", level_id) AND`semester_id`= ".$sem_date['ID']." AND `config_count` = ".$count." ")->row_array();
						    
						            if($GetLevelTime['level_id'] == ''){$GetLevelTime['level_id'] = "NULL";}
						    
							     $GetTime = $this->db->query("SELECT config_lesson.start_time,config_lesson.end_time FROM config_lesson 
							                                  INNER JOIN row_level ON row_level.Level_ID=config_lesson.level_id
							                                  INNER JOIN config_semester on config_semester.ID = config_lesson.semester_id
							                                  WHERE row_level.Level_ID = IFNULL(".$GetLevelTime['level_id'].", row_level.Level_ID) AND config_lesson.config_count = ".$count." 
							                                  AND '$Date' BETWEEN config_semester.start_date AND config_semester.end_date ");
							           if($GetTime->num_rows()>0){$ResultTime = $GetTime->row_array(); $start_time = $ResultTime['start_time'];$end_time = $ResultTime['end_time'];}
				// 	print_r($GetTime);die;
				
							   ?>
					             <td class="graytd">
					                <table class="smalltable">
					                    <tbody>
					                        <tr>
					                            <td class="subtd">
					                                <div><?php echo $GetClassTable['subjectName'] ?></div>
					                 <!--<?php if($start_time){?>-->
                      <!--               <span class="lessonsDateDay tx-align-center" >-->
                      <!--               <?php echo $end_timee.'-'.$start_timee ?> </span> <br> <?php }else{}?>-->
                                                    <div><?php echo $GetClassTable['Level_Name'].' - '.$GetClassTable['Row_Name'] .' - '. $GetClassTable['className'] ?></div>
                                                </td>
                                            
                                                <td class="subicon">
                                                    <?php if($GetClassTable['icon']){?>
                                                    <img src="<?php echo base_url(); ?>assets/icontables/<?php echo $GetClassTable['icon']; ?>">
                                                    <?php } ?>
                                                </td>
                                            </tr>    
                                        </tbody>
                                    </table>    
                                    
                                </td>
					           <?php
							
					}
					 ?>
                                                
                                            </tr>
                                        </tbody>
                                        <!-- // Table Body -->
                                    </table>
                                </div>
                                <!-- // Classes Table -->
                            </div>
                            <!-- // Tab Content -->
                        </div>
                        <!-- // Tabs Wraper -->
                    </div>
                    <?php } ?>
                    <!-- // Classes Table -->
                     <?php } ?>
                    <!-- Daily Sessions -->
                    <div class="content-card tabs mb30">
                        <!-- Head -->
                        <div class="card-head clear-after">
                            <!-- Title -->
                            <h3 class="inline-block"><?php echo lang('ra_virtual_sessions');?></h3>
                            <!-- Date -->
                            <!--<strong class="inline-block">الأحد : 13/01/2021</strong>-->
                            <!-- Tabs Group -->
                            <ul class="tabs-menu tabs-group flexbox">
                                <li data-tab="sessions-daily"><?php echo lang('am_day');?></li>
                                <li data-tab="sessions-upcoming"><?php echo lang('ra_tomorrow');?></li>
                            </ul>
                            <!-- More Button -->
                            <a href="<?php echo site_url('emp/zoom/zoomTableEmp');?>" class="float-end btn outline small secondary rounded"><?php echo lang('am_view_all');?></a>
                        </div>
                        <!-- Tabs Wraper -->
                        <div class="tabs-wraper">
                            <!-- Tab Content -->
                            <?php 
                            $zoom_today      =$this->zoom_model->Teacher_Timetable($id,$Date,$Date);
                            
                            ?>
                            <div class="tab-content" id="sessions-daily">
                                <!-- Date -->
                                <div >
                                <?php  if($Lang == "arabic"){ ?>
                                  <strong style="color:blue;text-align: center;"><?php echo $dayname['Name']; ?> :<?php echo $Date; ?></strong>
                                  <?php } else { ?>
                                  <strong style="color:blue;text-align: center;"><?php echo $dayname['Name_en']; ?> :<?php echo $Date; ?></strong>
                                  <?php } ?>
                                </div>                               
                                <!-- Grid -->
                                <div class="row">
                                    <!-- Session Card -->
                                    <?php
                                    foreach($zoom_today as $Key=>$i)
                                        {
                                        
                                         $zoom_meeting_id = $i->MeetingId;    
                                         $meeting_id      = $i->meeting_id;
                                         $name            = $i->MeetingTopic;
                                         $start           = $i->MeetingStartTime;
                                         $end             = $i->MeetingEndTime;
                                         $zoom_name       = explode('/',$name);
                                            // print_r($date);die;
                                        ?>    
                                    <div class="session-card mb30 col-12 col-m-4 col-l-3">
                                        <div class="content-box" data-status="online">
                                            <a href="#"><h3><?php echo $zoom_name[0];?> </h3></a>
                                            <p class="mb5"><?php echo lang('br_from');?>:<?php echo $start;?></p>
                                            <p class="mb5"><?php echo lang('br_to');?>:<?php echo $end;?></p>
                                            <?php 
					                              $starttime = date('Y-m-d H:i:s',strtotime($start));
					                              $endTime = date('Y-m-d H:i:s',strtotime($end));
					                              if($endTime>$date&&$date>$starttime){?>
                                            <a href="<?php echo site_url('emp/zoom/user_attend/' . $meeting_id .'/' . $zoom_meeting_id.'/'.$end ) ?>" class="btn small success rounded block-lvl"><?php echo lang('br_join');?></a>
                                            <?php } else if($endTime<$date){ ?>
							                <a href="" class="btn small gray rounded block-lvl" disabled><?php echo lang('br_finished');?></a>
						                    <?php } else if($endTime>$date){ ?>
							                <a href="" class="btn small gray rounded block-lvl" disabled><?php echo lang('br_cant_start');?></a>
						                    <?php } ?>
                                        </div>
                                    </div>
                                    <?php }  ?>
                                    <!-- // Session Card -->
                                </div>
                                <!-- // Grid -->
                            </div>
                            <!-- Tab Content -->
                            <?php 
                            $zoom_tomorrow    = $this->zoom_model->Teacher_Timetable($id,$Date_plus,$Date_plus);
                            // print_r($zoom_tomorrow);die;
                            ?>
                            <div class="tab-content" id="sessions-upcoming">
                                
                                <!-- Date -->
                                <div>
                                <?php  if($Lang == "arabic"){ ?>
                                  <!--<strong style="margin-right: 20px;"><?php echo $Date_plus; ?></strong>-->
                                   <strong style="color:blue;text-align: center;"><?php echo $daynameplus['Name']; ?> :<?php echo $Date_plus; ?></strong>
                                   <?php }else{ ?>
                                  <strong style="color:blue;text-align: center;"><?php echo $daynameplus['Name_en']; ?> :<?php echo $Date_plus; ?></strong>
                                <?php } ?>
                                </div>
                                <!-- Grid -->
                                <div class="row">
                                    <!-- Session Card -->
                                    <?php
                                    foreach($zoom_tomorrow as $Key=>$i)
                                        {
                                        
                                         $zoom_meeting_id = $i->MeetingId;    
                                         $meeting_id      = $i->meeting_id;
                                         $name            = $i->MeetingTopic;
                                         $start           = $i->MeetingStartTime;
                                         $end             = $i->MeetingEndTime;
                                         $zoom_name       = explode('/',$name);
                                            
                                        ?>    
                                    <div class="session-card mb30 col-12 col-m-4 col-l-3">
                                        <div class="content-box" data-status="online">
                                            <a href="#"><h3><?php echo $zoom_name[0];?> </h3></a>
                                            <p class="mb5"><?php echo lang('br_from');?>:<?php echo $start;?></p>
                                            <p class="mb5"><?php echo lang('br_to');?>:<?php echo $end;?></p>
                                            <?php 
					                              $starttime = date('Y-m-d H:i:s',strtotime($start));
					                              $endTime = date('Y-m-d H:i:s',strtotime($end));
					                              if($endTime>$date&&$date>$starttime){?>
                                            <a href="<?php echo site_url('emp/zoom/user_attend/' . $meeting_id .'/' . $zoom_meeting_id.'/'.$end ) ?>" class="btn small success rounded block-lvl"><?php echo lang('br_join');?></a>
                                            <?php } else if($endTime<$date){ ?>
							                <a href="" class="btn small gray rounded block-lvl" disabled><?php echo lang('br_finished');?></a>
						                    <?php } else if($endTime>$date){ ?>
							                <a href="" class="btn small gray rounded block-lvl" disabled><?php echo lang('br_cant_start');?></a>
						                    <?php } ?>
                                        </div>
                                    </div>
                                    <?php }  ?>
                                    <!-- // Session Card -->
                                </div>
                                <!-- // Grid -->
                            </div>
                            <!-- // Tab Content -->
                        </div>
                        <!-- // Tabs Wraper -->
                    </div>
                    <!-- // Daily Sessions -->
                    <!-- Upcoming Exams -->
                    <div class="content-card mb30">
                        <!-- Head -->
                        <div class="card-head">
                            <!-- Title -->
                            <h3 class="inline-block"><?php echo lang('exam_today');?></h3>
                        </div>
                        <!-- Upcoming Table -->
                        <div class="responsive-sm-table">
                            <table class="table striped round-corner overflow">
                                <!-- Table Head -->
                                <thead>
                                    <tr class="secondary-bg">
                                        <th class="width-30 tx-align-center">#</th>
                                        <th><?php echo lang('Exam_Name');?></th>
                                        <th class="tx-align-center"><?php echo lang('am_level');?>/<?php echo lang('am_subject');?></th>
                                        <th class="tx-align-center"><?php echo lang('time_per_minute');?></th>
                                        <th class="tx-align-center"><?php echo lang('from');?></th>
                                        <th class="tx-align-center"><?php echo lang('am_to');?></th>
                                        <th class="tx-align-center"><?php echo lang('Degree');?></th>
                                        <th class="tx-align-center"><?php echo lang('br_status');?></th>
                                        <th class="tx-align-center"><?php echo lang('na_Follow_up_on_attendance'); ?></th>
                                    </tr>
                                </thead>
                                <!-- Table Body -->
                                <tbody>
                                    <!-- Row -->
                                    <?php
                                    foreach($exam_today as $Key=>$tes)
                                        {
                                         $Key             = $Key+1;
                                         $test_id         = $tes->test_id;
                                         $testName        = $tes->testName;    
                                         $date_from       = $tes->date_from;
                                         $date_to         = $tes->date_to;
                                         $Level_Name      = $tes->Level_Name;
                                         $Row_Name        = $tes->Row_Name;
                                         $subject_Name    = $tes->subject_Name;
                                         $time_count      = $tes->time_count;
                                         $degree          = $tes->degree;
                                         $rowlevelid      = $tes->rowlevelid;
                                         $subjectid       = $tes->subjectid;
                                         $type            = $tes->type;
                                         $sumDegree       = $this->exam_new_model->get_sum_degree($test_id);
                                        ?>  
                                    <tr>
                                        <td class="width-30 tx-align-center"><?php echo $Key;?></td>
                                        <td><?php echo $testName;?></td>
                                        <td class="tx-align-center"><?php echo $Level_Name."/".$Row_Name."/".$subject_Name;?></td>
                                        <td class="tx-align-center"><?php echo $time_count /60;?></td>
                                        <td class="tx-align-center"><?php echo $date_from;?></td>
                                        <td class="tx-align-center"><?php echo $date_to;?></td>
                                        <td class="tx-align-center"><?php echo $sumDegree;?></td>
                                        <td class="tx-align-center">
                                            <?php if($date<$date_from){?>
                                             <a class="btn small block-lvl rounded gray"><?php echo lang('br_cant_start');?></a> 
                                            <?php }elseif($date>$date_from && $date<$date_to){ ?>
                                            <a class="btn small block-lvl rounded gray" style="background: #1cb569;color: black;width: max-content;"><?php echo lang('exam_start_now');?></a> 
                                            <?php }elseif($date>$date_to){?>
                                            <a class="btn small block-lvl rounded gray"style="background: #f01311;color: black;"><?php echo lang('na_exam_finished');?></a> 
                                            <?php }else{}?>
                                        </td>
                                        <td class="tx-align-center">
                                          <?php if($date>=$date_from){ ?>
                                          <span class="tip" >
                                            <a class="btn btn-success btn-rounded" title="follow" href="<?php echo site_url('emp/exam_new/follow_attendance/'.$test_id."/".$rowlevelid."/".$subjectid."/".$type)?>">
                                               <i class="fas  fa-users" style="color:blue;"></i>
                                            </a>
                                          </span>
                                           <?php } ?>
                                </td>
                                    </tr>
                                    <!-- Row -->
                                    
                                    <!-- // Row -->
                                </tbody>
                                <!-- // Table Body -->
                                <?php } ?>
                            </table>
                        </div>
                        <!-- // Upcoming Table -->
                    </div>
                    <!-- // Upcoming Exams -->
                   
                </div>
                <!-- // Page Content -->
            </div>
            <!-- // Page Wraper -->
        </div>
        <?php }?>
        <script>
    jQuery(document).ready(function($) {
        $.ajax({
            url: 'https://chat.lms.esol.com.sa/vistore/store?apikey=chat.<?= $_SERVER['SERVER_NAME'] ?>',
            type: 'GET',
            success: function(response) {
               
            },
            error: function(error) {
                console.error(error);
            }
        });
       

    });
   
</script>