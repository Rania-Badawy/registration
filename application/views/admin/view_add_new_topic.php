<link href="<?php echo base_url(); ?>assets_new/css/fontawsome.css" rel="stylesheet" crossorigin="anonymous" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets_new/css/table_style.css">
           <link rel="stylesheet" href="<?php echo base_url(); ?>assets_new/css/load.css">
         <link href="<?php echo base_url(); ?>assets_new/css/inbox-style.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets_new/css/select2.min.css" rel="stylesheet" />
        <?php if($this->session->userdata('language') != 'english'){ ?>
        <link href="<?php echo base_url(); ?>assets_emp/exam/css/tornado-rtl.css" rel="stylesheet" />
        <?php }else{ ?>
        <link href="<?php echo base_url(); ?>assets_emp/exam/css/tornado.css" rel="stylesheet" /> 
        <?php } ?>
        
<!-- TinyMCE -->
<script type="text/javascript" src="<?php echo base_url(); ?>jscripts/tiny_mce/tiny_mce.js"></script>

<script type="text/javascript">
tinyMCE.init({
    mode : "textareas",
    theme : "advanced",
    theme_advanced_buttons1 : "fontselect,fontsizeselect,formatselect,bold,italic,underline,strikethrough,separator,sub,sup,separator,cut,copy,paste,undo,redo",
    theme_advanced_buttons2 : "justifyleft,justifycenter,justifyright,justifyfull,separator,numlist,bullist,outdent,indent,separator,forecolor,backcolor,separator,hr,link,unlink,image,media,table,code,separator,asciimath,asciimathcharmap,asciisvg",
    theme_advanced_buttons3 : "",
    theme_advanced_fonts : "Arial=arial,helvetica,sans-serif,Courier New=courier new,courier,monospace,Georgia=georgia,times new roman,times,serif,Tahoma=tahoma,arial,helvetica,sans-serif,Times=times new roman,times,serif,Verdana=verdana,arial,helvetica,sans-serif",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left", 
    theme_advanced_statusbar_location : "bottom",
    plugins : 'asciimath,asciisvg,table,inlinepopups,media',
   
    AScgiloc : 'http://www.imathas.com/editordemo/php/svgimg.php',			      //change me  
    ASdloc : 'http://www.imathas.com/editordemo/jscripts/tiny_mce/plugins/asciisvg/js/d.svg',  //change me  	
        
    content_css : "css/content.css"
});

</script>
<!-- /TinyMCE -->
<style>
        table, th, td {
         text-align: -webkit-right !important;
        }
       
        #drop_file_zone {
            width: 100%;
            height: 200px;
            padding: 8px;
            font-size: 18px;
        }
        #drag_upload_file {
          width:50%;
          margin:0 auto;
        }
        #drag_upload_file input{
          width:50%;
          margin:0 auto;
          height: 30px;
        }
        #drag_upload_file p {
          text-align: center;
        }
        #drag_upload_file #fileInput {
          display: none;
        }
        .img-content img{
            height: 168px;
            padding: 5px;
            width: 200px;
            border-radius: 12%;
        }
       .newNavPa{
           height: 84px;
       }
           .newNav .tooltip{
               position: absolute;
               z-index: 1;
               left: 0;
               width: fit-content;
               padding: 0 3px;
           }
           .newNav .tooltip-inner{
              padding: 5px;
              position: absolute !important;
              top: -15px !important;
              left: -61px;
              width: 65px !important;
           }
           .newNav .badge{
                display: inline-block;
                min-width: 10px;
                padding: 3px 7px;
                font-size: 12px;
                font-weight: 700;
                line-height: 1;
                color: #fff;
                text-align: center;
                white-space: nowrap;
                vertical-align: middle;top: -7px !important;
                left: -7px !important;
                background: #fd1901;
                border-radius: 10px;
                height: 20px;
           }
           .textAreaContain iframe{height: 200px !important;}
       </style>
<div class="loading_div" id="loadingDiv" ></div>

<script type="text/javascript">
    $(document).ready(function(){
        
       $("#loadingDiv").hide();
       
    });
</script>

      
      
      <div style="width: 100%;" class="container-xl white-bg padding-all-20 mb40 round-corner main-container">
          <div class="page-head container-xl pt30 blue">
        <div class="row">
            <div class="col-auto"> 
            <?php if($this->session->userdata('language') != 'english'){ ?>
              <h1><?php echo $cms_sub['Name'];?> </h1>
            <?php }else{?>
             <h1><?php echo $cms_sub['Name_en'];?> </h1>
            <?php } ?>
            </div>
        </div>
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
        <form class="form-ui manage-content__form" action="<?php echo site_url('admin/Content_management/add_new_topic') ?>" method="post">
          <h5 class="mb20"><?php echo lang('am_add_item');?> </h5>

          <div class="row mb30">
            <!-- field -->
            <div class="col-12 col-m-4 col-xl-6">
              <label class="mb5"><?php echo lang('am_title');?></label>
              <input type="text" name="txt_title" class="form-control" value="<?php echo $get_data['Title'];?>">
            </div>
            <div class="col-12 col-m-4 col-xl-6">
              <label class="mb5"><?php echo lang('am_title_en');?></label>
              <input type="text" name="txt_title_en" class="form-control" value="<?php echo $get_data['Title_en'];?>">
            </div>
            <input type="hidden" name="sub_id" value="<?php echo $sub_id ;?>">
            <input type="hidden" name="topic_id" value="<?php echo $topic_id ;?>">

            <div class="col-12 col-m-4 col-xl-6">
              <label class="mb5"><?php echo lang('br_Branches');?></label>
              <select name="school_id[]"   multiple required class="form-control selectpicker bs-select-hidden">
                   <!--<option value="0"><?php echo lang('br_Branches');?></option>-->
                  <?php 
                $school_array=explode(",",$get_data['schoolID']);
                  foreach($get_branches as $key=>$school)
					{
				// 		$Name  = $school-> SchoolName ;
				// 		$ID    = $school->ID;
						
					$ID   = $school->ID ;

					$Name = $school->Name ;
			       ?>
			       
                  <option value="<?php echo $ID ; ?>"<?php if(in_array($ID,$school_array)){echo 'selected' ;}?>><?php echo $Name ; ?></option>
    			<?php }?>
              </select>
            </div>
          
            <div class="col-12 col-m-4 col-xl-6" <?php if($this->uri->segment(4) == 115||$this->uri->segment(4) == 145){}else{echo 'style="display: none;"';}?> >
              <label class="mb5"><?php echo lang('am_levels');?></label>
                <select name="level_id[]" multiple required class="form-control selectpicker bs-select-hidden">
                  <option value=""></option>
                  <?php $level_array=explode(",",$get_data['LevelID']);?>
                  <option value="0" <?php if(in_array(0,$level_array)){echo 'selected' ;}?>><?php echo lang('am_general') ; ?></option>
                  <?php 
                  $get_levels=get_level_group();
                  foreach($get_levels as $key=>$level)
					{
						$Name  = $level->LevelName;
						$ID    = $level->LevelID;
			       ?>
                  <option value="<?php echo $ID ; ?>"<?php if(in_array($ID,$level_array)){echo 'selected' ;}?>><?php echo $Name ; ?></option>
    			<?php }?>
              </select>
            </div>
            </div>
            <div class="row mb30">
                <?php if($cms_sub['cms_type_id']==1){ ?>
            <div class="col-12 col-m-4 col-xl-12 textAreaContain">
              <label class="mb5"><?php echo lang('am_content');?></label>
              <textarea name="content"><?php echo $get_data['Content'];?></textarea>
            </div>
            
            <div class="col-12 col-m-4 col-xl-12 textAreaContain">
              <label class="mb5"><?php echo lang('am_content_en');?></label>
              <textarea name="content_en"><?php echo $get_data['Content_en'];?></textarea>
            </div>
           <?php }if($cms_sub['cms_type_id'] != 3){ ?>
            <div class="col-12 col-m-2 col-xl-2" style="width:100%;">
              <label class="mb5"><?php echo lang('attach');?></label>
              <!--<div class="file-input" data-text="Upload" style="width: fit-content;">-->
              <!--  <input type="file" id="fileUpload">-->
              <!--  <input name ="hidImg" id ="hidImg" type="hidden" value="<?php echo $get_data['ImagePath'];?>" />-->
              <!--</div>-->
                <div id="drop_file_zone" ondrop="upload_file(event)" ondragover="return false" class="advanced-uploader fas fa-images" data-size="hd">
                    <div id="drag_upload_file">
                        <p>Drop file here</p>
                        <p>or</p>
                        <p><input type="button" value="Select File" onclick="file_explorer();" multiple/></p> 
                        <?php $img_array=explode(",",$get_data['ImagePath']);?>
                        <input type="file"  name ="fileInput" id ="fileInput" multiple value="<?php echo $get_data['ImagePath'];?>"/>
                        <input type="hidden" name ="hidImg[]" id ="hidImg" value="<?php echo $get_data['ImagePath'];?>"/>
                       
                    </div>
                </div>
                <div class="img-content" style="display: ruby;">
                    <?php 
                    $img_array=explode(",",$get_data['ImagePath']);
                    $img_array=str_replace( '[' ,'' , $img_array );
                    $img_description=explode(",",$get_data['img_description']);
                    foreach($img_array as $key=>$ImagePath){
                        $n = $key+1;
                    ?>
                    <?php if($ImagePath){
                    $ext = pathinfo($ImagePath, PATHINFO_EXTENSION); ?>
                    <input type="hidden" id="img_del_<?= $n; ?>" value="<?= $ImagePath ;?>"/>
                    <div <?php if($ext!='xlsx'&& $ext!='xls' && $ext!='MP4' && $ext!='mp4' && $ext!='MP3' && $ext!='mp3' && $ext!='pdf' && $ext!='txt') { ?>style="width: 200px;" <?php } ?> id="imgcon_<?= $n; ?>">
                   <?php if($ext==MP4||$ext==mp4 ||$ext==MP3 ||$ext==mp3){?>
                     
                    <video width="200px" height="200" controls><source src="<?php echo base_url().'upload/'.$ImagePath; ?>" type="video/<?=$ext;?>"></video>
                    
                    <?php }
                    
                    
                    elseif($ext=='xlsx' || $ext=='xls'){
                                             ?>
                                              <iframe src='https://view.officeapps.live.com/op/embed.aspx?src=<?php echo base_url().'upload/'.$ImagePath;?>' width="300px" height="300px" ></iframe>
                                            
                                             <?php
                                        }elseif($ext=='pdf' || $ext=='txt'){?>
                                            <embed src="<?php echo base_url().'upload/'.$ImagePath;?>" type="application/pdf"   width="400px" height="400px">
                
                   <? }
                    else{ ?>
                    
                        <img src="<?php echo base_url().'upload/'.$ImagePath; ?>">
                     <?php } ?>  
                        <a href="javascript:void(0)" name="Band ring" title="Delete" onclick="delImgUp_<?= $n; ?>();" >
                            <i style="position: absolute;margin-right: -14px;background-color: white;" class="fas fa-trash-alt danger-color"></i>
                            
                        </a>
                   <input type='text' name ='img_description[]' id ='img_description' value='<?php echo $img_description[$key];?>' style='width: auto;'/>
                    </div>    
                    <?php }?>
                     <script>function delImgUp_<?= $n; ?>(){
                            $("#imgcon_<?= $n; ?>").remove();
                            var img_del = $("#img_del_<?= $n; ?>").val();
                            var imgArray = $("#hidImg").val()
                            var x = imgArray.split(",");
                            for(let i=0;i<=x.length;i++){
                                if(x[i] == img_del){
                                    x.splice(i, 1);
                                }
                            }
                            document.getElementById("hidImg").value = x.toString();
                            }</script>
                    <?php }} ?>
                </div>
            </div>
            <?php 
            
            if($cms_sub['cms_type_id']==4){ ?>
            <div class="col-12 col-m-4 col-xl-4" id="iframe_div">
              <label class="mb5"><?php echo lang('am_youtube');?></label>
              <input oninput="get_youtube_id()" type="text" name="txt_youtube" id="txt_youtube" class="form-control" value="<?php echo $get_data['YoutubeScript'];?>">
            </div>
            
            <?php
            if(strpos($get_data['YoutubeScript'], 'https://www.youtube.com/watch?v=')!== false) { 
            $yotube_space=strstr($get_data['YoutubeScript'],"&");
            $del_space  = str_replace($yotube_space, '', $get_data['YoutubeScript']);
            $get_Youtube_embed = str_replace('https://www.youtube.com/watch?v=', 'https://www.youtube.com/embed/', $del_space);
            }elseif(strpos($get_data['YoutubeScript'], 'https://youtu.be/')!== false){
                $get_Youtube_embed = str_replace('https://youtu.be/', 'https://www.youtube.com/embed/', $get_data['YoutubeScript']);
            }else{$get_Youtube_embed=$get_data['YoutubeScript'];}
            ?>
            <iframe width="200" height="200" src="<?php echo $get_Youtube_embed;?>" allowfullscreen></iframe>
            <?php }elseif($cms_sub['cms_type_id']==3){?>
            <div class="col-12 col-m-2 col-xl-2">
              <label class="mb5"><?php echo lang('am_sound');?></label>
              <div class="file-input" data-text="Upload" style="width: fit-content;">
                <input type="file" id="fileUpload1">
                <input name ="hidsound" id ="hidsound" type="hidden" value="<?php echo $get_data['Sound'];?>" />
              </div>
            </div>
            <?php if($get_data['Sound']){$ext = pathinfo($get_data['Sound'], PATHINFO_EXTENSION); if($ext==="mp3"){$x="mpeg";}else{$x=$ext;}  ?> 
             <audio  width="200px" height="200" controls><source src="<?php echo base_url().'upload/'.$get_data['Sound']; ?>" type="audio/<?=$x;?>"></audio>
            <!--<a class="btn btn-info" href="<?php echo base_url().'upload/'.$get_data['Sound']; ?>" target="_blank" style="margin-top: 20px;background-color: darkturquoise;"><?php echo lang('am_download');?></a>-->
            <?php } ?>
            <?php } ?>
            <div class="col-12 col-m-4 col-xl-4" style="margin-top: 23px;">
                <?php if(!$topic_id){?>
              <button class="btn small blue-bg" type="submit"><?php echo lang('br_save');?></button>
              <?php }else{ ?>
              <button class="btn small blue-bg" type="submit"><?php echo lang('br_edit');?></button>
              <?php } ?>
            </div>
           </div>
        </form>
   
     <table class="table bordered-y data-table white-bg medium-spaces" data-items="6">

     <thead>

              <tr class="purble-bg" >
                <th>#</th>
                <th><?php echo lang('am_title');?></th>
                <th><?php echo lang('br_Branches');?></th>
				<th><?php echo lang('am_levels');?></th>
				<th><?php echo lang('am_edit');?></th>
				<?php  /*if($this->uri->segment(4) != 193 && $this->uri->segment(4) != 196 && $this->uri->segment(4) != 199){ */?>
				<th><?php echo lang('am_delete');?></th>
				<?php /*}*/ ?> 
              </tr>
     </thead>
     <tbody>         

			  <?php
			  foreach($get_details as $Key=>$item)

			  {
			       $Num                = $Key+1;
				   $ID                 = $item->ID;
				   $MainSubID          = $item->MainSubID;
				   $Title              = $item->Title;
				   $Content            = $item->Content;
				   $ImagePath          = $item->ImagePath;
				   $YoutubeScript      = $item->YoutubeScript;
				   $LevelID            = $item->LevelID;
				   $schoolID           = $item->schoolID; 
				   $get_school         = $this->content_management_model->get_specific_school($schoolID);
				   $get_level          = $this->content_management_model->get_specific_level($LevelID);
                  ?>

                <tr> 
                    <td><?php  echo $Num ?> </td>
                    <td><?php  echo $Title ?> </td>
                    <td>
                            <?php foreach($get_school as $Key=>$school){ echo $school->SchoolName .","; }?>
                     </td>
                     <td>
                            <?php
                            $LevelID = explode(',',$LevelID);
                            if (in_array(0, $LevelID)){echo lang('am_general').' , ';}
                            foreach($get_level as $Key=>$level){ echo $level->Name .","; }?>
                     </td>
                     <td>
                        <a   href="<?php echo site_url('admin/content_management/new_topic/'.$MainSubID."/".$ID )?>" >
                                          <i class="fas fa-edit" style="color:blue;" title="edit"></i>
                        </a>
                      </td>
                      <?php  /*if($this->uri->segment(4) != 193 && $this->uri->segment(4) != 196 && $this->uri->segment(4) != 199){*/ ?>
					<td> 
					    <a  href="<?php echo site_url('admin/content_management/delete_topic/'.$MainSubID."/".$ID);?>" onclick="return confirm('Are you sure to delete?')" name="Band ring" title="Delete"  >
                            <i class="fas fa-trash-alt danger-color"></i>
                        </a>
                    </td>
                    <?php /*}*/ ?> 
                    </tr>

				  <?php   }?>
       </tbody>       

			  </table>
      <script>
               $('#fileUpload').change(function(e) {
                   $("#loadingDiv").show();
					var xhr    = new XMLHttpRequest();
					var data   = new FormData();
					jQuery.each($('#fileUpload')[0].files, function(i, file) {data.append('file', file);});
				 /*==============================================================================================*/
				 /*----------------------------------------------------------------------------*/
								$.ajax({
										url: '<?php echo site_url('admin/Content_management/up_ax') ?>',
										data: data,
										cache: false,
										contentType: false,
										processData: false,
										type: 'POST',
										beforeSend : function()
										{
											
										},  
										success: function(data){
											$("#loadingDiv").hide();
											if(data.msg_type == 0 )
											{
											   $("#msgUpload").html(data.msg_upload) ;
											}
											else if(data.msg_type == 1 )
											{
												var newImg = data.base+'upload/'+data.img;
												var fileInput       = $("#fileInput").val(data.img);
												$("#div_img").append('<div id="imgcon"><a href="'+newImg+'" ><?php echo lang('am_download');?></a><button class="uploadclose" onClick="delImgUp();">X</button></div>');
											}
										}
						});
				/*==============================================================================================*/
                }); 
       </script>
       <script>
               $('#fileUpload1').change(function(e) {
                   $("#loadingDiv").show();
					var xhr    = new XMLHttpRequest();
					var data   = new FormData();
					jQuery.each($('#fileUpload1')[0].files, function(i, file) {data.append('file', file);});
								$.ajax({
										url: '<?php echo site_url('admin/Content_management/up_ax_sound') ?>',
										data: data,
										cache: false,
										contentType: false,
										processData: false,
										type: 'POST',
										beforeSend : function()
										{
											
										},  
										success: function(data){
											$("#loadingDiv").hide();
											if(data.msg_type == 0 )
											{
											   $("#msgUpload").html(data.msg_upload) ;
											}
											else if(data.msg_type == 1 )
											{
												var newImg = data.base+'upload/'+data.img;
												var hidsound       = $("#hidsound").val(data.img);
												$( "#div_img" ).append('<div id="imgcon"><a href="'+newImg+'" ><?php echo lang('am_download');?></a><button class="uploadclose" onClick="delImgUp();">X</button></div>');
											}
										}
						});
				/*==============================================================================================*/
                });

            
       </script>
       
       <script type="text/javascript">
    function get_youtube_id(YouTubeUrl,scriptID)
{
 
	var url = YouTubeUrl ; 
	 var ID = '';
  url = url.replace(/(>|<)/gi,'').split(/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/);
  if(url[2] !== undefined) {
    ID = url[2].split(/[^0-9a-z_\-]/i);
    ID = ID[0];
	var src = 'https://www.youtube.com/embed/'+ID;
	
// 	  var iframe = '<iframe id="youtube" width="100%" height="115" frameborder="0" src="'+src+'" allowfullscreen></iframe>';
    $("#iframe_div"+scriptID).html(iframe); 
	$("#txt_youtube"+scriptID).val(ID);
    return false;
	
  }
  else {
    ID = url;
    }
 }

var fileobj;
function upload_file(e) {
    e.preventDefault();
    fileobj = e.dataTransfer.files[0];
    ajax_file_upload(fileobj);
}
  
function file_explorer() {
    document.getElementById('fileInput').click();
    document.getElementById('fileInput').onchange = function() {
        var selectedFiles = document.getElementById('fileInput').files
        for (var i = 0, f; f = selectedFiles[i]; i++) {
            if (f.size > 200145728) // 3 MiB for bytes.
                {
                  alert("File size must under 200MiB!");
                  return false;
                }
         ajax_file_upload(f)
         $("#loadingDiv").show();
        }
    };
}
  
function ajax_file_upload(file_obj) {
    if(file_obj != undefined) {
        var form_data = new FormData();                  
        form_data.append('file', file_obj);
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "<?php echo site_url('admin/Content_management/up_ax_new') ?>", true);
        xhttp.onload = function(event) {
            oOutput = document.querySelector('.img-content');
            if (xhttp.status == 200) {
                $("#loadingDiv").hide();
                var y =this.responseText.split('/')[1];
                oOutput.innerHTML += "<div id='imgcon' style='width: 200px;'> <img src='<?php echo base_url(); ?>"+ this.responseText +"' alt='The Image' /><i style='position: absolute;margin-right: -14px;background-color: white;' class='fas fa-trash-alt danger-color'></i><label><?php echo lang('Description');?></label><input type='text' name ='img_description[]' id ='img_description' value='' style='width: auto;'/><a href='javascript:void(0)' name='Band ring' title='Delete' onclick='delImg_new(\"" + y + "\")' > </div>";
                $("#hidImg").val($("#hidImg").val() + this.responseText.split('/')[1] + ',');
            } else {
                oOutput.innerHTML += "Error " + xhttp.status + " occurred when trying to upload your file.";
            }
        }
        xhttp.send(form_data);
    }
} 
function delImg_new(files){
    $("#imgcon").remove();
    var img_del = files;
    var imgArray = $("#hidImg").val()
    var x = imgArray.split(",");
    var img_description = $("#img_description").val()
    var y = img_description.split(",");
    for(let i=0;i<=x.length;i++){
        if(x[i] == img_del){
            x.splice(i, 1);
            y.splice(i, 1);
        }
    }
    document.getElementById("hidImg").value = x.toString();
 document.getElementById("img_description").value = y.toString();
}
</script>
 
<?php
 ?>