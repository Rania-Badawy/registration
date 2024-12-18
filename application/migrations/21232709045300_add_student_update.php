<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_student_update extends CI_Migration
{
  public function up()
  {
      $table_name = 'student';
  
      $existing_fields = $this->db->list_fields($table_name);
  
      if (!in_array('is_update', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'is_update' => array(
                  'type'       => 'TINYINT',
                  'constraint' => 4,
                  'after'      => 'R_L_ID_old',
                  'default'    => NULL,
                  'comment'    => 'cannot update student when value is 1',
              ),
          ));
      }
  
  }
  
  
  
  

  public function down()
  {
    $fields_to_remove = ['is_update'];
    $this->dbforge->drop_column('student', $fields_to_remove);
  }
}