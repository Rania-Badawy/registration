<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . '/traits/VistorTrait.php';

class questionBank extends CI_Controller
{
    use VistorTrait;

    private $data = array();

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->model(array('emp/exam_new_model', 'emp/subject_model', 'emp/config_model', 'emp/question_new_model', 'emp/lessons_model', 'emp/homework_new_model', 'admin/setting_model'));
		$this->load->library('get_data_emp');
		$this->data['UID']            = $this->session->userdata('id');
		$this->data['YearID']         = $this->session->userdata('YearID');
		$this->data['Year']           = $this->session->userdata('Year');
		$this->data['Semester']       = $this->session->userdata('Semester');
		$this->data['Lang']           = $this->session->userdata('language');
		$this->data['date']           = $this->setting_model->converToTimezone();
        $this->data['apikey']                  = "chat.lms.esol.com.sa";

	}

    public function index(){
        // print_r($this->data['UID']);die;
        // if($this->session->userdata('type') == E){
        // $url =   ' https://chat.lms.esol.com.sa/apikey/bank?userID='.$this->data['UID'].'&apikey='.$this->data['apikey'];
        // }
        // print_r($this->data['UID']);die;
        $url =   'https://chat.lms.esol.com.sa/apikey/bank?userID='.$this->data['UID'].'&apikey='.$this->data['apikey'];
    //    print_r($url);die;
        $this->data['queBank']            = $this->getAPIData($url);
        $this->load->emp_template('viewBank', $this->data);
    }

    public function saveBankQuestion(){
        $Data['type'] = $_POST['get'];
        $Data['bankID'] = $_POST['BankId'];
        $Data['title'] = $_POST['txt_question'];
        $Data['UserID'] = $this->session->userdata('id');
        $Data['status'] = 1;
        $_POST['Type_question_ID'] =$_POST['get'];
		$Data['apikey'] = "chat.lms.esol.com.sa"; //static for local -v
        // chat.lms.esol.com.sa
        // $data['apikey']= "chat.lms.esol.com.sa"; 
        // print_r($_POST);
        // die;
         include APPPATH . '/traits/QuestionBank/SaveQuestion.php';
         redirect('/emp/questionBank');



    }
}