<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_certificate_midterm_to_setting extends CI_Migration
{
  public function up()
  {
      $table_name = 'setting';
  
      $existing_fields = $this->db->list_fields($table_name);
  
      if (!in_array('certificate_midterm_temp', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'certificate_midterm_temp' => array(
                  'type'       => 'VARCHAR',
                  'constraint' => 255,
                  'default'    => NULL,
                  'after'      => 'certificate_temp',
                  'collation'  => 'utf8_general_ci'
              ),
          ));
      }
  
  }
  
  
  
  

  public function down()
  {
    $fields_to_remove = ['certificate_midterm_temp'];
    $this->dbforge->drop_column('setting', $fields_to_remove);
  }
}