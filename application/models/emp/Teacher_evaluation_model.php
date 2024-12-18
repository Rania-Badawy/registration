<?php
class Teacher_evaluation_model  extends CI_Model 
 {
    public function  count_test($id){
        $this->db->where('contact_ID' , $id);
        $count = $this->db->get('vw_test_select');
        return $count->num_rows();
    } 
    
    public function  count_e_library($id){
        $this->db->where('ContactID' , $id);
        $count = $this->db->get('e_library');
        return $count->num_rows();
    } 
    public function count_lesson_prep ($id){
        $this->db->where('Teacher_ID' , $id);
        $count = $this->db->get('lesson_prep');
        return $count->num_rows();
    } 
     public function count_ask_teacher ($id){
        $this->db->where('teacherID', $id);
        $count = $this->db->get('ask_teacher');
        return $count->num_rows();
    } 
    
    public function homework($id){
        $query = $this->db->query(
            '
            SELECT homework.date_homework, homework.token, contact.Name as emp 
            FROM (clerical_homework as homework) JOIN config_emp ON homework.subjectEmpID = config_emp.ID 
            JOIN contact ON config_emp.EmpID = contact.ID 
            JOIN subject ON subject.ID = config_emp.SubjectID 
            WHERE config_emp.EmpID = ' . $id .' 
            GROUP BY homework.token'    
        );
       return $query->num_rows();
    }
    
 }