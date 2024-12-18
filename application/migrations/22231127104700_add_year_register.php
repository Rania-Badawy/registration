<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_year_register extends CI_Migration
{
  public function up()
  {
      $table_name = 'setting';
  
      $existing_fields = $this->db->list_fields($table_name);
  
      if (!in_array('reg_year', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'reg_year' => array(
                  'type'       => 'VARCHAR',
                  'constraint' => 255,
                  'default'    => NULL,
                  'collation'  => 'utf8_general_ci' ,
                  'after'      => 'semester',
              ),
          ));
      }
}

  public function down()
  {
    $fields_to_remove = ['reg_year'];
    $this->dbforge->drop_column('setting', $fields_to_remove);
  }
  
}