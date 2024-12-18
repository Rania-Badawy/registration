<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/dataTable/dataTables.bootstrap.css">

<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/dataTable/jquery.dataTables.js"></script>

<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script type="text/javascript" language="javascript" class="init">

    $(function () {

        $('#example').dataTable();

    });

</script>

<div class="clearfix"></div>

<div class="content margin-top-none container-page">

    <div class="col-lg-12">

        <div class="block-st">

            <div class="sec-title">

                <h2><?php echo lang( 'br_permission_zoom'); ?> </h2>

                <a href="<?php echo site_url('admin/zoom_premission/add_new_permission_zoom'); ?>" class="btn btn-success pull-left" role="button">   <?= lang('Add groups for virtual classes') ?></a>
             <br>
                <a href="<?php echo site_url('admin/zoom_premission/get_permission_zoom'); ?>" class="btn btn-success pull-left" role="button">   عرض المجموعات</a>

            </div>

            <div class="clearfix"></div>





            <?php

            if($this->session->flashdata('SuccessAdd')){echo  '<div class="alert alert-success">'. $this->session->flashdata('SuccessAdd').'</div>';}

            if($this->session->flashdata('ErrorAdd')){echo  '<div class="alert alert-error">'. $this->session->flashdata('ErrorAdd').'</div>';}

            ?>

  <div class="form-group col-lg-6">


            <label for="multiple-label-example " class="label-control col-lg-4"><?php echo "اسم المجموعه"; ?></label>

            <div class="col-lg-8">

           <input name="Name" id="Name" class="form-control" type="text" value="<?php echo urldecode($Name);?>">

			</div>

          </div>


          

          <div class="col-lg-3">

               <input type="button" class="btn btn-primary" onclick="return get_filter_student();" value="<?php echo lang('br_search'); ?>">
            </div>



 <script type="text/javascript">


		   function get_filter_student()

		  {

			var str = $("#Name").val();
             var Name = str.trim(); 

			 window.location = "<?= site_url("admin/zoom_premission/all_permission_zoom"); ?>/"+Name;



		  }

          </script>



            <?php

            if(is_array($GetPermission))

            {?>

                <div class="clearfix"></div>

                <div class="panel panel-danger">

                    <div class="panel-body no-padding">

                        <table id="example" class="table table-striped table-bordered">

                            <thead>

                            <tr>

                                <th><?php echo lang('br_n') ?></th>
                                
                                <th><?= lang('Group') ?>  </th>
                                
                                <th><?php echo lang('br_edit') ?></th>

                                <!--<th><?= lang('br_emp') ?></th>-->

                                <!--<th><?= lang('br_school') ?></th>-->

                               <!--<th> <?= lang('Members') ?> </th>-->

                                <!--<th>الصف</th>-->
                                
                                <!--<th>الفصول</th>-->

                                <th><?= lang('br_page_add') ?></th>
                                
                                <th><?= lang('br_page_view') ?></th>
                                
                            <th class="primary-bg"><?= lang('br_delete') ?></th>
                            <th>من تم حذفهم</th>
                            </tr>

                            </thead>

                            <tbody>

                            <?php

                            foreach($GetPermission as $Key=>$Row)

                            {

                                $KeyVal         = $Key+1 ;

                                $ID             = $Row->ID ;
                                
                                 $Name          = $Row->Name ;

                                $contactName    = $Row->contactName ;
							
								$SchoolName     = $Row->SchoolName ;
								
								$ClassID        = $Row->ClassID ;
								
								$Getclass       = $this->zoom_model->get_class_data($ClassID) ;
								
					         	$count          = $Row->count;
					         	
					         	$query          = $this->db->query("select group_id from zoom_meetings where group_id=".$ID."")->row_array();
					         	
					         	$Created_by     = $Row->Created_by; 
					         	
					         	$query_type     =$this->db->query("select Type from contact  where ID=".$UID."")->row_array();
					         	$query_type_created     =$this->db->query("select Type from contact where ID=".$Created_by."")->row_array();
					       //  	print_r($query_type['Type']);die;
                                ?>

                                <tr>

                                    <td><?php echo $KeyVal ; ?></td>
                                    
                                    <td><?php echo $Name ; ?></td>
                                   <!--<td><?php echo $contactName ; ?></td>-->
                                   <!-- <td><?php echo $SchoolName ; ?></td>-->
                                    
                                   
                                   <!--<td><?php foreach($count as $key=>$SN){echo $SN->count."_";}?></td>-->

                                    
                                     <td>
                                       <?php if(($query_type['Type']=='E' && $query_type_created['Type']!='U') ||$query_type['Type']=='U'){ ?>
                                     <a class="btn btn-success btn-sm" href="<?= site_url('admin/Zoom_premission/get_group_name/'.$ID.'') ?>" ><i class="fa fa-edit"></i></a>
                                      <?PHP }?>
                                    </td>
                                    
                                    <td>
                                         <?php if(($query_type['Type']=='E' && $query_type_created['Type']!='U') ||$query_type['Type']=='U'){ ?>
                                  <div class="inbox-body">
                                    <a class="btn btn-success btn-sm" href="#myModal" data-toggle="modal" title="add" onclick="change(<?=$ID?>)" ><i class="fa fa-edit"></i></a>
                                    <!--<a class="btn btn-success btn-sm" href="<?= site_url('admin/supervisor/delete_permission_work/'.$ID.'') ?>" onclick="return confirm('Are you sure to delete?')"><i class="fa fa-show"></i></a>-->
                                   
                                   </div>
                                   <?PHP }?>
                                    </td>

                                 <td>
                                  <div class="inbox-body">
                                      <a class="btn btn-success btn-sm" type= butten href="<?= site_url('admin/Zoom_premission/show_details1/'.$ID.'') ?>"  title="show" ><i class="fa fa-search-plus"></i></a>
                                   </div>
                                    </td>
                                    <td>
                                  <div class="inbox-body">
                                      
                                      <?php if(($query_type['Type']=='E' && $query_type_created['Type']!='U') ||$query_type['Type']=='U'){
                                      if(!empty($query)){ }else{ ?>
                                      <a class="btn btn-danger btn-sm" type= butten href="<?= site_url('admin/Zoom_premission/delete_meeting_zoom/'.$ID.'') ?>"  title="delete" onclick="return confirm('Are you sure to delete?')"><i class="fa fa-trash-o"></i></a>
                                   <?php }}?>
                                   </div>
                                    </td>
                                    
                                     <td>
                                          <?php if(($query_type['Type']=='E' && $query_type_created['Type']!='U') ||$query_type['Type']=='U'){?>
                                  <div class="inbox-body">
                                      <a class="btn btn-success btn-sm" type= butten href="<?= site_url('admin/Zoom_premission/show_deleted/'.$ID.'') ?>"  title="show" ><i class="fa fa-search-plus"></i></a>
                                   </div>
                                   <?php }?>
                                    </td>
                                </tr>

                            <?php

                            }

                            ?>

                            </tbody>

                        </table>

                    </div>

                </div>



            <?php

            }else{echo '<div class="alert alert-error">'.lang('br_check_add').'</div>';}

            ?>

            <div class="clearfix"></div>

        </div>

        <div class="clearfix"></div>

    </div>

    <div class="clearfix"></div>

</div>

<div class="clearfix"></div>

<script>

    function check_Request()

    {

        var msg = confirm('تأكيد العمليه ');

        if(msg){return true ; }else{return false ; }

    }

</script>
<div class="col-lg-3 col-md-3 col-sm-4 p-0">
    <div class="sm-side">
        <div class="user-head">
            
            <div class="user-name">
               
            </div>
        </div>
        <div class="inbox-body">
           
        </div>
        
    </div>
</div>
<?php 
$type = array('E'=>'Employers', 'F'=>'Parents', 'S'=>'Students');
?>
   <script>
          function change(value){
          document.getElementById("count").value= value; 
          }
          
       </script>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade inbox-compose" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close pull-left" type="button">×</button>
                <h4 class="modal-title">  <?= lang('Add categories to the group') ?>    </h4>
            </div>
            <div class="modal-body">
                <form method="post" action="<?=site_url('admin/zoom_premission/add_meeting_zoom/'.$ID.'')?>" role="form">
                   <input type="hidden" id="count" name='group_id' value="">
                   <div class="col-sm-12" style="padding: 0">
                        <div class="form-group" id="clr_cont">
                            <label class="control-label"><?= lang('br_EmpType') ?></label>
                            <?=$this->load->view('chatting/select_category2')?>
                        </div>
                    </div>
                    <div class="col-sm-12" style="padding: 0">
                        <div class="form-group" id="clr_cont">
                            <label class="control-label"><?= lang('people') ?></label>
                            <select   class="fav_clr fav_clrPlace2 form-control   " id="to_user" name="to_user[]" multiple="multiple" required="">
                                <option value="all">جميع</option>
                            </select>
                        </div>
                    </div>
                    
                   
                        <div class="remove-file" style="display: inline-block;"></div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="attachment" id="attachment">
                        <button class="btn btn-send" type="submit" onclick="return checkEmptyMessage()" "LTR"><?= lang('br_save') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var am_level = "<?=lang('am_level')?>";
    var am_row   = "<?=lang('am_row')?>";
    var am_class = "<?=lang('am_class')?>";

   $(window).on('load', function() {
        $('.form-group select').select2({
            placeholder: ' <?= lang('br_EmpType') ?>',
            width: '100%',
            border: '1px solid #e4e5e7',
        });
    });

    $('.fav_clr').on("select2:select", function(e) {
        var data = e.params.data.id;
        if (data == 'all') {
            var optionsLength   = $('.fav_clr option').length;
            var selected_option = $('.fav_clr option:selected').length;
            if (optionsLength > selected_option) {
                $(this).find('option:selected').prop("selected", "");
                $(".fav_clr > option[value!='all']").prop("selected", "selected");
            }
            else if(optionsLength == selected_option) {
                $(this).find('option:selected').prop("selected", "selected");
                $(".fav_clr > option").prop("selected", "");
            }
            $(".fav_clr").trigger("change");
        }
    });

    $('select[name="category"]').on('change', function (){
        $("#loading").show();
        $('.StuFa').css('display','none');
        $('.fav_clr').find('optgroup')
                     .remove();
        $('.fav_clr').find('option')
                     .remove()
                     .end()
                     .append('<option value="all">جميع</option>');
        var category = $(this).val();
        var to_user = {'S': "<?=lang('am_students')?>", 'F': "<?=lang('am_parents')?>", 'E': "<?=lang('am_staff')?>"};
        if (category == 'levels' || category == 'row' || category == 'class'|| category == 'U-class') {
            $('.StuFa').css('display','block');
        }
        if (category == 'group') {
            for (var key in to_user) {
                $('#to_user').append(`<option value="`+key+`">`+to_user[key]+`</option>`); 
            }
            $("#loading").hide();
        }
        else {
            $.ajax({
                url: '<?=site_url('chatting/conversation/getUsers')?>',
                data: {category:category},
                cache: false,
                type: 'POST',
                success: function(data){
                    if (category == 'students') {
                        StudentSelectOptions(data);
                    }
                    else if (category == 'row') {
                        RowSelectOptions(data);
                    }
                    else if (category == 'class' || category == 'E-class'|| category == 'U-class') {
                        ClassSelectOptions(data);
                    }
                    else if (category == 'admin') {
                        AdminSelectOptions(data);
                    }
                    else {
                        buildSelectOptions(data);
                    }
                    $("#loading").hide();
                }
            });
        }
    });

    function buildSelectOptions(data) {
        for (var i = 0; i < data.length; i++) {
            $('#to_user').append(`<option value="`+data[i].ID+`">`+data[i].Name+`</option>`); 
        }
    }

    function StudentSelectOptions(data) {
        for (var level in data) {
            items = data[level];
            $('#to_user').append(`<optgroup label="`+level+`">`); 
            for (var key in items) {
                $('#to_user').append(`<option value="`+items[key].ID+`">`+items[key].Name+` - `+items[key].level+` - `+items[key].row+` - `+items[key].className+`</option>`); 
            }
            $('#to_user').append(`</optgroup>`); 
        }
    }

    function RowSelectOptions(data) {
        for (var i = 0; i < data.length; i++) {
            $('#to_user').append(`<option value="`+data[i].ID+`">`+am_level+` `+data[i].LevelName+` - `+am_row+` `+data[i].RowName+`</option>`); 
        }
    }

    function ClassSelectOptions(data) {
        for (var i = 0; i < data.length; i++) {
            $('#to_user').append(`<option value="`+data[i].RowLevelID+`,`+data[i].classid+`">`+am_level+` `+data[i].LevelName+` - `+am_row+` `+data[i].RowName+` - `+am_class+` `+data[i].ClassName+`</option>`); 
        }
    }

    function AdminSelectOptions(data) {
        for (var i = 0; i < data.length; i++) {
            $('#to_user').append(`<option value="`+data[i].ID+`">`+data[i].Name+` -- `+data[i].JobTitle+`</option>`); 
        }
    }
</script>

<script type="text/javascript">
    var img = null;
    function upload_file(fileInput) {
        $("#loading").show();
        var fd = new FormData();
        var files = fileInput[0].files[0]; 
        fd.append('fileUpload', files);
        $.ajax({
            url: '<?=site_url('chatting/conversation/uploadFile')?>',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success == 1) {
                    $("#loading").hide();
                    img = response.img;
                    $('#img_name').html(files.name);
                    $('#attachment').val(img);
                    $('.file-input').css('width','95%');
                    $('.remove-file').html('<span id="remove-file" style="padding-right:9px; color:red; cursor:pointer;" onclick="removeFile();"><i class="fa fa-times"></i></span>');
                } else {
                    alert(response.msg_upload);
                }
            }
        });
    }
</script>

<script type="text/javascript">
    function removeFile() {
        var attachment = $('#attachment').val();
        var fd = new FormData();
        fd.append('attachment', attachment);
        $.ajax({
            url: '<?=site_url('chatting/conversation/deleteFile')?>',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success == 1) {
                    $('#attachment').val('');
                    $('.file-input').css('width','100%');
                    $('#remove-file').remove();
                    $('#img_name').html('No file selected');
                }
            }
        });
    }
</script>

<script type="text/javascript">
    function load_unseen_msg() {
        $.ajax({
            url:"<?=site_url('chatting/conversation/countAllUnread')?>",
            method:"POST",
            cache:false,
            contentType: false,
            processData: false,
            success:function(data) {
                $('.badge-header').html(data.total);
                if (data.total > 0) 
                    $('#count-total').html('<span class="label-danger">'+data.total+'</span>');
                if (data.father > 0) 
                    $('#count-father').html('<span class="label-danger">'+data.father+'</span>');
                if (data.student > 0) 
                    $('#count-student').html('<span class="label-danger">'+data.student+'</span>');
                if (data.employer > 0) 
                    $('#count-employer').html('<span class="label-danger">'+data.employer+'</span>');
            },
        });
    }
    load_unseen_msg();
</script>

<?php if ($this->uri->segment(4) != 'chat') { ?>
<script type="text/javascript">
    setInterval(function(){
            load_unseen_msg();
        }, 2000);
</script>
<?php } ?>