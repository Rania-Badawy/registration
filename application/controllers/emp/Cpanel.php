<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Cpanel extends CI_Controller
{
    private $data = array();
    function __construct()
    {
        parent::__construct();
        $this->load->model(array( 'admin/setting_model'));
        $this->data['UID']            = $this->session->userdata('id');
        $this->data['YearID']         = $this->session->userdata('YearID');
        $this->data['Year']           = $this->session->userdata('Year');
        $this->data['Semester']       = $this->session->userdata('Semester');
        $this->data['Lang']           = $this->session->userdata('language');
        $this->data['SchoolID']       = $this->session->userdata('SchoolID');
    }
   
    public function index(){
       
        $this->load->emp_template('view_supervisor', $this->data);
    }
   
}
