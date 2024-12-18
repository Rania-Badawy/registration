<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exam_result extends CI_Controller {

    	private $data = array() ;
		
    function __construct()
    {
        parent::__construct();     
	   $this->load->model(array('admin/Exam_result_model','admin/setting_model','admin/Permission_model','emp/report_model'));
	   $this->data['UID']            = $this->session->userdata('id');
	   $this->data['YearID']         = $this->session->userdata('YearID');
	   $this->data['Year']           = $this->session->userdata('Year');
	   $this->data['Semester']       = $this->session->userdata('Semester');
	   $this->data['Lang']           = $this->session->userdata('language');
	   $get_api_setting              = $this->setting_model->get_api_setting(); 
	   $this->ApiDbname              = $get_api_setting[0]->{'ApiDbname'};
        
    }
    public function index()
	{
	         if(! $this->session->userdata('id')){
		      redirect('home/login');
		      }
		     $Data['Lang']           = $this->session->userdata('language');

	         $Data['ID']            = $this->uri->segment(4);
	         
	         $Data['edit']          = $this->uri->segment(5);
	         
	         $Data['year_id']       = $this->setting_model->get_current_year();

			 $Data['exam_result']   = $this->Exam_result_model->exam_result_details_per_emp($Data);

			 $this->load->emp_template('config_exam_result',$Data);
	}
	///////////////
	public function student_degree()
	{
	         $Data['exam_ID']           = $Data['typeid']  = $this->uri->segment(4);
	         
	         $Data['UID']               = $this->session->userdata('id');
	        
			 $Data['year_id']            = $this->setting_model->get_current_year();
			 
			 $Data['get_per_type']      = $this->Permission_model->Get_PerType();
	         
	         if($Data['exam_ID']){
	             
	         $Data['get_exam_result']   = $this->Exam_result_model->get_exam_result($this->data['Lang'],$Data['exam_ID']);
		     
		     $Data['Subjectid']         = $Data['get_exam_result'][0]->subject_ID;
	             
	         $Data['getexamtype']       = $this->Exam_result_model->get_exam_type_add($this->data['Lang'],$Data);
	          
		     $Data['get_exam_result']   = $this->Exam_result_model->get_exam_result($this->data['Lang'],$Data['exam_ID']);
		     
	         }
	         
		     $Data['get_type']          = $this->Exam_result_model->get_type();
			 
			 $Data['type']              = $Data['get_type']['Type'];
			 
		     $Data['get_degree_type']   = $this->Exam_result_model->get_degree_type($Data);
			 
			 $this->load->emp_template('add_student_degree_new',$Data);
	}
	/////////////////////////
	public function student_degree1()
	{
	   
			 $Data['exam_ID']           = $this->uri->segment(4);
			 
			 $Data['class_id']          = $this->input->post('classid');
			 
			 $row_class                 = explode('/',$Data['class_id']);
			 
			 $Data['row_level_id']      = $row_class[0];
			 
		     $Data['classid']           = $row_class[1];
			
			$Data['Subjectid']          = $this->input->post('Subjectid');
			
			$Data['typeid']             = $this->input->post('typeid');
			
			$Data['main_exam_type']     = $this->input->post('main_exam_type');
			
			$Data['year_id']            = $this->setting_model->get_current_year();
			
			$Data['get_type']           = $this->Exam_result_model->get_type();
			
			$Data['show_edit']          = $this->Exam_result_model->get_show_edit();
			
			$Data['show_edit_emp']      = $Data['show_edit']['certificate_emp'];
			 
			$Data['type']               = $Data['get_type']['Type'];
		  
		     if(!empty($Data['class_id'])){
		     
		     $Data['get_degree_type']   = $this->Exam_result_model->get_degree_type($Data);
		
			 $Data['get_student']         = $this->Exam_result_model->get_student($Data);

		     }
		     
		     $this->load->view('admin/student_degree1.php',$Data);
	    
	}
	///////////////
	public function add_student_degree()
	{
	    
	    $Timezone                       = $this->setting_model->converToTimezone();
	    
	    $exam_ID  =$Data['exam_ID']     = $this->uri->segment(4);
	  
	    $Data['id']                     = $this->session->userdata('id');
	    
	    $Count                          = $this->input->post('KeyCount');

	   // if($Data['monthid']!=0){
	        
		for($i = 0 ; $i<= $Count ; $i++ )

		{

			$Data['student_id']          = $this->input->post('student_id_'.$i);
			
			$Data['notes']               = $this->input->post('notes_'.$i);
			 
		    $Data['degree_theoretical']  = $this->input->post('degree_theoretical_'.$i);
		    
		    $Data['degree_practical']    = $this->input->post('degree_practical_'.$i);
		    
		    $Data['year_works']          = $this->input->post('year_works_'.$i);
		     
		    $Data['exam_result_id']      = $this->input->post('exam_result_id');
		    
		    $Data['typeid']              = $this->input->post('typeid');
		    
		    $Data['main_exam_type']      = $this->input->post('main_exam_type');

		    $Data['get_exam_result_id']  = $this->Exam_result_model->get_exam_result_id($Data);
		      
            if($Data['get_exam_result_id']){
                
			$this->db->query("UPDATE exam_result_details SET  theoretical_degree = '".$Data['degree_theoretical']."' ,practical_degree = '".$Data['degree_practical']."' ,year_works_degree = '".$Data['year_works']."', notes = '".$Data['notes']."' , main_exam_type = '".$Data['main_exam_type']."',exam_type_id = '".$Data['typeid']."', updated_at = '".$Timezone."' ,Updated_by = '".$Data['id']."' where exam_result_master_id = '".$exam_ID."' AND student_id = ".$Data['student_id']." AND main_exam_type = '".$Data['main_exam_type']."' AND exam_type_id = '".$Data['typeid']."' ");
            
                
            }else{
                
            $this->db->query("insert into exam_result_details SET exam_result_master_id = '".$exam_ID."'  , student_id = '".$Data['student_id']."' , theoretical_degree = '".$Data['degree_theoretical']."' ,practical_degree = '".$Data['degree_practical']."' , year_works_degree = '".$Data['year_works']."' , notes = '".$Data['notes']."' , main_exam_type = '".$Data['main_exam_type']."',exam_type_id = '".$Data['typeid']."', inserted_at = '".$Timezone."' ,inserted_by = '".$Data['id']."' ");
            
                
            }
		}
			
			 $this->session->set_flashdata('SuccessAdd',lang('br_add_suc'));			   

		redirect('emp/exam_result/student_degree/'.$exam_ID,'refresh');
	}
	///////////////////////
	public function student_degree_report()
	{
	    if(! $this->session->userdata('id')){
		      redirect('home/login');
		      }
		$Data['type']                = $this->session->userdata('type');
		
	    $Data['row_level']           = $this->Exam_result_model->get_row_level_per_emp($this->data['Lang']);
	    
	    $Data['month']               = $this->Exam_result_model->get_month($this->data['Lang']);
	    
        $Data['exam_type']           = $this->Exam_result_model->get_exam_type($this->data['Lang']);
        
        $Data['row_level_id']        = $this->input->post('row_level_id');
        
        $Data['classid']             = $this->input->post('classid');
        
        $Data['SelectUser']          = $this->input->post('SelectUser');
        
        $Data['monthid']             = $this->input->post('monthid');
        
        $Data['exam_type_id']        = $this->input->post('exam_type_id');

        if($Data['row_level_id']){
            
        $Data['get_subject']     = $this->Exam_result_model->get_subject_per_class($Data);

        $Data['get_student']     = $this->Exam_result_model->get_student_per_class($Data);
                
        }
          
        $this->load->emp_template('student_degree_report',$Data);
    }
    
    ///////////////////////
    public function config_certificate()
	{
	         if(! $this->session->userdata('id')){
		      redirect('home/login');
		      }
		      
		     $Data['ApiDbname']     = $this->ApiDbname;
		     
		     $Data['UID']           = $this->session->userdata('id');
		     
		     $Data['row_level_id']  = $this->uri->segment(4);
        
             $Data['Subjectid']     = $this->uri->segment(5);
             
             $Data['SemesterID']    = $this->uri->segment(6);
             
		    if(!$Data['SemesterID']){
		        
		    $Data['SemesterID'] =  $this->setting_model->get_semester();
		    
		    }
		     
		     $Data['Lang']          = $this->session->userdata('language');
			 
			 $Data['year_id']       = $this->setting_model->get_current_year();
			 
			 $Data['Semesters']     = $this->setting_model->get_semesters();
			 
		     $Data['exam_result']   = $this->Exam_result_model->config_certificate_details_emp($Data);
		     
			 $this->load->emp_template('view_config_certificate',$Data);
	}
	///////////////
	public function student_degree_certificate()
	{
	         $Data['Lang']              = $this->session->userdata('language');
	     
	         $Data['exam_ID']           = $this->uri->segment(4);
	         
	         $Data['UID']               = $this->session->userdata('id');
	         
	         $Data['type']              = $this->session->userdata('type');
	         
	         $Data['year_id']           = $this->setting_model->get_current_year();
	         
	         if($Data['exam_ID']){
	          
		       $Data['get_exam_result']   = $this->Exam_result_model->config_certificate_show($Data);
		  //print_r($Data['get_exam_resul/t']);die;
	         }
	 
			 $this->load->emp_template('view_student_degree_certificate',$Data);
	}
	////////////////////////
	public function student_certificate_show()
	{
	     $Data['ApiDbname']          = $this->ApiDbname;
	     
	     $Data['year_id']            = $this->setting_model->get_current_year();
	     
	     $Data['current_Semester']   = $this->setting_model->get_semester();
	    
         $Data['type']               = $this->session->userdata('type');
    
		 $Data['exam_ID']            = $this->uri->segment(4);
		 
		 $Data['get_exam_result']    = $this->Exam_result_model->config_certificate_show($Data);
		 
		 $Data['classid']            = $this->input->post('classid');

		 $Data['Subjectid']          = $Data['get_exam_result'][0]->subject_ID;
		 
		 $Data['row_level_id']       = $Data['get_exam_result'][0]->row_level_ID;
		 
	     $Data['Semesterid']         = $Data['get_exam_result'][0]->semester_ID;
	     
	     $Data['exam_type_id']       = $Data['get_exam_result'][0]->exam_types_ID;
	     
	     $Data['exam_types_name']    = $Data['get_exam_result'][0]->exam_types_name;
	     
	     $Data['exam_types_degree']  = $Data['get_exam_result'][0]->exam_types_degree;
		
		
	     if($Data['classid']){
	
		 $Data['get_student']         = $this->Exam_result_model->get_student($Data);

	     }
	     
	     $this->load->view('admin/view_student_certificate_show.php',$Data);
	    
	}
	///////////////////
	public function add_student_degree_certificate()
	{
	    
	    $Timezone                       = $this->setting_model->converToTimezone();
	    
	    $exam_ID  =$Data['exam_ID']     = $this->uri->segment(4);

	    $Data['id']                     = $this->session->userdata('id');
	    
	    $Count                          = $this->input->post('KeyCount');
	    
	    $x                              = 0;
	        
		for($i = 0 ; $i<= $Count ; $i++ )

		{

			$Data['student_id']        = $this->input->post('student_id_'.$i);
			
			$Data['notes']             = $this->input->post('notes_'.$i);
			 
		    $Data['stu_degree']        = $this->input->post('stu_degree_'.$i);
		 
		    $Data['check_stu_degree']  = $this->Exam_result_model->check_stu_degree($Data);
            
            // if(!empty($Data['stu_degree'])){
                
            //     $x = 1;
                
                if($Data['check_stu_degree']){
                    
    			$this->db->query("UPDATE student_degree_certificate SET  degree = '".$Data['stu_degree']."', updated_at = '".$Timezone."' ,Updated_by = '".$Data['id']."' where certificate_id = '".$exam_ID."' AND student_id = ".$Data['student_id']." ");
                
                    
                }else{
                    
                $this->db->query("insert into student_degree_certificate SET certificate_id = '".$exam_ID."'  , student_id = '".$Data['student_id']."' ,degree = '".$Data['stu_degree']."' , inserted_at = '".$Timezone."' ,inserted_by = '".$Data['id']."' ");
                
                    
                }
            }
            
// 		}

// 		if($x == 0){
		    
// 		    $mes = lang('no_enter_numder_degree');
		
// 		    echo "<script> 
//                       alert('$mes');
//                       window.location.replace('".site_url()."/emp/exam_result/student_degree_certificate/'+$exam_ID);
//                       </script>";

		    
// 		}else{
			
		 $this->session->set_flashdata('SuccessAdd',lang('br_add_suc'));			   

		redirect('emp/exam_result/student_degree_certificate/'.$exam_ID,'refresh');
		
// 		}

	}
	///////////////////////////////////
	public function exam_type_report()
	{
	    if(! $this->session->userdata('id')){
		      redirect('home/login');
		      }
		
		$Data['Lang']                = $this->session->userdata('language');
		
		$Data['UID']                 = $this->session->userdata('id');

		$Data['ApiDbname']           = $this->ApiDbname;
		
		$Data['row_level_id']        = $this->uri->segment(4);
        
        $Data['Subjectid']           = $this->uri->segment(5);
		
		$Data['get_class']           = $this->Exam_result_model->get_class_per_emp($Data,$this->data['Lang']);

	    $Data['Semester']            = $this->Exam_result_model->get_semester($this->data['Lang']);
	    
	    $Data['exam_type']           = $this->Exam_result_model->get_exam_type($this->data['Lang']);
        
        $Data['classid']             = $this->input->post('classid');
        
        $Data['SelectUser']          = $this->input->post('SelectUser');
        
        $Data['Semesterid']          = $this->input->post('Semesterid');
        
        $Data['exam_type_id']        = implode(',',$this->input->post('exam_type_id'));
            
        $Data['year_id']            = $this->setting_model->get_current_year();


        if($Data['classid']){
            
            $Data['report']              = 1;
            
            $Data['current_year_id']     = $this->setting_model->get_current_year();
            
       
            $Data['get_all_student']     = $this->Exam_result_model->get_all_student($Data);
            
            $Data['exam_type_report']    = $this->Exam_result_model->get_exam_type_report($Data);
            
            $Data['get_student']         = $this->Exam_result_model->get_student_per_class($Data);
        
        }
          
        $this->load->emp_template('view_exam_type_report',$Data);
    }
    ///////////////
	public function Conduct()
	{
	   $data['ApiDbname']       = $this->ApiDbname;
	   $data['Lang']            = $this->session->userdata('language');
       $data['UID']             = $this->session->userdata('id');
       $data['get_class']       = $this->report_model->get_class_school_active($data['Lang']);
       $data['Semester']        = $this->Exam_result_model->get_semester($data['Lang']);
       $data['ExamType']        = $this->Exam_result_model->exam_type_cert($data['Lang']);
	   $data['Semesterid']      = $this->uri->segment(4);
	   $data['row_level_id']    = $this->uri->segment(5);
	   $data['classid']         = $this->uri->segment(6);
	   $data['rowlevelclass']   = $data['row_level_id']."/".$data['classid'];

       if($data['classid']){
  
          $data['GetData']       = $this->Exam_result_model->get_student_condact($data);
          
    	}
	    
		  $this->load->emp_template('view_conduct_certificate',$data);
	}

}

