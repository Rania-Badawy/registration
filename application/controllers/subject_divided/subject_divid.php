<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . '/traits/VistorTrait.php';
class subject_divid extends CI_Controller
{
    use VistorTrait;
    private $data = array();
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('home/home_model', 'emp/emp_class_table_model', 'emp/exam_model', 'emp/exam_new_model', 'config/config_class_table_model', 'admin/setting_model', 'emp/zoom_model'));
        $this->load->library('get_data_emp');
        $this->data['UID']            = $this->session->userdata('id');
        $this->data['YearID']         = $this->session->userdata('YearID');
        $this->data['Year']           = $this->session->userdata('Year');
        $this->data['Semester']       = $this->session->userdata('Semester');
        $this->data['Lang']           = $this->session->userdata('language');


        $this->data['SchoolID']           = $this->session->userdata('SchoolID');
    }
    //////index
    public function index()
    {

        $apikey = 'chat.lms.esol.com.sa'; 
        $url ='https://chat.lms.esol.com.sa/apikey/subdivid?id=88&apikey='.$apikey;
        $this->data['subject'] =  $this->getAPIData($url)['data'];

        $this->load->view('subject_dived/index', $this->data);
    }
}

