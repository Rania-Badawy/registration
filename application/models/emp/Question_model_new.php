<?php
class Question_Model_New  extends CI_Model 
 {
	 private $q_ID ;
	 private $q_txt ;
	 private $q_attach ; 
	
///create_token
	 public function create_token()
	{
			$ArrayNum = array('0','1','2','3','4','5','6', '7','8','9');
			$Num = '';
			$Count = 0;
			while ($Count <= 9) {$Num .= $ArrayNum[mt_rand(0, 8)];$Count++; }
			$ArrayStr = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','W','X','Y','Z');
			$Str = '';
			$Count = 0;
	
			while ($Count <= 14) {$Str .= $ArrayStr[mt_rand(0, 15)];$Count++;}	
			$encrypt = 'qwdfghm,][poiasdfghj.zxcvbnm,.957365254068061531qwertyuiasdfghjkl;12345678-=dfdsfsdfdferwerrvxcvbbn' ;	
			$Token            = md5($encrypt.$Str.$Num.uniqid(mt_rand()).microtime()) ;
			
			return $Token ; 
	}

//get_Type_question
	 public function get_Type_question()
	 {
		$this->db->select('*');
        $this->db->from('questions_types');
        $this->db->where('IsActive', 1 );
		$ResultContactData = $this->db->get();			
		$NumRowResultContactData  = $ResultContactData->num_rows() ; 
			if($NumRowResultContactData <=0)
			  {
				return FALSE;	
			  }
        	else 
			{
			   $ResultContactData     = $ResultContactData ->result() ;
			   return $ResultContactData ; 
			   return TRUE ;
				
			}
	 }
//get_name_question
	 public function get_name_question($q_ID)
	 {
		$this->db->select('*');
        $this->db->from('questions_types');
        $this->db->where('ID', $q_ID );
		$ResultContactData = $this->db->get();			
		$NumRowResultContactData  = $ResultContactData->num_rows() ; 
			if($NumRowResultContactData <=0)
			  {
				return FALSE;	
			  }
        	else 
			{
			   $ResultContactData     = $ResultContactData ->result() ;
			   return $ResultContactData ; 
			   return TRUE ;
				
			}
	 }
	
//get_question
	 public function get_question($q_ID)
	 {
		$this->db->select('answers.Answer , answers.Answer_correct , answers.ID AS answers_ID , questions_content.ID AS questions_content_ID , questions_content.Degree , questions_content.Question, questions_content.degree_difficulty ,questions_content.Q_attach ,test.Name AS test_Name ,questions_types.Name,questions_types.ID AS questions_types_ID,questions_content.youtube_script   ');
        $this->db->from('questions_content');
		$this->db->join('questions_types', 'questions_types.ID =questions_content.questions_types_ID', 'INNER');
		$this->db->join('test_questions', 'test_questions.Questions_ID = questions_content.ID', 'INNER');
		$this->db->join('answers', 'answers.Questions_Content_ID = questions_content.ID', 'INNER');
		$this->db->join('test', 'test.ID = test_questions.Test_ID', 'INNER');
		
        $this->db->where('questions_content.ID', $q_ID );
        $this->db->group_by('answers.ID' );
		$this->db->order_by("answers.ID", "asc");
		
		$ResultContactData = $this->db->get();
 		$NumRowResultContactData  = $ResultContactData->num_rows() ; 	 
			if($NumRowResultContactData <=0)
			  {
				return FALSE;	
			  }
        	else 
			{
			   $ResultContactData     = $ResultContactData ->result() ;
 			   return $ResultContactData ; 
			   return TRUE ;
				
			}
	 }
	//get_question_exam
	 public function get_question_exam($exam_id)
	{
		$this->db->select('test_questions.Test_ID,test_questions.Questions_ID,test_questions.Questions_ID , questions_types.Name,questions_types.ID AS questions_types_ID ,questions_content.Degree,questions_content.Question,questions_content.Q_attach,questions_content.ID AS questions_content_ID');
		$this->db->from('test_questions');
		$this->db->join('questions_content', 'questions_content.ID =test_questions.Questions_ID', 'INNER');
		$this->db->join('questions_types', 'questions_types.ID =questions_content.questions_types_ID', 'INNER');
		$this->db->where('test_questions.Test_ID',$exam_id);
		$ResultExam = $this->db->get();			
		$NumRowResultExam = $ResultExam->num_rows() ; 
		
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->result() ;
				
			   return $ReturnExam ; 
			   
			   return TRUE ; 
							 
			  }else{
				  return $NumRowResultExam ; 
				  return FALSE ;}
	}
	
//insert_question
	 public function insert_question()
	 {
			
			$degree_difficulty         = $this->input->post('degree_difficulty');	
			$txt_Tquestion_ID         = $this->input->post('txt_Tquestion_ID');	
			$txt_question             = $this->input->post('txt_question');
				$txt_Degree           = $this->input->post('txt_Degree');
				$youtube_script       = '';
							
				$txt_exam_ID          = $this->input->post('txt_exam_ID');
				$Answer_ID            = $this->input->post('slct_Correct_Answer');
				$txt_attach           = $this->input->post('txt_attach') ;
			   (string)$this->Token   = $this->create_token();	
				
				$add_q = array(
								 'Degree'                 =>(string)$txt_Degree  ,
								 'Question'               =>(string)$txt_question ,
								 'Q_attach'               =>$txt_attach ,
								 'questions_types_ID'     =>(int)$txt_Tquestion_ID,
								 'degree_difficulty'     =>(int)$degree_difficulty,
 								 'Token'                  =>(string)$this->Token
								 );
	
	
			   $Insert_q =  $this->db->insert('questions_content', $add_q); 
			   
			   
				$this->db->select('ID');
				$this->db->from('questions_content');
				$this->db->where('Token', (string)$this->Token );
				$this->db->limit(1);
				$ResultContactData = $this->db->get();			
				$NumRowResultContactData  = $ResultContactData->num_rows() ; 
					if($NumRowResultContactData <=0)
					  {
						return FALSE;	
					  }
					else 
					{
						$ResultContactData = $ResultContactData ->row_array() ;
						$Insert_q = $ResultContactData['ID'];
					}
				
			   $add_q_t = array(
								 'Test_ID'                =>(int)$txt_exam_ID  ,
								 'Questions_ID'           =>(int)$Insert_q ,
								 'Token'                  =>(string)$this->Token
								 );
	
	
			   $Insert_q_t =  $this->db->insert('test_questions', $add_q_t);
			   
		   switch($txt_Tquestion_ID){
			   case '1':
				$num_Choices     = $this->input->post('num_Choices');
			    			
				$count_Choices   =0; 
				while($count_Choices<$num_Choices){
 					 $txt_Choices         = $this->input->post('txt_Choices');
 					 $slct_Correct_Answer         = $this->input->post('slct_Correct_Answer');
					 if($txt_Choices[$count_Choices]  != ""){
 					 $add_answer = array(
								 'Answer'                 => $txt_Choices[$count_Choices]  ,
								 'Answer_correct'         =>$slct_Correct_Answer[$count_Choices]  ,
								 'Questions_Content_ID'   =>(string)$Insert_q ,
								 'Token'                  =>(string)$this->create_token()
								 );
				 
					
					$Insert_q_t =  $this->db->insert('answers', $add_answer);
					 }
					$count_Choices++;
					}
					break;
			   case '2':
					$num_Choices     = $this->input->post('num_Choices');
			    			
				$count_Choices   =0; 
				while($count_Choices<$num_Choices){
 					 $txt_Choices         = $this->input->post('txt_Choices');
 					 $slct_Correct_Answer         = $this->input->post('slct_Correct_Answer');
					 if($txt_Choices[$count_Choices]  != ""){
 					 $add_answer = array(
								 'Answer'                 => $txt_Choices[$count_Choices]  ,
								 'Answer_correct'         =>$slct_Correct_Answer[$count_Choices]  ,
								 'Questions_Content_ID'   =>(string)$Insert_q ,
								 'Token'                  =>(string)$this->create_token()
								 );
				 
					
					$Insert_q_t =  $this->db->insert('answers', $add_answer);
					 }
					$count_Choices++;
					}
					break;
			   case '3':
					$false_txt     = $this->input->post('false_txt');
					$true_txt      = $this->input->post('true_txt');		
 					 
						$add_answer = array(
								 'Answer'                 =>   lang("wrong_answer")    ,
								 'Answer_correct'         =>$false_txt  ,
								 'Questions_Content_ID'   =>(string)$Insert_q ,
								 'Token'                  =>(string)$this->create_token()
								 );
						$add_answer =  $this->db->insert('answers', $add_answer);
						$add_answer = array(
								 'Answer'                 =>   lang("right_answer")    ,
								 'Answer_correct'         =>$true_txt  ,
								 'Questions_Content_ID'   =>$Insert_q ,
								 'Token'                  =>(string)$this->create_token()
								 );
						$add_answer =  $this->db->insert('answers', $add_answer); 

						  
					break;
			   case '4':			   
 					$num_answers_txt = $this->input->post('num_answers')-1;
					$answer_txt = $this->input->post('answer_txt');  
						$count_ans =0 ;
						while($num_answers_txt>=$count_ans){ 
 							$add_answer = array(
								 'Answer'                 =>(string)$answer_txt[$num_answers_txt]  ,
								 'Answer_correct'         =>1  ,
								 'Questions_Content_ID'   =>(string)$Insert_q ,
								 'Token'                  =>(string)$this->create_token()
								 );
						    $add_answer =  $this->db->insert('answers', $add_answer); 
						
						$num_answers_txt--;
						}
					break;
			   case '5':		
						$txt_answer     = $this->input->post('txt_answer');	
						$add_answer = array(
								 'Answer'                 =>(string)$txt_answer  ,
								 'Answer_correct'         =>1  ,
								 'Questions_Content_ID'   =>(string)$Insert_q ,
								 'Token'                  =>(string)$this->create_token()
								 );
						$add_answer =  $this->db->insert('answers', $add_answer); 

				
					break;
			   case '6':		
						$txt_answer     = $this->input->post('txt_attach2');
 						$add_answer = array(
								 'Answer'                 =>(string)$txt_answer   ,
								 'Answer_correct'         =>1  ,
								 'Questions_Content_ID'   =>(string)$Insert_q ,
								 'Token'                  =>(string)$this->create_token()
								 );
						$add_answer =  $this->db->insert('answers', $add_answer); 
					break;
			   case '7':		 
						$txt_answer     = $this->input->post('txt_answer');
 						$add_answer = array(
								 'Answer'                 =>(string)$txt_answer   ,
								 'Answer_correct'         =>1  ,
								 'Questions_Content_ID'   =>(string)$Insert_q ,
								 'Token'                  =>(string)$this->create_token()
								 );
						$add_answer =  $this->db->insert('answers', $add_answer); 
					break;

		   }
				return $Insert_q;
			
	 }	
//update_del_question
	 public function update_del_question($txt_question,$txt_answer,$del_Degree)
	 {
			$txt_Tquestion_ID     = $this->input->post('txt_Tquestion_ID');	
			$txt_question_ID      = $this->input->post('txt_question_ID');
			(string)$this->Token  = $this->create_token();	
			$answers_ID                   = $this->input->post('txt_answer_ID');
				
				$add_q = array(
								 'Question'               =>(string)$txt_question ,
								 'questions_types_ID'     =>(int)$txt_Tquestion_ID,
								 'Degree'                 =>$del_Degree,
								 'Token'                  =>(string)$this->Token
								 );
	
			   $this->db->where('ID', (int)$txt_question_ID); 
			   $Insert_q =  $this->db->update('questions_content', $add_q); 
			$add_answer = array(
						'Answer'                 =>(string)$txt_answer   ,
						'Answer_correct'         =>1  ,
						'Questions_Content_ID'   =>(string)$txt_question_ID ,
						'Token'                  =>(string)$this->create_token()
					 );
			$this->db->where('ID', (int)$answers_ID);
			$add_answer =  $this->db->update('answers', $add_answer); 

		$DataSession                  = array('edit_question_ID'=>$Insert_q );
		$this->session->set_userdata($DataSession);
		return $txt_question_ID ;
	 }
	
//insert_del_question
	 public function insert_del_question($txt_question,$txt_answer,$del_Degree)
	 {
			$txt_Tquestion_ID     = $this->input->post('txt_Tquestion_ID');	
			$txt_exam_ID          = $this->input->post('txt_exam_ID');	
			(string)$this->Token  = $this->create_token();	
				
				$add_q = array(
								 'Question'               =>(string)$txt_question ,
								 'questions_types_ID'     =>(int)$txt_Tquestion_ID,
								 'Degree'                 =>$del_Degree,
								 'Token'                  =>(string)$this->Token
								 );
	
	
			   $Insert_q =  $this->db->insert('questions_content', $add_q); 
			   
			   
				$this->db->select('ID');
				$this->db->from('questions_content');
				$this->db->where('Token', (string)$this->Token );
				$this->db->limit(1);
				$ResultContactData = $this->db->get();			
				$NumRowResultContactData  = $ResultContactData->num_rows() ; 
					if($NumRowResultContactData <=0)
					  {
						return FALSE;	
					  }
					else 
					{
						$ResultContactData = $ResultContactData ->row_array() ;
						$Insert_q = $ResultContactData['ID'];
					}
				
			   $add_q_t = array(
								 'Test_ID'                =>(int)$txt_exam_ID  ,
								 'Questions_ID'           =>(int)$Insert_q ,
								 'Token'                  =>(string)$this->Token
								 );
	
	
			   $Insert_q_t =  $this->db->insert('test_questions', $add_q_t);
			   if($txt_answer !=""){	
				$add_answer = array(
								 'Answer'                 =>(string)$txt_answer   ,
								 'Answer_correct'         =>1  ,
								 'Questions_Content_ID'   =>(string)$Insert_q ,
								 'Token'                  =>(string)$this->create_token()
								 );
				$add_answer =  $this->db->insert('answers', $add_answer); 
			   }
				return $txt_exam_ID;
			
	 }
	//update_question
	 public function update_question()
	{
			$txt_Tquestion_ID     = $this->input->post('txt_Tquestion_ID');	
			$txt_question_ID      = $this->input->post('txt_question_ID');
			$txt_question         = $this->input->post('txt_question');
				
			$youtube_script         = $this->input->post('youtube_script');
				$txt_Degree           = $this->input->post('txt_Degree');			
				$Answer_ID            = $this->input->post('slct_Correct_Answer');			
				$txt_attach           =  $this->input->post('txt_attach');		
				$degree_difficulty           =  $this->input->post('degree_difficulty');
			   (string)$this->Token   = $this->create_token();	
			   if($youtube_script!=""){
				if($txt_attach==""){$add_q = array(
								 'Degree'                 =>(string)$txt_Degree  ,
								 'Question'               =>(string)$txt_question ,
								 'questions_types_ID'     =>(int)$txt_Tquestion_ID,
								 'degree_difficulty'     =>(int)$degree_difficulty,
								 'youtube_script'         =>$youtube_script,
								 'Token'                  =>(string)$this->Token
								 );
				}else{
				$add_q = array(
								 'Degree'                 =>(string)$txt_Degree  ,
								 'Question'               =>(string)$txt_question ,
								 'Q_attach'               =>(string)$txt_attach ,
								 'questions_types_ID'     =>(int)$txt_Tquestion_ID,
								 'degree_difficulty'     =>(int)$degree_difficulty,
								 'youtube_script'         =>$youtube_script,
								 'Token'                  =>(string)$this->Token
								 );}
			   }else{
				   
				if($txt_attach==""){$add_q = array(
								 'Degree'                 =>(string)$txt_Degree  ,
								 'Question'               =>(string)$txt_question ,
								 'questions_types_ID'     =>(int)$txt_Tquestion_ID,
								 'degree_difficulty'     =>(int)$degree_difficulty,
								 'Token'                  =>(string)$this->Token
								 );
				}else{
				$add_q = array(
								 'Degree'                 =>(string)$txt_Degree  ,
								 'Question'               =>(string)$txt_question ,
								 'degree_difficulty'     =>(int)$degree_difficulty,
								 'Q_attach'               =>(string)$txt_attach ,
								 'questions_types_ID'     =>(int)$txt_Tquestion_ID,
								 'Token'                  =>(string)$this->Token
								 );}
				   }
			   $this->db->where('ID', (int)$txt_question_ID); 
			   $Insert_q =  $this->db->update('questions_content', $add_q); 
			   
 		   switch($txt_Tquestion_ID){
			   case '1':
				
				$this->db->query("DELETE FROM answers WHERE Questions_Content_ID = '".$txt_question_ID."' ");
 			    			
				$count_Choices   =0; 
				$num_Choices     = $this->input->post('num_Choices');
 					 $txt_Choices         = $this->input->post('txt_Choices');
 					 $slct_Correct_Answer         = $this->input->post('slct_Correct_Answer');
					 
				while($count_Choices<$num_Choices){ 
					 if($txt_Choices[$count_Choices]  != ""){
 					 $add_answer = array(
								 'Answer'                 => $txt_Choices[$count_Choices]  ,
								 'Answer_correct'         =>$slct_Correct_Answer[$count_Choices]  ,
								 'Questions_Content_ID'   => $txt_question_ID ,
								 'Token'                  =>(string)$this->create_token()
								 );
					$Insert_q_t =  $this->db->insert('answers', $add_answer);
					 }
					$count_Choices++; 
					}
					break;
			   case '2': 
					$this->db->query("DELETE FROM answers WHERE Questions_Content_ID = '".$txt_question_ID."' ");
					 
					
					$num_Choices     = $this->input->post('num_Choices');
			    			
				$count_Choices   =0; 
				while($count_Choices<$num_Choices){
 					 $txt_Choices         = $this->input->post('txt_Choices');
 					 $slct_Correct_Answer         = $this->input->post('slct_Correct_Answer');
					 if($txt_Choices[$count_Choices]  != ""){
 					 $add_answer = array(
								 'Answer'                 => $txt_Choices[$count_Choices]  ,
								 'Answer_correct'         =>$slct_Correct_Answer[$count_Choices]  ,
								 'Questions_Content_ID'   =>(string)$txt_question_ID ,
								 'Token'                  =>(string)$this->create_token()
								 );
				 
					
					$Insert_q_t =  $this->db->insert('answers', $add_answer);
					 }
					$count_Choices++;
					}
					break;

			   case '3':
					
					$this->db->query("DELETE FROM answers WHERE Questions_Content_ID = '".$txt_question_ID."' ");
					 
					
					$false_txt     = $this->input->post('false_txt');
					$true_txt      = $this->input->post('true_txt');		
 					 
						$add_answer = array(
								 'Answer'                 =>   lang("wrong_answer")    ,
								 'Answer_correct'         =>$false_txt  ,
								 'Questions_Content_ID'   =>(string)$txt_question_ID ,
								 'Token'                  =>(string)$this->create_token()
								 );
						$add_answer =  $this->db->insert('answers', $add_answer);
						$add_answer = array(
								 'Answer'                 =>   lang("right_answer")    ,
								 'Answer_correct'         =>$true_txt  ,
								 'Questions_Content_ID'   =>$txt_question_ID ,
								 'Token'                  =>(string)$this->create_token()
								 );
						$add_answer =  $this->db->insert('answers', $add_answer); 

						  
					break;
			   case '4':			   
					$this->db->query("DELETE FROM answers WHERE Questions_Content_ID = '".$txt_question_ID."' ");

 					$num_answers_txt = $this->input->post('num_answers')-1;
					$answer_txt = $this->input->post('answer_txt');  
						$count_ans =0 ;
						while($num_answers_txt>=$count_ans){ 
 							$add_answer = array(
								 'Answer'                 =>(string)$answer_txt[$num_answers_txt]  ,
								 'Answer_correct'         =>1  ,
								 'Questions_Content_ID'   =>(string)$txt_question_ID ,
								 'Token'                  =>(string)$this->create_token()
								 );
						    $add_answer =  $this->db->insert('answers', $add_answer); 
						
						$num_answers_txt--;
						}
						
					break;
			   case '5':		   
					$this->db->query("DELETE FROM answers WHERE Questions_Content_ID = '".$txt_question_ID."' ");
	
						$txt_answer     = $this->input->post('txt_answer');	
						$answers_ID     = $this->input->post('txt_answer_ID');	
						$add_answer = array(
								 'Answer'                 =>(string)$txt_answer  ,
								 'Answer_correct'         =>1  ,
								 'Questions_Content_ID'   =>(string)$txt_question_ID ,
								 'Token'                  =>(string)$this->create_token()
								 );
						$this->db->where('ID', (int)$answers_ID);
						$add_answer =  $this->db->update('answers', $add_answer); 

				
					break;
			   case '6':		   
					$this->db->query("DELETE FROM answers WHERE Questions_Content_ID = '".$txt_question_ID."' ");
	
						$txt_attach_answer            = $_FILES['txt_attach_answer']['name'] ;
						$answers_ID                   = $this->input->post('txt_answer_ID');
						$add_answer = array(
								 'Answer'                 =>(string)$txt_attach_answer   ,
								 'Answer_correct'         =>1  ,
								 'Questions_Content_ID'   =>(string)$txt_question_ID ,
								 'Token'                  =>(string)$this->create_token()
								 );
						$this->db->where('ID', (int)$answers_ID);
						$add_answer =  $this->db->update('answers', $add_answer); 
					break;
			   case '7':		   
					$this->db->query("DELETE FROM answers WHERE Questions_Content_ID = '".$txt_question_ID."' ");
	
						
						$txt_answer     = $this->input->post('txt_answer');
 						$add_answer = array(
								 'Answer'                 =>(string)$txt_answer   ,
								 'Answer_correct'         =>1  ,
								 'Questions_Content_ID'   =>(string)$txt_question_ID ,
								 'Token'                  =>(string)$this->create_token()
								 );
						$add_answer =  $this->db->insert('answers', $add_answer); 
					break;

		   }
		 
		return $txt_question_ID ;
	}
	/////del_qui
	public function del_qui($ID)
	{
		
		if($this->db->delete('questions_content',array('ID'=>(int)$ID)))
		{
	 		$this->db->delete('test_questions',array('Questions_ID'  =>(int)$ID));
			$this->db->delete('answers',array('Questions_Content_ID' =>(int)$ID));
	       
		    return TRUE ; 		
		}
		else
		{
			return FALSE ; 
		}
		
	}


	//get_question_exam
	 public function get_all_question($exam_id)
	{
		$query = $this->db->query("select test_questions.Test_ID,test_questions.Questions_ID,test_questions.Questions_ID , questions_types.Name,questions_types.ID AS questions_types_ID ,questions_content.Degree,questions_content.Question,questions_content.Q_attach,questions_content.ID AS questions_content_ID,questions_content.degree_difficulty

from test 
inner join config_emp on config_emp.ID=test.Subject_emp_ID
inner join config_emp as all_emp on all_emp.RowLevelID=config_emp.RowLevelID and  all_emp.SubjectID=config_emp.SubjectID 
inner join test as all_test on all_emp.ID=all_test.Subject_emp_ID
inner join test_questions on test_questions.Test_ID=all_test.ID 
inner join questions_content on test_questions.Questions_ID=questions_content.ID
inner join questions_types on questions_types.ID =questions_content.questions_types_ID

where test_questions.Questions_ID NOT IN  (select Questions_ID from  test_questions as t_Q where t_Q.Test_ID = '".$exam_id."' )
and test.ID='".$exam_id."'
and questions_content.IsActive=1
and all_test.ID!='".$exam_id."'
group by  test_questions.Questions_ID
ORDER BY questions_content.Date_Stm DESC");

		$NumRowResultExam = $query->num_rows() ; 
		
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $query ->result() ;
				
			   return $ReturnExam ; 
			   
			   return TRUE ; 
							 
			  }else{
				  return $NumRowResultExam ; 
				  return FALSE ;}
	}
//insert_question
	 public function add_exist_question($question,$exam_ID)
	 {
	
		$this->db->select('*');
        $this->db->from('test_questions');
		
        $this->db->where('Test_ID', $exam_ID );
        $this->db->where('Questions_ID', $question );
		$ResultContactData = $this->db->get();			
		$NumRowResultContactData  = $ResultContactData->num_rows() ; 
			if($NumRowResultContactData <=0)
			  {
			   (string)$this->Token   = $this->create_token();	
			
				
			   $add_q_t = array(
								 'Test_ID'                =>(int)$exam_ID  ,
								 'Questions_ID'           =>(int)$question ,
								 'Token'                  =>(string)$this->Token
								 );
	
	
			   $Insert_q_t =  $this->db->insert('test_questions', $add_q_t);
		
				return true;
			
			  }
        	else 
			{
			   return false ;
				
			}
	 }	
 }

?>