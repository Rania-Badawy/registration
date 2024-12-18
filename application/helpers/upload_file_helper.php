<?php 

function upload_file($Type = "")
{
	$Data['Type'] = $Type ;
	$CI = &get_instance();
	$CI->load->view('admin/view_upload_file_helper', $Data);
}


?>