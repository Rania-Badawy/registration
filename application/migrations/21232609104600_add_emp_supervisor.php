<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_emp_supervisor extends CI_Migration
{
  public function up()
  {
      $table_name = 'employee';
  
      $existing_fields = $this->db->list_fields($table_name);
  
      if (!in_array('emp_supervisor', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'emp_supervisor' => array(
                  'type'       => 'TINYINT',
                  'constraint' => 4,
                  'after'      => 'jobTitleID',
                  'default'    => 0,
                  'comment'    => 'when user is teacher and supervisor value will be 1',
              ),
          ));
      }
  
  }
  
  
  
  

  public function down()
  {
    $fields_to_remove = ['emp_supervisor'];
    $this->dbforge->drop_column('employee', $fields_to_remove);
  }
}
