<?php if(!defined('BASEPATH')) exit('No direct script access allowed');ini_set('default_charset','UTF-8');
class Get_Data_Emp{
	
		private  $DataLib = array();
        private  $CI   ;
		 function __construct()
		 {
			$this->CI =& get_instance();
			$this->CI->load->model(array('class_table/config_class_table_model','subject/subjects_model','emp/emp_permission_model'));
			if(!$this->CI->session->userdata('login')){redirect('home/login');}
			else{
			      $GetJobTitle = $this->CI->emp_permission_model->get_job_title($this->CI->session->userdata('id'));
				  $this->CI->session->set_userdata('job_title',$GetJobTitle['jobTitleID']);
			    }
			if($this->CI->session->userdata('language') == 'english')
			{
				$this->CI->lang->load('am','english');
		        $this->CI->lang->load('br','english');
		        $this->CI->lang->load('er','english');
				$this->CI->session->set_userdata('style_loc','style_ltr.css');
				$this->CI->session->set_userdata('bootstrap','bootstrap_ltr.css');
				$this->CI->session->set_userdata('css_cpanel','css_ltr');
				$this->CI->session->set_userdata('js_cpanel','js_ltr');
			}else{
				   	   $this->CI->lang->load('am','arabic');
		               $this->CI->lang->load('br','arabic');
		               $this->CI->lang->load('er','arabic');
				       $this->CI->session->set_userdata('style_loc','style.css');
				       $this->CI->session->set_userdata('bootstrap','bootstrap.css');
					   $this->CI->session->set_userdata('css_cpanel','css');
				       $this->CI->session->set_userdata('js_cpanel','js');

				 }
		 }
		  ////check data session
		public function get_data_emp_cp()
		{
		  $this->DataLib['UID']       = $this->CI->session->userdata('id');
	      $this->DataLib['DataTAble']= $this->CI->config_class_table_model->get_class_cpanel($this->DataLib['UID']);
		  $this->DataLib['GetSubject']= $this->CI->subjects_model->get_emp_subjects();
		  return $this->DataLib  ;
		}
}///// END OF LIBRARY 
?>