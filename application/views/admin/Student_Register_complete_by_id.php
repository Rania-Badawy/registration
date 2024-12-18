<style>
.school_name,
.imgCode {
    display: none;
}

img {
    width: 100px;
    height: 100px
}


}

th {
    text-align: right;
}

.open-button {
    display: none;
}

@media print {}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/dataTable/dataTables.bootstrap.css">

<script type="text/javascript" language="javascript"
    src="<?php echo base_url(); ?>assets/dataTable/jquery.dataTables.js"></script>

<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap.js">
</script>

<script type="text/javascript">
function PrintElem(elem) {
    Popup($(elem).html());
    this.align = "center";


}

function Popup(data) {

    var mywindow = window.open('', 'print_div', 'height=1200,width=1400');
    <?php if($this->session->userdata('language') != 'english'){ ?>
    mywindow.document.write(
        '<html dir="rtl" ><head><title></title><style>.form-group{text-align: start;}.printDivO label{text-align: start;} </style>'
    );
    mywindow.document.write('<link href="<?php echo base_url(); ?>assets/new/css/rtl.css" rel="stylesheet">');
    <?php }else{?>
    mywindow.document.write(
        '<html dir="ltr"><head><title></title><style>.form-group{text-align: end;}.printDivO label{text-align: end;}</style>'
    );
    mywindow.document.write('<link href="<?php echo base_url(); ?>assets/new/css/ltr.css" rel="stylesheet">');
    <?php } ?>
    mywindow.document.write('<link href="<?php echo base_url(); ?>assets/new/css/style.css" rel="stylesheet">');
    mywindow.document.write('<link href="<?php echo base_url(); ?>exam/exam.css" rel="stylesheet">');
    mywindow.document.write('<link href="<?php echo base_url(); ?>assets/new/css/bootstrap.min.css" rel="stylesheet">');
    mywindow.document.write(`<style>
		body{
		    font-size: large;
		}
		.divPrint{
		    min-height: 34px;
            width: 100%;
            font-size: 1.6rem;
            border: 1px solid #000;
            background-color: white;
		}
         .printDivO{
             width: 33.333333% !important;
             margin-bottom: 10px !important;
             <?php if($this->session->userdata('language') != 'english'){ ?>
             float : right ;
             <?php }else { ?>
             float : left ;
             <?php } ?>
         }
         .col-md-4{
             width: 33.333%;
         }
         .printDivO label{
		    font-size: 14px;
		}
		h4.divHeader{
		    margin-bottom: 5px !important;
		    border-bottom: 1px solid #eaeaea !important;
		    padding-bottom: 0 !important
		}
		.printDivO.certificate{
		    margin-bottom: 350px !important
		}
		.mediacl_datah4{
		    margin-top: 500px !important
		}
		.printDivO hr{
		    margin: 0 !important
		}
		@page {
          margin: 0 0 0 0 !important;
        }
    
    
    .imgLink{
        display: none;
    }
    .fatherData{
        min-height:1120px !important;
    }
    .motherData{
        min-height:1120px !important;
    }
    .publicData{
        min-height:1130px !important;
    }
    .studentData{
        min-height:1150px !important;
    }
    .busAbroP{
        min-height: 1120px !important
    }
    .nafsyaaDiv{
        min-height: 1130px !important;
    }
    img{
        width: 100px;
        height: 100px
    }
    .school_name{
            display: none;
        }
		.content h1 {
        text-transform: revert;}
        }
		</style>`);


    mywindow.document.write(
        '</head><body class="content" ><h4 class="school_name"><?= $getStudentR['schoolName'] ?></h4>');
    mywindow.document.write(data);
    mywindow.document.write('</body></html>');
    mywindow.document.close();
    setTimeout(function() {
        mywindow.print();
    }, 2000)

    return true;
}
</script>
<style>
h4.divHeader {
    margin-bottom: 0 !important;
    border-bottom: 1px solid #000 !important;
    padding-bottom: 5px !important
}
</style>
<?php  $reg=$this->db->query("select reg_type from school_details ")->row_array(); 
$reg_type = $reg['reg_type'];
?>

<div class="col-lg-12">
    <div class="block-st">
        <div class="sec-title">
            <h4><?php echo lang('br_check_st_register'); ?></h4>
            <a href="<?php echo site_url('admin/Report_Register/reg_complete/'.$school_id . "/" . $year_id); ?>"
                class="btn btn-danger pull-left" role="button"> <?php echo lang('Back'); ?> </a>
            <div class="pull-left">
                <input type="button" onclick="PrintElem('#print_div')" value="print" class="btn btn-success" />
            </div>
        </div>

        <div class="panel-body no-padding">
            <?php
                
                    if($getStudentR['IsAccepted']==0){
                         $query1 = $this->db->query("SELECT jobTitleID FROM employee	WHERE Contact_ID = '".$this->session->userdata('id')."' ")->row_array();
                        if($getPerEmp=='U'||($this->session->userdata('type')=='E' && $query1['jobTitleID']!=0 && ($get_permission_request['NameSpaceID'] !=87 && $get_permission_request['NameSpaceID'] !=85 ))){ ?>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                <?=  lang('am_accept') ?>/<?=  lang('am_refuse')?></button>
            <div class="modal" id="myModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title"> <?=  lang('am_accept') ?>/<?=  lang('am_refuse')?></h4>
                        </div>
                        <!-- Modal body -->

                        <div class="modal-body row">
                            <?php if($reg_type==2){?>
                            <form
                                action="<?=site_url('admin/Report_Register/accept_student_register_marketing/'.$getStudentR['reg_id'].'/0');?>"
                                method="post">
                                <?php }else{ ?>
                                <form
                                    action="<?=site_url('admin/Report_Register/accept_student_register/'.$getStudentR['reg_id'].'/0');?>"
                                    method="post">
                                    <?php } ?>
                                   
                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <textarea class="form-control" name="Reason" rows="7"></textarea>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12 col-sm-12 col-xs-12"> <br /> </label>
                                        <input type="hidden" name="parent_mobile"
                                            value="<?=$getStudentR['person_mobile'];?>" />
                                        <input type="hidden" name="IsActive" id="IsActive">
                                        <button type="submit"
                                            onclick="$('#IsActive').val(2);return confirm('Are you sure to refuse?')"
                                            class="btn btn-danger"><?=  lang('am_refuse')?></button>
                                        <button type="submit"
                                            onclick="$('#IsActive').val(1);return confirm('Are you sure to accept?')"
                                            class="btn btn-success"><?=  lang('am_accept') ?></button>
                                    </div>
                                    <br /><br />
                                </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php  
                    
                    } elseif($get_permission_request['NameSpaceID'] ==87){
                //var_dump($getPerEmp, $get_permission_request);
                        if($getPerEmp['IsActive']==1){
                            echo '<div class="alert alert-success">'.lang('am_accepted').' - '.$getPerEmp['name_space'].'</div>'; 
                        }else{
                        	if ($getPerEmp['IsActive']==0 ||$getPerEmp['IsActive']==2) {
                     ?>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                <?=  lang('am_accept') ?>/<?=  lang('am_refuse')?></button>
            <div class="modal" id="myModal">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title"> <?=  lang('am_accept') ?>/<?=  lang('am_refuse')?> </h4>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body row">
                            <?php if($reg_type==2){?>
                            <form
                                action="<?=site_url('admin/Report_Register/accept_student_register_marketing/'.$getPerEmp['RequestID'].'/'.$getPerEmp['NameSpaceID']);?>"
                                method="post">
                                <?php }else{ ?>
                                <form
                                    action="<?=site_url('admin/Report_Register/accept_student_register/'.$getPerEmp['RequestID'].'/'.$getPerEmp['NameSpaceID']);?>"
                                    method="post">
                                    <?php } ?>
                                    <!--div class="form-group col-md-4 col-sm-12 col-xs-12">
                                        <label>   نص رساله  SMS لولى الأمر</label>
                                        <input type="text" class="form-control" name="txtSms" value="<?=$auto_sms_accept?>"/>
                                    </div-->
                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <textarea class="form-control" name="Reason" rows="7"></textarea>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12 col-sm-12 col-xs-12"> <br /> </label>
                                        <input type="hidden" name="parent_mobile"
                                            value="<?=$getStudentR['person_mobile'];?>" />
                                        <input type="hidden" name="IsActive" id="IsActive">
                                        <button type="submit"
                                            onclick="$('#IsActive').val(2);return confirm('Are you sure to refuse?')"
                                            class="btn btn-danger"><?=  lang('am_refuse').' - '.$getPerEmp['name_space']?></button>
                                        <button type="submit"
                                            onclick="$('#IsActive').val(1);return confirm('Are you sure to accept?')"
                                            class="btn btn-success"><?=  lang('am_accept').' - '.$getPerEmp['name_space']?></button>
                                    </div>
                                </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php }

                // if ($getPerEmp['IsActive']==2) {
                                	?>
            <!--<div class="alert alert-danger"><?=  lang('am_refuse').' - '.$getPerEmp['name_space']; ?></div>-->
            <?php
                                // } 
            }
            }elseif($get_permission_request['NameSpaceID'] ==85&&$getStudentR['IsRefused']==0) { 
            	?>
            <?php
            if($this->session->flashdata('SuccessAdd'))
            {
                ?>
            <div class="widget-content">
                <div class="widget-box">
                    <div class="alert alert-success fade in">
                        <button data-dismiss="alert" class="close" type="button">×</button>
                        <?php
                            echo $this->session->flashdata('SuccessAdd');
                            ?>
                    </div>
                </div>
            </div>
            <?php
            }

            if($this->session->flashdata('Failuer'))
            {
                ?>
            <div class="widget-content">
                <div class="widget-box">
                    <div class="alert alert-danger fade in">
                        <button data-dismiss="alert" class="close" type="button">×</button>
                        <?php
                            echo $this->session->flashdata('Failuer');
                            ?>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
            <?php
                			
                                if($all_accept_request==1){
                                    echo '<div class="alert alert-danger">'.'لم يتم المراجعه من الشئون الأكاديمية'.'</div>';
                                    
                                }
                                elseif($all_accept_request2==1){
                                    echo '<div class="alert alert-danger">'.'تم الرفض من الشئون الأكاديمية'.'</div>';
                                    
                                }
                                else{
                                	if($getPerEmp['IsActive']==1){
                            echo '<div class="alert alert-success">'.lang('am_accepted').' - '.$getPerEmp['name_space'].'</div>'; 
                        }else {
                        	if ($getPerEmp['IsActive']==0) {
                                ?>


            <!--div class="row form-group">       
                                <form action="<?=site_url('admin/student_register/send_sms/'.$getPerEmp['RequestID']);?>" method="post">
                                    <div class="form-group col-md-4 col-sm-12 col-xs-12">
                                        <label>      ارسال رساله نصيه SMS</label>
                                        <input type="text" class="form-control" name="txtSms" value=" "  />
                                        
                                    </div>
                                    <div class="form-group col-md-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12 col-sm-12 col-xs-12"> <br /> </label>
                                        <input type ="hidden" name="parent_mobile" value="<?=$getStudentR['person_mobile'];?>"/>
                                        <button type="submit"  class="btn btn-success"><?=  lang('send sms')?></button>
                                    </div>
                              </form>
                          </div-->
            <div class="row form-group">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"> قبول /
                    رفض</button>
                <div class="modal" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title"> <?=  lang('am_accept') ?>/<?=  lang('am_refuse')?></h4>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body row">
                                <?php if($reg_type==2){?>
                                <form
                                    action="<?=site_url('admin/Report_Register/accept_student_register_marketing/'.$getPerEmp['RequestID'].'/'.$getPerEmp['NameSpaceID']);?>"
                                    method="post">
                                    <?php }else{ ?>
                                    <form
                                        action="<?=site_url('admin/Report_Register/accept_student_register/'.$getPerEmp['RequestID'].'/'.$getPerEmp['NameSpaceID']);?>"
                                        method="post">
                                        <?php } ?>

                                        <!--div class="form-group col-md-4 col-sm-12 col-xs-12">
                                        <label>   نص رساله  SMS لولى الأمر</label>
                                        <input type="text" class="form-control" name="txtSms" value="<?=$auto_sms_accept?>" disabled/>
                                        
                                    </div-->
                                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                            <textarea class="form-control" name="Reason" rows="7"></textarea>
                                        </div>
                                        <div class="form-group col-md-4 col-sm-12 col-xs-12">
                                            <!--label class="col-md-12 col-sm-12 col-xs-12"> <br /> </label-->
                                            <input type="hidden" name="parent_mobile"
                                                value="<?=$getStudentR['person_mobile'];?>" />
                                            <input type="hidden" name="IsActive" id="IsActive">
                                            <button type="submit"
                                                onclick="$('#IsActive').val(2);return confirm('Are you sure to refuse?')"
                                                class="btn btn-danger"><?=  lang('am_refuse').' - '.$getPerEmp['name_space']?></button>
                                            <button type="submit"
                                                onclick="$('#IsActive').val(1);return confirm('Are you sure to accept?')"
                                                class="btn btn-success"><?=  lang('am_accept').' - '.$getPerEmp['name_space']?></button>
                                        </div>
                                        <br /><br />
                                    </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php  
                               }  

                               if ($getPerEmp['IsActive']==2) {
                                	?>
            <div class="alert alert-danger"><?=  lang('am_refuse').' - '.$getPerEmp['name_space']; ?></div>
            <?php
                                } 
                               
                                } }
                             } ?>
            <?php
                 }elseif($getStudentR['IsRefused']==1){?>
            <div class="alert alert-danger"><?=  lang('am_refuse'); ?></div>
            <?php }else{
                ?>
            <div class="alert alert-success"><?=  lang('am_accepted').' - '.$getPerEmp['name_space']; ?></div>
            <?php
                 }?>

            <div class="row form-group">

                <?php
  $query =$this->db->query("select accpet_reg_type,reg_type	 from school_details limit 1")->row_array(); 
    if($query['accpet_reg_type']==1 || $query['accpet_reg_type']==2 ||$query['reg_type']==2) {
                                
        $array = array(
                     87 =>   lang('Academic Affairs Note') ,
                    85 =>  lang('Note the financial affairs') 
                );
    }else{
        $array = array(
                     87 =>   lang('Academic Affairs Note') 
                );
    }
 ?>
                <div class="col-xs-12">
                    <div class="col-md-12">
                        <div class="row">
                            <?php foreach ($array as $key => $value) { ?>
                            <div class="col-md-6">
                                <div class="clearfix"></div>
                                <h4 style="color: green;"> <?=$value?></h4>
                                <div class="clearfix"></div>
                                <hr>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <?=(isset($reason[$key]))?($reason[$key]->Reason?$reason[$key]->Reason: lang('No notes') ): lang('Not reviewed')  ;?>

                                </div>
                            </div>
                            <?php } ?>
                            <div class="row form-group" id="print_div">
                                <?php $setting = $this->db->query("SELECT * FROM `form_setting` WHERE `form_type` =1")->result(); ?>

                                <!--<div id="print_div">-->
                                <div class="pagebreak">
                                    <div class="col-xs-12">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="fatherData">
                                                    <h4 class="divHeader"> <?php echo lang('am_father_data'); ?> </h4>
                                                    <div class="row">
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('am_father_name'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                <?=$getStudentR['parentname'];?>
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('am_ID_Number'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                <?=$getStudentR['ParentNumber'];?>
                                                            </div>
                                                        </div>


                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('am_mail'); ?></label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint email">
                                                                <?=$getStudentR['parentemail'];?>
                                                            </div>
                                                        </div>


                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('am_Nationality'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                <?php  foreach($get_nationality as $n) {
                                                if($n->NationalityId ==$getStudentR['parent_national_ID']) {
                                                    echo $n->NationalityName;
                                                }
                                            } ?>

                                                            </div>
                                                        </div>



                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('father_mobile'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                <?=$getStudentR['parentmobile'];?>
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php if ($this->ApiDbname == "SchoolAccUniversitySchools") {echo lang('br_st_mo_mobile');} else { echo lang('am_Mobile') . "2";} ?>
                                                            </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                <?=$getStudentR['parentmobile2'];?>
                                                            </div>
                                                        </div>


                                                    </div>

                                                </div>


                                                <input hidden <?=$lang=$getStudentR['sec_language'];?>>
                                                <input hidden <?=$school_type_stu =$getStudentR['note'];?>>
                                                <div class="studentData">
                                                    <h4 class="school_name"><?= $getStudentR['schoolName'] ?></h4>
                                                    <div class="clearfix"></div>
                                                    <h4 class="divHeader"> <?php echo lang('am_student_data'); ?> </h4>
                                                    <div class="row">
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('am_frist_name'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                <?=$getStudentR['name'];?>
                                                            </div>
                                                        </div>



                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('am_ID_Number'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                <?=$getStudentR['student_NumberID'];?>
                                                            </div>
                                                        </div>


                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label"> <?php echo lang('am_type'); ?>
                                                            </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                <?php  foreach($get_genders as $gender) {
                                                    if($gender->GenderId ==$getStudentR['gender'] ) {
                                                        echo $gender->GenderName;
                                                    }
                                                } ?>
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('class_type'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                <?php  foreach ($get_ClassTypeName as $TypeName) {
            										 if($TypeName->ClassTypeId ==$getStudentR['ClassTypeId'] ) {
                                                        echo $TypeName->ClassTypeName;
                                                     
                                                       
            											}} ?>
                                                            </div>
                                                        </div>



                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('am_studeType'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                <?php  foreach($studeType as $type){
            							    
                                                    if($type->StudyTypeId ==$getStudentR['studyType'] ) {
                                                        echo $type->StudyTypeName;
                                                    }
                                                } ?>
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('school_Name'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                <?php echo $getStudentR['schoolName'];?>

                                                            </div>
                                                        </div>

                                                        
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('am_level'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                 <?php echo $getStudentR['levelName'];?>
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label"> <?php echo lang('am_row'); ?>
                                                            </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                 <?php echo $getStudentR['rowLevelName'];?>
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label"><?=lang('br_year')?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                <?php  foreach($getYear as $Year) {
                							   
                                                        if($Year->YearId == $getStudentR['YearId'] ) {
                                                            echo $Year->YearName;
                                                        }
                                                    } ?>
                                                            </div>
                                                        </div>


                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php if ($this->ApiDbname == "SchoolAccUniversitySchools") {echo lang('er_TeacherName');} else {echo lang('am_notes');} ?></label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                <?=$getStudentR['note'];?>
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('br_how_school_name'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                <?=$getStudentR['how_school_name'];?>
                                                            </div>
                                                        </div>



                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>


                        </div>
                    </div>
                </div>




            </div>
        </div>