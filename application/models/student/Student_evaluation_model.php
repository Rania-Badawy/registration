<?php
class Student_evaluation_model  extends CI_Model 
 {
     public function  count_ask($id){
        $this->db->where('studentID' , $id);
        $count = $this->db->get('ask_teacher');
        return $count->num_rows();
    } 
    
 }