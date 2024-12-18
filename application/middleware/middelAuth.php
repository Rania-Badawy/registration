
<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
trait AuthMiddleware {

protected $CI;



public function checkLogin()
{
    $this->CI =& get_instance();
    $this->CI->load->library('session');
    each 'iam here frome middelware';die;
    if (!$this->CI->session->userdata('type')) {
       

        $this->load->view('home_new/login'); 
}
}
////////////////////
public function dividSubject()
{
    $ID    = $this->CI->session->userdata('UID');

    $query = $this->db->query(" SELECT `jobTitleID`,`Type` FROM `employee` WHERE `Contact_ID` = $ID ")->row_array();

    if ($this->CI->session->userdata('type') == "E" && $query->jobTitleID == 1 && $query->Type == 4) {
       
        $this->load->view('subject_dived/index'); 
}
}
}
?>