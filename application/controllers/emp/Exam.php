<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exam extends CI_Controller {

    	private $data = array() ;
		
    function __construct()
    {
        parent::__construct();     
	   $this->load->helper(array('form', 'url'));
	   $this->load->model(array('emp/exam_model','emp/subject_model','emp/config_model','emp/answer_exam_model'));
	   $this->load->library('get_data_emp');
	   $this->data['UID']            = $this->session->userdata('id');
	   $this->data['YearID']         = $this->session->userdata('YearID');
	   $this->data['Year']           = $this->session->userdata('Year');
	   $this->data['Semester']       = $this->session->userdata('Semester');
	   $this->data['Lang']           = $this->session->userdata('language');
        
    }
	public function index()
	{
		     $Data['exam_details']    = $this->exam_model->get_exam((string)$this->data['Lang']);	
			 $Data['exams_students']  = $this->exam_model->get_exams_students();		
			 $this->load->emp_template('all_exam',$Data);
	}
	public function set_subjectEmpIDSession()
	{
		$DataSession = array('subjectEmpIDSession'=> '-1');
		$this->session->set_userdata($DataSession);	
		redirect('/emp/exam', 'refresh');
	}
	public function report_father()
	{
				 $Data['exams_students']  = $this->exam_model->get_exams_students_father();		
				 $this->load->father_template('report_father',$Data);
	}
	public function report_father_header()
	{
	$studentID = $this->uri->segment(4) ;
				 $Data['exams_students']  = $this->exam_model->get_exams_students_father_header($studentID);		
				 $this->load->father_template('report_father',$Data);
	}
	public function create_exam()
	{   
		$Data['create_msg'] ="";
		$Data['subjectEmp_details'] = $this->subject_model->get_Subjects_emp();	
		$Data['GetSemester']     = $this->config_model->get_semester((string)$this->data['Lang']);
		if($this->subject_model->get_Subjects_emp())
		{
		   $this->load->emp_template('exam',$Data);
		}
		else{
		echo $this->session->userdata('subjectEmpIDSession');
		   $Data['create_msg'] =  lang('no_subject_insert') ;
		   $this->load->emp_template('exam',$Data);
		   }
	}
	public function create_exam_fast()
	{
		$Data['create_msg'] ="";
		$Data['subjectEmp_details'] = $this->subject_model->get_Subjects_emp();	
		$Data['GetSemester']     = $this->config_model->get_semester((string)$this->data['Lang']);
		if($this->subject_model->get_Subjects_emp())
		{
		   $this->load->emp_template('exam_fast',$Data);
		}
		else{
		echo $this->session->userdata('subjectEmpIDSession');
		   $Data['create_msg'] =  lang('no_subject_insert') ;
		   $this->load->emp_template('exam_fast',$Data);
		   }
	}
	public function add_exam()
	{	
		$Data['subjectEmp_details'] = $this->subject_model->get_Subjects_emp();			
		$Data['Form_Action']     = 'exam/add_exam';	
		$Data['GetSemester']     = $this->config_model->get_semester((string)$this->data['Lang']);
	
	    $this->form_validation->set_rules('slct_subject', 'lang:Subject_Name','is_natural_no_zero');
		$this->form_validation->set_rules('slct_Semester', 'lang:Semester','is_natural_no_zero');		
	    $this->form_validation->set_rules('txt_exam', 'lang:Exam_Name','required|min_length[4]');		
	    $this->form_validation->set_rules('txt_time', 'lang:Exam_Time','min_length[1]');		
		if ($this->form_validation->run() === false)
		{
			$this->create_exam() ;
		}else
		{
			$data['slct_Semester']      = $this->input->post('slct_Semester');
			$data['slct_subject']       = $this->input->post('slct_subject');
			$data['txt_exam']           = $this->input->post('txt_exam');
			$data['txt_time']           = $this->input->post('txt_time');
			$data['txt_description']    = $this->input->post('txt_description');
			$data['Date_from']          = $this->input->post('Date_from');
			$data['Date_to']            = $this->input->post('Date_to');
			$data['num_student']        = (int)$this->input->post('num_student');
			$Data['add_exam_ID']        = $this->exam_model ->add_exam($data);
			if($Data['add_exam_ID']!=false)
				{
					$this->load->emp_template('ask_question',$Data);
				  }else{
					$this->load->emp_template('error');	
					}
		}
	}
	public function add_exam_fast()
	{	
		$Data['subjectEmp_details'] = $this->subject_model->get_Subjects_emp();			
		$Data['Form_Action']     = 'exam/add_exam';	
		$Data['GetSemester']     = $this->config_model->get_semester((string)$this->data['Lang']);
	
	    $this->form_validation->set_rules('slct_subject', 'lang:Subject_Name','is_natural_no_zero');
		$this->form_validation->set_rules('slct_Semester', 'lang:Semester','is_natural_no_zero');		
	    $this->form_validation->set_rules('txt_exam', 'lang:Exam_Name','required|min_length[4]');		
	    $this->form_validation->set_rules('txt_time', 'lang:Exam_Time','min_length[1]');
	    $this->form_validation->set_rules('num_question', 'lang:num_question','required|min_length[1]|integer|less_than[15]');
	    $this->form_validation->set_rules('difficulty_test', 'lang:difficulty_test','required|is_natural_no_zero');		
		if ($this->form_validation->run() === false)
		{echo 'MMM';
			//$this->create_exam_fast() ;
		}else
		{
			$data['slct_Semester']      = $this->input->post('slct_Semester');
			$data['slct_subject']       = $this->input->post('slct_subject');
			$data['txt_exam']           = $this->input->post('txt_exam');
			$data['txt_time']           = $this->input->post('txt_time');
			$data['txt_description']    = $this->input->post('txt_description');
			$data['Date_from']          = $this->input->post('Date_from');
			$data['Date_to']            = $this->input->post('Date_to');
			$data['num_student']        = (int)$this->input->post('num_student');
			$data['num_question']        = (int)$this->input->post('num_question');
			$data['difficulty_test']        = (int)$this->input->post('difficulty_test'); 
			$Data['add_exam_ID']        = $this->exam_model ->add_exam_fast($data);
			if($Data['add_exam_ID']!=false)
				{echo 'cc';
					//$this->load->emp_template('exam',$Data);
				  }else{echo 'ss';
			//		$this->load->emp_template('exam',$Data);
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
			redirect('/emp/exam/set_exam', 'refresh');
		}else{
			redirect('/emp/exam', 'refresh');
			}
	}
//set_exam
	public function set_exam()
	{
		
		$Data['id']                 = $this->session->userdata('ExamID_Edit');		
		$Data['subjectEmp_details'] = $this->subject_model->get_Subjects_emp();		
		$Data['exam_details_edit']  = $this->exam_model->get_specific_exam($Data['id'],(string)$this->data['Lang']);
		$Data['GetSemester']        = $this->config_model->get_semester((string)$this->data['Lang']);
		$Data['css']                = $this->Style_Sheet ;
		$Data['Form_Action']        = '';	
		if($this->exam_model->get_specific_exam($Data['id'],(string)$this->data['Lang']))
			{
			  $this->load->emp_template('edit_exam',$Data);
			 }
			 else{echo 'error';}
				 
	}
//edit_exam
	public function edit_exam()
	{
		
	    $this->form_validation->set_rules('slct_subject', 'lang:Subject_Name','is_natural_no_zero');
		$this->form_validation->set_rules('slct_Semester', 'lang:Semester','is_natural_no_zero');		
	    $this->form_validation->set_rules('txt_exam', 'lang:Exam_Name','required|min_length[4]');		
	    $this->form_validation->set_rules('txt_time', 'lang:Exam_Time','min_length[1]');		
		$data['txt_test_ID']           = $this->input->post('txt_test_ID');
		if ($this->form_validation->run() === false)
		{
			$this->set_exam() ;
			
		}else
		{
			$data['slct_Semester']      = $this->input->post('slct_Semester');
			$data['slct_subject']       = $this->input->post('slct_subject');
			$data['txt_exam']           = $this->input->post('txt_exam');
			$data['txt_time']           = $this->input->post('txt_time');
			$data['txt_description']    = $this->input->post('txt_description');
			if($this->exam_model->edit_exam($data))
			{
				$this -> session -> set_flashdata('msg','<div class="alert alert-success">'.lang('am_op_suc').'</div>');
			   redirect('emp/exam/set_exam', 'refresh');
			}else{}
		}
	}
//del_exam
	public function del_exam()
	{
		if($this->uri->segment(4) === FALSE){redirect('/emp/exam', 'location');}
			else
			{
				$ID = $this->uri->segment(4) ;
				$examID = array('ID'=>$ID);
	
				if($this->exam_model->delete_exam($examID))
				{
					
					redirect('/emp/exam', 'location');
				}
				else
				{
					$Message = lang('am_error');

					$this->session->set_flashdata('msg',$Message);
					
					redirect('/emp/exam', 'location');
				}
			}
	}
//add_upload_degree
	public function add_upload_degree()
	{
		 $t_s_ID = $this->input->post('t_s_ID'); /* foreach($t_s_ID as $key =>$row){echo $row;}*/
		 $s_Degree = $this->input->post('s_degree'); 
		  $t_Degree = $this->input->post('total_degree');
 
		 $this->answer_exam_model->insert_s_d_upload($s_Degree,$t_Degree,$t_s_ID);
	}

}

