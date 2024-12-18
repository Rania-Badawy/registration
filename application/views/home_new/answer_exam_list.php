 <link rel="stylesheet" href="<?php echo base_url(); ?>assets/new/datatable-filter/jquery.dataTables-filter-columns.css" type="text/css" />
<script type="text/javascript" src="<?php echo base_url(); ?>assets/new/datatable-filter/jquery.dataTables-filter-columns.min.js"></script>
 
<script type="text/javascript">

 $(document).ready(function(){	
  setInterval(function() {
        $("#divMessage").hide("slow");
    }, 10000);  
 })
$(document).ready(function() {
      document.title = '<?php  echo lang('Exams');?>';
    $('#static').DataTable( {
        "paging":   false,
        "ordering": false,
        "info":     false,
        initComplete: function () {
            this.api().columns().every( function () {
                var column = this;
                var select = $('<select class="form-control"><option value=""></option></select>')
                    .appendTo( $(column.header()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }
    } );
} );

</script>
<style type="text/css">
.divMessage {
	width:98%;
	padding:7px;
	text-align:center;
	font-weight:bold;
	background-color: #C1F3A0;
	border: 1px solid #B4F37A;
	-moz-border-radius: 9px;
	-webkit-border-radius: 9px;
	border-radius: 9px;
	/*IE 7 AND 8 DO NOT SUPPORT BORDER RADIUS*/
	-moz-box-shadow: 0px 0px 2px #B4F37A;
	-webkit-box-shadow: 0px 0px 2px #B4F37A;
	box-shadow: 0px 0px 2px #336633;
	/*IE 7 AND 8 DO NOT SUPPORT BLUR PROPERTY OF SHADOWS*/
	opacity: 0.89;
	-ms-filter: progid:DXImageTransform.Microsoft.Alpha(Opacity = 89);
	/*-ms-filter must come before filter*/
	filter: alpha(opacity = 89);
	/*INNER ELEMENTS MUST NOT BREAK THIS ELEMENTS BOUNDARIES*/
	/*All filters must be placed together*/
	line-height:30px;
	

	}.divMessage h4 {
		border:none !important;
		color:#336633;
		}
		.content{min-height: calc(100vh - 90px);}
		#static{
		    width: 90%;
		    margin: 50px auto 0 ;
		}
		#static td,
		#static th{
		    text-align: center;
		    padding: 8px;
		    border: 1px solid #eaeaea;
		}
		tbody{
		    background: #faf9f6;
		}
		thead{
		    background: #b3dce9;
            color: #080848;
		}
</style>

    <div class="clearfix"></div>
  <div class="content margin-top-none container-page">  
       <div class="col-lg-12">   
 <div class="block-st">
 <div class="sec-title">
    <h2><?php  echo lang('Exams');?></h2>
 </div>
<?php

if (isset($message)){ 
			echo "<div id='divMessage' class='divMessage'><h4>".$message."</h4></div>"; 
}
?><?php  
		$count=0;
        if($exam_details!=0){ 
 //$student_class  = $this->answer_exam_model->get_student_class(); 
			?>
<table class="table table-bordered table-striped" id="static" style="border-radius: 8px 8px 0 0">
     <thead>
         <tr>
            <th style="border-radius:0 8px 0 0"align="center"><?php echo lang('Exam_Name'); ?></th>
            <th><?php echo lang('am_row'); ?></th>
              <th style="border-radius:8px 0 0"><?php echo lang('answer_exam')  ; ?></th>
          </tr>
      </thead> 
     <tbody>
        <?php  
            foreach($exam_details as $row){
				$test_ID              = $row->test_ID;
				$test_Name            = $row->test_Name;
				$row_level_Name       = $row->rowLevelName;
			
				$count++; 
				$query=$this->db->query("select * from test_student where  Contact_ID=".$this->session->userdata('id')."")->result();
                              
			?>
        <tr>
         <td  align="center"><?php  echo $test_Name;?></td>
         <td  align="center"><?php  echo $row_level_Name;?></td>
           <td  align="center"><?php if(empty($query)){?><a  class="btn btn-success btn-rounded" title="Edit" href="<?php echo site_url('student/answer_exam/show_exam/4/'.$test_ID."/reg")?>" >
           <?php echo lang('answer_exam'); ?> <i class="fa fa-pencil-square fa-lg" style="margin: 0 10px"></i>
          </a> <?php }else{ ?>
           سنوافيكم بالنتيجة وبالتوفيق
         <?php } ?>
        </td> 
        
   </tr>
      <?php
            }
        ?>
  </tbody>
</table>		     
                     
		<?php
            }else{?><div class="alert alert-danger"><?php echo lang('Not_exit') ;?></div><?php }
        ?>
       
    <input type="hidden" name="txt_count_ID" id="txt_count_ID" value="<?php  echo $count;?>" />
    
     
     
     </div>
     <div class="clearfix"></div>
     </div>
      <div class="clearfix"></div>
     </div>
