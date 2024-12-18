<script type="text/javascript" src="<?php echo base_url()?>jscripts/tiny_mce/plugins/asciimath/js/ASCIIMathMLwFallback.js"></script>

<script type="text/javascript">

var AMTcgiloc = "http://www.imathas.com/cgi-bin/mimetex.cgi";  		//change me

</script>



<!-- TinyMCE -->

<script type="text/javascript" src="<?php echo base_url()?>jscripts/tiny_mce/tiny_mce.js"></script>



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

        

    content_css : "<?php echo base_url() ?>jscripts/tiny_mce/themes/advanced/skins/default/content.css"

});



</script>

<script type="text/javascript">

function act_del()

{

  var msg = confirm("تأكيد الحذف") ;

  

  if(msg)

  {

	  return true ; 

  } 

  else

  {

	  return false ; 

  }



}



</script>

    <div class="clearfix"></div>

  <div class="content margin-top-none container-page">  

       <div class="col-lg-12">   

 <div class="block-st">



<div class="foem-group col-lg-12" >

   <a href="<?php echo site_url('emp/question/add_question/'.$id.''); ?>" class="btn btn-success pull-left" ><?php echo lang('add_questions'); ?></a>

   </div>

   <div class="clearfix"></div> 

   <br />

 <div class="clearfix"></div>



<?php

	 if($question !=0 ){            

?>  

             <div class="clearfix"></div>



            <div  class="panel panel-danger">

				<div class="panel-body no-padding"> 

<table class="table table-bordered table-striped" id="static">

   <thead>

	<tr>

    	<th><?php echo lang('question'); ?></th>

        <th><?php echo lang('Type_question'); ?></th>

        <th><?php echo lang('Degree'); ?></th>

        <th><?php echo lang('am_edit'); ?></th>

        <th><?php echo lang('am_delete'); ?></th>

    </tr>

   </thead>

  <?php foreach($question as $row){

	  $q_type = $row->questions_types_ID;

	  ?><?php if($q_type!=7){?>

   <tbody>

	<tr>

    	<td><?php  echo $row->Question;?></td>

    	<td><?php  echo $row->Name;?></td>

    	<td><?php  echo $row->Degree?></td>

        <td><span class="tip" >

         <a class="btn btn-success btn-rounded" title="Edit" href="<?php echo site_url('emp/question/sees_edit_item/'.$row->questions_content_ID)?>" >

          <?php echo lang('am_edit'); ?> <i class="fa fa-edit"></i>

          </a>

       </span></td>

        <td><span class="tip" >

         <a class="btn btn-danger btn-rounded" id="1" class="Delete" href="<?php echo site_url('emp/question/sees_del_item/'.$row->questions_content_ID)?>"name="Band ring" title="Delete"   

         onclick="return act_del();">

          <?php echo lang('Degree'); ?> <i class="fa fa-trash-o"></i>

        </a>

      </span></td>

    </tr>

   </tbody>

    <?php }else{

		$Question = explode('%!%',$row->Question);

		$q_more = $Question[0].'...';

		$count_degree = count($Question)-1;

		$count_array = 1;

		$degree= 0;

		while($count_degree>$count_array){ 

		$degree = $degree+floatval($Question[$count_array]);

		$count_array= $count_array+2;}

		?>

   <tbody>

	<tr>

    	<td><?php  echo $q_more;?></td>

    	<td><?php  echo $row->Name;?></td>

    	<td><?php  echo $degree;?></td>

        <td><span class="tip" >

         <a class="btn btn-success btn-rounded" title="Edit" href="<?php echo site_url('emp/question/sees_edit_item/'.$row->questions_content_ID)?>" >

          <?php echo lang('am_edit'); ?> <i class="fa fa-edit"></i>

          </a>

       </span></td>

        <td><span class="tip" >

         <a class="btn btn-danger btn-rounded" id="1" class="Delete" href="<?php echo site_url('emp/question/sees_del_item/'.$row->questions_content_ID)?>"name="Band ring" title="Delete"   

         onclick="return act_del();">

         <?php echo lang('am_delete'); ?> <i class="fa fa-trash-o"></i>

        </a>

      </span></td>

    </tr>

   </tbody>

    <?php }//else type_q?>

 <?php }?>

</table>

</div>

</div>

<?php  }

else

{?>

 <div class="clearfix"></div>

 <br />

  <div class="clearfix"></div>

<div class="alert alert-danger"><?php echo lang('Not_exit') ;?></div><?php }?></div>

    

    

    </div>

       <div class="clearfix"></div>

    </div>

      <div class="clearfix"></div> 

    </div>

