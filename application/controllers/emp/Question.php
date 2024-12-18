<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Question extends CI_Controller {

        public $Style_Sheet = 'css_rtl'  ; 
		public $GetLang     = 'ar'  ;
		
    function __construct()
    {
       parent::__construct();     	
	   $this->load->helper(array('form', 'url'));
	   $this->load->model(array('emp/exam_model','emp/subject_model','emp/config_model','emp/question_model'));
	   $this->load->library('get_data_emp');
	   $this->data['UID']            = $this->session->userdata('id');
	   $this->data['YearID']         = $this->session->userdata('YearID');
	   $this->data['Year']           = $this->session->userdata('Year');
	   $this->data['Semester']       = $this->session->userdata('Semester');
	   $this->data['Lang']           = $this->session->userdata('language');
    }

//add_question
	public function add_question()
	{
		if($this->uri->segment(4) === FALSE){redirect('emp/exam', 'location');}
			else
			{
				$Data['id']                 = $this->session->userdata('ExamID_Edit');
				$Data['exam_ID']            = (int)$this->uri->segment(4) ;		
				$Data['subjectEmp_details'] = $this->subject_model->get_Subjects_emp();		
				$Data['exam_details_edit']  = $this->exam_model->get_specific_exam($Data['exam_ID'] ,(string)$this->GetLang);
				$Data['GetSemester']        = $this->config_model->get_semester((string)$this->GetLang);
				$Data['Type_question']      = $this->question_model->get_Type_question();
				$Data['question']      = $this->question_model->get_all_question($Data['exam_ID']);
			    $this->load->emp_template('add_question',$Data);
				
			}
		
	}
	
//sess_show_question
	public function sess_show_question()
	{
		if($this->uri->segment(4) === FALSE){redirect('emp/exam', 'location');}
			else
			{
				$Data['slct_Types_questions'] = (int)$this->uri->segment(4) ;
				$Data['exam_ID']              = (int)$this->uri->segment(5);
				$DataSession                  = array('slct_Types_questions'=>$Data['slct_Types_questions'],'exam_ID'=>$Data['exam_ID'] );
				$this->session->set_userdata($DataSession);
				redirect('emp/question/show_question', 'refresh');
				
			}
	}
//sees_edit_item
	public function sees_edit_item()
	{
		if($this->uri->segment(4) === FALSE){redirect('emp/exam', 'location');}
			else
			{
				$Data['edit_question_ID']          = (int)$this->uri->segment(4);
				$DataSession                  = array('edit_question_ID'=>$Data['edit_question_ID'] );
				$this->session->set_userdata($DataSession);
				redirect('emp/question/show_edit_question', 'refresh');
			}
	}
//show_question _Delivery
	public function get_q_del()
	{	
		$num_q        = (int)$this->input->post('num_q');	
		$type_q       = (int)$this->input->post('type_q');	
		$exam_ID      = (int)$this->input->post('exam_ID');
		$numSession   = array('num_q'=>$num_q,'type_q'=>$type_q,'exam_ID'=>$exam_ID );
		$this->session->set_userdata($numSession);
		
	}
//show_question _Delivery showing
	public function show_q_del($mess = NULL)
	{
		 $Data['slct_Types_questions'] = $this->session->userdata('type_q') ;
	     $Data['exam_ID']              = $this->session->userdata('exam_ID') ;
		 $Data['mess'] = $mess ; 
		 if($Data['slct_Types_questions']==7 ){ 
			 $Data['name_question']    = $this->question_model->get_name_question(7);
			
			 $Data['id']                 = $this->session->userdata('exam_ID');		
			 $Data['subjectEmp_details'] = $this->subject_model->get_Subjects_emp();		
			 $Data['exam_details_edit']  = $this->exam_model->get_specific_exam($Data['id'] ,(string)$this->GetLang);
			 $Data['GetSemester']        = $this->config_model->get_semester((string)$this->GetLang);
			 $Data['css']                = $this->Style_Sheet ;
			 $Data['Form_Action']        = 'emp/question/insert_question';	
					
			$Data['exam_ID']     = (int)$this->session->userdata('exam_ID');
			$Data['question_ID'] = (int)$this->session->userdata('question_ID');
			$Data['num_quest']   = (int)$this->session->userdata('num_q');
			$this->load->emp_template('q_Delivery_num',$Data);
		}
	}
//show_question
	public function show_question($mess = NULL)
	{	
			   $Data['slct_Types_questions'] = $this->session->userdata('slct_Types_questions') ;
	           $Data['exam_ID']              = $this->session->userdata('exam_ID') ;
			   
			   $Data['mess'] = $mess ; 
			   if($Data['slct_Types_questions']>0&&$Data['slct_Types_questions'] <=7 ){ 
			   $Data['name_question']          = $this->question_model->get_name_question($Data['slct_Types_questions'] );
     	
	            $Data['id']                 = $this->session->userdata('ExamID_Edit');		
				$Data['subjectEmp_details'] = $this->subject_model->get_Subjects_emp();		
				$Data['exam_details_edit']  = $this->exam_model->get_specific_exam($Data['exam_ID'] ,(string)$this->GetLang);
				$Data['GetSemester']        = $this->config_model->get_semester((string)$this->GetLang);
				$Data['css']                = $this->Style_Sheet ;

				switch($Data['slct_Types_questions']){
					 case'1':
				        $this->load->emp_template('q_choose_one',$Data);
					   break;
					 case'2':
				        $this->load->emp_template('q_choose',$Data);
					   break;
					 case'3':
				        $this->load->emp_template('q_correct',$Data);
					   break;
					 case'4':
				        $this->load->emp_template('q_complete',$Data);
					   break;
					 case'5':
				        $this->load->emp_template('q_mean',$Data);
					   break;
					 case'6':
				       $this->load->emp_template('q_freeUpload',$Data);
					   break; 
					 case'7':
				     	$this->load->emp_template('q_Delivery',$Data);
					   break;
					 default:
					}
			}
	}	
//show_edit_question
	public function show_edit_question($mess = NULL)
	{	
	           	$Data['edit_question_ID']   = $this->session->userdata('edit_question_ID') ;		   
			    $Data['mess'] = $mess ; 
			    $Data['item_question']      = $this->question_model->get_question($Data['edit_question_ID']);
				$count_q=0;
				 foreach($Data['item_question'] as $row){
					if($count_q==0){$Data['slct_Types_questions'] = $row->questions_types_ID;} 
					$count_q++;
					 }
				switch($Data['slct_Types_questions']){
					 case'1':
				        $this->load->emp_template('q_choose_one_edit',$Data);
					   break;
					 case'2':
				        $this->load->emp_template('q_choose_edit',$Data);
					   break;
					 case'3':
				        $this->load->emp_template('q_correct_edit',$Data);
					   break;
					 case'4':
				        $this->load->emp_template('q_complete_edit',$Data);
					   break;
					 case'5':
				        $this->load->emp_template('q_mean_edit',$Data);
					   break;
					 case'6':
				        $this->load->emp_template('q_freeUpload_edit',$Data);
					   break;
					 case'7':
				        $this->load->emp_template('q_Delivery_edit',$Data);
					   break;
					 default:
					}

	}	
//insert_question
	public function insert_question()
	{	
		$txt_question         = (int)$this->input->post('txt_Tquestion_ID');		
	    if($txt_question <=6&&$txt_question >0)
		{
			$this->form_validation->set_rules('txt_question', 'lang:question','required|min_length[2]');
			$this->form_validation->set_rules('degree_difficulty', 'lang:am_degree_difficulty','required|is_natural_no_zero');
			$this->form_validation->set_rules('txt_Degree', 'lang:Degree','required');
		}
		if($txt_question <=7&&$txt_question >0)
		{
			switch($txt_question){
				case'1':
					$this->form_validation->set_rules('txt_Choices1', 'lang:Choices','required|min_length[1]');
					$this->form_validation->set_rules('txt_Choices2', 'lang:Choices','required|min_length[1]');
					$this->form_validation->set_rules('slct_Correct_Answer', 'lang:Correct_Answer','required|is_natural_no_zero');
					break;
				case'2':
					$this->form_validation->set_rules('txt_Choices1', 'lang:Choices','required|min_length[1]');
					$this->form_validation->set_rules('txt_Choices2', 'lang:Choices','required|min_length[1]');
					$num_Choices         = $this->input->post('num_Choices');
					$count_check =1;
					$if_check=0;
					while($count_check<=$num_Choices){
						$check_item = 'check'.$count_check;
						$check_item         = $this->input->post($check_item);
						if($check_item!=""){
							$if_check++;
							}
						$count_check++;
						}
						if($if_check==0){
							$this->session->set_flashdata('result', 'لم تقم باختيار اى الاجابات صحيحة');
							redirect('/emp/question/show_question', 'refresh');
							}
					break;
				case'3':
					$this->form_validation->set_rules('txt_answer_one', 'lang:answer','required|min_length[1]');
					$this->form_validation->set_rules('txt_answer_two', 'lang:answer','required|min_length[1]');
					break;
				case'4':
					$num_answers_txt = $this->input->post('num_answers');
					if($num_answers_txt==0){
						$this->session->set_flashdata('result', 'لم تقم بكتابة الإجابات الصحيحة');
						redirect('/emp/question/show_question', 'refresh');
						}else{			
							
					$num_answers_txt      = $this->input->post('num_answers');
					$count_ans =1 ;
					while($count_ans<=$num_answers_txt){
						$txt_answers = 'answer_txt_'.$count_ans;
						$txt_answers = $this->input->post($txt_answers);
						if(strlen($txt_answers) <1){
							$this->session->set_flashdata('result', 'لم تقم بكتابة الإجابات الصحيحة');
							redirect('/emp/question/show_question', 'refresh');
							}
						$count_ans++;
						}
						}
					break;
				case'5':
					$this->form_validation->set_rules('txt_answer', 'lang:answer','required|min_length[1]');
					break;
				case'6':
					$txt_attach_answer = $_FILES['txt_attach_answer']['name'];
					if (empty($_FILES['txt_attach_answer']['name']))
						{
							$this->form_validation->set_rules('txt_attach_answer', 'lang:answer', 'required');
						}
				case'7':
					$num_quest      = $this->input->post('txt_num_quest');
					$questions="";
					$answers  ="";
					$Degrees  ="";
					$del_Degree;
					$num=1;
					while($num_quest>=$num){
						$questions      = $questions.$this->input->post('txt_question_'.$num).'%!%';
						$answers        = $answers.$this->input->post('txt_answer_'.$num).'%!%';
						/*$questions      = $questions.$this->input->post('txt_Degree_'.$num).'%!%';*/
						$del_Degree     = $del_Degree+(int)$this->input->post('txt_Degree_'.$num);
						$this->form_validation->set_rules('txt_question_'.$num, 'lang:question', 'required|min_length[1]');
						$this->form_validation->set_rules('txt_answer_'.$num, 'lang:answer', 'required|min_length[1]');
						$this->form_validation->set_rules('txt_Degree_'.$num, 'lang:Degree', 'required|min_length[1]');
						$num++;
					}
					break;
				default:
			}
			}
		
		if ($this->form_validation->run() === false)
		{
			$this->session->set_flashdata('msg',lang('error_content'));
			$this->session->set_flashdata('msg_class','error_contant');
			 if($txt_question <=6&&$txt_question >0)
			{
				$this->show_question() ; 
			}else if($txt_question==7){
				$this->show_q_del(lang('error_content')) ; 
				}
			
		}else		
		{
		
		if($txt_question==6){
			$txt_attach_answer_f = $_FILES['txt_attach_answer']['name'];	
			$txt_attach_answer ="txt_attach_answer";		
			if(!empty($txt_attach_answer_f)){
				$config['upload_path'] = './upload/';
				$config['allowed_types'] = 'txt|doc|rtf|ppt|pdf|swf|flv|avi|wmv|mov|jpg|jpeg|gif|png|mp4|mp3|rar|avi|wmv|xlsx|docx|pptx|ppsx|zip';
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload($txt_attach_answer))
				{
					$error = array('error' => $this->upload->display_errors());
					print_r($error);
				}
			}
		} 
		$txt_question         = (int)$this->input->post('txt_Tquestion_ID');
		  if($txt_question <=6&&$txt_question >0)
			{		 
			$Data['id_exam']          = $this->question_model->insert_question();
			}else if($txt_question ==7){
				$Data['id_exam']          = $this->question_model->insert_del_question($questions ,$answers,$del_Degree);
				}
		 redirect('emp/question/sees_edit_q/'.$Data['id_exam'], 'refresh');
		}
	}
	//sees_edit
	public function sees_edit_q()
	{
		(int)$Data['id'] = (int)$this->uri->segment(4);
		if(isset($Data['id'])&&$Data['id']!=0 )
		{
			$this->session->set_userdata('ExamID_Edit',(int)$Data['id'])  ;
			redirect('/emp/question/edit_questions', 'refresh');
		}else{redirect('/emp/exam', 'refresh');}
	}	
//edit_questions
	public function edit_questions()
	{		
		$Data['id']                 = $this->session->userdata('ExamID_Edit');	
		
		$Data['subjectEmp_details'] = $this->subject_model->get_Subjects_emp();		
		$Data['exam_details_edit']  = $this->exam_model->get_specific_exam($Data['id'] ,(string)$this->GetLang);
		$Data['GetSemester']        = $this->config_model->get_semester((string)$this->GetLang);
		
		$Data['question']           = $this->question_model->get_question_exam($Data['id']);
		$this->load->emp_template('edit_questions',$Data);
	}
//post_correct_answer
	public function post_correct_answer()
	{
		$Data['str']         = $this->input->post('str');	
		$this->load->view('emp/post_correct_answer',$Data);
	}
//post_correct_answer_exist
	public function post_correct_answer_exist()
	{		
		$Data['str']             = $this->input->post('str');
		$Data['all_answers']     = $this->input->post('all_answers');
		$Data['count_Answer']    = $this->input->post('count_Answer');
		$this->load->emp_template('post_correct_answer_exist',$Data);
	}
//insert_question
	public function update_question()
	{
		$txt_question         = $this->input->post('txt_Tquestion_ID');	
		 if($txt_question <=6&&$txt_question >0)
		{	
			$this->form_validation->set_rules('txt_question', 'lang:question','required|min_length[2]');
			$this->form_validation->set_rules('degree_difficulty', 'lang:am_degree_difficulty','required|is_natural_no_zero');
		}
		switch($txt_question){
			case'1':
 				break;
			case'2':
			
				break;
			case'3':		
				break;
			case'4':
				$num_answers_txt = $this->input->post('num_answers');
				if($num_answers_txt==0){
					$this->session->set_flashdata('result', 'لم تقم بكتابة الإجابات الصحيحة');
					redirect('/emp/question/show_edit_question', 'refresh');
					}else{			
						
				$num_answers_txt      = $this->input->post('num_answers');
				$count_ans =1 ;
				while($count_ans<=$num_answers_txt){
					$txt_answers = 'answer_txt_'.$count_ans;
					
					$txt_answers = $this->input->post($txt_answers);
					
					if(strlen($txt_answers) <1){
						$this->session->set_flashdata('result', 'لم تقم بكتابة الإجابات الصحيحة');
						redirect('/emp/question/show_edit_question', 'refresh');
						}
					$count_ans++;
					}
					}
				break;
			case'5':
			
				break;
			case'6':
			
				break;
			case'7':
					$num_quest      = $this->input->post('txt_num_quest');
					$questions="";
					$answers  ="";
					$Degrees  ="";
					$del_Degree;
					$num=1;
					while($num_quest>=$num){
						$questions      = $questions.$this->input->post('txt_question_'.$num).'%!%';
						$answers        = $answers.$this->input->post('txt_answer_'.$num).'%!%';
						$del_Degree     = $del_Degree+(int)$this->input->post('txt_Degree_'.$num);
						$this->form_validation->set_rules('txt_question_'.$num, 'lang:question', 'required|min_length[1]');
						$this->form_validation->set_rules('txt_answer_'.$num, 'lang:answer', 'required|min_length[1]');
						$this->form_validation->set_rules('txt_Degree_'.$num, 'lang:Degree', 'required|min_length[1]');
						$num++;
					}
				break;
			default:
			}
		if ($this->form_validation->run() === false)
		{  
			 $this->show_edit_question() ; 
		}else		
		{ 
		
		if($txt_question==6){
			$txt_attach_answer_f = $_FILES['txt_attach_answer']['name'];	
			$txt_attach_answer ="txt_attach_answer";		
			if(!empty($txt_attach_answer_f)){
				$config['upload_path'] = './upload/';
				$config['allowed_types'] = 'txt|doc|rtf|ppt|pdf|swf|flv|avi|wmv|mov|jpg|jpeg|gif|png|mp4|mp3|rar|avi|wmv|xlsx|docx|pptx|ppsx|zip';
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload($txt_attach_answer))
				{
					$error = array('error' => $this->upload->display_errors());
					print_r($error);
				}
			}
		}
		 
		 if($txt_question <=6&&$txt_question >0)
			{		 
			$Data['id_q']          = $this->question_model->update_question();
			}else if($txt_question ==7){
				$Data['id_q']          = $this->question_model->update_del_question($questions ,$answers,$del_Degree);
				}
		 redirect('/emp/question/sees_edit_item/'.$Data['id_q'], 'refresh');
		}
	}
	//////sees_del_item
	public function sees_del_item()
	{
		    if($this->uri->segment(4) === FALSE ||(int)$this->uri->segment(4) === 0){redirect('/exam', 'location');}
			else
			{
				$Data['del_question_ID']      = (int)$this->uri->segment(4);
				$DataSession                  = array('del_question_ID'=>$Data['del_question_ID'] );
				$this->session->set_userdata($DataSession);
				redirect('/emp/question/del_qui', 'refresh');
				
			}
	}
	
	//////del_qui
	public function del_qui()
	{
		$Data['del_question_ID'] = $this->session->userdata('del_question_ID') ;
	    if($this->question_model->del_qui($Data['del_question_ID']))
		{
			redirect('/emp/question/edit_questions', 'refresh');
		}

		   
	}
	
	//////add_exist_question
	public function add_exist_question()
	{ 
		if(IS_AJAX&&isset($_POST))
		{		
		  $this->form_validation->set_rules('questionID', '','required|integer|xss_clean');
			   if ($this->form_validation->run() === false)
				{
					$data_ajax['msg']          = lang('am_op_error');
					$data_ajax['stp']          = 0;
					$this->output->set_content_type('application/json')->set_output(json_encode($data_ajax));				
				}
				else
				{
					$questionID   = (int)$this->input->post('questionID');
					$txt_exam_ID   = (int)$this->input->post('txt_exam_ID');
					
					
							if($this->question_model->add_exist_question($questionID,$txt_exam_ID))
							 {
							   $data_ajax['stp']          = 1;
							   $data_ajax['msg']          = lang('am_op_suc');
							   $this->output->set_content_type('application/json')->set_output(json_encode($data_ajax)); 
							 }else{
								  $data_ajax['stp']              = 0;
								  $data_ajax['msg']          = 'موجود بالفعل';
								  $this->output->set_content_type('application/json')
								  ->set_output(json_encode($data_ajax));
								 }
				
				}///END ELSE FORM VALIDATION
		}///END IF CHECK IS_AJAX
	}
}	

