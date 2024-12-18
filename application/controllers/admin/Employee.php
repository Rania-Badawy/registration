<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Employee extends MY_Admin_Base_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('admin/employee_model', 'admin/setting_model'));
		$this->load->library('get_data_admin');
		$this->data['UID']            = $this->session->userdata('id');
		$this->data['YearID']         = $this->session->userdata('YearID');
		$this->data['Year']           = $this->session->userdata('Year');
		$this->data['Semester']       = $this->session->userdata('Semester');
		$this->data['Lang']           = $this->session->userdata('language');
		$this->data['SchoolID']       = $this->session->userdata('SchoolID');
		$get_api_setting              = $this->setting_model->get_api_setting();
		$this->ApiDbname              = $get_api_setting[0]->{'ApiDbname'};
	}
	public function index($Name = "", $NumberID = "", $IsActive = 1)
	{
	   
		$Data['get_employee']    = "NULL";
		$Data['IsActive']          = 1;
		
		if ($this->uri->segment(4) == 'show') {
		    
			$Data['get_employee']     = $this->employee_model->get_employee($Data);
			$Data['Name']            = '';
			$Data['NumberID']            = '';
			
		}elseif($this->uri->segment(4) == 'disactive'){
		    
		    $Data['IsActive']         = 0;
		    $Data['get_employee']     = $this->employee_model->get_employee($Data);
		}elseif (($Name != "") || $NumberID != "") {
		    $Data['Name']                = filter_var($Name, FILTER_SANITIZE_STRING);
			$Data['get_employee']        = $this->employee_model->get_employee_admin($Name, $NumberID, $IsActive);
			$Data['Name']                = $Name;
			$Data['Name_en']             = $Name;
			$Data['NumberID']            = $NumberID;
		}

		$this->load->admin_template('view_employee', $Data);
	}
	///////////
	public function new_employee()
	{
		$Data['Nationality']     = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllNationalities"));

		$this->load->admin_template('view_new_employee', $Data);
	}
	///////////
	public function add_employee()
	{
	
		$this->form_validation->set_rules('Name', 'lang:br_Name', 'required|min_length[4]|max_length[50]|xss_clean');
		$this->form_validation->set_rules('numberid', 'lang:br_NumberID', 'required');
		$this->form_validation->set_rules('nationality', 'lang:br_nationality', 'required');
		$this->form_validation->set_rules('UserName', 'lang:br_User_Name', 'required|min_length[6]|max_length[50]|xss_clean|is_unique[contact.User_Name]');
		$this->form_validation->set_rules('Password', 'lang:br_Password', 'required|min_length[6]|max_length[50]|xss_clean');
		$this->form_validation->set_rules('Mobile', 'lang:br_Mobile', 'min_length[8]|max_length[15]|xss_clean');
	
		if ($this->form_validation->run() === false) {
			$this->new_employee();
		} else {
			$data['Name']           = $this->security->xss_clean(filter_var($this->input->post('Name'), FILTER_SANITIZE_STRING));
			$data['nationality']    = $this->security->xss_clean($this->input->post('nationality'));
			$data['numberid']       = $this->security->xss_clean(str_replace('', ' ', $this->input->post('numberid')));
			$data['Mobile']         = $this->security->xss_clean($this->input->post('Mobile'));
			$data['Email']          = $this->input->post('Email');
			$data['UserName']       = str_replace(" ", "", $this->security->xss_clean($this->input->post('UserName')));
			$data['Password']       = str_replace(" ", "", md5($this->config->item('encryption_key') . $this->input->post('Password')));
			
			
			if ($this->employee_model->add_employee($data)) {
				$this->session->set_flashdata('SuccessAdd', lang('br_add_suc'));
				redirect('admin/employee', 'refresh');
			} else {
				$this->session->set_flashdata('ErrorAdd', lang('br_add_error'));
				redirect('admin/employee', 'refresh');
			}
		}
	}
	/////////
	public function get_employee($ID = NULL)
	{
		$Data = array();
		$Data['Nationality']        = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllNationalities"));
		$Data['get_employee']       = $this->employee_model->get_employee_edit($ID);
		$Data['Getupdate']          = $this->employee_model->get_updated($ID);

		$this->load->admin_template('view_edit_employee', $Data);
	
	}
	/////////
	public function edit_employee($ConID = NULL)
	{
		
	  $this->form_validation->set_rules('Name', 'lang:br_Name','required|min_length[4]|max_length[50]|xss_clean');
		
	  $this->form_validation->set_rules('User_Name', 'lang:br_User_Name','required|min_length[4]|max_length[30]|xss_clean');
	  
	  $this->form_validation->set_rules('numberid', 'lang:br_NumberID','required');
	  
	  if($this->form_validation->run() === false)

		{
			$this->get_employee($ConID);
		}else{
		$data['Name']           = $this->security->xss_clean($this->input->post('Name'));
		$data['UserName']       = str_replace(" ", "", $this->security->xss_clean($this->input->post('User_Name')));
		$data['OldPass']        = $this->security->xss_clean($this->input->post('OldPass'));
		$data['Password']       = $this->security->xss_clean($this->input->post('Password'));
		$data['numberid']       = $this->security->xss_clean(str_replace('', ' ', $this->input->post('numberid')));
		$data['nationality']    = $this->security->xss_clean($this->input->post('nationality'));
		$data['am_mobile']      = $this->security->xss_clean($this->input->post('am_mobile'));
		$data['Email']          = $this->security->xss_clean($this->input->post('Email'));
		$data['ConID']          = $this->security->xss_clean($this->input->post('ConID'));
		$data['date']           = $this->setting_model->converToTimezone();
		if (empty($data['Password'])) {
			$data['NewPass'] = $data['OldPass'];
		} else {
			$data['NewPass'] = str_replace(" ", "", md5($this->config->item('encryption_key') . $data['Password']));
		}
		if ($this->employee_model->edit_employee($data)) {
			$this->session->set_flashdata('SuccessAdd', lang('br_add_suc'));
			redirect('admin/employee', 'refresh');
		} else {
			$this->session->set_flashdata('ErrorAdd', lang('br_add_error'));
			redirect('admin/employee', 'refresh');
		}
		}
	}
	///////////////////////////////
	public function check_active($ID = 0)
	{
		$query = $this->db->query("SELECT Isactive FROM contact WHERE ID = '" . $ID . "' ")->row_array();
		if (sizeof($query) > 0) {
		
			if((int)$query['Isactive'] == 0) {
				    $CheckActive = 1;
			}else{
			        $CheckActive = 0;
			    }
		}
		$this->db->query("UPDATE contact SET  Isactive = '" . $CheckActive . "' WHERE ID = '" . $ID . "' ");
		$this->session->set_flashdata('SuccessAdd', lang('br_add_suc'));
		redirect('admin/employee', 'refresh');
	}
	////////////////////////////////
	public function delete_emp_check()
	{
		$data['EmpID']           = $this->input->post('EmpID');
		$empArray                = explode(",",$data['EmpID']);
		foreach($empArray as $ID){
		$query = $this->db->query("SELECT Isactive FROM contact WHERE ID = '" . $ID . "' ")->row_array();
		if (sizeof($query) > 0) {
		
			if ((int)$query['Isactive'] == 0) {
				$CheckActive = 1;
			}else{
			        $CheckActive = 0;
			    }
		}
		$this->db->query("UPDATE contact SET  Isactive = '" . $CheckActive . "' $type WHERE ID = '" . $ID . "' ");
		    
		}
		 
	}
	
}///////////////////END CLASS