<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Answer_Exam extends CI_Controller {
	private $data = array() ;
		
    function __construct()
    {
        parent::__construct();     
		$this->load->helper(array('form', 'url'));	
		$this->load->model(array('home/answer_exam_model','emp/subject_model','emp/exam_model','emp/config_model'));
	
    }
	
	public function index()
	{
     $Data['exam_details']    = $this->answer_exam_model->get_exams((string) $this->data['Lang'] ); //print_r($this->db->last_query());
	 $this->load->home_template('answer_exam_list',$Data);
	 
	}
	public function Reg_exam()
	{
     $Data['exam_details']    = $this->answer_exam_model->get_exam_reg(); 
    // print_r($this->db->last_query() );
	 $this->load->home_template('answer_exam_list',$Data);
	}
	public function Adv_exam()
	{
     $Data['exam_details']    = $this->answer_exam_model->get_exam_adv(); 
	 $this->load->home_template('answer_exam_adv',$Data);
	}
	public function answer_exam_header()
	{
                 $subjectID= (int)$this->uri->segment(4);
		         $Data['exam_details']    = $this->answer_exam_model->get_exams_header((string) $this->data['Lang'],$subjectID );
 				 $this->load->home_template('answer_exam_list',$Data);
	}
//sees_answer
	public function sees_answer()
	{
		
		(int)$Data['exam_id'] = (int)$this->uri->segment(4);
		//print_r($Data['exam_id'] );
		if(isset($Data['exam_id'])&&$Data['exam_id']!=0 )
		{
			$this->session->set_userdata('ExamID',(int)$Data['exam_id'])  ;
			redirect('/job/answer_exam/show_exam');

		}
				 
	}
//show_exam
public function show_exam()
	{
		 $Data['exam_details'] = $this->answer_exam_model->get_exam_no_rpt((string) $this->data['Lang'] );
		 $Data['q_details'] = $this->answer_exam_model->get_questions((string) $this->data['Lang'] );
		 $Data['q_answers'] = $this->answer_exam_model->get_answers((string) $this->data['Lang'] ); 
		 $this->load->home_template('answer_exam',$Data);
	}
//correction_exam
public function correction_exam()
	{
		$idContact           =(int)$this->session->userdata('id');
$subjectID =  $this->answer_exam_model->get_exam_subject($this->input->post("txt_test_ID")); 
		if(isset($_SERVER['HTTP_REFERER'])){
		$count_types=1;
		$crct_ans_t_1=0;
		$crct_ans_t_2=0;
		$crct_ans_t_3=0;
		$crct_ans_t_4=0;
		$crct_ans_t_5=0;
		$crct_ans_t_6=0;
		$crct_ans_t_7=0;
		while($count_types<=7){
			$txt_type = 'txt_t_q_ID_'.$count_types;
			$txt_type = $this->input->post($txt_type);
			$count_q = 'txt_q_one_count_'.$count_types;
			$count_q = $this->input->post($count_q);
			$count_q_z = 1;
			
			while($count_q_z<=$count_q){		
				$q_ID = 'txt_q_ID_'.$txt_type.'_'.$count_q_z;
				$q_ID = $this->input->post($q_ID);
			////////////////////////////////////////switch types
			switch($txt_type){
				case'1':
					$ans_ID            = 'radio_'.$count_q_z;
					$ans_ID            = $this->input->post($ans_ID);
					$q_old_id_1 =  array();
					if($ans_ID !=""){
						$degree_1      = (int) $this->answer_exam_model->check_answer($ans_ID , $q_ID);
						$crct_ans_t_1 += $degree_1;
						$q_old_id_1[$q_ID]=$degree_1;
					}else{
						$degree_1=0;
						$q_old_id_1[$q_ID]=$degree_1;
						}
					//end check empty answer
					$this->answer_exam_model->insert_student_degrees($ans_ID ,$q_old_id_1,$idContact);
				break;
				case'2':
				$data            =  $this->answer_exam_model->get_degree($q_ID);
				$dataCorrect     =  $this->answer_exam_model->get_answer_correct_count($q_ID);
				$dataAnswers     =  $this->answer_exam_model->get_answer_correct($q_ID);
				$for_count=0;
                                $answer_student  =  '';
		       	foreach($dataAnswers as $row ){
				   $answers_correct[$for_count] = $row->Answer_ID;
				   $for_count++;
				   }
				
				$countRows       =  $data['countRows'];	
				$Degree          =  $data['Degree'];	
				$countAnsCorrect =  $dataCorrect['countAnsCorrect'];
				$q_degree        = 	$Degree /$countAnsCorrect;
				$if_fail=1;
				$count_answers = 1;	
				$q_old_id_2 =  array();				
				$all_degree_2 =$crct_ans_t_2;

				while($count_answers<=$countRows){
					$ans_ID            = 'check_'.$count_q_z.'_'.$count_answers;
					$ans_ID            = $this->input->post($ans_ID);
 if( $answer_student!=""){$answer_student =$answer_student+' , '+$ans_ID;}else{$answer_student = $ans_ID;}
					if($ans_ID!=""){
						if(in_array($ans_ID,$answers_correct)){
							$degree_2      = $q_degree;
							$crct_ans_t_2 +=$q_degree;
							if(isset($q_old_id_2[$q_ID])){
								if($q_old_id_2[$q_ID]!=0){
									$q_old_id_2[$q_ID]+=$degree_2;
								}
							}else{
								$q_old_id_2[$q_ID]=$degree_2;
								} 
							$if_fail=0;							
						}else{
							$degree_2=0;
							$q_old_id_2[$q_ID]=$degree_2;
							$if_fail=1;
						}
					 }
					 $count_answers++;
					}
					if($if_fail===1){
						$crct_ans_t_2=$all_degree_2;
					    $degree_2=0;
						$q_old_id_2[$q_ID]=$degree_2;
					}
					//end check empty answer*/
					$this->answer_exam_model->insert_student_degrees($answer_student,$q_old_id_2,$idContact);
				break;
				case'3':
					$ans_ID            = 'correct_'.$count_q_z;
					$ans_ID            = $this->input->post($ans_ID);
					$q_old_id_3 =  array();
					if($ans_ID !=""){
						$degree_3 =(int)$this->answer_exam_model->check_answer($ans_ID , $q_ID);
						$crct_ans_t_3 +=  $degree_3;
						$q_old_id_3[$q_ID]=$degree_3;
					}else{
						$degree_3 =0;
						$q_old_id_3[$q_ID]=$degree_3;
						}
					$this->answer_exam_model->insert_student_degrees($ans_ID,$q_old_id_3,$idContact);
				break;
				case'4':
					$data            =  $this->answer_exam_model->get_degree($q_ID);
					$dataCorrect     =  $this->answer_exam_model->get_answer_correct_count($q_ID);
					$countRows       =  $data['countRows'];	
					$Degree          =  $data['Degree'];	
					$countAnsCorrect =  $dataCorrect['countAnsCorrect'];
					$q_degree        = 	$Degree /$countAnsCorrect;
 $answer_student ="";
					$if_fail=1;
					$count_answers = 1;	
					$q_old_id_4 =  array();
					$all_degree_2 =$crct_ans_t_3;
					while($count_answers<=$countRows){
						$ans_txt            = 'answer_txt_complete_'.$count_q_z.'_'.$count_answers;
						
						$ans_txt            = $this->input->post($ans_txt);


 if( $answer_student!=""){$answer_student =$answer_student+' , '+$ans_txt;}else{$answer_student = $ans_txt;}
						if($ans_txt!=""){
							$data_answer    =  $this->answer_exam_model->get_answer($q_ID);
							$count_for_each=1;
							$no_strt_ans="";
							foreach($data_answer as $row){
								if($count_for_each==$count_answers){
									$pieces = explode("|", $row->Answer);
									foreach($pieces as $rowPices){
										if(substr_count($rowPices, "%")==2){
											$no_strt_ans = $this->after( '%',$rowPices);
											$no_strt_ans = $this->before('%',$no_strt_ans);
											if(strstr($ans_txt,$no_strt_ans)!=false){
												$crct_ans_t_4+=$q_degree;
												$degree_4=$q_degree;
												if(isset($q_old_id_4[$q_ID])){
													if($q_old_id_4[$q_ID]!=0){
														$q_old_id_4[$q_ID]+=$degree_4;
													}
												}else{
													$q_old_id_4[$q_ID]=$degree_4;
													} 
												}
											}else if(substr_count($rowPices, "%")==1){
												$pos = strripos($rowPices,"%");
												if($pos==0){
													$no_strt_ans = $this->after( '%',$rowPices);
													if(strripos($ans_txt,$no_strt_ans)>=1){
														$crct_ans_t_4+=$q_degree;
														$degree_4=$q_degree;
														if(isset($q_old_id_4[$q_ID])){
															if($q_old_id_4[$q_ID]!=0){
																$q_old_id_4[$q_ID]+=$degree_4;
															}
														}else{
															$q_old_id_4[$q_ID]=$degree_4;
															} 
														}
													}else{
														$no_strt_ans = $this->before('%',$rowPices);
														$pos_answers = strpos($ans_txt, $no_strt_ans);
														if ($pos !== false) {
															$crct_ans_t_4+=$q_degree;
															$degree_4=$q_degree;
															if(isset($q_old_id_4[$q_ID])){
																if($q_old_id_4[$q_ID]!=0){
																	$q_old_id_4[$q_ID]+=$degree_4;
																}
															}else{
																$q_old_id_4[$q_ID]=$degree_4;
																} 
														}
														}
												}
											else{
												if($ans_txt==$rowPices){
													$crct_ans_t_4+=$q_degree;
													$degree_4=$q_degree;
													if(isset($q_old_id_4[$q_ID])){
														if($q_old_id_4[$q_ID]!=0){
															$q_old_id_4[$q_ID]+=$degree_4;
														}
														}else{
															$q_old_id_4[$q_ID]=$degree_4;
															} 
													}
												}
										}
								}
								$count_for_each++;
								}
						 }
						$count_answers++;
						}
						if($if_fail===0){
							$degree_4=0;
							$q_old_id_4[$q_ID]=$degree_4;
							}
						//end check empty answer*/
						$this->answer_exam_model->insert_student_degrees($answer_student,$q_old_id_4,$idContact);
				break;
				case'5':
					$data            =  $this->answer_exam_model->get_degree($q_ID);
					$dataCorrect     =  $this->answer_exam_model->get_answer_correct_count($q_ID);
					$countRows       =  $data['countRows'];	
					$Degree          =  $data['Degree'];	
					$countAnsCorrect =  $dataCorrect['countAnsCorrect'];
					$q_degree        = 	$Degree ;
					$if_fail=1;	
					$q_old_id_5 =  array();
					$count_answers = 1;	
					while($count_answers<=$countRows){
						$ans_txt            = 'answer_txt_mean_'.$count_q_z.'_'.$count_answers;
						$ans_txt            = $this->input->post($ans_txt);
						if($ans_txt!=""){
							$data_answer    =  $this->answer_exam_model->get_answer($q_ID);
							$count_for_each=1;
							$no_strt_ans="";
							foreach($data_answer as $row){
								if($count_for_each==$count_answers){
									$pieces = explode("|", $row->Answer);
									foreach($pieces as $rowPices){
										if(substr_count($rowPices, "%")==2){
											$no_strt_ans = $this->after( '%',$rowPices);
											$no_strt_ans = $this->before('%',$no_strt_ans);
											if(strstr($ans_txt,$no_strt_ans)!=false){
												$crct_ans_t_5+=$q_degree;
												$degree_5=$q_degree;
												if(isset($q_old_id_5[$q_ID])){
													if($q_old_id_5[$q_ID]!=0){
														$q_old_id_5[$q_ID]+=$degree_5;
													}
												}else{
													$q_old_id_5[$q_ID]=$degree_5;
													} 
												}
											}else if(substr_count($rowPices, "%")==1){
												$pos = strripos($rowPices,"%");
												if($pos==0){
													$no_strt_ans = $this->after( '%',$rowPices);
													if(strripos($ans_txt,$no_strt_ans)>=1){
														$crct_ans_t_5+=$q_degree;
														$degree_5=$q_degree;
														if(isset($q_old_id_5[$q_ID])){
															if($q_old_id_5[$q_ID]!=0){
																$q_old_id_5[$q_ID]+=$degree_5;
															}
														}else{
															$q_old_id_5[$q_ID]=$degree_5;
															} 	
														}
													}else{
														$no_strt_ans = $this->before('%',$rowPices);
														$pos_answers = strpos($ans_txt, $no_strt_ans);
														if ($pos !== false) {
															$crct_ans_t_5+=$q_degree;
															$degree_5=$q_degree;
															if(isset($q_old_id_5[$q_ID])){
																if($q_old_id_5[$q_ID]!=0){
																	$q_old_id_5[$q_ID]+=$degree_5;
																}
															}else{
																$q_old_id_5[$q_ID]=$degree_5;
																} 	
														}
														}
												}
											else{
												if($ans_txt==$rowPices){
													$crct_ans_t_5+=$q_degree;
													$degree_5=$q_degree;
													if(isset($q_old_id_5[$q_ID])){
														if($q_old_id_5[$q_ID]!=0){
															$q_old_id_5[$q_ID]+=$degree_5;
														}
													}else{
														$q_old_id_5[$q_ID]=$degree_5;
														} 	
													}
												}
										}
								}
								$count_for_each++;
								}

						 }
						$count_answers++;
						}
						if($if_fail===0){$crct_ans_t_5=$all_degree_2;}
						//end check empty answer*/
						$this->answer_exam_model->insert_student_degrees($ans_txt ,$q_old_id_5,$idContact);
				break;
				case'6':
				    $case_6 =1;
					$txt_attach   = "answer_txt_upload_".$count_q_z;
					$txt_attach_f = $_FILES[$txt_attach]['name'];	
					
					if(!empty($txt_attach_f)){
						$config['upload_path'] = './upload/';
						$config['allowed_types'] = 'txt|doc|rtf|ppt|pdf|swf|flv|avi|wmv|mov|jpg|jpeg|gif|png|mp4|mp3|rar|avi|wmv|xlsx|docx|pptx|ppsx|zip|wmv|vob|swf|srt|rm|mpg|mp4|mov|m4v|flv|avi|asx|asf|3gp|3g2|mp4|aif|iff|m3u|m4a|mid|mp3|mpa|ra|wav|wma|gif|jpg|png|bmp|tiff|wmf|EMF';
						$this->load->library('upload', $config);
						if ( ! $this->upload->do_upload($txt_attach ))
						{
							$error = array('error' => $this->upload->display_errors());
				
							print_r($error);
						}
					}
					$this->answer_exam_model->insert_upload_answer($txt_attach_f,$q_ID);
				break;
				case'7':
				    $q_old_id_7 =  array();
					$ans_ID            = 'txt_answer_ID_'.$count_q.'_'.$count_q_z;
					$ans_ID            = $this->input->post($ans_ID);
					$all_answer        = $this->input->post("all_answer_".$count_q_z);
					$crct_ans_t_7 +=(int)$this->answer_exam_model->check_del_answer($ans_ID , $q_ID,$all_answer,$count_q_z,$idContact);
					$q_old_id_7[$q_ID]=$crct_ans_t_7;
				break;
				default:
				
				}
			///////////////////////////////////////end switch types
			$count_q_z++;
			}//end count questions
			$count_types++;
			}//end count types
			
			$q_old_id      =  array();	
			if(isset($q_old_id_1)){$q_old_id =array_merge($q_old_id,$q_old_id_1);}
			if(isset($q_old_id_2)){$q_old_id =array_merge($q_old_id,$q_old_id_2);}
			if(isset($q_old_id_3)){$q_old_id =array_merge($q_old_id,$q_old_id_3);}
			if(isset($q_old_id_4)){$q_old_id =array_merge($q_old_id,$q_old_id_4);}
			if(isset($q_old_id_5)){$q_old_id =array_merge($q_old_id,$q_old_id_5);}
			if(isset($q_old_id_7)){$q_old_id =array_merge($q_old_id,$q_old_id_7);}
			$this->answer_exam_model->not_answer($q_old_id);
			if($crct_ans_t_6!=1){
					$result_exam = $crct_ans_t_1+$crct_ans_t_2+$crct_ans_t_3+$crct_ans_t_4+$crct_ans_t_5+$crct_ans_t_7;
					$txt_test_ID = $this->input->post("txt_test_ID");
					$messa_flash = 'درجتك :'.$result_exam.'.سيتم تصحيح السؤال المقالى وإرسال النتيجة لك .' ; 
				}else{
					$result_exam = $crct_ans_t_1+$crct_ans_t_2+$crct_ans_t_3+$crct_ans_t_4+$crct_ans_t_5;
					$txt_test_ID = $this->input->post("txt_test_ID");
					$messa_flash = 'درجتك :'.$result_exam; 
					}	
					
			redirect('home/answer_exam/answer_exam_header/'.$subjectID, 'refresh'); 
					}else{
					
			redirect('home/answer_exam/answer_exam_header/'.$subjectID, 'refresh'); 
						  }//end httprefer
			
	}
public function after ($chr, $inthat)
    {
        if (!is_bool(strpos($inthat, $chr)))
        return substr($inthat, strpos($inthat,$chr)+strlen($chr));
    }
public function after_last ($chr, $inthat)
    {
        if (!is_bool(strrevpos($inthat, $chr)))
        return substr($inthat, strrevpos($inthat, $chr)+strlen($chr));
    }
public function before ($chr, $inthat)
    {
        return substr($inthat, 0, strpos($inthat, $chr));
    }
public function before_last ($chr, $inthat)
    {
        return substr($inthat, 0, strrevpos($inthat, $chr));
    }
public function between ($chr, $that, $inthat)
    {
        return before ($that, after($chr, $inthat));
    }
public function between_last ($chr, $that, $inthat)
    {
     return after_last($chr, before_last($that, $inthat));
    }
}

