<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation
{

    public function __construct($rules = array())
    {
        parent::__construct($rules);
    }
    
    public function unique_number_id()
    {

        $number_id = $this->CI->input->post('student_NumberID')[0];
        $YearId = $this->CI->input->post('YearId')[0];

        $check = $this->CI->db->get_where('register_form', array('student_NumberID' => $number_id, 'YearId' => $YearId), 1);
        $check1 = $this->CI->db->get_where('contact', array('Number_ID' => $number_id), 1);
        
        
        if ($check1->num_rows() > 0) {
            
            $this->set_message('unique_number_id', 'الطالب مسجل بالفعل بالمدرسه ');

            return FALSE;
        }
        else if ($check->num_rows() > 0) {
            $query=$check->row();

            $this->set_message('unique_number_id', 'الطالب مسجل بالفعل من قبل بكود تتبع '.$query->check_code);

            return FALSE;
        }

        return TRUE;
    }
}


?>