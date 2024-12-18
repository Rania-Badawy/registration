<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cpanel extends MY_Admin_Base_Controller
{
    private $data = array();
    function __construct()
    {
        parent::__construct();
         $this->load->library('get_data_admin');
        $this->load->model(array( 'admin/admin_model' ,'admin/setting_model' ));
       
        $this->data['Lang']           = $this->session->userdata('language');
      
        $get_api_setting = $this->setting_model->get_api_setting();
        $this->ApiDbname = $get_api_setting[0]->{'ApiDbname'};
       
    }
    ////////////////////////////////////////////
    public function index()
    {
        $this->load->admin_template('view_cpanel');
    }
    /////////////////////////
    public function chang_school($SchoolID = 0)
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->session->set_userdata('SchoolID', $SchoolID);
            $PageUrl = $_SERVER['HTTP_REFERER'];
            redirect($PageUrl, 'refresh');
        } else {
            echo 'error';
        }
    }
    
     public function admin()
    {
        $this->data['Lang']         = $this->session->userdata('language');
        $this->data['Admin']        = $this->admin_model->get_admin();
        $this->data['EmpAdmin']     = $this->admin_model->get_emp_admin();
        $this->data['Branch']       = $this->session->userdata('SchoolID') ;
        $this->data['GetSchool']    = json_decode(file_get_contents(lang('api_link')."/api/Schools/" . $this->ApiDbname . "/GetAllSchools"));
        //print_r($this->data['GetSchool']);die;
        // $this->data['GetSchool']  = $this->user_permission_model->get_school();
        $this->load->admin_template('view_admin_contact', $this->data);
    }
    
      public function add_new_admin($UID = 0)
    {

        $data['UID']            = (int)$this->input->post('Contact');
        $data['SchoolID']       = implode(",", $this->input->post('SchoolID'));
        $this->admin_model->add_admin($data);
        $this->session->set_flashdata('SuccessAdd', lang('br_add_suc'));
        redirect('admin/cpanel/admin', 'refresh');
    }
    
    public function change_type($UserID = 0)
    {

        $this->admin_model->change_type_users($UserID);
        $this->session->set_flashdata('SuccessAdd', lang('br_add_suc'));
        redirect('admin/cpanel/admin', 'refresh');
    }
  
    /////////////////END CLASS 	
}