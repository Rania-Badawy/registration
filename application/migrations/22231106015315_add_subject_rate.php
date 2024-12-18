<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_subject_rate extends CI_Migration
{
  public function up()
  {
      $table_name = 'father_emp_rate';
  
      $existing_fields = $this->db->list_fields($table_name);
  
      if (!in_array('subject_ID', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'subject_ID' => array(
                  'type' => 'INT',
                  'constraint' => 11,
                  'after' => 'student_id',
              ),
          ));
      }
  
      if (!in_array('Class_ID', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'Class_ID' => array(
                  'type' => 'INT',
                  'constraint' => 11,
                  'after' => 'studentRLID',
              ),
          ));
      }
  }

  public function down()
  {
    $fields_to_remove = ['Class_ID', 'subject_ID'];
    $this->dbforge->drop_column('father_emp_rate', $fields_to_remove);
  }
  
}