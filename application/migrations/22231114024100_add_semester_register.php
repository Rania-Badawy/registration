<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_semester_register extends CI_Migration
{
  public function up()
  {
      $table_name = 'register_form';
  
      $existing_fields = $this->db->list_fields($table_name);
  
      if (!in_array('semester', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'semester' => array(
                  'type'       => 'VARCHAR',
                  'constraint' => 255,
                  'default'    => NULL,
                  'collation'  => 'utf8_general_ci' ,
                  'after'      => 'Year_lms',
              ),
          ));
      }
}

  public function down()
  {
    $fields_to_remove = ['semester'];
    $this->dbforge->drop_column('register_form', $fields_to_remove);
  }
  
}