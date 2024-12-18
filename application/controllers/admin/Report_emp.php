<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Report_Emp extends MY_Admin_Base_Controller{

	private $data = array() ;

	function __construct()

    {

	   parent::__construct();

	   $this->load->model(array('admin/Permission_model','emp/homework_model','emp/clerical_homework_model','emp/homework_new_model','e_library_model','emp/question_new_model', 'emp/config_model','emp/lessons_model','emp/exam_new_model','emp/subject_model','report/report_emp_model','config/config_class_table_model','emp/report_student_eval_model'
                               ,'admin/setting_model','admin/Exam_result_model','admin/Permission_model','emp/emp_class_table_model' , 'admin/admin_model','admin/User_permission_model','admin/user_permission_model','admin/skills_model','admin/report_statistical_model' ,'admin/students_affairs_model'

							   ));

	   $this->load->library('get_data_admin');

	   $this->data['UID']            = $this->session->userdata('id');

	   $this->data['YearID']         = $this->session->userdata('YearID');

	   $this->data['Year']           = $this->session->userdata('Year');

	   $this->data['Semester']       = $this->session->userdata('Semester');

	   $this->data['Lang']           = $this->session->userdata('language');
	   
	   $get_api_setting=$this->setting_model->get_api_setting(); 
	   
	   $this->ApiDbname=$get_api_setting[0]->{'ApiDbname'};

    }

	////// this functio for use to test 
public function test()

	{
		$getStatusPremission = false;
		// check user in premission group 
		$checkpremissionGroup = $this->db->query('
        		select contact.type as typeUser, employee.Type , PerType from  employee 
        		inner join contact on contact.ID = employee.Contact_ID
        		where Contact_ID = "'.$this->session->userdata('id').'"  and contact.GroupID != 0 
				');
				// if have premission 
			if($checkpremissionGroup->num_rows() > 0) {
				$getStatusPremission = true;
				$getType = $checkpremissionGroup->row();
			}else{
				
				// if dont have premission check in premission user not group 
				$checkpremissionPage = $this->db->query("
				SELECT  * 
				FROM
				user_permission
				WHERE 
				EmpID = '".$this->session->userdata('id')."' 
				AND CURDATE() between DateFrom and DateTo ");
				if($checkpremissionPage->num_rows() > 0) {
					
					$getStatusPremission = true;
					$getType = $checkpremissionPage->row();
				}

			}	
		// if user have any  premission show report for emp 
		if($getStatusPremission){
				$this->data['getType'] = $getType; // getType for use in get_type_one
				// helper function name  add in view  get_type_one($getType->Type,$getType->PerType)
                $this->load->admin_template('view_test_premission',$this->data);
		}else{
			// admin report page
            $this->load->admin_template('view_get_emp_report',$this->data);
		}
	}
	public function report_all_school( $LevelID = 0 , $RowLevelID = 0 , $classID = 0 , $subjectID = 0 )
	{
		if($LevelID == 0 ){ $this->data['LevelID'] = 'NULL'; }else{ $this->data['LevelID'] = (int)$LevelID;  }
		if($RowLevelID == 0 ){ $this->data['RowLevelID'] = 'NULL'; }else{ $this->data['RowLevelID'] = (int)$RowLevelID;  }
		if($classID == 0 ){ $this->data['classID'] = 'NULL'; }else{ $this->data['classID'] = (int)$classID;  }
		if($subjectID == 0 ){ $this->data['subjectID'] = 'NULL'; }else{ $this->data['subjectID'] = (int)$subjectID;  }
        $this->load->admin_template('view_get_emp_report_school',$this->data);
	}
	public function index()

	{
	
       $this->load->admin_template('view_get_emp_report',$this->data);
	
	}
////////////////////////////////////////////
	public function get_data( $show = NULL , $LevelID = 0 , $RowLevelID = 0 , $classID = 0 , $subjectID = 0 , $order = 0 , $DayDateFrom = 'NULL' , $DayDateTo = 'NULL' )

	{
		 if($LevelID == 0 ){ $LevelID = 'NULL'; }else{ $LevelID = (int)$LevelID;  }
		 if($RowLevelID == 0 ){ $RowLevelID = 'NULL'; }else{ $RowLevelID = (int)$RowLevelID;  }
		 if($classID == 0 ||$classID==''){ $classID = 'NULL'; }else{ $classID = (int)$classID;  }
		 if($subjectID == 0 ){ $subjectID = 'NULL'; }else{ $subjectID = (int)$subjectID;  }
		 if($DayDateFrom == 'NULL'){ $DayDateFrom = 'NULL'; }
		 $dataResponse['data'] = $this->report_emp_model->get_all_emp($this->data['Lang'] , $LevelID , $RowLevelID , $classID , $subjectID ,$DayDateFrom , $DayDateTo );
         $this->output->set_content_type('application/json')->set_output(json_encode($dataResponse));
	}
/////////////////////////////////////////////////////
	public function get_teacher_weeks_data($TeacherID=0, $week = 0 ,$SemesterID =0 )
	{
	
       $data['get_semester'] = $this->data['Semester']  ;

		$data['get_class']   = $this->emp_class_table_model->get_emp_class($this->data['Lang'],$TeacherID);
 
        $data['TeacherID']      = $this->uri->segment(4);	
        
        $data['week']           = $this->uri->segment(5);	
        
        $data['SemesterID']     = $this->uri->segment(6);
        
        $data['group_day']      = $this->uri->segment(7);
        
        if($data['group_day']){
            
            $data['group_day']      = $this->uri->segment(7);
            
        }else{
            
            $data['group_day']      = 1;
        }
		
		if($data['SemesterID']){
		    
		$data['get_week']    = $this->setting_model->get_week_per_semester($SemesterID);
		
		}
            
		$data['GetFile']     =  $this->emp_class_table_model->get_file_week($data['week'] , $data['SemesterID'] ,$TeacherID,$data['group_day']);
		$data['GetFile2']   = $this->emp_class_table_model->get_file_week_emp($data['week'] , $data['SemesterID'] , $TeacherID ,$data['group_day'] );
		if($this->emp_class_table_model->get_base_id())

		{

			$data['UID']                  = $TeacherID;

			$data['BaseClassTableID']     = (int)$this->emp_class_table_model->get_base_id();

			$data['Lang']                 = (string)$this->session->userdata('language');

			$data['getDay']               = $this->emp_class_table_model->get_day($data['Lang']);

			$data['get_max_numlesson']    = $this->config_class_table_model->get_max_numlesson();

			$data['get_row_level']        = $this->emp_class_table_model->get_row_level($data['Lang']);

			$data['get_subject']          = $this->emp_class_table_model->get_subject();

			$data['getclass']             = $this->emp_class_table_model->getclass($data['Lang']);

			$data['get_lesson']           = $this->emp_class_table_model->get_lesson_by_group_day($data);
			$this->load->admin_template('view_report_teacher_plan_weeks',$data);
			



		}else{

			    $data['Msg'] = lang('error_class_table') ; $this->load->emp_template('view_error',$data);

			 }
	}

	public function get_teacher_libiraries($TeacherID=0, $LevelID = 0 , $RowLevelID = 0 , $classID = 0 , $subjectID = 0 , $DayDateFrom = 'NULL' , $DayDateTo = 'NULL'  )
	{
		$teacherData['data'] = $this->report_emp_model->get_teacher_libiraries($TeacherID,$LevelID,$RowLevelID,$classID,$subjectID,$DayDateFrom,$DayDateTo);

		$this->load->admin_template('view_report_teacher_libiraries',$teacherData);
	}

	public function get_teacher_libirary_details($ID,$ContactID = 0, $RowLevelID = 0 , $SubjectID  = 0  , $SemesterID = 0 )
	{
		$MethodID = "1";
		$Data['SubjectID']         = $SubjectID  ;
		$Data['RowLevelID']        = $RowLevelID   ;
		$Data['SemesterIDUrl']     = $SemesterID  ;
		$Data['ContactID']         = $ContactID  ;
		$Data['e_libraryID']       = $ID  ;
		$Data['PageTitle']  	   = lang('Methodological_Materials_Library');
		$Data['Method']  		   = "1";
		$Data['mLib'] 			   = $this->e_library_model->load_methodLib_one($Data);
		$Data['Semesters']  	   = $this->e_library_model->get_semesters();
		$this->load->admin_template('review_m_library',$Data);	}

	public function get_teacher_tests($TeacherID=0, $LevelID = 0 , $RowLevelID = 0 , $classID = 0 , $subjectID = 0 , $DayDateFrom = 'NULL' , $DayDateTo = 'NULL'  )
	{
		$teacherData['data'] = $this->report_emp_model->get_teacher_tests($TeacherID,$LevelID,$RowLevelID,$classID,$subjectID,$DayDateFrom,$DayDateTo);		
		$this->load->admin_template('view_report_teacher_tests',$teacherData);
	}

	public function get_teacher_test_details($TeacherID=0)
	{
		$Data['id']                 = $TeacherID;	
		$Data['subjectEmp_details'] = $this->subject_model->get_Subjects_emp();		
		$Data['exam_details_edit']  = $this->exam_new_model->get_specific_exam($Data['id']   ,(string)$this->data['Lang']);
		
		if($Data['exam_details_edit'] !=0){
		    foreach($Data['exam_details_edit']  as $key=>$row){
		       if($key==0){
		        
        	    $Data['SubjectID']   = $row->SubjectID_subject;
        	    $Data['RowLevelID']   =$row->RowLevelID;
        	    $Data['SemesterID']   =$row->ID_sms;
		       }
		    
		}}else{
		    
		    $Data['SubjectID']   = 0;
	        $Data['RowLevelID']   =0;
	        $Data['SemesterID']   =0;
		}  
		$Data['lessonsTitles'] = $this->lessons_model->get_lessons_prep($Data);
		
		
		
		$Data['GetSemester']        = $this->config_model->get_semester((string)$this->data['Lang']);
		$Data['Type_question']      = $this->question_new_model->get_Type_question();
		$Data['question']           = $this->question_new_model->get_question_exam($Data['id']);
		if($this->exam_new_model->get_specific_exam($Data['id']   ,(string)$this->data['Lang']))
			{
			  $this->load->admin_template('exam_details',$Data);
			}
			 else{echo 'error';}
	}

	public function get_teacher_homeWorks($TeacherID=0, $LevelID = 0 , $RowLevelID = 0 , $classID = 0 , $subjectID = 0 , $DayDateFrom = 'NULL' , $DayDateTo = 'NULL'  )
	{
		$teacherData['data'] = $this->report_emp_model->get_teacher_homeWorks($TeacherID,$LevelID,$RowLevelID,$classID,$subjectID,$DayDateFrom,$DayDateTo);	

		$this->load->admin_template('view_report_teacher_homeworks',$teacherData);
	}

	public function get_teacher_homeWork_details()
	{
		$Data['id']                 = (int)$this->uri->segment(4);	
		$Data['subjectEmp_details'] = $this->subject_model->get_Subjects_emp();		
		$Data['exam_details_edit']  = $this->homework_new_model->get_specific_exam($Data['id']   ,(string)$this->data['Lang']);
		$Data['GetSemester']        = $this->config_model->get_semester((string)$this->data['Lang']);
		$Data['Type_question']      = $this->question_new_model->get_Type_question();
		$Data['question']           = $this->question_new_model->get_question_exam($Data['id']);
 		if($this->homework_new_model->get_specific_exam($Data['id']   ,(string)$this->data['Lang']))
		{
			$this->load->admin_template('view_report_teacher_homework_details',$Data);
		}

		else{echo 'error';}
	}
	
	
	public function get_teacher_lessonPreps($TeacherID=0, $LevelID = 0 , $RowLevelID = 0 , $classID = 0 , $subjectID = 0 , $DayDateFrom = 'NULL' , $DayDateTo = 'NULL'  )
	{
	  $TeacherID=  $Data['TeacherID'] =$this->uri->segment(4);
	   $LevelID= $Data['LevelID'] =$this->uri->segment(5);
	   $RowLevelID= $Data['RowLevelID'] =$this->uri->segment(6);
	  $classID=  $Data['classID'] =$this->uri->segment(7);
	   $subjectID= $Data['subjectID'] =$this->uri->segment(8);
	    $DayDateFrom=$Data['DayDateFrom'] =$this->uri->segment(9);
	   $DayDateTo= $Data['DayDateTo'] =$this->uri->segment(10);
		$Data['data'] = $this->report_emp_model->get_teacher_lessonPreps($TeacherID,$LevelID,$RowLevelID,$classID,$subjectID,$DayDateFrom,$DayDateTo);
		
		$this->load->admin_template('view_report_teacher_lessonPreps',$Data);
	}

	public function get_teacher_lessonPreps_details()
	{
	    $Data['TeacherID']=$this->uri->segment(5);
	    $Data['LevelID']=$this->uri->segment(6);
	    $Data['RowLevelID']=$this->uri->segment(7);
	    $Data['classID']=$this->uri->segment(8);
	    $Data['subjectID']=$this->uri->segment(9);
	    $Data['DayDateFrom']=$this->uri->segment(10);
	    $Data['DayDateTo']=$this->uri->segment(11);
		if((string)$this->uri->segment(4))
		  {
			$LessonID = (string)$this->uri->segment(4) ;
			$Data['Lesson_prep_details']= $this->lessons_model->get_lesson_details($LessonID);
			
			if($Data['Lesson_prep_details']!=0)
			  {
				$this->load->admin_template('view_report_teacher_lessonPreps_details',$Data);
			  }
			 // else
			 // {
			 // 	redirect('emp/lesson/lessons_review', 'refresh');
			 // }
		  }
	}

	
	public function get_teacher_ClericalHomework($TeacherID=0, $LevelID = 0 , $RowLevelID = 0 , $classID = 0 , $subjectID = 0 , $DayDateFrom = 'NULL' , $DayDateTo = 'NULL',$type  )
	{
		$teacherData['data'] = $this->report_emp_model->get_teacher_ClericalHomework($TeacherID,$LevelID,$RowLevelID,$classID,$subjectID,$DayDateFrom,$DayDateTo,$type);		
		$teacherData['type'] = $type;
		$this->load->admin_template('view_report_teacher_ClericalHomework',$teacherData);
	}

	public function get_teacher_ClericalHomework_details()
	{
		$dataSend['RowLevelID'] = $this->uri->segment(3);
		$dataSend['SubjectID']  = $this->uri->segment(4);
// 		$this->data['lessonsTitles']  = $this->lessons_model->get_lessons_prep($dataSend);
		$this->data['subjects'] = $this->subject_model->get_Subjects_emp();
		$this->data['homework'] = $this->clerical_homework_model->edit_clerical_homework_details($this->uri->segment(5));

		$this->load->admin_template('view_report_teacher_ClericalHomework_details', $this->data);
	}

	

	public function get_teacher_classTables($TeacherID=0, $LevelID = 0 , $RowLevelID = 0 , $classID = 0 , $subjectID = 0 , $DayDateFrom = 'NULL' , $DayDateTo = 'NULL'  )
	{
		$teacherData['data'] = $this->report_emp_model->get_teacher_classTables($TeacherID,$LevelID,$RowLevelID,$classID,$subjectID,$DayDateFrom,$DayDateTo);		
		$this->load->admin_template('view_report_teacher_classTables',$teacherData);

		$this->session->set_userdata('emp_id',$TeacherID);
		header("location:".base_url()."index.php/admin/emp_class_table/emp_edit/1");
	}

	

	public function get_data_emp( $show = NULL , $LevelID = 0 , $RowLevelID = 0 , $classID = 0 , $subjectID = 0 , $order = 0 , $DayDateFrom = NULL , $DayDateTo = NULL )

	{

		//echo  $DayDateFrom  .'<br>'.$DayDateTo ;  

		 if($LevelID == 0 ){ $LevelID = 'NULL'; }else{ $LevelID = (int)$LevelID;  }
		 if($RowLevelID == 0 ){ $RowLevelID = 'NULL'; }else{ $RowLevelID = (int)$RowLevelID;  }
		 if($classID == 0 ){ $classID = 'NULL'; }else{ $classID = (int)$classID;  }
		 if($subjectID == 0 ){ $subjectID = 'NULL'; }else{ $subjectID = (int)$subjectID;  }

        
		if($DayDateFrom == 'NULL'){ $DayDateFrom = 'NULL'; }

		if($DayDateTo == 'NULL'){ $DayDateTo  = date('Y-m-d');}
		
        $dataResponse['data'] = $this->report_emp_model->get_all_emp_permission($this->data['Lang'] , $LevelID , $RowLevelID , $classID , $subjectID ,$DayDateFrom , $DayDateTo );
        $this->output->set_content_type('application/json')->set_output(json_encode($dataResponse));
	}
    public function emp_not_in_classtable()

	{
	    $dataResponse['data'] = $this->report_emp_model->emp_not_in_classtable();
        $this->output->set_content_type('application/json')->set_output(json_encode($dataResponse));
	}
	//////report_student

	public function report_exam($EmpID = 0  , $DayDateFrom = 'NULL' , $DayDateTo = 'NULL' )

	{

		$this->data['EmpID'] = $EmpID ;

	  if($DayDateFrom == 'NULL'){$this->data['DayDateFrom']   = date('Y-m-d');}else{$this->data['DayDateFrom']   = $DayDateFrom;}

	  if($DayDateTo == 'NULL'){$this->data['DayDateTo']   = date('Y-m-d');}else{$this->data['DayDateTo']   = $DayDateTo;}

		$this->data['GetExam']  = $this->report_emp_model->report_exam_view($EmpID , $DayDateFrom , $DayDateTo   );

		$this->load->admin_template('view_report_exam',$this->data);



	}

	//////report_student

	public function report_home_work($EmpID = 0 , $DayDateFrom = 'NULL' , $DayDateTo = 'NULL'  )

	{

		$this->data['EmpID'] = $EmpID ;

	  if($DayDateFrom == 'NULL'){$this->data['DayDateFrom']   = date('Y-m-d');}else{$this->data['DayDateFrom']   = $DayDateFrom;}

	  if($DayDateTo == 'NULL'){$this->data['DayDateTo']   = date('Y-m-d');}else{$this->data['DayDateTo']   = $DayDateTo;}

		$this->data['GetHomeWork']  = $this->report_emp_model->report_home_work_view($EmpID , $DayDateFrom , $DayDateTo  );

		$this->load->admin_template('view_report_home_work',$this->data);



	}

	//////report_student

	public function report_student($LevelID = 0 , $RowLevelID = 0  , $ClassID = 0 )

	{
		$this->data['Lang']        = $this->session->userdata('language');

		$this->data['LevelID']     = $LevelID ; 

		$this->data['RowLevelID']  = $RowLevelID ;

		$this->data['ClassID']     = $ClassID ; 
		
		$Student  = get_student_select_in() ;
		
		$R_L_ID_array =get_rowlevel_select_in();
		
		$Class_array=get_class_select_in();
			
       
		$this->data['GetLevel']    = get_level_group();
        if($LevelID){
		  $this->data['GetRowLevel'] = $this->report_emp_model->get_RowLevel1($LevelID);
        }
        if($RowLevelID){
		 $this->data['GetClass']    = $this->report_emp_model->get_Class1($RowLevelID);
        }
        $this->data['ApiDbname']   = $this->ApiDbname;
        
		$this->data['GetStudent']  = $this->report_emp_model->get_student($this->data['Lang'] , $LevelID ,$RowLevelID , $ClassID );
		// PRINT_R($this->db->last_query());DIE;
		$this->load->admin_template('view_report_student',$this->data);



	}

	///////////////////////////////////

	public function report_all_student( $show = NULL , $Branche = 0 )

	{

		$this->data['Lang']                = $this->session->userdata('language');

		$this->data['show']                = $this->uri->segment(4);
		
		$this->data['year_id']             = $this->input->post('year_id');
        
        if(!$this->data['year_id']){
            
            $this->data['year_id']  = $this->setting_model->get_current_year();
        }
		
		$this->data['Branche']          = $this->input->post('Branche');
		$this->data['level']            = $this->input->post('level');
	    $this->data['RowLevel']         = $this->input->post('RowLevel');
	    $this->data['Classgg']          = $this->input->post('Classgg');
		if($this->data['Branche']){
	        $this->session->set_userdata('SchoolID', $this->data['Branche']);
	    }
	    if($this->data['level']){
		$this->data['row_level']           = $this->report_statistical_model->get_rowlevel($this->data['level']);
		}
		if(	$this->data['RowLevel']  ){
    	$this->data['get_class']           = $this->report_statistical_model->getclass_per_school($this->data );
	    }
 
		$this->data['get_year']            = $this->setting_model->get_all_year();
		
		$this->data['current_year_id']     = $this->setting_model->get_current_year();

		$this->data['GetBranches']         = $this->setting_model->get_branches($this->data['Lang']);

		$this->data['GetStudent']          = $this->report_emp_model->get_all_student($this->data);
		
		$this->data['ApiDbname']           = $this->ApiDbname;

		$this->load->admin_template('view_report_student_all_branch',$this->data);

	}

	////////////////////////////////////////

	public function report_all_student_api( $show = NULL , $Branche = 0 )

	{

	//	$this->data['show']        = $show ;

	//	$this->data['Branche']     = $Branche ; 

	//	$this->data['GetBranches'] = $this->report_emp_model->get_branches($this->data['Lang']);

		$this->data['GetStudent']  =   json_decode(file_get_contents("https://api-school-ibnrushd.esol.dev/api/Students/SchoolAcc/GetAllStudentBasicData"));

		$this->load->admin_template('view_report_student_all_branch_api',$this->data);



	}

   /////////////////////count_student

   public function number_student()

   {

	 $this->data['GetLevel']    = $this->report_emp_model->get_level_number_student($this->data['Lang']);

	 $this->load->admin_template('view_count_student',$this->data);



   }

   /////////////////////emp_details

   public function emp_details($JobTitle = 0 )

   {

	 $this->data['JobTitle']             = $JobTitle ; 

	 $this->data['get_Job_Title']        = $this->report_emp_model->get_Job_Title($this->data['Lang']);

	 $this->data['get_emp_Job_Title']    = $this->report_emp_model->get_emp_Job_Title($JobTitle);

	 $this->load->admin_template('view_emp_details',$this->data);



   }

//////////////////////////////////////////////////////////////////////// Emp E Lib

	public function ELibReport($EmpID = 0 , $DayDateFrom = NULL ,  $DayDateTo = NULL )

	{

		$this->data['EmpID'] = $EmpID ;

	  if($DayDateFrom == 'NULL'){$this->data['DayDateFrom']   = date('Y-m-d');}else{$this->data['DayDateFrom']   = $DayDateFrom;}

	  if($DayDateTo == 'NULL'){$this->data['DayDateTo']   = date('Y-m-d');}else{$this->data['DayDateTo']   = $DayDateTo;}

		$this->data['GetData']  = $this->report_emp_model->report_emp_elib($EmpID , $DayDateFrom , $DayDateTo );

		$this->load->admin_template('reportEmpLib',$this->data);

	}



	//////////////////////////////////////////////////////////////////////// Emp E Lib

	public function view_clerical_homework_report($EmpID = 0 , $DayDateFrom = NULL ,  $DayDateTo = NULL )

	{

		$this->data['EmpID'] = $EmpID ;

	  if($DayDateFrom == 'NULL'){$this->data['DayDateFrom']   = date('Y-m-d');}else{$this->data['DayDateFrom']   = $DayDateFrom;}

	  if($DayDateTo == 'NULL'){$this->data['DayDateTo']   = date('Y-m-d');}else{$this->data['DayDateTo']   = $DayDateTo;}

		$this->data['GetData']  = $this->report_emp_model->clerical_homework_view_report($this->data['Lang'] , $EmpID , $DayDateFrom , $DayDateTo );

		$this->load->admin_template('view_clerical_homework_report',$this->data);

	}

//////////////////////////////////////////////////////////////////////// Emp Students Eval

	public function StudentsEvalReport($EmpID = 0 )

	{

		$Data['GetData']  = $this->report_emp_model->report_student_eval($EmpID);

		$Data['EmpID']    = $EmpID ;

		$this->load->admin_template('reportStudentEval',$Data);

	}

	//////////////////////////////////////////////////////////////////////// Emp Students Eval

	public function students_eval_report($EmpID = 0 ,  $DayDateFrom = NULL ,  $DayDateTo = NULL  )

	{

		$this->data['EmpID'] = $EmpID ;

	  if($DayDateFrom == 'NULL'){$this->data['DayDateFrom']   = date('Y-m-d');}else{$this->data['DayDateFrom']   = $DayDateFrom;}

	  if($DayDateTo == 'NULL'){$this->data['DayDateTo']   = date('Y-m-d');}else{$this->data['DayDateTo']   = $DayDateTo;}

		$this->data['GetData']  = $this->report_emp_model->students_eval_report($this->data['Lang'] , $EmpID , $this->data['DayDateFrom'] , $this->data['DayDateTo']  );

		$this->load->admin_template('view_students_eval_report',$this->data);

	}

	//////////////////////////////////////////////////////////////////////// Emp Students Eval

	public function students_eval_absence_report(  $DayDateFrom = 'NULL' ,  $DayDateTo = 'NULL'  )

	{

		$Student  = get_student_select_in() ;

	  if($DayDateFrom == 'NULL'){$this->data['DayDateFrom']   = ''; }else{$this->data['DayDateFrom']   = $DayDateFrom;}

	  if($DayDateTo == 'NULL'){$this->data['DayDateTo']   = '';}else{$this->data['DayDateTo']   = $DayDateTo;}

		$this->data['GetData']  = $this->report_emp_model->students_eval_absence_report($this->data['Lang'] ,  $this->data['DayDateFrom'] , $this->data['DayDateTo'] , $Student  );

		$this->load->admin_template('view_students_eval_absence_report',$this->data);

	}

	

	//////////////////////////////////////////////////////////////////////// Emp Students Eval

	public function students_delay_absence_report(  $DayDateFrom = 'NULL' ,  $DayDateTo = 'NULL'  )

	{

		$Student  = get_student_select_in() ;

	 

	  if($DayDateFrom == 'NULL'){$this->data['DayDateFrom']   = date('Y-m-d');}else{$this->data['DayDateFrom']   = $DayDateFrom;}

	  if($DayDateTo == 'NULL'){$this->data['DayDateTo']   = date('Y-m-d');}else{$this->data['DayDateTo']   = $DayDateTo;}

		$this->data['GetData']  = $this->report_emp_model->students_delay_absence_report($this->data['Lang'] ,  $this->data['DayDateFrom']  , $this->data['DayDateTo']  , $Student  );

		//print_r($this->data);

		$this->load->admin_template('view_students_delay_absence_report',$this->data);

	}

	

	public function studentpage($StudentID = 0 , $TeacherID = 0 ,$SubjectID = 0)

	{
        
		$Data['StudentEval'] = $this->report_emp_model->get_student_eval($StudentID , $TeacherID ,$SubjectID);
		$Data['Studentid'] = $StudentID;
        //  print_r($this->db->last_query());

		$this->load->admin_template('StudentEvalPage' , $Data);

	}

	

//////////////////////////////////////////////////////////////////////// Emp Lesson Prep

	public function empLessonPrepReport($EmpID = 0 , $DayDateFrom = NULL ,  $DayDateTo = NULL  )

	{

		$Language = $this->data['Lang'];

		$this->data['EmpID'] = $EmpID ;

	  if($DayDateFrom == 'NULL'){$this->data['DayDateFrom']   = date('Y-m-d');}else{$this->data['DayDateFrom']   = $DayDateFrom;}

	  if($DayDateTo == 'NULL'){$this->data['DayDateTo']   = date('Y-m-d');}else{$this->data['DayDateTo']   = $DayDateTo;}

		$this->data['GetData']  = $this->report_emp_model->emp_lesson_prep_report($Language , $EmpID , $DayDateFrom , $DayDateTo  );

		//print_r($this->data['GetData'] );

		$this->load->admin_template('view_lessons_review',$this->data);

	}

	

	public function get_lessons_titles()

	{

		$data['RowLevelID']    = (int)$this->input->post('RowLevelID');

		$data['SubjectID']     = (int)$this->input->post('SubjectID');

		$data['TeacherID']     = (int)$this->input->post('TeacherID');

		

		$Data['lessonsTitles'] = $this->report_emp_model->get_lessons_prep($data);

		

		if($this->report_emp_model->get_lessons_prep($data))

		{

		   $this->load->view('admin/getLesson_prep_ax',$Data);

		}

		else

		{

			 echo lang('er_NO_Lessons_Prep');

		}

	}

	

	public function lesson_details()

	{

		  if((string)$this->uri->segment(4))

		  {

			$LessonToken	= (string)$this->uri->segment(4) ;

			$Data['Lesson_prep_details']= $this->report_emp_model->get_lesson_details($LessonToken);

			

			if($Data['Lesson_prep_details']!=0)

			  {

				$this->load->admin_template('Emp_Lesson_prep_details',$Data);

			  }else

			  {

			  	$this->index();

			  }

		  }

	}

//////get_report_eval

	public function get_report_eval()

	{
       $UserID  = $this->session->userdata('id'); 
		$this->data['GetEmpper']        = get_emp_select_in();

		$this->data['GetReport']  = $this->report_emp_model->get_report_eval($this->data['YearID'] , $this->data['Lang'] , $this->data['GetEmpper'],$UserID  );



		$this->load->admin_template('view_report_eval',$this->data);

	}//////get_report_Level
	public function get_report_eval1()

	{
       $Data['ContactID']         = $this->uri->segment(4); 
       $Data['ContactEmpID']      = $this->uri->segment(5); 
       $Data['datee']             = $this->uri->segment(6);
       $Data['Semesterid']        = $this->uri->segment(7);
	   $Data['GetEmpper']         = get_emp_select_in();
	   $Data['GetReport']         = $this->report_emp_model->get_report_eval1($this->data['YearID'] , $this->data['Lang'] , $Data['GetEmpper'],$Data['ContactID'],$Data['ContactEmpID'],$Data['datee'],$Data['Semesterid'] );
	   $Data['GetReport1']        = $this->report_emp_model->get_report_eval5($this->data['YearID'] , $this->data['Lang'] , $Data['GetEmpper'],$Data['ContactID'],$Data['ContactEmpID'],$Data['datee'],$Data['Semesterid'] );
// print_r($this->db->last_query());

		$this->load->admin_template('view_report_eval_details',$Data);

	}
		public function get_report_eval2()

	{
	   $Data['YearID']           = $this->session->userdata('YearID');
       $Data['UserID']           = $this->uri->segment(4); 
       $Data['Semesterid']       = $this->uri->segment(5); 
	   $Data['GetEmpper']        = get_emp_select_in();
	   $Data['GetReport']        = $this->report_emp_model->emp_eval_report_details($Data);

		$this->load->admin_template('view_report_eval_precentage',$Data);

	}
	//////////////////
	public function delete_report_eval( $emp_evaluation_ID)
	{
	    
	     $Data['ContactID']       = $this->uri->segment(4) ;
	     
	     $Data['ContactEmpID']    = $this->uri->segment(5) ;
	     
	     $Data['Date']            = $this->uri->segment(6) ;
	     
	     $Data['Semesterid']      = $this->uri->segment(7); 
	     
	 
	     
		 if($this->report_emp_model->delete_report_eval($Data))
		  {
			 $this->session->set_flashdata('SuccessAdd',lang('br_add_suc'));
			 redirect('admin/report_emp/get_report_eval2/'.$Data['ContactID']."/".$Data['Semesterid'],'refresh');
		  }else{
				 $this->session->set_flashdata('ErrorAdd',lang('br_add_error'));
				 redirect('admin/report_emp/get_report_eval2/'.$Data['ContactID']."/".$Data['Semesterid'],'refresh');							
	      } 

	}
		public function get_report_eval3()

	{
       $UserID  = $this->session->userdata('id'); 
		$this->data['GetEmpper']        = get_emp_select_in();

		$this->data['GetReport']  = $this->report_emp_model->get_report_eval2($this->data['YearID'] , $this->data['Lang'] , $this->data['GetEmpper'],$UserID  );
        //  print_r($UserID);die;
		$this->load->admin_template('view_report_eval_precentage1',$this->data);

	}
	public function get_report_eval4()

	{
       $ContactID  = $this->uri->segment(4); 
       $ContactEmpID  = $this->uri->segment(5); 
        $datee  = $this->uri->segment(6);
		$this->data['GetEmpper']        = get_emp_select_in();

		$this->data['GetReport']  = $this->report_emp_model->get_report_eval1($this->data['YearID'] , $this->data['Lang'] , $this->data['GetEmpper'],$ContactID,$ContactEmpID,$datee );

		$this->load->admin_template('view_report_eval',$this->data);

	}
	public function get_report_level($LevelID=0,$RowLevelID=0,$ClassID=0)

	{
	   	$this->data['LevelID']    = $LevelID;
    
    	$this->data['rowlevel']   = $RowLevelID;

		$this->data['ClassID']    = $ClassID ;
		
		 if($this->data['LevelID']){
		  $this->data['GetRowLevel'] = $this->report_emp_model->get_RowLevel1($this->data['LevelID']);
        }
        if($this->data['rowlevel']){
		 $this->data['GetClass']    = $this->report_emp_model->get_Class1($this->data['rowlevel']);
        }

                // if($ClassID!=0){$pieces = explode("/", $ClassID);$ClassID=$pieces[1];$RowLevelID=$pieces[0]; }

                    

 		$this->data['GetEmp']  = $this->report_emp_model->get_emp_level($LevelID,$RowLevelID,$ClassID); 

		$this->load->admin_template('view_report_level',$this->data);

	}////////////get_emp_level 

	public function get_emp_level($LevelID,$RowLevelID,$ClassID)

	{

    	$this->data['LevelID']    = $LevelID;
    
    	$this->data['rowlevel']   = $RowLevelID;

		$this->data['ClassID']    = $ClassID ;
		
		 if($this->data['LevelID']){
		  $this->data['GetRowLevel'] = $this->report_emp_model->get_RowLevel1($this->data['LevelID']);
        }
        if($this->data['rowlevel']){
		 $this->data['GetClass']    = $this->report_emp_model->get_Class1($this->data['rowlevel']);
        }

                if($ClassID!=0){$pieces = explode("/", $ClassID);$ClassID=$pieces[1];$RowLevelID=$pieces[0]; }

                    

 		$this->data['GetEmp']  = $this->report_emp_model->get_emp_level($LevelID,$RowLevelID,$ClassID); 

		$this->load->view('admin/view_report_level_ajax',$this->data);

	}

////////////emp_plan_week_report

	public function emp_plan_week_report($ID = 0 )

	{

		$ID     = (int)$ID;

		$this->data['GetPlanWeek']  = $this->report_emp_model->emp_plan_week_report($ID,$this->data['Lang']);

		$this->load->admin_template('view_report_plan_ajax',$this->data);

	}

   

	////////////emp_report_cms

	public function emp_report_cms()

	{
      
		$this->data['GetEmp']  = $this->report_emp_model->emp_report_cms();



		$this->load->admin_template('view_emp_report_cms',$this->data);

	}

	////////////emp_eval_report

	public function emp_eval_report()

	{
	    $Data['Lang']              = $this->session->userdata('language');
	    
	    $Data['GetSemester']       = $this->config_model->get_semester($Data['Lang']);
	    
	    $Data['Semesterid']        = implode(',',$this->input->post('Semesterid'));
        
        if($Data['Semesterid']){
            
		$Data['GetEmpEval']        = $this->report_emp_model->emp_eval_report($Data);

		$Data['GetEmpEvalLesson']  = $this->report_emp_model->emp_eval_report_lesson($Data);
        
        }
        
		$this->load->admin_template('view_emp_eval_report',$Data);

	}

////////////////////////////////////////////////////////////////////////

/////////////////////emp_details

   public function emp_all_data($Branche = 0 )

   {
       
     $this->data['ApiDbname']        = $this->ApiDbname;

	 $this->data['Branche']          = $Branche ; 

	 $this->data['GetBranches']      = $this->setting_model->get_branches($this->data['Lang']);

	 $this->data['GetEmpAllData']    = $this->report_emp_model->employee_all_data($Branche);

	 $this->load->admin_template('view_emp_all_data',$this->data);



   }
   
   public function emp_all_data_emp()

   {
	 $this->data['GetBranches']      = $this->report_emp_model->get_branches($this->data['Lang']);
	 
	 $this->data['GetEmpAllData']    = $this->report_emp_model->emp_all_data_emp();

	 $this->load->admin_template('view_emp_all_data',$this->data);
   }


   /////////////////////emp_details

   public function emp_without_class($Branche = 0 )

   {

	 $this->data['Branche']          = $Branche ; 

	 $this->data['GetBranches']      = $this->report_emp_model->get_branches($this->data['Lang']);
	 if($Branche){

	 $this->data['GetEmpAllData']    = $this->report_emp_model->emp_all_data_without_class($Branche);
	 }

	 $this->load->admin_template('view_emp_without_class',$this->data);



   }

   /////////////////////////report_emp_rate

   public function report_emp_rate($Branche = 0 , $Month = 0 ,$LevelID =0 ,$RowLevelID =0,$ClassID=0, $WeekSearch = 0)

   { 
       $this->data['level_ID']  = $LevelID    /* =  $this->input->post('level_ID')*/ ;
	   $this->data['RowLevel']  = $RowLevelID /* =  $this->input->post('RowLevel') */;
	   $this->data['Class']     = $ClassID    /* =  $this->input->post('Class') */;
	    	if($this->data['level_ID']){
		$this->data['row_level']         = $this->report_statistical_model->get_rowlevel($this->data['level_ID']);
		}
			if(	$this->data['RowLevel']  ){
    	$this->data['get_class']    = $this->report_statistical_model->getclass($this->data['RowLevel'] );
	}
	

	  $this->data['Branche']         = $Branche /*= $this->input->post('Branche')*/; 

	  $this->data['Months']          = $Month   /*=$this->input->post('Month')*/;

	  $this->data['WeekSearch']      = $WeekSearch /*=$this->input->post('WeekSearch ')*/; 

	  if($Month == 0){if($Month !=10 ){$Month = str_replace('0','', date('m')) ;} }

	  $MonthArray = array(1=>"January" , 2=>"February" , 3=>"March" , 4=>"April" , 5=>"May" , 6=>"June" , 7=>"July" , 8=>"August" , 9=>"September" , 10=>"October" , 11=>"November" , 12=>"December");

	  $this->data['Week1']      =  $this->test_date(date('Y'),$MonthArray[$Month],1);

	  $this->data['Week2']      =  $this->test_date(date('Y'),$MonthArray[$Month],2);

	  $this->data['Week3']      =  $this->test_date(date('Y'),$MonthArray[$Month],3);

	  $this->data['Week4']      =  $this->test_date(date('Y'),$MonthArray[$Month],4);

	  $this->data['WeekSearch'] =  $WeekSearch ;

	  if($WeekSearch != 0){$this->data['WeekActive'] =  $this->data['Week'.$WeekSearch] ;}

	  //print_r($this->data);exit ;

	  $this->data['GetBranches']      = $this->report_emp_model->get_branches($this->data['Lang']);

	  $this->data['GetEmpAllData']    = $this->report_emp_model->emp_all_data($Branche, $LevelID  ,$RowLevelID ,$ClassID);

	  $this->load->admin_template('view_report_emp_rate',$this->data); 

   }

   /////////////////////////report_emp_rate

   public function get_active_library()

   {

	  $this->data['GetEmpper']        = get_emp_select_in();

	  $this->data['GetEmpAllData']    = $this->report_emp_model->get_active_library($this->data['GetEmpper'] , $this->data['Lang']);

	  $this->load->admin_template('view_get_active_library',$this->data); 

   } /////////////////////////report_emp_rate

   public function active_library($active_library = 0 )

   {

	  $this->report_emp_model->active_library($active_library);

	  $this->session->set_flashdata('Sucsess',lang('br_saved'));

	  redirect('admin/report_emp/get_active_library','refresh');

   }

   ////////////////////////////student_without_class

   public function student_without_class()

   {

	  $this->data['GetStudent']    = $this->report_emp_model->get_student_without_class();

	  $this->load->admin_template('view_student_without_class',$this->data); 

   }

   /////////////////////////report_emp_rate

   public function lesson_prep_eval_report()

   {

	  $this->data['GetEmpper']        = get_emp_select_in();

	  $this->data['GetEmpAllData']    = $this->report_emp_model->lesson_prep_eval_report($this->data['GetEmpper'] );

	  $this->load->admin_template('view_lesson_prep_eval_report',$this->data); 

   } 
   public function lesson_prep_eval_report1()

   {
       $Data['ContactID']  = $this->uri->segment(4); 
       $Data['lesson_id']  = $this->uri->segment(5); 
       $Data['datee']      = $this->uri->segment(6);
       $Data['Semesterid'] = $this->uri->segment(7);

	   $Data['GetEmpAllData']    = $this->report_emp_model->lesson_prep_eval_report1($Data);

	   $this->load->admin_template('view_lesson_prep_eval_report',$Data); 

   } 
    public function lesson_prep_eval_report2()

   {
     $Data['UserID']           = $this->uri->segment(4); 
     $Data['Semesterid']       = $this->uri->segment(5);
	 $Data['GetEmpper']        = get_emp_select_in();
	 $Data['GetEmpAllData']    = $this->report_emp_model->lesson_prep_eval_report2($Data );

	  $this->load->admin_template('view_lesson_eval_precentage',$Data); 

   } 

 /////////////////////////lesson_prep_eval_group_contact_report

   public function lesson_prep_eval_group_contact_report()

   {

	  $this->data['GetEmpper']        = get_emp_select_in();

	  $this->data['GetEmpAllData']    = $this->report_emp_model->lesson_prep_eval_group_contact_report($this->data['GetEmpper'] );

	  $this->load->admin_template('view_lesson_prep_eval_group_contact_report',$this->data); 

   } 
   ////////////get_student_class

   public function get_student_class()

   {
       
       $this->data['level']            = $this->input->post('level');
	   $this->data['RowLevel']         = $this->input->post('RowLevel');
	  
	   	if($this->data['level']){
		$this->data['row_level']         = $this->report_statistical_model->get_rowlevel($this->data['level']);
		}
	   $this->data['GetClass']           = $this->report_emp_model->get_class_school($this->data['Lang']);

	   $this->data['GetRowLevel']        = $this->report_emp_model->get_row_level_school_report($this->data['Lang'],$this->data);

	   $this->load->admin_template('view_get_student_class',$this->data);

   }

   //////////////////test_date

   public function test_date($Year = 0 , $Month = NULL  , $Week = 0 )

	{

		

		//echo $Year.'--'.$Month.'--'.$Week ; exit ;

		$time = strtotime("1 $Month $Year", time());

        $day = date('w', $time);

        $time += ((7*$Week)-$day-1)*24*3600;

        $return[0] = date('Y-n-j', $time);

        $time += 6*24*3600;

        $return[1] = date('Y-n-j', $time);

        return   $return;

	}

	///////////HijriToJD  $m , $d , $y

	public   function HijriToJD($Date = "1437/3/14" )

	{

		//

		$NewDate = str_replace("/" , "-" , $Date);

		$Date = explode('-',$NewDate) ;

		//print_r($Date);exit();

		$m = $Date[1] ;

		$d = $Date[2] ;

		$y = $Date[0] ;

		//echo $y .'-'.$m.''.$d ; exit;

		echo  (int)((11 * $y + 3) / 30) + 354 * $y +

		30 * $m -(int)(($m - 1) / 2) + $d + 1948440 - 385;

	}

	

	///////////////////////////////////////////////chaild_page_report

	public function report_weekly_plan($EmpID = 0 , $DayDateFrom = NULL ,  $DayDateTo = NULL  )

	{

		$this->data['EmpID'] = $EmpID ;

	  if($DayDateFrom == 'NULL'){$this->data['DayDateFrom']   = date('Y-m-d');}else{$this->data['DayDateFrom']   = $DayDateFrom;}

	  if($DayDateTo == 'NULL'){$this->data['DayDateTo']   = date('Y-m-d');}else{$this->data['DayDateTo']   = $DayDateTo;}

      $this->data['GetPlanWeek']           = $this->report_emp_model->report_weekly_plan($this->data['Lang'] , $EmpID , $DayDateFrom ,  $DayDateTo);

	  $this->load->admin_template('view_report_weekly_plan',$this->data);

	}
	
	
	public function report_emp_add_test ()
	{
	    
	    $this->data['dataEmp'] = $this->report_emp_model->report_emp_add_test();
	    
	    $this->load->admin_template('view_report_emp_add_test', $this->data );
	    
	}
	public function del_exam_app()
	{
	    
	    $testID        = $this->uri->segment(4); 
	    
	    $this->db->query("UPDATE `test` SET `is_deleted`=1 WHERE `ID`= '".$testID."' ");
	    
	    $this->session->set_flashdata('success',lang('br_add_suc'));
	    
        redirect('admin/report_emp/report_emp_add_test','refresh');
	}
	public function emp_report_cms2()

	{

		$this->data['GetEmp']  = $this->report_emp_model->emp_report_cms2();



		$this->load->admin_template('view_report_cms2',$this->data);

	}
	
	public function empReactionReport()
	{
	   
            $this->load->admin_template('view_get_emp_report_reactions',$this->data);
	
	}

	public function get_data_reaction( $show = NULL , $LevelID = 0 , $RowLevelID = 0 , $classID = 0 , $subjectID = 0 , $order = 0 , $DayDateFrom = 'NULL' , $DayDateTo = 'NULL' )
	{
		if($LevelID == 0 ){ $LevelID = 'NULL'; }else{ $LevelID = (int)$LevelID;  }
		if($RowLevelID == 0 ){ $RowLevelID = 'NULL'; }else{ $RowLevelID = (int)$RowLevelID;  }
		if($classID == 0 ){ $classID = 'NULL'; }else{ $classID = (int)$classID;  }
		if($subjectID == 0 ){ $subjectID = 'NULL'; }else{ $subjectID = (int)$subjectID;  }

        if($DayDateFrom == 'NULL'){ $DayDateFrom = 'NULL'; }
        
        $dataResponse['data'] = $this->report_emp_model->get_all_emp_reaction($this->data['Lang'] , $LevelID , $RowLevelID , $classID , $subjectID ,$DayDateFrom , $DayDateTo  );
     
        $this->output->set_content_type('application/json')->set_output(json_encode($dataResponse));
	}
	
	public function empReactionReportTotal()
	{
	    $this->data['DateFrom'] = $this->input->post('DayDateFrom');
		$this->data['DateTo'] = $this->input->post('DayDateTo');
		$this->data['DayDateFrom'] = '';
		$this->data['DayDateTo'] = '';
		if($this->input->post('DayDateFrom')!='' && $this->input->post('DayDateTo')!=''){
			$this->data['DayDateFrom'] = $this->input->post('DayDateFrom').' 00:00:00';
			$this->data['DayDateTo'] = $this->input->post('DayDateTo').' 23:59:59';
		}
                $this->load->admin_template('view_get_emp_report_reactions_total',$this->data);
	
	}

	public function get_data_reaction_total( $show = NULL , $DayDateFrom = 'NULL' , $DayDateTo = 'NULL' )
	{
        $dataResponse['data'] = $this->report_emp_model->get_all_emp_reaction_total($this->data['Lang'] ,$DayDateFrom , $DayDateTo );
        $this->output->set_content_type('application/json')->set_output(json_encode($dataResponse));
	}

	public function student_activity_by_level()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->load->model('student/student_points_model');
			$records['dateFrom'] = '';
			$records['dateTo'] = '';
			if($this->input->post('dateFrom')!='' && $this->input->post('dateTo')!=''){
				$records['dateFrom'] = $this->input->post('dateFrom').' 00:00:00';
				$records['dateTo'] = $this->input->post('dateTo').' 23:59:59';
			}
			$data = array();
			$GetLevel = get_level_group();
			
			if($GetLevel)
			{
				$school_id = $this->session->userdata('SchoolID');
				foreach($GetLevel as $Key => $Level)
				{
					$ID   = $Level->LevelID ;
					$lessons = $this->student_points_model->report_level_lessons($ID, $school_id, strtotime($records['dateFrom']), strtotime($records['dateTo']));
					$revisions = $this->student_points_model->report_level_revisions($ID, $school_id, strtotime($records['dateFrom']), strtotime($records['dateTo']));
					$clerical = $this->student_points_model->report_level_clerical($ID, $school_id, $records['dateFrom'], $records['dateTo']);
					$homework = $this->student_points_model->report_level_homework($ID, $school_id, $records['dateFrom'], $records['dateTo']);
					$exam = $this->student_points_model->report_level_exam($ID, $school_id, $records['dateFrom'], $records['dateTo']);
					$data[$Key] = [
						'name' => $Level->LevelName,
						'lessons' => $lessons->total,
						'revisions' => $revisions->total,
						'clerical' => $clerical->total,
						'homework' => $homework->total,
						'exam' => $exam->total,
						'total' => $lessons->total + $revisions->total + $clerical->total + $homework->total + $exam->total
					];
				}
				$records['records'] = $data;
            //  $this->load->admin_template('report_activities_by_level', $records);
				
			}
		}
		$this->load->admin_template('report_activities_by_level', $records);
// 		$this->load->admin_template('report_activities_by_level', $this->data);
	}


	public function student_activity_by_students1()
	{
	$param_DateFrom ='2020-01-01';
    $param_DateTo ='2020-05-30';
    $param_SchoolID =43;
    $param_LevelID =5;
    $param_OrderNo =5;
    
    
    $a_procedure = "CALL Usp_GetNTopMarks_ByLevel (?,?,?,?,?)";
$res = $this->db->query( $a_procedure, array('param_DateFrom'=>$param_DateFrom,'param_DateTo'=>$param_DateTo,'param_SchoolID'=>$param_SchoolID,'param_LevelID'=>$param_LevelID,'param_OrderNo'=>$param_OrderNo) );


	  //  $query    = $this->db->query("CALL Usp_GetNTopMarks_ByLevel($param_DateFrom,$param_DateTo,$param_SchoolID,$param_LevelID,$param_OrderNo)");
      //  $res      = $query->result();

      //  mysqli_next_result( $this->db->conn_id );
        //  print_r($res);
	}
	
	public function student_activity_by_students()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST') {

			$this->load->model('student/student_points_model');
			$records['dateFrom'] = '';
			$records['dateTo'] = '';
			
			if($this->input->post('dateFrom')!='' && $this->input->post('dateTo')!=''){
			//	$records['dateFrom'] = $this->input->post('dateFrom').' 00:00:00';
			//	$records['dateTo'] = $this->input->post('dateTo').' 23:59:59';
				$records['dateFrom'] = $this->input->post('dateFrom');
				$records['dateTo'] = $this->input->post('dateTo');
			}
				$records['levelID'] = $this->input->post('level_id');
				$records['RowLevel'] = $this->input->post('RowLevel');
				$records['max'] = $this->input->post('max');
				
					// echo json_encode($records);die();
			$data = array();
			$school_id = $this->session->userdata('SchoolID');
	//	 	$GetLevel = $this->student_points_model->report_students($records['levelID'], $school_id, strtotime($records['dateFrom']), strtotime($records['dateTo']), $records['dateFrom'] , $records['dateTo'],$records['max'],$records['RowLevel'] );





	$param_DateFrom =$this->input->post('dateFrom');
    $param_DateTo =$this->input->post('dateTo');
    $param_SchoolID =$school_id;
    $param_LevelID =	$records['levelID'];
    $param_OrderNo =$records['max'];
    
    
 $a_procedure = "CALL Usp_GetNTopMarks_ByLevel (?,?,?,?,?)";
$query = $this->db->query( $a_procedure, array('param_DateFrom'=>$param_DateFrom,'param_DateTo'=>$param_DateTo,'param_SchoolID'=>$param_SchoolID,'param_LevelID'=>$param_LevelID,'param_OrderNo'=>$param_OrderNo) );
$GetLevel      = $query->result();  
mysqli_next_result( $this->db->conn_id );  
			// echo json_encode($GetLevel); die();

  // echo $this->db->last_query();die;
			
			if($GetLevel)
			{
				
				$records['records'] = $GetLevel;
				$this->load->admin_template('report_activities_by_students', $records); 
			}else{
				$this->load->admin_template('report_activities_by_students', $records);	
			}
		}else{
			$this->load->admin_template('report_activities_by_students', $this->data);	
		}
		
	}
/////////////////////////////////
public function students_delay_absence()

	{
	    $id        = $this->session->userdata('id');
        
     	$this->data['DateFrom']  = $DateFrom  = $this->uri->segment(4) ;

      	$this->data['DateTo']    = $DateTo    = $this->uri->segment(5) ;

	    $this->data['level']     = $level     = $this->uri->segment(6) ;
		
	    $this->data['RowLevel']  = $RowLevel  = $this->uri->segment(7) ;
		
		$this->data['Class']     = $Class     = $this->uri->segment(8) ;
		
		

     	//$this->data['GetStudent']  = $this->report_emp_model->get_students();
     	
       $Gettype = $this->db->query("SELECT Type from contact where ID =".$id."")->result();
       
       if($Gettype[0]->Type=='E')
       {
   
   
       $GetEmpData = $this->Permission_model->Get_PerType();
       $PerType =explode(',',$GetEmpData['PerType'] );
       if($GetEmpData['Type']==1)
       {
         $this->data['Getlevel']=$this->Permission_model->Get_level1($GetEmpData['PerType']);
       }
      if($GetEmpData['Type']==2)
      {
         $this->data['Getlevel']=$this->Permission_model->Get_level2($GetEmpData['PerType']);
        
      }
     if($GetEmpData['Type']==3)
     {
        
     $row_lev_arr=[];
     foreach($PerType as $Key=>$i)
     {
     $ee=explode('|',$i);
     $row_lev=$ee[0];
        array_push($row_lev_arr,$row_lev);
        $AA=implode(',',$row_lev_arr);
     }
     
     $this->data['Getlevel']=$this->Permission_model->Get_level2($AA);
	  }
	  if($GetEmpData['Type']==4){
     $row_lev_arr=[];
     foreach($PerType as $Key=>$i)
     {
     $ee=explode('|',$i);
     $row_lev=$ee[0];
        array_push($row_lev_arr,$row_lev);
        $AA=implode(',',$row_lev_arr);
     }
     
     $this->data['Getlevel']=$this->Permission_model->Get_level2($AA);
    
	  }
  }else
    {
     	$this->data['Getlevel']    = $this->Permission_model->get_level($this->data['Lang']);
    }
		if($level||$RowLevel||$Class||$DateFrom||$DateFrom){
		    
		    $this->data['row_level']    = $this->report_emp_model->get_rowlevel($this->data,$this->data['Lang']);

            $this->data['get_class']    = $this->report_emp_model->getclass($this->data,$this->data['Lang']);
		    
		    $this->data['GetData']      = $this->report_emp_model->students_delay_absence($this->data['Lang'],$level,$RowLevel,$Class,$DateFrom,$DateTo); 
		    
		}


		$this->load->admin_template('view_students_delay_absence',$this->data);
	}
///////////////////////////////
public function getRowLevel( $levelID)

	{
	    //$levelID =(int)$this->uri->segment(4);
	     $id=$this->session->userdata('id');
       $Gettype = $this->db->query("SELECT Type from contact where ID =".$id."")->result();
 if($Gettype[0]->Type=='E')
   {
   
   
       $GetEmpData = $this->Permission_model->Get_PerType();
       $PerType =explode(',',$GetEmpData['PerType'] );
       if($GetEmpData['Type']==1)
       {
         $result=$this->Permission_model->get_RowLevel1($GetEmpData['PerType'],$levelID);
       }
      if($GetEmpData['Type']==2)
      {
         $result=$this->Permission_model->get_RowLevel2($GetEmpData['PerType'],$levelID);
      }
     if($GetEmpData['Type']==3)
     {
        
     $row_lev_arr=[];
     foreach($PerType as $Key=>$i)
     {
     $ee=explode('|',$i);
     $row_lev=$ee[0];
        array_push($row_lev_arr,$row_lev);
        $AA=implode(',',$row_lev_arr);
     }
     $result=$this->Permission_model->get_RowLevel2($AA,$levelID);
	 }
	  if($GetEmpData['Type']==4){
     $row_lev_arr=[];
     foreach($PerType as $Key=>$i)
     {
     $ee=explode('|',$i);
     $row_lev=$ee[0];
        array_push($row_lev_arr,$row_lev);
        $AA=implode(',',$row_lev_arr);
     
     }
      $result=$this->Permission_model->get_RowLevel2($AA,$levelID);
    
	  }
  }else
    {
	    $result = $this->report_emp_model->getRowLevel($this->data['Lang'],$levelID); 
    }
	    echo json_encode($result);
	}
//////////////////////////////
public function getclass($row_level){
       	//$row_level                      =(int)$this->uri->segment(4);
       	 $id=$this->session->userdata('id');
       $Gettype = $this->db->query("SELECT Type from contact where ID =".$id."")->result();
 if($Gettype[0]->Type=='E')
   {
       $GetEmpData = $this->Permission_model->Get_PerType();
       $PerType =explode(',',$GetEmpData['PerType'] );
       if($GetEmpData['Type']==1)
       {
         $result  =$this->Permission_model->get_Class1($row_level);
        
       }
      if($GetEmpData['Type']==2)
      {
         $result =$this->Permission_model->get_Class1($row_level);
        
      }
     if($GetEmpData['Type']==3)
     {
     $class_arr=[];
     foreach($PerType as $Key=>$i)
     {
     $ee=explode('|',$i);
     if ($ee[0] == $row_level) {
     $class=$ee[1];
        array_push($class_arr,$class);
        $bb=implode(',',$class_arr);
     }
     }
     
      $result  = $this->Permission_model->get_Class_special($bb,$row_level);
	  }
	  if($GetEmpData['Type']==4)
	  {
       $result =$this->Permission_model->get_Class1($row_level);
    
	  }
  }else
    {
        $result      = $this->Permission_model->get_Class1($row_level);
    }
         echo json_encode($result);
    }
////////////////////////
public function edit_delay_absence( )

	{
	  $id                       = $this->uri->segment(4) ; 
	 
	  $this->data['DateFrom']   = $this->uri->segment(6) ;

      $this->data['DateTo']     = $this->uri->segment(7) ;

	  $this->data['level']      = $this->uri->segment(8) ;
		
	  $this->data['RowLevel']   = $this->uri->segment(9) ;
		
	  $this->data['Class']      = $this->uri->segment(10) ; 
	 
	  $this->data['GetStudent'] = $this->report_emp_model->edit_students($id);
   
     $this->load->admin_template('edit_students_delay_absence',$this->data);
	}
//////////////////////////////
public function add_delay_absence()

	{
	       $Timezone    = $this->setting_model->converToTimezone();
	       $DateFrom    = $this->uri->segment(4) ;
           $DateTo      = $this->uri->segment(5) ;
	       $level       = $this->uri->segment(6) ;
	       $RowLevel    = $this->uri->segment(7) ;
	       $Class       = $this->uri->segment(8) ; 
	       $id          = (int)$this->input->post('id');
	       $StID    	= (int)$this->input->post('name1');
	       $CheckAttend	= (int)$this->input->post('CheckAttend');
		   $CheckData	= (int)$this->input->post('Check');
		   $CheckDelay	= (int)$this->input->post('Delay');
		  //  print_r($Timezone);die;
		   if($CheckData != 0 || !empty($CheckDelay)||$CheckAttend!=0)
		   {
		    $this->report_emp_model->add_delay_absence($StID ,$CheckAttend, $CheckData , $CheckDelay,$id,$Timezone ) ; 
		  
		   }
		$this->session->set_flashdata('SuccessAdd',lang('br_add_suc'));
        redirect('admin/report_emp/students_delay_absence/'.$DateFrom."/".$DateTo."/".$level."/".$RowLevel."/".$Class,'refresh');
	}
/////////////////////////////////
	public function dele_delay_absence( )

	{
	     $id       = $this->uri->segment(4) ;
	     
	     $Student  = $this->uri->segment(5) ;
	     
		 if($this->report_emp_model->dele_delay_absence($id))
		  {
			 $this->session->set_flashdata('SuccessAdd',lang('br_add_suc'));
			 redirect('admin/report_emp/students_delay_absence/'.$Student,'refresh');
		  }else{
				 $this->session->set_flashdata('ErrorAdd',lang('br_add_error'));
				 redirect('admin/report_emp/students_delay_absence/'.$Student,'refresh');							
	      } 

	}
		public function delete_evaluation( $emp_evaluation_ID)

	{
	     $Data['emp_evaluation_ID']       = $this->uri->segment(4) ;
	     $Data['ContactID']               = $this->uri->segment(5); 
         $Data['ContactEmpID']            = $this->uri->segment(6); 
         $Data['datee']                   = $this->uri->segment(7);
         $Data['Semesterid']              = $this->uri->segment(8);
	    
		 if($this->report_emp_model->delete_evaluation($Data))
		  {
			 $this->session->set_flashdata('SuccessAdd',lang('br_add_suc'));
			 redirect('admin/report_emp/get_report_eval1/'.$Data['ContactID']."/".$Data['ContactEmpID']."/".$Data['datee']."/".$Data['Semesterid'],'refresh');
		  }else{
				 $this->session->set_flashdata('ErrorAdd',lang('br_add_error'));
				 redirect('admin/report_emp/get_report_eval1/'.$Data['ContactID']."/".$Data['ContactEmpID']."/".$Data['datee']."/".$Data['Semesterid'],'refresh');							
	      } 

	}
	///////////////////////////////////
	public function delete_total_evaluation()

	{
	     $ContactID       = $this->uri->segment(4) ;
	     
	     $ContactEmpID       = $this->uri->segment(5) ;
	     
	     $EvaluationDateStm       = $this->uri->segment(6) ;
	     
		 if($this->report_emp_model->delete_total_evaluation($ContactID,$ContactEmpID,$EvaluationDateStm))
		  {
		      //print_r($this->db->last_query());die;

			 $this->session->set_flashdata('SuccessAdd',lang('br_add_suc'));
			 redirect('admin/report_emp/get_report_eval3','refresh');
		  }else{
				 $this->session->set_flashdata('ErrorAdd',lang('br_add_error'));
				 redirect('admin/report_emp/get_report_eval3','refresh');							
	      } 

	}
		public function get_evaluation( $emp_evaluation_ID)

	{
	     $Data['emp_evaluation_ID']       = $this->uri->segment(4) ;
	     $Data['ContactID']               = $this->uri->segment(5); 
         $Data['ContactEmpID']            = $this->uri->segment(6); 
         $Data['datee']                   = $this->uri->segment(7);
         $Data['Semesterid']              = $this->uri->segment(8);
	     
		 $this->load->admin_template('view_edit_eval', $Data); 

	}
		public function edit_eval( $emp_evaluation_ID)

	{
	    $emp_evaluation_ID    = $this->uri->segment(4);
	    $ContactID            = $this->uri->segment(5); 
        $ContactEmpID         = $this->uri->segment(6); 
        $datee                = $this->uri->segment(7);
        $Semesterid           = $this->uri->segment(8);
        
        $Degree = $this->input->post('Degree') ;
        $Note   = $this->input->post('Note') ;
         if(  $this->db->query("UPDATE emp_evaluation  SET emp_evaluation.Degree = '".$Degree."', emp_evaluation.Note='".$Note."'  WHERE emp_evaluation.ID =$emp_evaluation_ID ") )

        {

            $this->session->set_flashdata('SuccessAdd',lang('br_add_suc'));

        }else{

            $this->session->set_flashdata('ErrorAdd',lang('br_add_error'));

        }
         redirect('admin/report_emp/get_report_eval1/'.$ContactID."/".$ContactEmpID."/".$datee."/".$Semesterid,'refresh');


	}
	
		public function exam_details()

	{


		$Data['GetEmp']  = $this->config_class_table_model->get_emp12();


		$this->load->admin_template('view_exam_details',$Data);
		
	}
	
		public function get_emp_subject($select_emp ,$RowLevel)

	{
      // $this->data['id']				 = $this->input->post('emp_id');
	   $result   = $this->report_emp_model->get_subject_emp1($select_emp,$RowLevel,$this->data['Lang']);
	    echo json_encode($result); 
		
	}
	
	public function get_emp_exam($select_subject ,$RowLevel,$select_emp)

	{
	  $result    = $this->report_emp_model->get_exam_ids($select_subject,$RowLevel,$select_emp);
	  echo json_encode($result);
		
	}
	
		public function get_exam_details()

	{
	    $data['level_ID']            = $this->input->post('level_ID') ;
	    $data['RowLevel']            = $this->input->post('RowLevel') ;
	    $data['Class']               = $this->input->post('Class') ;
	    $data['select_emp']          = $this->input->post('select_emp');
        $data['select_subject']      = $this->input->post('select_subject');
        $data['select_exam']         = $this->input->post('select_exam');
	    if($data['level_ID']){
		$data['row_level']         = $this->report_statistical_model->get_rowlevel($data['level_ID']);
		}
		if(	$data['RowLevel']){
    	$data['get_class']         = $this->report_statistical_model->getclass($data['RowLevel'] );
      	}
		if(	$data['Class'] && $data['RowLevel']){
    	$data['get_emp']           = $this->Permission_model->get_emp_rowlevclas($data['Class'] ,$data['RowLevel']);
    	}
		if(	$data['select_emp'] && $data['RowLevel']){
    	$data['get_subject']    = $this->report_emp_model->get_subject_emp1($data['select_emp'],$data['RowLevel']);
	    }
	    if(	$data['select_emp'] && $data['RowLevel'] &&$data['select_subject']){
    	$data['get_exam']    = $this->report_emp_model->get_exam_ids($data['select_subject'],$data['RowLevel'] ,$data['select_emp']);
  	
	    }
	
       //$data['GetEmp']  = $this->config_class_table_model->get_emp12();
      
       
      // $data['data']               = $this->report_emp_model->get_exam_ids($data['select_emp'],$data['select_subject']);
      if($data['select_exam']) {
        $data['data1']  = $this->report_emp_model->get_exam_details($data['select_exam']) ;
        //print_r($data['data1'] );die;
        $data['data2']  = $this->report_emp_model->get_exam_students($data['select_exam']) ;
      }
         if($data['data1'] )
		{
			$this->load->admin_template('view_exam_details',$data);
		}else{
// 			$this->session->set_flashdata('Failuer',"لا توجد اختبارات");
			redirect('admin/report_emp/exam_details','refresh');
		}
		
	}
	public function get_clerical_homework()

	{

		$this->data['plnID']            = $this->input->post('plnID');

		$this->data['SubjectID']        = $this->input->post('SubjectID');

		$this->data['RowLevelID']       = $this->input->post('RowLevelID');

		$this->data['EmpID']            = $this->data['UID']  ;  

		$this->data['GetEmpClass']      = $this->emp_class_table_model->get_emp_class_clerical_homework($this->data);

		$this->data['ClericalHomework'] = $this->emp_class_table_model->get_clerical_homework($this->data);

		$Data = array();

	    $Data['CheckBox']  = '' ;

		$Data['Content']   = '' ;

		$Data['Attach']    = '' ;

		

		if(is_array($this->data['ClericalHomework']))

		{

			$Data['Content']   = $this->data['ClericalHomework']['content'] ;

		    $Data['Attach']    = $this->data['ClericalHomework']['attach'] ;

		}

		//print_r($this->data);exit;

		if(is_array($this->data['GetEmpClass']))

		{

			$Data['CheckBox']      = '' ; 

			$DataChack = ''  ;

			foreach($this->data['GetEmpClass'] as $Key=>$Class)

			{

				$this->data['ClassID'] = $Class->ClassID ; 

				 

				$this->data['CheckAddClass'] = $this->emp_class_table_model->check_add_class($this->data);

				if(sizeof($this->data['CheckAddClass'])>0){$DataChack = 'checked'  ; }
				$Data['CheckBox'] .= '<div class="col-lg-4">';
				$Data['CheckBox'] .= '<label class="control control-checkbox">';
				$Data['CheckBox'] .= $Class->LevelName.'-'.$Class->RowName.'-'.$Class->ClassName ; 
				$Data['CheckBox'] .= '<input type="checkbox" class="CheckBoxClass" '.$DataChack.' name="Select_class[]" 

				value="'.$this->data['ClassID'].'" >' ;
				$Data['CheckBox'] .= '<div class="control_indicator"></div>';
				$Data['CheckBox'] .= '</label>';
				$Data['CheckBox'] .= '</div>';
			    $DataChack = ''  ;

			}

			$Data['CheckBox']      .= '' ;

		}

		        $this->output->set_header('Content-Type: application/json; charset=utf-8');

				$this->output->set_content_type('application/json')->set_output(json_encode($Data));

	}
	
	/////////////////////////////
		public function certificate_report()

	{
	   	$Student  = get_student_select_in() ;
        $Data['GetClass'] = get_class_group();
       $this->load->admin_template('view_report_certificate.php',$this->data);
	
	}
	////////////////////////////////////////
		public function certificate_report_add()

	{
	   	$this->data['level']          = $this->input->post('level_ID');
       
		$this->data['hidImg']         = $this->input->post('hidImg');
		
	   $this->data['Class']           = $this->input->post('Class');
//	 print_r($this->data['hidImg'] );die;
		 if($this->report_emp_model->add_certificate_photo($this->data))
		  {
		   //   print_r($this->db->last_query());die;

			 $this->session->set_flashdata('SuccessAdd',lang('br_add_suc'));
			 redirect('admin/report_emp/certificate_report','refresh');
		  }else{
				 $this->session->set_flashdata('ErrorAdd',lang('br_add_error'));
				 redirect('admin/report_emp/certificate_report','refresh');							
	      } 
		
      
	
	}
	//////////////////////////////////////////
	
			public function delete_cource_attach()
	{
	    
	   $Data['course_attend_ID']       = $this->uri->segment(4) ;
	  if($this->report_emp_model->delete_cource_attach($Data))
		  {
			 $this->session->set_flashdata('SuccessAdd',lang('br_add_suc'));
			redirect('admin/report_emp/certificate_report','refresh');	
		  }else{
				 $this->session->set_flashdata('ErrorAdd',lang('br_add_error'));
				redirect('admin/report_emp/certificate_report','refresh');								
	      } 
	    
	}
	//////////////////////////////////////
	
		public function certificate_card()
	{
	    
	    
	    $this->load->admin_template('course_card',$Data);
	    
	}
	////////////////////////////
	
	public function certificate_report_attach() 
	{
	    $Data['level']          = $this->input->post('level_ID');
      
		$Data['class']          = $this->input->post('Class');
	
		$Data['subject']          = $this->input->post('subject'); 
		
		if($Data['level'] && $Data['class'] ){
     	$Data['Get_Student']    = $this->report_emp_model->get_students_new($Data['class'],$Data['level'] );
		}


	    $Data['Get_attach']     = $this->report_emp_model->certificate_report_attach($Data);
	   
	    $this->load->admin_template('course_card',$Data);
	    
	}
	/////////////////////////////////
	
		public function get_rowlevel_class()
	{
	

		$this->load->admin_template('view_add_rowlevel_classes',$Data);
	}
	
	///////////////////////////////////
		public function add_rowlevel()
	{       
	        $data['school_id']          = $this->session->userdata('SchoolID');
		   	$data['rowlevel_name']		= $this->input->post('rowlevel_name'); 
			$data['rowlevel_nameEN']    = $this->input->post('rowlevel_nameEN');
			$data['rowlevel_id']        = $this->uri->segment(4);
		
			if($data['rowlevel_id']){
			    	
			    $data_insert = $this->report_emp_model->update_rowlevel($data);
			    
			    redirect('admin/report_emp/get_rowlevel_class' , 'refresh');
			}else{
			   // $data_insert = $this->report_emp_model->add_rowlevel($data);
		
			if($this->report_emp_model->add_rowlevel($data))
        	{
        	   
        		$this->session->set_flashdata('Sucsess', lang('br_add_suc'));
                redirect('admin/report_emp/get_rowlevel_class' , 'refresh');
        	}else{
        		$this->session->set_flashdata('Failuer',lang('br_add_error'));
                redirect('admin/report_emp/get_rowlevel_class' , 'refresh');
            }
			}
	}
	/////////////////////////////
	
		public function delete_rowlevel()
	{
        $data['rowlevel_id']        = $this->uri->segment(4);
        $data['level_id']           = $this->uri->segment(5);
       //  print_r($data['level_id'] );die;
        
		if($this->report_emp_model->delete_rowlevel($data))

			{
				$this->session->set_flashdata('Sucsess', lang('br_add_suc'));

			 redirect('admin/report_emp/get_rowlevel_class');

			}else{
        		$this->session->set_flashdata('Failuer',lang('br_add_error'));
               redirect('admin/report_emp/get_rowlevel_class');
            }
	}
	//////////////////////////////
	
		public function add_class()
	{
	        $data['school_id']        = $this->session->userdata('SchoolID');
		   	$data['class_name']		  = $this->input->post('class_name'); 
			$data['class_nameEN']     = $this->input->post('class_nameEN');
			$data['class_id']         = $this->uri->segment(4);
			if($data['class_id']){
			    $data_insert = $this->report_emp_model->update_class($data);
			}else{
			    $data_insert = $this->report_emp_model->add_class($data);
			}
			if($data_insert)
        	{
        		$this->session->set_flashdata('Sucsess', lang('br_add_suc'));
               redirect('admin/report_emp/get_rowlevel_class');
        	}else{
        		$this->session->set_flashdata('Failuer',lang('br_add_error'));
               redirect('admin/report_emp/get_rowlevel_class');
            }
	}
	
	///////////////////////////////////
			public function delete_class()
	{
        $data['class_id']        = $this->uri->segment(4);
		if($this->report_emp_model->delete_class($data))

			{
				$this->session->set_flashdata('Sucsess', lang('br_add_suc'));
               redirect('admin/report_emp/get_rowlevel_class');
        	}else{
        		$this->session->set_flashdata('Failuer',lang('br_add_error'));
               redirect('admin/report_emp/get_rowlevel_class');
            }
	}
	
	///////////////////////////////////////

			public function student_evaluation_report_details()

	{
	    $Data['Timezone']              = $this->setting_model->converToTimezone();
	    $Data['Lang']                  = $this->session->userdata('language');
       
        $Data['level']                 = $this->input->post('level');
	    $Data['RowLevel']              = $this->input->post('RowLevel');
	    $Data['Classgg']                 = $this->input->post('Classgg');
	    $Data['subject']               = $this->input->post('subject');
	   
	    
 
          if( $Data['level']  ){
            $Data['row_level']    = $this->students_affairs_model->get_rowlevel($Data);
          
            $Data['get_class']    = $this->students_affairs_model->getclass($Data);
           }
           
          if($Data['RowLevel'] &&	$Data['Classgg']   ){
           $Data['get_Subject']  = $this->students_affairs_model->get_subject_per_row_level_class(  $Data['RowLevel'],$Data['Classgg']   );
           
           }
            if( $Data['level']  &&	$Data['subject']){
       
	       $Data['GetData']       = $this->report_emp_model->students_Behavior_report($Data);
	      
	     if( $Data['subject'] ){
	        $Data['GetData_sub']       = $this->report_emp_model->get_subject_data($Data);  
	     }
//	print_r( $Data['GetData_sub']);die;
		$Data['get_eval_item'] 	       = $this->report_emp_model->students_evaluation_items($Data);
		$Data['GetData_absence']  = $this->report_emp_model->students_eval_absence_report2($Data);
            }
		$this->load->admin_template('view_all_data_ksiscs',$Data);

	}
	public function show_father_aceept()
	{
		$Data['level']     = $LevelID    = $this->input->post('level');;
        $Data['RowLevel']  = $RowLevelID = $this->input->post('RowLevel');;
        $Data['ClassID']     = $ClassID    = $this->input->post('Classgg');;
        
		if( $Data['level']  ){
            $Data['row_level']    = $this->students_affairs_model->get_rowlevel($Data);
          
            $Data['get_class']    = $this->students_affairs_model->getclass($Data);
           }
        if ($LevelID || $RowLevelID || $ClassID) {
            $Student  = get_student_select_in();
            $Data['Contact']  = $this->report_emp_model->show_father_aceept($Data);
			//print_r($this->db->last_query());die;
		}

        $this->load->admin_template('view_show_father_aceept', $Data);
	}

	public function father_condtions()
	{
        $this->data['father_id']    = $this->uri->segment(4);
       
		$this->load->view('view_accept_father_condtions' ,$this->data ); 

	}
	
////////////get_update_report

	public function get_update_report()

	{
		$this->data['ApiDbname']     = $this->ApiDbname;
		
		$this->data['GetReport']           = $this->report_emp_model->get_update_report($this->data['Lang']);

		$this->load->admin_template('view_get_update_report',$this->data);

	}

}////// END CLASS
