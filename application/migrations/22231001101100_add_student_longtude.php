<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_student_longtude extends CI_Migration
{
  public function up()
  {
      $table_name = 'student';
  
      $existing_fields = $this->db->list_fields($table_name);
  
      if (!in_array('longtude_stu', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'longtude_stu' => array(
                  'type'       => 'VARCHAR',
                  'constraint' => 255,
                  'after'      => 's_language',
                  'default'    => NULL,
                
              ),
          ));
      }
  
  }
  
  
  
  

  public function down()
  {
    $fields_to_remove = ['longtude_stu'];
    $this->dbforge->drop_column('student', $fields_to_remove);
  }
}