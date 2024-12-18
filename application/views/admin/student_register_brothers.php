		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
  
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>


	<script type="text/javascript">

		$( document ).ready(function() {

			$('#example').DataTable({

				"dom": 'lBfrtip',

						buttons:[
							'excel',
							'print',
							'pdf'
						]

			});

		});

	</script>

<div class="clearfix"></div>
<div class="content margin-top-none container-page">
    <div class="col-lg-12">
        <div class="block-st">
            <div class="sec-title">
                <h2><?php echo lang('br_check_st_register'); ?></h2>
            </div>

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
           
            <!----- Add title -------->

            

            <!----- Edit title -------->


<div class="col-lg-12 text-left">
<a role="button"   href="<?= site_url('admin/Report_Register') ?>" class="btn btn-success btn-rounded" rtl>
                                       رجوع
                                    </a>
                                    </div>
            <div class="clearfix"></div>

            <div class="clearfix"></div>
            <div class="panel panel-danger">

                <div class="panel-body no-padding">

                    <?php if(is_array($getStudentR)){ ?>
                    <table id="example" class="table table-bordered table-striped" >
                        <thead>
                        <tr>
                            <th style="text-align: center !important;" >#</th>
                           
                            <!--<th style="text-align: center !important;" ><?php echo lang('br_father') ?></th>-->
                             <th style="text-align: center !important;" ><?php echo lang('er_StudentName') ?></th>
                            <th style="text-align: center !important;" ><?php echo lang('br_row_level') ?></th>
                            <th style="text-align: center !important;" ><?php echo lang('am_Check_Code_student') ?></th>
                            <th style="text-align: center !important;" ><?php echo lang('er_Nationality') ?></th>
                            <th style="text-align: center !important;" ><?php echo lang('br_BirhtDate') ?></th>
                            <th style="text-align: center !important;" ><?php echo lang('br_st_fa_mobile') ?></th>
                            <th style="text-align: center !important;" ><?php echo lang('br_st_mo_mobile') ?></th>
                             <!--<th style="text-align: center !important;" >تاريخ الاختبار   </th>-->
                            <!--<th style="text-align: center !important;" >تقرير لتاريخ الاختبار </th>-->
                            
                            
                           <th style="text-align: center !important;" ><?php echo lang('br_academy_accept') ?></th>
                            <th style="text-align: center !important;" ><?php echo lang('br_money_accept') ?></th>
                            <!--<th style="text-align: center !important;" ><?php echo lang('br_page_view') ?></th>-->
                            
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        foreach ($getStudentR as $Key=>$StudentR )
                        {
                            $Num		       = $Key+1 ;
							$id 	           = $StudentR->id ;
                            $name 	           = $StudentR->FullName ;
                            $parent_name       = $StudentR->parentname ;
                            $Rowid 	           = $StudentR->rowLevelID ;
                            $Nationality       = $StudentR->nationality ;
                            $IsAccepted        = $StudentR->IsAccepted ;
                            $date              = $StudentR->birthdate;
                            $parent_mobile     = $StudentR-> parentmobile  ;
                            $mother_mobile     = $StudentR->mothermobile ;
                            $code              = $StudentR->check_code ;
                             $last_date        = $this->Report_Register_model->register_date($id);
                             $IsActiveArray    = array(1=>lang('br_active'),0=>lang('br_not_active'));
                            $accepted = array(
                                            lang('br_request_wating'),
                                            lang('br_request_accepted')
                                        );
                            $refused = array(
                                            lang('br_request_wating'),
                                            lang('br_request_refused')
                                        );
                            $status_academy = lang('br_request_wating');
                            $status_money   = lang('br_request_wating');
                            $query = $this->db->where('RequestID',$StudentR->id)->get('active_request')->result();
                            if ($query != null) {
                                foreach ($query as $row) {
                                    if ($row->NameSpaceID == 87 && $row->IsActive == 1) {
                                        $status_academy = lang('br_request_accepted');
                                    }
                                    if ($row->NameSpaceID == 87 && $row->IsActive == 2) {
                                        $status_academy = lang('br_request_refused');
                                    }
                                    if ($row->NameSpaceID == 85 && $row->IsActive == 1) {
                                        $status_money = lang('br_request_accepted');
                                    }
                                    if ($row->NameSpaceID == 85 && $row->IsActive == 2) {
                                        $status_money = lang('br_request_refused');
                                    }
                                }
                            }
                            ?>
                            <tr>
                                <td><?php echo $Num ; ?></td>
                                <!-- <td>-->
                                <!--    <?php echo $parent_name; ?>-->
                                <!--</td>-->
                                <td>
                                    <?php if( $name !== '' ){ echo $name; }else{ echo 'لم تتم الاضافة'; }; ?>
                                </td>
                               

                                <td>
                                    <?php  foreach($getRowLevel as $p) {
                                        if($p->RowLevelId ==$Rowid ) {
                                            echo $p->LevelName." ".$p->RowName;
                                        }
                                    } ?>
                                </td>
                                <td><?=$code?></td>
                                <td>
                                    
                                    <?php  foreach($get_nationality as $n) {
                                        if($n->NationalityId ==$Nationality ) {
                                            echo $n->NationalityName;
                                        }
                                    } ?>
                                </td>
                                <td><?=$date?></td>
                                 <td><?=$parent_mobile?></td>
                                  <td><?=$mother_mobile?></td>
                                  <!--<td><?=$last_date[0]->Date?></td>-->
                                  <!--<td>-->
                                  <!--<a    href="<?= site_url('admin/student_register/register_form_date/'.$id.'') ?>" >-->
                                  <!--     <?=$last_date[0]->Date?> <i class="fa fa-edit"></i>-->
                                  <!--  </a>-->
                                  <!--  </td>-->
                                  
                                <td><?=$status_academy?></td>

                                <td><?=$status_money?></td>

                                <!--<td> <!-----EDIT----->

                                <!--     <a onclick="$('#person_mobile').val(<?=$StudentR->person_mobile?>); $('#txtSms').val('');" href="#" role="button" class="btn btn-warning btn-rounded" data-toggle="modal" data-target="#msg"> <?php echo lang('br_send_sms_table') ?> <i class="fa fa-envelope"></i> </a>-->
                                <!--    <a role="button"   href="<?= site_url('admin/student_register/view_student_register/'.$id.'') ?>" class="btn btn-success btn-rounded" >-->
                                <!--        <?php echo lang('br_page_view') ?> <i class="fa fa-edit"></i>-->
                                <!--    </a>-->
                                    
                                <!--    <a role="button"   href="<?= site_url('admin/student_register/get_student_register/'.$id.'') ?>" class="btn btn-primary btn-rounded" >-->
                                <!--        <?php echo lang('br_edit') ?> <i class="fa fa-edit"></i>-->
                                <!--    </a>-->
                                <!--</td>-->
                            </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

        <?php }else{echo "";}?>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>

</div>
<div class="modal fade" id="msg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="margin-top: 0; margin-right: 30px"><?=  lang('br_send_sms_table') ?></h4>
            </div>
            <form method="post" action="<?=site_url('admin/student_register/send_sms') ?>">
                <div class="modal-body">
                    <label> <?=  lang('br_send_label') ?></label>
                    <input type="text" class="form-control" id="txtSms" name="txtSms" required="" />   
                </div>
                <div class="modal-footer">
                    <input type ="hidden" id="person_mobile" name="parent_mobile"/>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?=  lang('br_close') ?> </button>
                    <button type="submit" class="btn btn-success"><?=  lang('br_send_button') ?> <i class="fa fa-paper-plane"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

