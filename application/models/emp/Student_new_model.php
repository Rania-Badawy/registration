<?php
class Student_New_Model  extends CI_Model 
 {
    public function get_all_student(){
      $query= $this->db->query("
          SELECT tb1.ID AS StudentID, tb1.Name AS StudentName, tb2.ID AS FatherID , tb2.Name AS FatherName , row_level.Level_Name , row_level.Row_Name , class.Name,
            CONCAT(tb1.Name,' ',tb2.Name) AS FullName 
            FROM contact As tb1 
            INNER JOIN student ON tb1.ID = student.Contact_ID 
            INNER JOIN contact AS tb2 ON student.Father_ID = tb2.ID 
            INNER JOIN row_level on row_level.ID = student.R_L_ID
            INNER JOIN class on class.ID = student.Class_ID
            WHERE tb1.SchoolID = '".$this->session->userdata('SchoolID')."' and  student.R_L_ID in(
            select GROUP_CONCAT(DISTINCT class_table.RowLevelID) from class_table where class_table.EmpID = '".$this->session->userdata('id')."'  group by class_table.RowLevelID
            )
        ");
        if($query->num_rows() > 0){
            return $query->result();
        }
    }
    
    public function get_row_lavel(){
        $query= $this->db->query("
            SELECT row_level.Level_Name,row_level.Row_Name , class.Name ,row_level.ID as RowLavelID , class.ID as ClassID
            FROM class_table
            INNER JOIN row_level on row_level.ID = class_table.RowLevelID
            INNER join class on class.ID = class_table.ClassID
            where class_table.EmpID = '".$this->session->userdata('id')."'
        ");
         if($query->num_rows() > 0){
            return $query->result();
        }
    }
    
     public function add_new($data){
         $insert = $this->db->insert('student_emp',$data);
         return $insert;
     }
 }