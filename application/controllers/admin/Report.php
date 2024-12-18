<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Report extends MY_Admin_Base_Controller{
	private $data = array() ;
	function __construct()
    {
	  parent::__construct();
	   $this->load->model(array('admin/Report_model','admin/setting_model'));
	   $this->data['UID']            = $this->session->userdata('id');
	   $this->data['Semester']       = $this->session->userdata('Semester');
	   $this->data['Lang']           = $this->session->userdata('language');
	   $get_api_setting              = $this->setting_model->get_api_setting();
       $this->data['ApiDbname']      = $get_api_setting[0]->{'ApiDbname'};
    }
    /////////////////////////
     public function user_login($Type = NULL , $LevelID = 0 , $RowLevelID = 0  , $ClassID = 0 )
	{
	    
		$this->data['LevelID']     = $LevelID    =$this->input->post('level') ; 
		$this->data['RowLevelID']  = $RowLevelID =$this->input->post('RowLevel') ;
		$this->data['ClassID']     = $Class_ID   =$this->input->post('Class') ;
		$this->data['Contact']     = "" ; 
		$this->data['Type']        = $Type = (string)$this->input->post('SelectUser');
		$this->data['datefrom']    = $datefrom  = $this->input->post('datefrom');
		$this->data['dateto']      = $dateto    = $this->input->post('dateto');
		if($Type == 'E' )
		{
			$this->data['get_emp_per']  = get_emp_select_in() ;
		  	$this->data['Contact']      = $this->db->query("SELECT DISTINCT contact.ID , contact.Name , contact.Mobile , contact.Mail FROM sessionToken
		  	INNER JOIN  contact ON sessionToken.UserID = contact.ID WHERE contact.Type = 'E' AND contact.SchoolID = '".$this->session->userdata('SchoolID')."'
		  	AND DATE(Date) between '$datefrom' AND '$dateto' and contact.Isactive=1 ")->result();
		}
		else if($Type == 'F'||$Type == 'S'){
			$Student  = get_student_select_in() ;
			   	$this->data['Contact']  = $this->Report_model->get_student_father_login( $this->data['Lang'] , $LevelID ,$RowLevelID , $Class_ID ,$datefrom, $dateto ,$Student);

			}
			
		$this->load->admin_template('view_user_login',$this->data);
	}
		/////////////////////////////
     public function evaluationSupervisor()
	{
	    
		$this->data['Date_from']      = $this->input->post('Date_from') ; 
		$this->data['Date_to']        = $this->input->post('Date_to') ;
		$this->data['supervisors']    = $this->Report_model->evaluationSupervisor($this->data);

		$this->load->admin_template('view_evaluationSupervisor',$this->data);
	}
}