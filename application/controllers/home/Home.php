<?php if(!defined('BASEPATH'))exit('No direct script access allowed');

class Home extends CI_Controller{

	private $data = array() ;

	function __construct()

    {
	   	parent::__construct();
	   	$this->load->model(array('home/home_model'));
		$this->load->helper('language');
	   	$this->data['Lang'] = $this->session->userdata('language');
	   	//$this->load->library('google');
	   	$this->load->helper('url');
	    if($this->data['Lang'])
	    {$this->lang->load('am',$this->session->userdata('language'));$this->lang->load('config',$this->session->userdata('language'));}
	    else{$this->lang->load('am','arabic');$this->lang->load('config','arabic');}
	    
	   
	    
    }
    
  //////////////////////////////////
   ///////////////////
    public function set_lang()

    { /////set langauge

        $Lang = (int)$this->uri->segment(5);

        if ($Lang == 1 || $Lang == 2) {

            switch ($Lang) {

                case 1:

                    $this->session->set_userdata('language', 'english');

                    break;


                case 2:

                    $this->session->set_userdata('language', 'arabic');

                    break;

                default:

                    $this->session->set_userdata('language', 'english');
            }
        }
        $referer = $_SERVER['HTTP_REFERER'];
        redirect($referer, 'refresh');
        //redirect($this->session->userdata('previous_page'),'refresh');

    }
  	public function intro()
	{
		
		$this->load->view('home_new/view_intro');
	}

	public function Reg_exam()
	{
     $Data['exam_details']    = $this->home_model->get_exam_reg(); 
    // print_r($this->db->last_query() );
	 $this->load->home_template('answer_exam_list',$Data);
	}
	
	

}