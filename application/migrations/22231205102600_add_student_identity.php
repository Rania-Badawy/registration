<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_student_identity extends CI_Migration
{
  public function up()
  {
      $table_name = 'student';
  
      $existing_fields = $this->db->list_fields($table_name);
  
      if (!in_array('studentIdentity', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'studentIdentity' => array(
                  'type'       => 'VARCHAR',
                  'constraint' => 255,
                  'default'    => NULL,
                  'collation'  => 'utf8_general_ci' ,
                  'after'      => 'Latitude_stu',
              ),
          ));
      }
}

  public function down()
  {
    $fields_to_remove = ['studentIdentity'];
    $this->dbforge->drop_column('student', $fields_to_remove);
  }
  
}