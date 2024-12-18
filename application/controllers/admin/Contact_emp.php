<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Contact_emp extends MY_Admin_Base_Controller{

	private $data = array() ;

	function __construct()

    {

	   parent::__construct();

	   $this->load->model(array('contact/contact_emp_model'));

	   $this->load->library('get_data_admin');

	   $this->data['UID']           = $this->session->userdata('id');

	   $this->data['Lang']           = $this->session->userdata('language');

	   print_r($this->session->all_userdata());exit();

    }

	//////index

	public function index()

	{

		$this->data['get_emp']  = $this->contact_emp_model->get_emp();

		$this->load->admin_template('view_emp',$this->data);

	}

	

	//////new_emp

	public function new_emp()

	{

		$this->load->admin_template('view_new_emp',$this->data);

	}

	

}

