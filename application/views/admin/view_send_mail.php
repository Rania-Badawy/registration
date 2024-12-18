
    <div class="clearfix"></div>
  <div class="content margin-top-none container-page">  
       <div class="col-lg-12">
 <div class="block-st">
 <div class="sec-title">
      <h2><?php echo 'بريد إلكترونى '; ?></h2>
</div>

<div class="widget-content">

 
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

  <form action="<?php echo site_url('admin/mobile_msg/active_send_mail') ?>" enctype="multipart/form-data" method="post">
<!---------------------------------------------------------------------------------->
<div class="form-group col-lg-5"  id="div_class">
  <label class="control-label col-lg-3"><?php echo lang('br_class');?></label>
 <div class="col-lg-9">
  <select name="SelectClass[]" multiple data-live-search="true" class="selectpicker form-control bs-select-hidden" tabindex="18" id="SelectClass">
        <?php
        if($GetRowLevel && $GetClass)
			{
				foreach($GetRowLevel as $Key=>$RowLevel)
				{
					
					if($GetClass)
			       {
				    foreach($GetClass as $Key=>$Class)
				   {
					$ID   = $RowLevel->RowLevelID.'|'.$Class->ClassID ;
					$Name = $RowLevel->LevelName."--".$RowLevel->RowName."--".$Class->ClassName ;
					
					$query = $this->db->query("SELECT student.ID FROM student INNER JOIN contact ON student.Contact_ID	 = contact.ID WHERE Class_ID = '".$Class->ClassID."' AND  student.R_L_ID = '".$RowLevel->RowLevelID."' AND contact.SchoolID = '".$this->session->userdata('SchoolID')."'  ")->num_rows();
					
					?>
					<option value="<?php echo $ID ; ?>"
                    ><?php echo $Name .'&nbsp;&nbsp;&nbsp;'.lang('br_Num').'&nbsp;&nbsp;&nbsp;'.$query ; ?></option>
					<?php 
				  }
			   }
					
				}
			}
         ?>
    </select>
 </div>
</div>

<!------------------------------------------------------------------------------------------------->

<div class="form-group col-lg-5"  id="div_father">
  <label class="control-label col-lg-3"><?php echo 'الطلاب';?></label>
 <div class="col-lg-9">
  <select name="GetStudent[]" multiple  data-live-search="true" class="selectpicker form-control bs-select-hidden" tabindex="18" id="GetStudent">
        <?php
        if($GetFather )
			{
				foreach($GetFather as $Key=>$Father)
				{
					
					
				   
					$ID     = $Father->StudentID ;
					$Name   = $Father->FullName ;
					$Mobile = '' ;
					$query = $this->db->query("SELECT Mail	 FROM contact WHERE ID = '".$ID."' ")->row_array();
					if(sizeof($query) > 0 )
					{
						$Mail = $query['Mail'] ;
					}if(!empty($Mail))
					{
					?>
					<option value="<?php echo $ID ; ?>"
                    ><?php echo $Name  ; ?></option>
					<?php	
					}
					 
					
				}
			}
         ?>
    </select>
 </div>
</div>

<div class="clearfix"></div> 

      <div class="form-group col-lg-12">
      <label class="control-label col-lg-1 padd_left_none padd_right_none"><?php echo lang('am_message'); ?></label>
                    <div class="col-lg-11">
                        <textarea id="message" style="min-height:200px" class="form-control" name="message"></textarea>
                    </div>
                </div>
  
  
  <!------------------------File ------------------------------------>
                <?php upload_file() ; ?> 
  <!------------------------File ------------------------------------>
  

    <div class="form-group col-lg-12">      
      <input type="submit"  class="btn btn-success pull-left" onClick="chk_sub();" value="<?php echo "إرسال " ?>" />
    <script type="text/javascript">
    function chk_sub()
    {
		window.onbeforeunload = false ;
    }
    </script>

 </div> 
 <div class="clearfix"></div> 
    </form>
</div>
<div class="clearfix"></div>    
</div>
<div class="clearfix"></div>
</div>
  