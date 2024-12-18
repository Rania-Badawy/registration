<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Report extends CI_Controller {
    function __construct()
    {
        parent::__construct();     
		$this->load->model(array('emp/report_model','admin/report_statistical_model','admin/setting_model'));
		$this->load->library('get_data_emp');
	    $this->data['UID']            = $this->session->userdata('id');
	    $this->data['YearID']         = $this->session->userdata('YearID');
	    $this->data['Year']           = $this->session->userdata('Year');
	    $this->data['Semester']       = $this->session->userdata('Semester');
	    $this->data['Lang']           = $this->session->userdata('language');
		$get_api_setting              = $this->setting_model->get_api_setting();
	    $this->ApiDbname              = $get_api_setting[0]->{'ApiDbname'};
		
    }
    //////////////////////////////
	public function index()
	{
	    $Data['Semesters']     = $this->setting_model->get_semesters();
	
		$Data['SemesterID']    = $this->uri->segment(4);
		if(!$Data['SemesterID']){
		    $Data['SemesterID'] =  $this->setting_model->get_semester();
		}
	    $Data['GetReport'] = $this->report_model->get_report_eval($this->data['UID'],$this->data['YearID'], $this->data['Lang'] ,$Data['SemesterID']);
		$this->load->emp_template('view_Eval_report',$Data);
	}
	
	public function get_report_eval_detials()

	{
      
       $ContactEmpID  = $this->uri->segment(4); 
       $datee  = $this->uri->segment(5);

	   $this->data['GetReport']  = $this->report_model->get_report_eval1($this->data['YearID'] ,$ContactEmpID,$datee );

		$this->load->emp_template('view_report_eval_details',$this->data);

	}
	////////////////////////////
	public function exam_report()
	{
        $UID                             = $this->session->userdata('id');
		$this->data['show']              = $this->uri->segment(4);
		$this->data['level_id']        = $this->input->post("level_id"); 
		$this->data['from']              = $this->input->post("DayDateFrom"); 
		$this->data['to']                = $this->input->post("DayDateTo"); 
		$this->data['subjectID']         = $this->input->post("subject_id"); 
		//print_r($this->data['subjectID'] ); die;
		$this->data['all_row_level']     = $this->report_model->get_emp_row_level($this->data['Lang'],$UID);
		$this->data['all_subject']       = $this->report_model->get_emp_subjects($lang,$UID);
		if($this->data['show'] != "NULL"){
		$this->data['exam_report']       = $this->report_model->exam_report($this->data['level_id'] , $this->data['from'] , $this->data['to'],$this->data['subjectID'] ) ;

        $this->data['homework_report']   = $this->report_model->homework_report($this->data['level_id'] , $this->data['from'] , $this->data['to'],$this->data['subjectID']) ;
		//print_r($this->db->last_query()); die; 
		    
		}
		
	
	    $this->load->emp_template('exam_report',$this->data);
	}
	///////////////////////////
	public function exam_report_detils()
	{
        $UID                             = $this->session->userdata('id');
		$this->data['show']              = $this->uri->segment(4);
		$this->data['test']              = $this->uri->segment(5);
		$this->data['from']              = $this->uri->segment(6);
		$this->data['to']                = $this->uri->segment(7);
		$this->data['RowLevelID']        = $this->uri->segment(8);
		$this->data['subjectID']         = $this->uri->segment(9);
		if($this->data['show'] != "NULL"){
		
		$this->data['GetData']  = $this->report_statistical_model->exam_report_detils($this->data) ;
//print_r($this->data['GetData']); die;  
		}	
	
	    $this->load->emp_template('exam_report_details',$this->data);
	}
	////////////////////////////
	public function report_student($LevelID = 0 , $RowLevelID = 0  , $ClassID = 0)
    
	{
    	$this->data['LevelID']     = $this->uri->segment(4); 
		$this->data['RowLevelID']  = $this->uri->segment(5);
		$this->data['ClassID']     = $this->uri->segment(6);
		$this->data['GetClass']    = $this->report_model->get_class_school_active($this->data['Lang']);
		$this->data['GetStudent']  = $this->report_model->get_student_emp($this->data['Lang'] , $LevelID ,$RowLevelID , $ClassID );

		$this->load->emp_template('view_report_student',$this->data);

	}
	/////////////////////////////
		public function Supervisors_Report()
	{
	     $Data['classID']=0;
	     $Data['subjectID']=0;
	     $Data['LevelID']=$LevelID=$this->input->post("level");
	     $Data['RowLevelID']= $RowLevelID=$this->input->post("RowLevel");
	     $Data['classID']=$classID=$this->input->post("Classgg");
	     $Data['subjectID']= $subjectID=$this->input->post("subject");
	     $Data['dateFrom'] = $dateFrom=$this->input->post("Date_from");
	     $Data['dateTo'] =$dateTo=$this->input->post("Date_to");
	     $SchoolID= $this->session->userdata('SchoolID');
         if($LevelID == 0 ){ $LevelID = 'NULL'; }else{ $LevelID = (int)$LevelID;  }
		 if($RowLevelID == 0 ){ $RowLevelID = 'NULL'; }else{ $RowLevelID = (int)$RowLevelID;  }
		 if($classID == 0 ){ $classID = 'NULL'; }else{ $classID = (int)$classID;  }
		 if($subjectID == 0 ){ $subjectID = 'NULL'; }else{ $subjectID = (int)$subjectID;  }
		 if(preg_match('/,/', $SchoolID)){
	          $school_array=$this->db->query("select ID from school_details where ID IN(".$SchoolID.")")->result();
	          $SchoolID = $school_array[0]->ID;
		 }
         $query    = $this->db->query("CALL Usp_Reporter_Select_Rpt(".$LevelID.",".$RowLevelID.",".$classID.",".$subjectID.",".$SchoolID.",'".$dateFrom."','".$dateTo."')");
         
         $res      = $query->result();

         mysqli_next_result( $this->db->conn_id );
         
         $Data['GetReport'] = $res;
         
          $bussines = [];
         foreach ($res as $number)
         {
            $emp = get_emp_select_in();
           $PerType =explode(',',$emp ); 
            if( in_array($number->ReporterId,$PerType))
            {
		     $bussines[] = $number;
	        }
         }
         $type=$this->session->userdata('type');
      if($type=='U')
      {
	    $Data['report_res'] =  $res; 
      }
      else{
          $Data['report_res'] =  $bussines;  
         }
	 	 
	 	 $this->load->admin_template('view_Supervisors_Report',$Data);
		
		
	}
	////////////////////////////
	public function absent_report($LevelID = 0 , $RowLevelID = 0  , $ClassID = 0)
    
	{
	    $Data['DateFrom']    = $this->input->post("DateFrom"); 
	    $Data['DateTo']      = $this->input->post("DateTo"); 
	    $Data['Class']       = explode("/",$this->input->post("Class"));
		$Data['RowLevelID']  = $Data['Class']['0'];
		$Data['ClassID']     = $Data['Class']['1'];
		$Data['GetClass']    = $this->report_model->get_class_school_active($Data['Lang']);
		$Data['GetStudent']  = $this->report_model->get_student_emp($Data['Lang'] , $LevelID ,$Data['RowLevelID'] , $Data['ClassID'] );

		$this->load->emp_template('view_absent_report',$Data);

	}
	////////////////////////////
	public function absent_report_details()
    
	{
    	$Data['type']                 = $this->uri->segment(4);
	    $Data['StudentID']            = $this->uri->segment(5);
		$Data['DateFrom']             = $this->uri->segment(6);
		$Data['DateTo']               = $this->uri->segment(7);
		$Data['student_absent']       = $this->report_model->get_absent_details($Data);

		$this->load->emp_template('view_absent_details',$Data);

	}
	////////////////////////////
	public function emp_rate_details()
	{
		$Data['all_rate']           = $this->report_model->get_all_rate($Data);

		$Data['rate_details']       = $this->report_model->get_rate_details($Data);

		$this->load->emp_template('view_emp_rate_details',$Data);

	}
}// End Class