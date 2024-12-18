<?php if(!defined('BASEPATH')) exit('No direct script access allowed');ini_set('default_charset','UTF-8');
class MyClass{
   private static $Style      = 'style_ltr.css';
   private static $bootstrap  = 'bootstrap_ltr.css';
   private static $LangType   = 'english';
   private static $css_cpanel = 'css_ltr';
   private static $js_cpanel  = 'js_ltr';
   private static $YearID     = 0;
   private static $Year     ;
   private static $Semester ;
   private        $CI ;
   
   
  function __construct()
   {
	    $this->CI =& get_instance();
		$this->CI->load->model(array('config/config_system_model'));
		if ($this->CI->session->userdata('language') == 'arabic' ) {
		    self::$LangType = $this->CI->session->userdata('language');
		}elseif($this->CI->session->userdata('language') == 'english'){
		    self::$LangType = $this->CI->session->userdata('language');
		}
   } 
   public function Myfunction()
   { 
      // print_r(self::$LangType);die;
	   if ($this->CI->session->userdata('language')) {
		   $this->CI->lang->load('am',self::$LangType);
		   $this->CI->lang->load('br',self::$LangType);
		   $this->CI->lang->load('er',self::$LangType);
		   $this->CI->lang->load('config',self::$LangType);
		   $this->CI->config->set_item('language',self::$LangType);
	      if(self::$LangType == 'english')
		   {
			   self::$Style     = 'style_ltr.css';
			   self::$bootstrap = 'bootstrap_ltr.css';
			   self::$css_cpanel= 'css_ltr';
			   self::$js_cpanel = 'js_ltr';
		   }else if(self::$LangType == 'arabic')
		   {
			   self::$Style     = 'style.css';
			   self::$bootstrap = 'bootstrap.css';
			   self::$css_cpanel= 'css';
			   self::$js_cpanel = 'js';
		   }
			}else{
				    $this->CI->session->set_userdata('language',self::$LangType )  ;
				    $this->CI->session->set_userdata('style_loc',self::$Style );
				    $this->CI->session->set_userdata('bootstrap',self::$bootstrap );
				    $this->CI->session->set_userdata('css_cpanel',self::$css_cpanel );
				    $this->CI->session->set_userdata('js_cpanel',self::$js_cpanel );
					$this->CI->lang->load('am',self::$LangType);
				    $this->CI->lang->load('br',self::$LangType);
				    $this->CI->lang->load('er',self::$LangType);
				    $this->CI->lang->load('config',self::$LangType);
					$this->CI->config->set_item('language',self::$LangType);
				}
			$GetData = $this->CI->config_system_model->get_year_hook() ;
			self::$Semester = $this->CI->config_system_model->get_semester(self::$LangType);
			if($GetData)
			{
			  self::$YearID = $GetData['ID'];
			  self::$Year = $GetData['YearFrom'].'-'.$GetData['YearTo'];
			}else{ self::$YearID = 0 ;}
			$DataArraySession = array
			('YearID'=>self::$YearID ,'Year'=>self::$Year ,'Semester'=>self::$Semester);
			$this->CI->session->set_userdata($DataArraySession)  ;
   }	
}//////END CLASS 