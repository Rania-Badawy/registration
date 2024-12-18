<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_student_latitude extends CI_Migration
{
  public function up()
  {
      $table_name = 'student';
  
      $existing_fields = $this->db->list_fields($table_name);
  
      if (!in_array('Latitude_stu', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'Latitude_stu' => array(
                  'type'       => 'VARCHAR',
                  'constraint' => 255,
                  'after'      => 'longtude_stu',
                  'default'    => NULL,
                
              ),
          ));
      }
  
  }
  
  
  
  

  public function down()
  {
    $fields_to_remove = ['Latitude_stu'];
    $this->dbforge->drop_column('student', $fields_to_remove);
  }
}