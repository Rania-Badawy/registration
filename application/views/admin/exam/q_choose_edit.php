<script type="text/javascript" >
$( document ).ready(function() {
	    $("#BtnSubmit").click(function(e) {
			$("#error_ans").hide();
			var num_answers = $("#num_answers").val();
			var count_ans   = 1;
			while(count_ans<=num_answers){
				var answer_txt = "#answer_txt_"+count_ans;
				var answer_txt = $(answer_txt).val();
				if(answer_txt<3){
					$("#error_ans").show();
					return false;
					}else{
						return true;
						}
						count_ans++;
				}
		});
});
</script>
<?php
	echo '<div class="sec-title"><h2>املأ الفراغات بالاجابات الصحيحه</h2></div>';
	echo '<div class="clearfix"></div>';
    $str = strip_tags($str);
	$txt_answers_pieces = explode("##", $str);
	$array_count = count($str);
	$index_answer = strrpos($str,'##');
	$count_index_answer =0;
	if($index_answer>=0 ){
		echo '<label  class="label-control" >'.$txt_answers_pieces[$count_index_answer].'</label>';
		$count_index_answer++;
		}
	$count_Str = substr_count($str, '##');
	$str_count =1;
	
	if($count_Str!=0){
		
		while($str_count<=$count_Str){
			?>
            <div>
			<input type="text"class="form-control" id="answer_txt_<?php echo $str_count?>" name="answer_txt_<?php echo $str_count?>" value="" />
            </div>
           <div id="error_ans" class="col-lg-2" style="display:none"><?php echo lang('complete_answer_not_write');?></div>
			<?php
			echo '<label class="label-control" >'.$txt_answers_pieces[$count_index_answer].'</label>';
			$count_index_answer++;
			?>  <?php $str_count++;?> <?php
			}
		}else{?> <div class="alert alert-danger"> <?php echo lang('Not_exit');?> </div> <?php }
?>
<input type="hidden" id="num_answers" name="num_answers" value="<?php echo $count_Str;?>" />
 