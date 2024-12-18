<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Employee extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('admin/employee_model','admin/namespace_model'));
		$this->load->library('get_data_admin');
	    $this->data['UID']            = $this->session->userdata('id');
	    $this->data['YearID']         = $this->session->userdata('YearID');
	    $this->data['Year']           = $this->session->userdata('Year');
	    $this->data['Semester']       = $this->session->userdata('Semester');
	    $this->data['Lang']           = $this->session->userdata('language');
		$this->data['SchoolID']       = $this->session->userdata('SchoolID');

    }
	////////////index
	public function index($show = "NULL")
	{
		//////////////////////////////////Permission///////////////////////////////////////////////
		$Data['page']     = $this->uri->segment(3);
		$this->get_data_admin->check_user_permission($Data['page']);
		$Data['permlevel']   = $this->session->userdata('permlevel');
		$Data['permAdd']     = $this->session->userdata('permAdd');
		$Data['permEdit']    = $this->session->userdata('permEdit');
		$Data['permDelete']  = $this->session->userdata('permDelete');
		$Data['permVeiw']    = $this->session->userdata('permVeiw');
		
		//////////////////////////////////Permission///////////////////////////////////////////////
        $Data['show']             = $show ;
		$Data['get_employee']     = $this->employee_model->get_employee();
		$this->load->admin_template('view_employee',$Data);
	}
	////////////new_employee
	public function new_employee()
	{
		$Data['GetJobTitle']     = $this->employee_model->get_job_title($this->data['Lang']);
		$Data['GetLevel']        = $this->employee_model->get_level();
		$Data['Nationality']     = $this->namespace_model->get_data_parent_ID(1,$this->data['Lang']);
		$Data['GetAllPer']       = $this->employee_model->get_group() ;

		$this->load->admin_template('view_new_employee',$Data);
	}
	///////////add_employee
	public function add_employee()
	{
		$data['JobTitle']           = $this->security->xss_clean($this->input->post('JobTitle'));
		if($data['JobTitle'] !=0)
		{
		$this->form_validation->set_rules('JobTitle', 'lang:er_job_title','integer|xss_clean|is_unique[employee.jobTitleID]');
		}
		$Mobile = $this->input->post("Mobile");
		if(!empty($Mobile))
		{
		  $this->form_validation->set_rules('Mobile', 'lang:br_Mobile','required|min_length[8]|max_length[15]|xss_clean');

		}
		
			$this->form_validation->set_rules('Name', 'lang:br_Name','required|min_length[4]|max_length[50]|xss_clean');
			$this->form_validation->set_rules('numberid', 'lang:br_NumberID','required|callback_checkUniqueNumberAdd');
			$this->form_validation->set_rules('nationality', 'lang:br_nationality','required');
			$this->form_validation->set_rules('UserName', 'lang:br_User_Name','required|min_length[6]|max_length[30]|xss_clean|is_unique[contact.User_Name]');
			$this->form_validation->set_rules('Password', 'lang:br_Password','required|min_length[6]|max_length[15]|xss_clean');
			$this->form_validation->set_rules('specialization', '','');
			$this->form_validation->set_rules('BirhtDate', '','');
			$this->form_validation->set_rules('JobNow', '','');
			$this->form_validation->set_rules('TeacherLevel', '','');
			$this->form_validation->set_rules('TeacherDegree', '','');
			$this->form_validation->set_rules('Salary', '','');
			$this->form_validation->set_rules('ServiceStart', '','');
			$this->form_validation->set_rules('ContractDate', '','');
			$this->form_validation->set_rules('note', '','');
			$this->form_validation->set_rules('GetGroup','','');

			if($this->form_validation->run() === false)
		    {
			      $this->new_employee();
		    }else
		        {
					$data['Name']           = $this->security->xss_clean($this->input->post('Name'));
					$data['numberid']       = $this->security->xss_clean($this->input->post('numberid'));
					$data['nationality']    = $this->security->xss_clean($this->input->post('nationality'));
					$data['Mobile']         = $this->security->xss_clean($this->input->post('Mobile'));
					$data['GetGroup']       = (int)$this->input->post('GetGroup');
					$data['UserName']       = str_replace(" ","",$this->security->xss_clean($this->input->post('UserName')));
					$data['Password']       = str_replace(" ","",md5($this->config->item('encryption_key').$this->input->post('Password')));
					$data['specialization'] = $this->security->xss_clean($this->input->post('specialization'));
					$data['BirhtDate']      = $this->security->xss_clean($this->input->post('BirhtDate'));
					$data['JobNow']         = $this->security->xss_clean($this->input->post('JobNow'));
					$data['TeacherLevel']   = $this->security->xss_clean($this->input->post('TeacherLevel'));
					$data['TeacherDegree']  = $this->security->xss_clean($this->input->post('TeacherDegree'));
					$data['Salary']         = $this->security->xss_clean($this->input->post('Salary'));
					$data['ServiceStart']   = $this->security->xss_clean($this->input->post('ServiceStart'));
					$data['EmpType']        = $this->security->xss_clean($this->input->post('EmpType'));
					$data['ContractType']   = $this->security->xss_clean($this->input->post('ContractType'));
					$data['ContractDate']   = $this->security->xss_clean($this->input->post('ContractDate'));
					$data['note']           = $this->security->xss_clean($this->input->post('note'));
					if($this->employee_model ->add_employee($data))
					{
						$this->session->set_flashdata('SuccessAdd',lang('br_add_suc'));
			            redirect('admin/employee','refresh');
					}else{
							$this->session->set_flashdata('ErrorAdd',lang('br_add_error'));
			                redirect('admin/employee','refresh');
						  }
		      }
	}
	/////////get_employee
	public function get_employee($Token= NULL)
	{
		$Data = array();
		$Data['GetJobTitle']        = $this->employee_model->get_job_title($this->data['Lang']);
		$Data['GetLevel']         = $this->employee_model->get_level();
		$Data['get_employee']       = $this->employee_model->get_employee_edit($Token);
		$Data['GetAllPer']       = $this->employee_model->get_group() ;

		if(is_array($Data['get_employee'] ))
		{
		  $this->load->admin_template('view_edit_employee',$Data);
		}else{exit('Error 5462310');}
		
	}
	/////////edit_employee
	public function edit_employee($Token= NULL)
	{
		$data['JobTitle']           = $this->security->xss_clean($this->input->post('JobTitle'));
		if($data['JobTitle'] !=0)
		{
		$this->form_validation->set_rules('JobTitle', 'lang:er_job_title','integer|xss_clean|callback_check_job_title');
		}
		$this->form_validation->set_rules('numberid', 'lang:br_NumberID','required|callback_checkUniqueNumber');
		$this->form_validation->set_rules('User_Name', 'lang:br_User_Name','required|min_length[6]|max_length[30]|xss_clean|callback_check_user_name');
		$this->form_validation->set_rules('Name', 'lang:br_Name','required|min_length[4]|max_length[50]|xss_clean');

		if($this->form_validation->run() === false)
		
		    {
			    $this->get_employee($Token);
		    }else{
					$data['ConID']          = $this->security->xss_clean($this->input->post('ConID'));
					$data['numberid']       = $this->security->xss_clean($this->input->post('numberid'));
					$data['EmpID']          = $this->security->xss_clean($this->input->post('EmpID'));
					$data['Name']           = $this->security->xss_clean($this->input->post('Name'));
					$data['UserName']       = str_replace(" ","",$this->security->xss_clean($this->input->post('User_Name')));
					$data['Isactive']       = (int)$this->input->post('Isactive');
					$data['specialization'] = $this->security->xss_clean($this->input->post('specialization'));
                    $data['GetGroup']       = (int)$this->input->post('GetGroup');
					$data['BirhtDate']      = $this->security->xss_clean($this->input->post('BirhtDate'));
					$data['JobNow']         = $this->security->xss_clean($this->input->post('JobNow'));
					$data['TeacherLevel']   = $this->security->xss_clean($this->input->post('TeacherLevel'));
					$data['TeacherDegree']  = $this->security->xss_clean($this->input->post('TeacherDegree'));
					$data['Salary']         = $this->security->xss_clean($this->input->post('Salary'));
					$data['ServiceStart']   = $this->security->xss_clean($this->input->post('ServiceStart'));
					$data['EmpType']        = (int)$this->input->post('EmpType');
					$data['ContractType']   = (int)$this->input->post('ContractType');
					$data['ContractDate']   = $this->security->xss_clean($this->input->post('ContractDate'));
					$data['note']           = $this->security->xss_clean($this->input->post('note'));
					$data['OldPass']        = $this->security->xss_clean($this->input->post('OldPass'));
					$data['Password']       = $this->security->xss_clean($this->input->post('Password'));
					if(empty($data['Password'])){$data['NewPass'] = $data['OldPass'] ;}
					else{$data['NewPass'] = str_replace(" ","",md5($this->config->item('encryption_key').$data['Password'])) ;}
					if($this->employee_model ->edit_employee($data))
					{
						$this->session->set_flashdata('SuccessAdd',lang('br_add_suc'));
			            redirect('admin/employee','refresh');
					}else{
							$this->session->set_flashdata('ErrorAdd',lang('br_add_error'));
			                redirect('admin/employee','refresh');
						 }
			}
	}
	public function get_vistor()
	{
		$Data['get_vistor']       = $this->employee_model->get_vistor();
		$this->load->admin_template('view_get_vistor',$Data);
	}
	public function new_vistor()
	{
		$this->load->admin_template('view_new_vistor');
	}
	public function add_new_vistor()
	{
		$this->form_validation->set_rules('Name',   'lang:br_Name','required|min_length[4]|max_length[20]|xss_clean');
		$this->form_validation->set_rules('mail',   'lang:br_Email','required|valid_email|xss_clean');
		$this->form_validation->set_rules('Mobile', 'lang:br_Mobile','required|min_length[10]|max_length[15]|xss_clean');
		if($this->form_validation->run() === false)

		{
			$this->new_vistor();
		}else{
				$data['Name']         = $this->security->xss_clean($this->input->post('Name'));
				$data['mail']         = $this->security->xss_clean($this->input->post('mail'));
				$data['Mobile']       = $this->security->xss_clean($this->input->post('Mobile'));
			if($this->employee_model ->add_new_vistor($data))
			{
				$this->session->set_flashdata('SuccessAdd',lang('br_add_suc'));
				redirect('admin/employee/get_vistor','refresh');
			}else{
				$this->session->set_flashdata('ErrorAdd',lang('br_add_error'));
				redirect('admin/employee/get_vistor','refresh');
			}



	      }

		}

	/////////////////////////////////////
	public function check_user_name()
	{
		$data['UserName']           = str_replace(" ","",$this->security->xss_clean($this->input->post('User_Name')));
		$data['EmpID']              = (int)$this->security->xss_clean($this->input->post('ConID'));
		if($this->employee_model->check_username($data['UserName']  ,$data['EmpID']  ))
		 {
			return TRUE ;
		 }else{
			    $this->form_validation->set_message('check_user_name', '' . lang('br_check_user') . '');
				return FALSE ; 
			  }
	}

	public function checkUniqueNumber()
	{
		$user              = $this->input->post('ConID');
		$numberid          = $this->input->post('numberid');
        $checkUniqueNumber = $this->employee_model->checkNumberUnique($user , $numberid)  ; 
		
		if(is_array($checkUniqueNumber)){
			$this->form_validation->set_message('checkUniqueNumber', lang('br_check_Number_ID').':'.$checkUniqueNumber['Name'].'-'.lang('br_Branche').':'.$checkUniqueNumber['SchoolName'] );
			return false;
		}else {
			return true;
		}
	}


public function checkUniqueNumberAdd()
	{
		$numberid          = $this->input->post('numberid');
        $checkUniqueNumber = $this->employee_model->checkNumberUniqueAdd($numberid)  ; 
		
		if(is_array($checkUniqueNumber)){
			$this->form_validation->set_message('checkUniqueNumberAdd', lang('br_check_Number_ID').':'.$checkUniqueNumber['Name'].'-'.lang('br_Branche').':'.$checkUniqueNumber['SchoolName'] );
			return false;
		}else {
			return true;
		}
	}

	//////////////////check_phone_number
	public function check_job_title()
	{
		$data['JobTitle']           = (int)$this->security->xss_clean($this->input->post('JobTitle'));
		$data['EmpID']              = (int)$this->security->xss_clean($this->input->post('EmpID'));
		$data['EMpNameHaveTittle']  = $this->employee_model->check_job_title($data) ;
		//print_r($data['EMpNameHaveTittle']);exit(); 
		if(is_array($data['EMpNameHaveTittle']) )
		{
			//exit(lang('br_check_job_title').'--'.$data['EMpNameHaveTittle']['Name']);
			$this->form_validation->set_message('check_job_title', lang('br_check_job_title').'--'.$data['EMpNameHaveTittle']['Name']);
				return FALSE ; 
		}else{
			    return TRUE ;
		}
	}////////////////////////delete_evaluation
	 public function delete_employee($Token = NULL)
	 {
		  if($this->employee_model->delete_employee($Token))
		  {
			 $this->session->set_flashdata('SuccessAdd',lang('br_add_suc'));
			 redirect('admin/employee','refresh');
		  }else{
				 $this->session->set_flashdata('ErrorAdd',lang('br_add_error'));
				 redirect('admin/employee','refresh');							
				} 
	 }
	 
	public function finger_print()
	{
		$Data['get_employee']     = $this->employee_model->get_employee();
		$this->load->admin_template('view_finger_print',$Data);

	}
	public function add_finger_print()
	{
		
	}
	////////////////////////////////
	public function delete_emp_check()
	{
		$data['EmpID']           = $this->input->post('EmpID');
		$this->db->query("DELETE contact , employee FROM employee INNER JOIN contact ON employee.`Contact_ID` = contact.ID WHERE contact.ID IN('".$data['EmpID']."') "); 
	}
	public function check_active($ID = 0)
	{
		$query = $this->db->query("SELECT Isactive FROM contact WHERE ID = '".$ID."' ")->row_array();
		if(sizeof($query)>0)
		{
			$CheckActive = 0 ;
			if((int)$query['Isactive'] == 0){$CheckActive = 1 ; }
		}
			 $this->db->query("UPDATE contact SET  Isactive = '".$CheckActive."' WHERE ID = '".$ID."' ");
			  $this->session->set_flashdata('SuccessAdd',lang('br_add_suc'));
			 redirect('admin/employee','refresh');

	}
}///////////////////END CLASS?>
