<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Answer_Exam extends MY_Student_Base_Controller
{
	private $data = array();

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->model(array('emp/exam_new_model','student/answer_exam_model', 'emp/exam_model','admin/setting_model'));

		
		$this->data['UID']            = $this->session->userdata('id');
		$this->data['YearID']         = $this->session->userdata('YearID');
		$this->data['Year']           = $this->session->userdata('Year');
		$this->data['Semester']       = $this->session->userdata('Semester');
		$this->data['Lang']           = $this->session->userdata('language');
	}
	/////////////////////////////////////
	public function answer_exam_header()
	{
	    $Data['Semesters']       = $this->setting_model->get_semesters();
	    $Data['date']            = $this->setting_model->converToTimezone();
		$Data['rowLevelId']      = $this->session->userdata('rowLevelId');
		$Data['classId']         = $this->session->userdata('classId');
		$Data['subjectID']       = $this->uri->segment(4);
		$Data['type']            = $this->uri->segment(5);
		$Data['examID']          = $this->uri->segment(6);
		$Data['task']            = $this->uri->segment(7);
		$Data['SemesterID']      =  $this->input->post('select_semester');
		if(!$Data['SemesterID']){
		    $Data['SemesterID']    =  $this->setting_model->get_semester();
		}
		$Data['exam_details']    = $this->answer_exam_model->get_exams_header($Data);
		$this->load->student_template('answer_exam_list', $Data);

	}
	////////////////////////////////////////////
	public function show_exam()
	{
		$Data['student_id']      = (int)$this->session->userdata('id');
		$Data['type']            = $this->uri->segment(4);
		$Data['examID']         = $this->uri->segment(5);
		$Data['task']            = $this->uri->segment(6);
	
        $num_student = array();
        $query = $this->db->query("SELECT subject_id, num_student FROM test WHERE ID = '" . $Data['examID'] . "'  ")->row_array();
        if (sizeof($query) > 0) {
          $num_student =  $query['num_student'];
        }

        if ($num_student) {
           $num_student = explode(",", $num_student);
        }
        
        $answers  = $this->answer_exam_model->answer_exam($Data['examID'], $Data['student_id']);
        $is_updated = 0;
        foreach ($answers as $row1) {
            if ($row1->is_updated == 1) {
               $is_updated   = $row1->is_updated;
            }
        }

        if (($answers && !(in_array($Data['student_id'], $num_student))) || $is_updated == 1) {
            
            echo " <script> 
              alert('تم حل الامتحان سابقا');
              window.location.replace('".site_url()."/student/answer_exam/answer_exam_header/'+".$Data['subjectID']."+"/"+".$Data['type'].");                       
              </script>";
            
        } else {
		        $Data['exam_details'] = $this->answer_exam_model->get_exam_data((string) $this->data['Lang'],$Data['examID']);
		        $Data['q_details']    = $this->answer_exam_model->get_questions($Data['examID']);
		        $Data['q_answers']    = $this->answer_exam_model->get_answers($Data['examID']);
		       
                $Data['time_consumed'] = $this->answer_exam_model->getConsumedTime($Data);
               // print_r($Data['time_consumed']);die;
                $Data['in_out']        = 'IN';
                $Data['consumed_time'] = $Data['time_consumed'];
                $Data['Timezone']      = $this->setting_model->converToTimezone();
                $this->answer_exam_model->setConsumedTime($Data);
                if($this->session->userdata('type')=='S'||$this->session->userdata('type')=='R'||$this->session->userdata('type')=='A'){
		        $this->load->student_template('answer_exam', $Data);
                    
                }else{
                     $this->load->emp_template('answer_exam', $Data);
                    
                }
		        
        }
   }
	
////////////////////////////////////////
    public function save_test_time_consumed()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $Data['in_out']         = $_POST['inOut'];
        $Data['examID']        = $_POST['examId'];
        $Data['consumed_time']  = $_POST['consumedTime'];
        $Data['student_id']     = $this->session->userdata('id');
        $Data['Timezone']       = $this->setting_model->converToTimezone();

        if ($this->answer_exam_model->setConsumedTime($Data)) {
            $dataResponse["success"] = 1;
        } else {
            $dataResponse["success"] = 0;
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($dataResponse));
    }
    ////////////////////////////////
	public function correction_exam()
	{     
		//   print_r($_POST);die;
	    	$idContact               = (int) $this->session->userdata('id');
	        $Data['Timezone']        = $Timezone = $this->setting_model->converToTimezone();
	        $Data['subjectID']       = $this->input->post("subjectID");
		    $Data['type']            = $this->input->post("type");
		    $Data['examID']          = $test_ID  = $this->input->post("txt_test_ID");
		    $Data['task']            = $this->input->post("task");
	        $Data['in_out']          = 'OUT';
            $Data['consumed_time']   = $this->input->post("txt_time_consumed");
            $Data['student_id']      =  $idContact;
            $Data['Timezone']        = $Timezone;
            $this->answer_exam_model->setConsumedTime($Data);
			$count_types  = 1;
			$test_degree_old= $this->db->query("select sum(Degree)  as student_degree_old ,is_updated from  test_student  where test_id =$test_ID and Contact_ID =$idContact ")->row_array() ; 
			while ($count_types <= 8) {
				$txt_type = 'txt_t_q_ID_' . $count_types;//type of question 
				$txt_type = $this->input->post($txt_type);
				$count_q = 'txt_q_one_count_' . $count_types;//count of question
				$count_q = $this->input->post($count_q);
				$count_q_no =0;
				$count_q_z = 1;

				while ($count_q_z <= $count_q) {
					$q_ID = 'txt_q_ID_' . $txt_type . '_' . $count_q_z;//question ID
					$q_ID = $this->input->post($q_ID);
					$degree =0;
					 $correct_answer= $this->db->query("select ID 
                                    				    from answers 
                                    				    where Answer_correct=1 and Questions_Content_ID=$q_ID")->result(); 
					////////////////////////////////////////switch types
				
					switch ($txt_type) {
						case '1':
					           $ans_correct            = 'radio_' . $count_q_z;
							   $ans_correct            = $this->input->post($ans_correct);
							   $ans_ID                 = 'txt_choice_ID' . $count_q_z;
							   $ans_ID                 = $this->input->post($ans_ID);
							  if(empty($ans_correct)) {
							      foreach($correct_answer as $key=>$value){
							          $this->answer_exam_model->insert_student_degrees($answer_id, $q_ID, $degree,$test_ID,$Timezone,'',$correct_answer[$key]->ID);
							      
							  }}else{
    						    foreach($ans_correct as $key=>$value)
    			                 { 
    			                    $answer_id = $value;
    			                    $ques_answer_correct       =  $this->answer_exam_model->get_ques_answer($q_ID,$answer_id);
    			                    $ques_answer_correct_ID =explode(",",$ques_answer_correct['ID']);
    			                      if(in_array($answer_id,$ques_answer_correct_ID)){
    			                          if($ques_answer_correct['Answer_correct']==1){
    			                            $degree =$ques_answer_correct['Degree'];
    			                          }else{
    			                            $degree =0;
    			                         }
    			                      }else{
    			                          $degree =0;
    			                      }
    							 $this->answer_exam_model->insert_student_degrees($answer_id, $q_ID, $degree,$test_ID,$Timezone,'',$correct_answer[$key]->ID);
			                 }}
							break;
						case '2':
						       //	print_r($answer_id);die;
                               $ans_correct            = 'check_' . $count_q_z;
							   $ans_correct            = $this->input->post($ans_correct);
							   $ans_ID                 = 'txt_multi_choice_ID' . $count_q_z;
							   $ans_ID                 = $this->input->post($ans_ID);
							  
							    if(empty($ans_correct)) {
							      foreach($correct_answer as $key=>$value){
							          $this->answer_exam_model->insert_student_degrees($answer_id, $q_ID, $degree,$test_ID,$Timezone,'',$correct_answer[$key]->ID);
							       }
							        
							    }else{
        						    foreach($ans_correct as $key=>$value)
        			                 { 
        			                   
        			                    $answer_id = $value;
        			                    $ques_answer_correct    =  $this->answer_exam_model->get_ques_answer($q_ID,$answer_id);
        			                    $ques_answer_correct_ID = explode(",",$ques_answer_correct['ID']);
        			                      if(in_array($answer_id,$ques_answer_correct_ID)){
        			                          if($ques_answer_correct['Answer_correct']==1){
        			                            $degree =$ques_answer_correct['Degree'];
        			                          }else{
        			                            $degree =0;
        			                         }
        			                      }else{
        			                          $degree =0;
        			                      }
        							 $this->answer_exam_model->insert_student_degrees($answer_id, $q_ID, $degree,$test_ID,$Timezone,'',$correct_answer[$key]->ID);
			                 }}
							break;
						case '3':
							   $ans_correct            = 'correct_' . $count_q_z;
							   $ans_correct            = $this->input->post($ans_correct);
							   $ans_ID                 = 'txt_correct_ID' . $count_q_z;
							   $ans_ID                 = $this->input->post($ans_ID);
							    if(empty($ans_correct)) {
							      foreach($correct_answer as $key=>$value){
							          $this->answer_exam_model->insert_student_degrees($answer_id, $q_ID, $degree,$test_ID,$Timezone,'',$correct_answer[$key]->ID);
							      }
							        
							    }else{
        						    foreach($ans_correct as $key=>$value)
        			                 { 
        			                   
        			                    $answer_id = $value;
        			                    $ques_answer_correct       =  $this->answer_exam_model->get_ques_answer($q_ID,$answer_id);
        			                    $ques_answer_correct_ID   = explode(",",$ques_answer_correct['ID']);
        			                      if(in_array($answer_id,$ques_answer_correct_ID)){
        			                          if($ques_answer_correct['Answer_correct']==1){
        			                            $degree =$ques_answer_correct['Degree'];
        			                          }else{
        			                            $degree =0;
        			                         }
        			                      }else{
        			                          $degree =0;
        			                      }
        							 $this->answer_exam_model->insert_student_degrees($answer_id, $q_ID, $degree,$test_ID,$Timezone,'',$correct_answer[$key]->ID);
			                 }}
							break;
							
							case '4':
					
    						  $count_answer                        = $this->answer_exam_model->get_answers_by_ques($q_ID);
    						  
    						  foreach($count_answer as $key=>$value)
    						  {
    						      $n =$key+1;
    						   
    						    $ans_txt                           = 'answer_txt_complete_' . $q_ID."_".$n;
    						    $ans_txt                           = $this->input->post($ans_txt);
    						    $answer_id                         = $value->Answer_ID;
			                    $ques_answer_correct               =  $this->answer_exam_model->get_ques_answer($q_ID,$answer_id);
			                    
			                    if(empty($ans_txt)) {
							      foreach($ques_answer_correct as $key=>$value){
							          $this->answer_exam_model->insert_student_degrees($answer_id, $q_ID, $degree,$test_ID,$Timezone,'',$ques_answer_correct[$key]->ID);
							       }
							        
							    }else{      
			                        $rowPices=$ques_answer_correct['Answer'];
									$no_strt_ans=explode('%', $rowPices);
									
			                       if(in_array($ans_txt,$no_strt_ans)){
			                      
                                       $degree =$ques_answer_correct['Degree'];
                                    }
			                         else{
			                            $degree =0;
			                        }
                			                        	
							$this->answer_exam_model->insert_student_degrees($ans_txt, $q_ID, $degree,$test_ID,$Timezone,'',$answer_id);
			                 }
    						  }
		
								break;
						

							case '6':
                               $ans_correct            = 'txt_content_' . $q_ID;
							   $answer_stu              = $this->input->post($ans_correct);
							   $ans_ques               = 'answer_txt_up_' . $count_q_z;
							   $answer_id              = $this->input->post($ans_ques);
							   $hidImg                 = 'hidImg' . $count_q_z;
							   $hidImg                 = $this->input->post($hidImg); 
			                   $degree                 = NULL;
			                   // print_r($answer_stu);die;    
							 $this->answer_exam_model->insert_student_degrees($answer_stu, $q_ID, $degree,$test_ID,$Timezone,$hidImg,$answer_id);
			                
							break;
							
							case '7':
								$ans_txt = 'answers_match_' . $count_q_z;
								$student_answers = $this->input->post($ans_txt);
								$correct_answers = $this->answer_exam_model->get_ques_match_answer($q_ID);
								
								$correct_answers_map = [];
								foreach ($correct_answers as $answer) {
									$key = strip_tags(trim($answer['Answer_match']));
									$correct_answers_map[$key] = [
										'answer' => strip_tags(trim($answer['Answer'])),
										'degree' => $answer['Degree'],
										'ID' => $answer['ID']
									];
								}
								
								foreach ($student_answers as $student_answer) {
									list($answer_match, $answer) = explode('___', trim($student_answer));
									
									$clean_student_match = strtolower(preg_replace('/\s+/', ' ', strip_tags($answer_match)));
									$clean_student_answer = strtolower(preg_replace('/\s+/', ' ', strip_tags($answer)));
									
									$degree = 0;
									$answer_id = null;
								
									foreach ($correct_answers_map as $key => $value) {
										if ($clean_student_match == strtolower(preg_replace('/\s+/', ' ', $key)) &&
											$clean_student_answer == strtolower(preg_replace('/\s+/', ' ', $value['answer']))) {
											$degree = $value['degree'];
											$answer_id = $value['ID'];
											break;
										}
									}
								
									$this->answer_exam_model->insert_student_degrees($answer_id, $q_ID, $degree, $test_ID, $Timezone, '', $student_answer);
								}
								
					
			                 	break;
						

							case '8':
                             
								$studentDraw       = $this->input->post('studentDraw');
								$data              = json_decode($studentDraw[0], true); 
								$degree            = NULL;
								foreach($data as $img){
									
									$q_ID   = $img['id'];
									$hidImg = $img['answer'];
									$this->answer_exam_model->insert_student_degrees('', $q_ID, $degree,$test_ID,$Timezone,'',$hidImg);
									
								}
						default:
					}
					///////////////////////////////////////end switch types
					$count_q_z++;
				} //end count questions
				$count_types++;
			} //end count types

			////// points 

		
	        redirect('home/home/Reg_exam', 'refresh');
	
		               

	}

	//sees_answer
	public function sees_answer()
	{

		(int) $Data['exam_id'] = (int) $this->uri->segment(4);
		$Data['dash'] = (int) $this->uri->segment(5);
		if($Data['dash'] == ''){
		$Data['task'] = $this->uri->segment(5);
		}else{
		    $Data['task'] = $this->uri->segment(6);
		}

		if (isset($Data['exam_id']) && $Data['exam_id'] != 0) {
			$this->session->set_userdata('ExamID', (int) $Data['exam_id']);
			redirect('/student/answer_exam/show_exam/'.$Data['exam_id']."/".$Data['dash']."/".$Data['task'], 'refresh');
		}
	}
	public function after($chr, $inthat)
	{
		if (!is_bool(strpos($inthat, $chr)))
			return substr($inthat, strpos($inthat, $chr) + strlen($chr));
	}
	public function after_last($chr, $inthat)
	{
		if (!is_bool(strrevpos($inthat, $chr)))
			return substr($inthat, strrevpos($inthat, $chr) + strlen($chr));
	}
	public function before($chr, $inthat)
	{
		return substr($inthat, 0, strpos($inthat, $chr));
	}
	public function before_last($chr, $inthat)
	{
		return substr($inthat, 0, strrevpos($inthat, $chr));
	}
	public function between($chr, $that, $inthat)
	{
		return before($that, after($chr, $inthat));
	}
	public function between_last($chr, $that, $inthat)
	{
		return after_last($chr, before_last($that, $inthat));
	}

	
	
		public function ExamReport($date='0', $test_id="0")

	{ /*	$this->data['test']         = $this->uri->segment(9); 
		$this->data['subjectID']         = $this->uri->segment(8); 
		$this->data['from']      = $this->uri->segment(5);
		$this->data['to']         = $this->uri->segment(6);
		$this->data['num']         = $this->uri->segment(7);
		$this->data['show']            = $this->uri->segment(4);
		
		*/
	       $DayDateFrom=$this->input->post("from");
	       $DayDateTo=$this->input->post("to"); 
	       $subjectID=$this->input->post("subjectID"); 
	       $student_id=$this->data['UID'];
	   //2020-10-102020-10-13
	   //23901
	   if($subjectID!=''){
     $subjectID=$subjectID; 
	   }else{
     $subjectID=''; 
	   }
	   if($DayDateFrom!=''){
     $fromdate=$DayDateFrom.' 00:00:00.000000'; //echo '7<br>';
	   }elseif($date!='0'){
     $fromdate=$date.' 00:00:00.000000'; //echo '7<br>';
	   }else{
     $fromdate=''; //echo '7<br>';
	   }
	   if($DayDateFrom!=''){
      $todate=$DayDateTo.' 23:59:59.999999';  //echo '8<br>';
	   }elseif($date!='0'){
     $todate=$date.' 23:59:59.999999'; //echo '7<br>';
	   }else{
      $todate='';  //echo '8<br>';
	   }
    
    //	SET @p0='79124'; SET @p1=''; SET @p2=''; SET @p3=''; SET @p4=''; SET @p5=''; SET @p6=''; SET @p7='2020-07-01 15:15:47.000000'; SET @p8='2020-09-30 15:15:47.000000'; SET @p9=''; CALL `Usp_GetMeetingAttendDetails_ByStudent`(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7, @p8, @p9); 
if($student_id ==''  ){
    
      $Data['GetData'] =  '';  
}else{ 
    
    
  //  SET @p0=''; SET @p1='49748'; SET @p2=''; SET @p3=''; SET @p4=''; SET @p5=''; SET @p6='2020-10-10 10:52:59.000000';
   // SET @p7='2020-10-13 10:52:59.000000'; CALL `Usp_GetStudentExamsResult`(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7);
    
    
 
  $a_procedure = "CALL `Usp_GetStudentExamsResult`(?, ?, ?, ?, ?, ?, ?, ?)";
$query = $this->db->query( $a_procedure, array('p0'=>'','p1'=>$student_id,'p2'=>$subjectID,'p3'=>'','p4'=>'','p5'=>'','p6'=>$fromdate,'p7'=>$todate) );
$res      = $query->result();  
// echo $this->db->last_query(); die;
mysqli_next_result( $this->db->conn_id );  

      $Data['GetData'] =  $res;
     // print_r($res);die;
      $Data['test_id'] =  $test_id;   
    
}
  
      
		$this->load->student_template('ExamReport',$Data);
   
	}
	
	
	function contains($haystack, $needle, $caseSensitive = false) {
    return $caseSensitive ?
            (strpos($haystack, $needle) === FALSE ? FALSE : TRUE):
            (stripos($haystack, $needle) === FALSE ? FALSE : TRUE);
}


/**
 * Studeen Show exam correct Answers 
 */
public function corrextAnswer(){
	$Data['test_id']               =$this->input->get('testID');
	
	if ($Data['test_id']) {
			$Data['test_data']         = $this->exam_new_model->get_test_data($Data['test_id']);
			$Data['questions']         = $this->exam_new_model->get_question($Data['test_id']);
			$Data['exam_student']          = $this->exam_new_model->get_exam_student($Data['test_id']);
			// dd($Data);
		}
		$this->load->student_template('exam/correct_answer',$Data);

}

function startsWith($string, $startString) { 
  $len = strlen($startString); 
  return (substr($string, 1, $len) === $startString); 
} 


	
   
}