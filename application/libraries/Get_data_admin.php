<?php if(!defined('BASEPATH')) exit('No direct script access allowed');ini_set('default_charset','UTF-8');
class Get_Data_Admin{
	
		private  $DataLib = array();
		private  $level   = array();
		private  $Add     = 1 ;
		private  $Edit    = 1 ;
		private  $Delete  = 1 ;
		private  $Veiw    = 1 ;
        private  $CI   ;
		 function __construct()
		 {
			$this->CI =& get_instance(); 
			$this->CI->load->model(array('emp/emp_permission_model'));
			if(!$this->CI->session->userdata('login')){redirect('home/login');}
			else{$this->DataLib['UID']       = $this->CI->session->userdata('id');}
				$this->CI->lang->load('am','english');
		        $this->CI->lang->load('br','english');
		        $this->CI->lang->load('er','english');
		      
			if($this->CI->session->userdata('language') == 'english')
			{
				$this->CI->lang->load('am','english');
		        $this->CI->lang->load('br','english');
		        $this->CI->lang->load('er','english');//echo $this->CI->lang->line();

				$this->CI->session->set_userdata('style_loc','style_ltr.css');
				$this->CI->session->set_userdata('bootstrap','bootstrap_ltr.css');
				$this->CI->session->set_userdata('css_cpanel','css_ltr');
				$this->CI->session->set_userdata('js_cpanel','js_ltr');
			}elseif ($this->CI->session->userdata('language') == 'arabic'){
				   	   $this->CI->lang->load('am','arabic');
		               $this->CI->lang->load('br','arabic');
		               $this->CI->lang->load('er','arabic');
				       $this->CI->session->set_userdata('style_loc','style.css');
				       $this->CI->session->set_userdata('bootstrap','bootstrap.css');
					   $this->CI->session->set_userdata('css_cpanel','css');
				       $this->CI->session->set_userdata('js_cpanel','js');

				 }
				else
			{
				$this->CI->lang->load('am','turky');
		         //print_r($this->CI->session->userdata('language'));die;

				$this->CI->session->set_userdata('style_loc','style_ltr.css');
				$this->CI->session->set_userdata('bootstrap','bootstrap_ltr.css');
				$this->CI->session->set_userdata('css_cpanel','css_ltr');
				$this->CI->session->set_userdata('js_cpanel','js_ltr');
			}
		 }
		public function check_user_permission($PageUrl)
		{
		$setData = array("permlevel"=>$this->level,"permAdd"=>$this->Add,"permEdit"=>$this->Edit,"permDelete"=>$this->Delete,"permVeiw"=>$this->Veiw);
		$this->CI->session->set_userdata($setData);		
		}
}///// END OF LIBRARY 
?>