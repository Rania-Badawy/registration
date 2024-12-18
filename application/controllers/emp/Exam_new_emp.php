<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Exam_New_Emp extends CI_Controller {

    	private $data = array() ;
		
    function __construct()
    {
        parent::__construct();     
	   $this->load->helper(array('form', 'url'));
	   $this->load->model(array('emp/exam_new_emp_model','emp/subject_emp_model','emp/config_model','emp/question_new_model', 'emp/lessons_model', 'home/emp_application_model'));
	   $this->load->library('get_data_emp');
	   $this->data['UID']            = $this->session->userdata('id');
	   $this->data['YearID']         = $this->session->userdata('YearID');
	   $this->data['Year']           = $this->session->userdata('Year');
	   $this->data['Semester']       = $this->session->userdata('Semester');
	   $this->data['Lang']           = $this->session->userdata('language');
        
    }
	public function index()
	{
		     $Data['exam_details']    = $this->exam_new_emp_model->get_exam((string)$this->data['Lang']);
            //print_r($this->db->last_query());		
                    // $Data['get_row_level_subject_emp']  = $this->  exam_new_emp_model->get_row_level_subject_emp();	
			//  $Data['exams_students']  = $this->  exam_new_emp_model->get_exams_students();	
			$this->load->emp_template('exam_emp/all_exam',$Data);
	}
	 
	public function get_result_students()
	{ 
		$Data['test_id'] = (int)$this->uri->segment(4);
		$this->data['exam_details_edit']  = $this->  exam_new_emp_model->get_specific_exam($Data['test_id']  ,(string)$this->data['Lang']);
		$this->data['exams_students']  = $this->  exam_new_emp_model->get_result_students($Data['test_id']);	

		$this->load->emp_template('exam_emp/result_students',$this->data);
	}
	public function set_subjectEmpIDSession()
	{
		$DataSession = array('subjectEmpIDSession'=> '-1');
		$this->session->set_userdata($DataSession);	
		redirect('/emp/exam_new_emp', 'refresh');
	}
	public function report_father()
	{
				 $Data['exams_students']  = $this->  exam_new_emp_model->get_exams_students_father();		
				 $this->load->father_template('report_father',$Data);
	}
	public function create_exam()
	{
	   // print_r(get_class_per());exit();
		$Data['create_msg'] ="";
		  $idContact =(int)$this->session->userdata('id');
         $data1=$this->db->query("SELECT SubjectID  FROM `supervisor` WHERE `EmpID`='".$idContact."'AND `SectorId`=1")->row();
          $Subject1 = $data1->SubjectID;
          $Subject1 = explode(',',$Subject1) ; 
         $Data['SubjectI']=$Subject1;
	    $Data['subjectEmp_details'] = $this->subject_emp_model->get_Subjects_emp();
	    $Data['all_subject'] =  $this->emp_application_model->all_subject();
	   
 	    $Data['SubjectIDSubjectID']  =$this->session->userdata('SubjectID'); 
	    $Data['lessonID']   = $this->session->userdata('lessonID');
	    $Data['SubjectID']   = $this->session->userdata('SubjectID');
	    $Data['RowLevelID']   = $this->session->userdata('RowLevelID');  
		$Data['Type_question']      = $this->question_new_model->get_Type_question(); 
 		if($Data['all_subject']  )
		{ 
		   $this->load->emp_template('exam_emp/exam',$Data);
		}
		else{
		echo $this->session->userdata('subjectEmpIDSession');
		   $Data['create_msg'] =  lang('no_subject_insert') ;
		   $this->load->emp_template('exam_emp/exam',$Data);
		   }
	}
	public function create_exam_fast()
	{
		$Data['create_msg'] =""; 
	    $Data['subjectEmp_details'] = $this->subject_emp_model->get_Subjects_emp();	
		$Data['GetSemester']     = $this->config_model->get_semester((string)$this->data['Lang']);
		if( $Data['subjectEmp_details'])
		{
		   $this->load->emp_template('exam_emp/exam_fast',$Data);
		}
		else{
		echo $this->session->userdata('subjectEmpIDSession');
		   $Data['create_msg'] =  lang('no_subject_insert') ;
		   $this->load->emp_template('exam_emp/exam_fast',$Data);
		   }
	}
	public function add_exam()
	{	
		if(IS_AJAX&&isset($_POST))
		{	 
	 	$Data['subjectEmp_details'] = $this->subject_emp_model->get_Subjects_emp();			
 		$Data['GetSemester']     = $this->config_model->get_semester((string)$this->data['Lang']);
	
	    $this->form_validation->set_rules('slct_subject', 'lang:Subject_Name','required|is_natural_no_zero');
	    //$this->form_validation->set_rules('slct_class', 'lang:br_class','required');
 	    $this->form_validation->set_rules('txt_exam', 'lang:Exam_Name','required|min_length[4]');		
	    $this->form_validation->set_rules('txt_time', 'lang:Exam_Time','min_length[1]');		
		if ($this->form_validation->run() === false)
		{ 
 					$data_ajax['slct_subject']  = form_error('slct_subject');
 					$data_ajax['txt_exam']      = form_error('txt_exam');
					$data_ajax['txt_time']      = form_error('txt_time');
					$data_ajax['slct_class']      = form_error('slct_class');
					$data_ajax['msg']           = '';
					$data_ajax['stp']           = 0;
					$this->output->set_content_type('application/json')->set_output(json_encode($data_ajax));
		}else
		{
			$data['slct_lesson']            = $this->input->post('slct_lesson');
 			$data['slct_subject']       = $this->input->post('slct_subject');
 			$data['txt_exam']           = $this->input->post('txt_exam');
			$data['txt_time']           = $this->input->post('txt_time') * 60;
			$data['txt_description']    = $this->input->post('txt_description');
			$data['Date_from']          = $this->input->post('Date_from');
			$data['Date_to']            = $this->input->post('Date_to');
			$data['num_student']        = (int)$this->input->post('num_student');
			if(!validateDate($data['Date_from'])){
              $data['Date_from'] =  date('Y-m-d h:i');
            }
            if(!validateDate($data['Date_to'])){
              $oneYearOn = date('Y-m-d h:i',strtotime(date("Y-m-d h:i", mktime()) . " + 365 day"));
              $data['Date_to'] =  $oneYearOn;
            }
			$Data['add_exam_ID']        = $this->exam_new_emp_model->add_exam($data);
			if($Data['add_exam_ID']!=false)
				{
					
					$data_ajax['add_exam_ID']           = $Data['add_exam_ID'];
					$data_ajax['stp']           = 1;
					$this->output->set_content_type('application/json')->set_output(json_encode($data_ajax));
				  }else{
					
					$data_ajax['msg']           = $this->db->last_query();
					$data_ajax['stp']           = 2;
					$this->output->set_content_type('application/json')->set_output(json_encode($data_ajax));
					}
		}
		}
	}
	public function add_exam_fast()
	{	 
	    $Data['subjectEmp_details'] = $this->subject_emp_model->get_Subjects_emp();			
		$Data['Form_Action']     = 'exam/add_exam';	
		$Data['GetSemester']     = $this->config_model->get_semester((string)$this->data['Lang']);
	
	    $this->form_validation->set_rules('slct_subject', 'lang:Subject_Name','is_natural_no_zero');
 	    $this->form_validation->set_rules('txt_exam', 'lang:Exam_Name','required|min_length[4]');		
	    $this->form_validation->set_rules('txt_time', 'lang:Exam_Time','min_length[1]');
	    $this->form_validation->set_rules('num_question', 'lang:num_question','required|min_length[1]|integer|less_than[15]');
	    $this->form_validation->set_rules('difficulty_test', 'lang:difficulty_test','required|is_natural_no_zero');		
		if ($this->form_validation->run() === false)
		{ 
			//$this->create_exam_fast() ;
		}else
		{
 			$data['slct_subject']       = $this->input->post('slct_subject');
			$data['txt_exam']           = $this->input->post('txt_exam');
			$data['txt_time']           = $this->input->post('txt_time');
			$data['txt_description']    = $this->input->post('txt_description');
			$data['Date_from']          = $this->input->post('Date_from');
			$data['Date_to']            = $this->input->post('Date_to');
			$data['num_student']        = (int)$this->input->post('num_student');
			$data['num_question']        = (int)$this->input->post('num_question');
			$data['difficulty_test']        = (int)$this->input->post('difficulty_test'); 
			$Data['add_exam_ID']        = $this->  exam_new_emp_model->add_exam_fast($data);
			if($Data['add_exam_ID']!=false)
				{echo 'cc';
					//$this->load->emp_template('exam_emp/exam',$Data);
				  }else{echo 'ss';
			//		$this->load->emp_template('exam_emp/exam',$Data);
					}
		}
	}
	//sees_edit

	public function sees_edit()
	{
		(int)$Data['id'] = (int)$this->uri->segment(4);
		
		if(isset($Data['id'])&&$Data['id']!=0 )
		{
			$this->session->set_userdata('ExamID_Edit',(int)$Data['id'])  ;
			redirect('/emp/exam_new/set_exam', 'refresh');
		}else{
			redirect('/emp/exam_new_emp', 'refresh');
			}
	}
//set_exam
	public function set_exam_edit()
	{
		
 		$Data['id']                 = (int)$this->uri->segment(4);	
		 
		$Data['subjectEmp_details'] = $this->subject_emp_model->get_Subjects_emp();		
		$Data['exam_details_edit']  = $this->  exam_new_emp_model->get_specific_exam($Data['id']   ,(string)$this->data['Lang']);
		
		if($Data['exam_details_edit'] !=0){
		    foreach($Data['exam_details_edit']  as $key=>$row){
		       if($key==0){
		        
        	    $Data['SubjectID']   = $row->SubjectID_subject;
        	    $Data['RowLevelID']   =$row->RowLevelID;
		       }
		    
		}}else{
		    
		    $Data['SubjectID']   = 0;
	        $Data['RowLevelID']   =0;
		}  
		$Data['lessonsTitles'] = $this->lessons_model->get_lessons_prep($Data);
		
		
		
		$Data['GetSemester']        = $this->config_model->get_semester((string)$this->data['Lang']);
		$Data['Type_question']      = $this->question_new_model->get_Type_question();
		$Data['question']           = $this->question_new_model->get_question_exam($Data['id']);
	
 		if($this->exam_new_emp_model->get_specific_exam($Data['id']   ,(string)$this->data['Lang']))
			{
			  $this->load->emp_template('exam_emp/set_exam_edit',$Data);
			 }
			 else{echo 'error';}
				 
	}
//set_exam
	public function frame_exam()
	{
		
 		$Data['id']                 = (int)$this->uri->segment(4);
 		 
		 $Data['subjectEmp_details'] = $this->subject_emp_model->get_Subjects_emp();		
		$Data['exam_details_edit']  = $this->  exam_new_emp_model->get_specific_exam($Data['id']   ,(string)$this->data['Lang']);
		$Data['GetSemester']        = $this->config_model->get_semester((string)$this->data['Lang']);
		$Data['Type_question']      = $this->question_new_model->get_Type_question();
		$Data['question']           = $this->question_new_model->get_question_exam($Data['id']);
 		if($this->  exam_new_emp_model->get_specific_exam($Data['id']   ,(string)$this->data['Lang']))
			{
			  $this->load->emp_template('exam_emp/frame_exam',$Data);
			 }
			 else{echo 'error';}
				 
	}
//set_exam
	public function frame_exam_admin()
	{
		
 		$Data['id']                 = (int)$this->uri->segment(4);
 		 
 		$Data['exam_details_edit']  = $this->  exam_new_emp_model->get_specific_exam_admin($Data['id']   ,(string)$this->data['Lang']);
 		$Data['Type_question']      = $this->question_new_model->get_Type_question();
		$Data['question']           = $this->question_new_model->get_question_exam($Data['id']);
 		if($this->  exam_new_emp_model->get_specific_exam_admin($Data['id']   ,(string)$this->data['Lang']))
			{
			  $this->load->admin_template('../emp/exam_emp/frame_exam_admin',$Data);
			 }
			 else{echo 'error';}
				 
	}
//set_exam
	public function set_exam()
	{ 
 		$Data['id']                 = (int)$this->input->post('txt_test_ID'); 
     	$Data['subjectEmp_details'] = $this->subject_emp_model->get_Subjects_emp();		
		$Data['exam_details_edit']  = $this->  exam_new_emp_model->get_specific_exam($Data['id']   ,(string)$this->data['Lang']);
		
			if($Data['exam_details_edit'] !=0){
		    foreach($Data['exam_details_edit']  as $key=>$row){
		       if($key==0){
		        
        	    $Data['SubjectID']   = $row->SubjectID_subject;
        	    $Data['RowLevelID']   =$row->RowLevelID;
		       }
		    
		}}else{
		    
		    $Data['SubjectID']   = 0;
	        $Data['RowLevelID']   =0;
		}  
		$Data['lessonsTitles'] = $this->lessons_model->get_lessons_prep($Data); 
		$Data['GetSemester']        = $this->config_model->get_semester((string)$this->data['Lang']); 
 		if($this->  exam_new_emp_model->get_specific_exam($Data['id']   ,(string)$this->data['Lang']))
			{
			  $this->load->view('emp/exam_emp/edit_exam',$Data);
			 }
			 else{echo 'error';}
				 
	}
//show_exam
	public function show_exam()
	{
		
	   $Data['id']                 = (int)$this->input->post('add_exam_ID');
	   $Data['add_exam_ID']        = (int)$this->input->post('add_exam_ID');		
	   $Data['subjectEmp_details']  = $this->subject_emp_model->get_Subjects_emp();		 
	   $Data['exam_details_edit']   = $this->  exam_new_emp_model->get_specific_exam($Data['id'] ,(string)$this->data['Lang']);  
  		if($Data['exam_details_edit'] )
			{ 
			  $this->load->view('emp/exam_emp/show_exam',$Data);
			 }
			 else{echo 'error';}
				 
	}
//show_exam
	public function show_exam_admin()
	{
		
	   $Data['id']                 = (int)$this->input->post('add_exam_ID');
	   $Data['add_exam_ID']        = (int)$this->input->post('add_exam_ID');		
 	   $Data['exam_details_edit']   = $this->  exam_new_emp_model->get_specific_exam_admin($Data['id'] ,(string)$this->data['Lang']);  
  		if($Data['exam_details_edit'] )
			{ 
			  $this->load->view('emp/exam_emp/show_exam',$Data);
			 }
			 else{echo 'error';}
				 
	}
//edit_exam
	public function edit_exam()
	{
		
	
		if(IS_AJAX&&isset($_POST))
		{	
		 
		 $Data['subjectEmp_details'] = $this->subject_emp_model->get_Subjects_emp();			
 		$Data['GetSemester']     = $this->config_model->get_semester((string)$this->data['Lang']);
	// $this->form_validation->set_rules('slct_class', 'lang:br_class','required');
	    $this->form_validation->set_rules('slct_subject', 'lang:Subject_Name','is_natural_no_zero');
 	    $this->form_validation->set_rules('txt_exam', 'lang:Exam_Name','required|min_length[4]');		
	    $this->form_validation->set_rules('txt_time', 'lang:Exam_Time','min_length[1]');		
		if ($this->form_validation->run() === false)
		{
					$data_ajax['msg']           = '';
					$data_ajax['stp']           = 0;
					$this->output->set_content_type('application/json')->set_output(json_encode($data_ajax));
			
		}else
		{
 			$data['slct_subject']       = $this->input->post('slct_subject');
			$data['txt_exam']           = $this->input->post('txt_exam');
			$data['txt_time']           = $this->input->post('txt_time') * 60;
 			$data['txt_description']    = $this->input->post('txt_description');
			$data['Date_from']          = $this->input->post('Date_from');
			$data['Date_to']            = $this->input->post('Date_to');
			$data['txt_test_ID']    = $this->input->post('txt_test_ID');
 			if($this->  exam_new_emp_model->edit_exam($data))
			{
				
					
					$data_ajax['add_exam_ID']           = $data['txt_test_ID'];
					$data_ajax['stp']           = 1;
					$this->output->set_content_type('application/json')->set_output(json_encode($data_ajax));
			}else{ 
					$data_ajax['msg']           = '';
					$data_ajax['stp']           = 2;
					$this->output->set_content_type('application/json')->set_output(json_encode($data_ajax));
					}
		}
		}
	}
//del_exam
	public function del_exam()
	{
		if($this->uri->segment(4) === FALSE){redirect('/emp/exam_new_emp', 'location');}
			else
			{
				$ID = $this->uri->segment(4) ;
				$examID = array('ID'=>$ID);
	
				if($this->  exam_new_emp_model->delete_exam($examID))
				{
					
					redirect('/emp/exam_new_emp', 'location');
				}
				else
				{
					$Message = lang('am_error');

					$this->session->set_flashdata('msg',$Message);
					
					redirect('/emp/exam_new_emp', 'location');
				}
			}
	}
//del_exam_admin
	public function del_exam_admin()
	{
		if($this->uri->segment(4) === FALSE){redirect('/emp/exam_new_emp', 'location');}
			else
			{
				$ID = $this->uri->segment(4) ;
				$examID = array('ID'=>$ID);
	
				if($this->  exam_new_emp_model->delete_exam($examID))
				{
					
				 	redirect('/admin/report_emp/report_emp_add_test', 'location');
				}
				else
				{
					$Message = lang('am_error');

					$this->session->set_flashdata('msg',$Message);
					
				 	redirect('/admin/report_emp/report_emp_add_test', 'location');
				} 
			}
	}
//add_upload_degree
	public function add_upload_degree()
	{
		 $t_s_ID = $this->input->post('t_s_ID'); /* foreach($t_s_ID as $key =>$row){echo $row;}*/
		 $s_Degree = $this->input->post('s_degree'); 
		 $t_Degree = $this->input->post('total_degree');
		 $this->load->model('answer_exam_model');
		 $this->answer_exam_model->insert_s_d_upload($s_Degree,$t_Degree,$t_s_ID);
	}
public function get_classes()
	{
                        $data['config_emp'] = $this->input->post('config_emp');
 			$this->load->view('emp/exam_emp/add_class',$data);
	}

}

