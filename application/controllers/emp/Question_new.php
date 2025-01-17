<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Question_New extends CI_Controller {



        public $Style_Sheet = 'css_rtl'  ; 

		public $GetLang     = 'ar'  ;

		

    function __construct()

    {

       parent::__construct();     	

	   $this->load->helper(array('form', 'url'));

	   $this->load->model(array('emp/exam_new_model','emp/subject_model','emp/config_model','emp/question_new_model'));

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

				$Data['subjectEmp_details'] = $this->subject_model->get_Subjects_emp();		

				$Data['exam_details_edit']  = $this->exam_new_model->get_specific_exam($Data['id'],(string)$this->GetLang);

				$Data['GetSemester']        = $this->config_model->get_semester((string)$this->GetLang);

				$Data['exam_ID']            = (int)$this->uri->segment(4) ;

				$Data['Type_question']      = $this->question_new_model->get_Type_question();

				$Data['question']      = $this->question_new_model->get_all_question($Data['exam_ID']);

			    $this->load->emp_template('exam/add_question',$Data);

				

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

			 $Data['name_question']    = $this->question_new_model->get_name_question(7);

			

			 $Data['id']                 = $this->session->userdata('exam_ID');		

			 $Data['subjectEmp_details'] = $this->subject_model->get_Subjects_emp();		

			 $Data['exam_details_edit']  = $this->exam_new_model->get_specific_exam($Data['id'],(string)$this->GetLang);

			 $Data['GetSemester']        = $this->config_model->get_semester((string)$this->GetLang);

 					

			$Data['exam_ID']     = (int)$this->session->userdata('exam_ID');

			$Data['question_ID'] = (int)$this->session->userdata('question_ID');

			$Data['num_quest']   = (int)$this->session->userdata('num_q');

			$this->load->emp_template('exam/q_Delivery_num',$Data);

		}

	}

//show_question

	public function show_question($mess = NULL)

	{	

		if(IS_AJAX&&isset($_POST))

		{	 

			   

	            $Data['slct_Types_questions']     = (int)$this->input->post('q_type_id');	

	            $Data['exam_ID']                  = (int)$this->input->post('txt_test_ID');	

 			    if($Data['slct_Types_questions']>0&&$Data['slct_Types_questions'] <=7 ){ 

			    $Data['name_question']           = $this->question_new_model->get_name_question($Data['slct_Types_questions'] );

	            $Data['id']                      = (int)$this->input->post('txt_test_ID');		

				$Data['subjectEmp_details']      = $this->subject_model->get_Subjects_emp();		

				$Data['exam_details_edit']       = $this->exam_new_model->get_specific_exam($Data['id'],(string)$this->GetLang);

				$Data['GetSemester']             = $this->config_model->get_semester((string)$this->GetLang);

				switch($Data['slct_Types_questions']){

					 case'1':

				        $this->load->view('emp/exam/q_choose_one',$Data);

					   break;

					 case'2':

				        $this->load->view('emp/exam/q_choose',$Data);

					   break;

					 case'3':

				        $this->load->view('emp/exam/q_correct',$Data);

					   break;

					 case'4':

				        $this->load->view('emp/exam/q_complete',$Data);

					   break;

					 case'5':

				        $this->load->view('emp/exam/q_mean',$Data);

					   break;

					 case'6':

				       $this->load->view('emp/exam/q_freeUpload',$Data);

					   break; 

					 case'7':

				     	$this->load->view('emp/exam/q_Delivery',$Data);

					   break;

					 default:

					}

			}

		}

	}	

//show_question

	public function show_all_question($mess = NULL)
	{	
		if(IS_AJAX&&isset($_POST))
		{	 
            $Data['slct_Types_questions']     = (int)$this->input->post('q_type_id');	

            $Data['exam_ID']                  = (int)$this->input->post('txt_test_ID');	

            $Data['question_id']              = (int)$this->input->post('questions_content_ID');

			if($Data['slct_Types_questions']>0&&$Data['slct_Types_questions'] <=7 ){ 

			   	$Data['name_question']      = $this->question_new_model->get_name_question($Data['slct_Types_questions'] );

	            $Data['id']                 = (int)$this->input->post('txt_test_ID');		

				$Data['subjectEmp_details'] = $this->subject_model->get_Subjects_emp();		

				$Data['exam_details_edit']  = $this->exam_new_model->get_specific_exam($Data['id'],(string)$this->GetLang);

				$Data['GetSemester']        = $this->config_model->get_semester((string)$this->GetLang);

				$Data['item_question']      = $this->question_new_model->get_question($Data['question_id']);
				// print_r($Data['item_question']);die;
				$Data['Questions_num']      = $this->db->query("SELECT num_ques from questions_content where ID =  ".$Data['question_id']." ")->row_array();
				
				$Data['num']                = $Data['Questions_num']['num_ques'];

				switch($Data['slct_Types_questions']){
			 		case'1':

				        $this->load->view('emp/exam/q_choose_one_show',$Data);
					   	break;

			 		case'2':

				        $this->load->view('emp/exam/q_choose_show',$Data);
					   	break;

			 		case'3':

				        $this->load->view('emp/exam/q_correct_show',$Data);
					   	break;

			 		case'4':

				        $this->load->view('emp/exam/q_complete_show',$Data);
					   	break;

			 		case'5':

				        $this->load->view('emp/exam/q_mean_show',$Data);
					   	break;

			 		case'6':

				        $this->load->view('emp/exam/q_freeUpload_show',$Data);
					    break; 

			 		case'7':

				     	$this->load->view('emp/exam/q_Delivery_show',$Data);
					   	break;

			 		default:
				}
			}
		}
	}

//show_edit_question

	public function show_edit_question($mess = NULL)

	{	

	           	$Data['edit_question_ID']   =(int) $this->input->post('txt_q_ID') ; 
	           	
	           	 $Data['txt_type_ID']   =(int) $this->input->post('txt_type_ID') ; 

			    $Data['item_question']      = $this->question_new_model->get_question($Data['edit_question_ID']);

				$count_q=0;

				 foreach($Data['item_question'] as $row){

					if($count_q==0){$Data['slct_Types_questions'] = $row->questions_types_ID;} 

					$count_q++;

					 }

				switch($Data['txt_type_ID']){

					 case'1':

				        $this->load->view('emp/exam/q_choose_one_edit',$Data);

					   break;

					 case'2':

				        $this->load->view('emp/exam/q_choose_edit',$Data);

					   break;

					 case'3':

				        $this->load->view('emp/exam/q_correct_edit',$Data);

					   break;

					 case'4':

				        $this->load->view('emp/exam/q_complete_edit',$Data);

					   break;

					 case'5':

				        $this->load->view('emp/exam/q_mean_edit',$Data);

					   break;

					 case'6':

				        $this->load->view('emp/exam/q_freeUpload_edit',$Data);

					   break;

					 case'7':

				        $this->load->view('emp/exam/q_Delivery_edit',$Data);

					   break;

					 default:

					}



	}	

//insert_question

	public function insert_question()

	{	

		if(IS_AJAX&&isset($_POST))

		{	 

		$txt_question         = (int)$this->input->post('txt_Tquestion_ID');	 

	    

			$this->form_validation->set_rules('txt_question', 'lang:question','required|min_length[2]');

 			$this->form_validation->set_rules('txt_Degree', 'lang:Degree','required');

 		 

 		

		if ($this->form_validation->run() === false)

		{

			

					$data_ajax['msg']           = 'خطأ';

					$data_ajax['stp']           = 0;

					$this->output->set_content_type('application/json')->set_output(json_encode($data_ajax));

			

		}else		

		{

		$txt_question            = (int)$this->input->post('txt_Tquestion_ID');

		$Data['question_id']     = $this->question_new_model->insert_question();

		$Data['item_question']   =  $this->question_new_model->get_question($Data['question_id']);
		
		$Data['Questions_num']   = $this->db->query("SELECT num_ques from questions_content where ID =  ".$Data['question_id']." ")->row_array();
				
		$Data['num']             = $Data['Questions_num']['num_ques'];

 

		switch((int)$this->input->post('txt_Tquestion_ID')){

				case'1':

					  $this->load->view('emp/exam/q_choose_one_show',$Data);

					break;

				case'2':

					  $this->load->view('emp/exam/q_choose_show',$Data); 

					break;

				case'3':

					  $this->load->view('emp/exam/q_correct_show',$Data); 

					break;

				case'4':

					  $this->load->view('emp/exam/q_complete_show',$Data); 

					break;

				case'5':

					  $this->load->view('emp/exam/q_mean_show',$Data); 

					break;

				case'6': 

					  $this->load->view('emp/exam/q_freeUpload_show',$Data); 

					break;

				case'7': 

					  $this->load->view('emp/exam/q_Delivery_show',$Data); 

 					break;

			   default:

			

			}		



		}

		

		}

	}

//insert_question_ex

	public function insert_question_ex()

	{	

		if(IS_AJAX&&isset($_POST))

		{	 

		$txt_question         = (int)$this->input->post('txt_Tquestion_ID');	 

	    

			$this->form_validation->set_rules('txt_question', 'lang:question','required|min_length[2]');

 			$this->form_validation->set_rules('txt_Degree', 'lang:Degree','required');

 		 

 		

		if ($this->form_validation->run() === false)

		{

			

					$data_ajax['msg']           = 'خطأ';

					$data_ajax['stp']           = 0;

					$this->output->set_content_type('application/json')->set_output(json_encode($data_ajax));

			

		}else		

		{

		

	 

		$txt_question         = (int)$this->input->post('txt_Tquestion_ID');

		   	 

			$Data['question_id']          = $this->question_new_model->insert_question_ex();

			 

		$Data['item_question']           =  $this->question_new_model->get_question($Data['question_id']);

 

		switch((int)$this->input->post('txt_Tquestion_ID')){

				case'1':

					  $this->load->view('emp/exam/q_choose_one_show',$Data);

					break;

				case'2':

					  $this->load->view('emp/exam/q_choose_show',$Data); 

					break;

				case'3':

					  $this->load->view('emp/exam/q_correct_show',$Data); 

					break;

				case'4':

					  $this->load->view('emp/exam/q_complete_show',$Data); 

					break;

				case'5':

					  $this->load->view('emp/exam/q_mean_show',$Data); 

					break;

				case'6': 

					  $this->load->view('emp/exam/q_freeUpload_show',$Data); 

					break;

				case'7': 

					  $this->load->view('emp/exam/q_Delivery_show',$Data); 

 					break;

			   default:

			

			}		



		}

		

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

		$Data['exam_details_edit']  = $this->exam_new_model->get_specific_exam($Data['id'],(string)$this->GetLang);

		$Data['GetSemester']        = $this->config_model->get_semester((string)$this->GetLang);

		

		$Data['question']           = $this->question_new_model->get_question_exam($Data['id']);

		$this->load->emp_template('exam/edit_questions',$Data);

	}

//post_correct_answer

	public function post_correct_answer()

	{

		$Data['str']         = $this->input->post('str');	

		$this->load->view('emp/exam/post_correct_answer',$Data);

	}

//post_correct_answer_exist

	public function post_correct_answer_exist()

	{		

		$Data['str']             = $this->input->post('str');

		$Data['all_answers']     = $this->input->post('all_answers');

		$Data['count_Answer']    = $this->input->post('count_Answer');

		$this->load->emp_template('exam/post_correct_answer_exist',$Data);

	}

//insert_question

	public function update_question()

	{

		$txt_question         = $this->input->post('txt_Tquestion_ID');	
// 		 if($txt_question <=6&&$txt_question >0)

// 		{	

// 			$this->form_validation->set_rules('txt_question', 'lang:question','required|min_length[2]');

// 			$this->form_validation->set_rules('degree_difficulty', 'lang:am_degree_difficulty','required|is_natural_no_zero');

// 		}

		 

// 		if ($this->form_validation->run() === false)

// 		{  

// 			 print_r("mmmmmmmmmmmmm");die;

// 					$data_ajax['msg']           = 'خطأ';

// 					$data_ajax['stp']           = 0;

// 					$this->output->set_content_type('application/json')->set_output(json_encode($data_ajax));

// 		}else		

// 		{ 

		
			    $Data['id_q']                    = $this->question_new_model->update_question();

				$Data['item_question']           =  $this->question_new_model->get_question($Data['id_q']); 
				
				$Data['Questions_num']      = $this->db->query("SELECT num_ques from questions_content where ID =  ".$Data['id_q']." ")->row_array();
				
				$Data['num']                = $Data['Questions_num']['num_ques'];
  		switch((int)$this->input->post('txt_Tquestion_ID')){

				case'1':

					  $this->load->view('emp/exam/q_choose_one_show',$Data);

					break;

				case'2':

					  $this->load->view('emp/exam/q_choose_show',$Data); 

					break;

				case'3':

					  $this->load->view('emp/exam/q_correct_show',$Data); 

					break;

				case'4':

					  $this->load->view('emp/exam/q_complete_show',$Data); 

					break;

				case'5':

					  $this->load->view('emp/exam/q_mean_show',$Data); 

					break;

				case'6': 

					  $this->load->view('emp/exam/q_freeUpload_show',$Data); 

					break;

				case'7': 

					  $this->load->view('emp/exam/q_Delivery_show',$Data); 

					break;

			   default:

			

		//	}
          
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

		$Data['del_question_ID'] =  (int)$this->input->post('txt_q_ID');

 	     $this->question_new_model->del_qui($Data['del_question_ID']);

 		 return true;

		   

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

					

					

							if($this->question_new_model->add_exist_question($questionID,$txt_exam_ID))

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



