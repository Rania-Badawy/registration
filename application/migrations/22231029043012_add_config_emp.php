<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_config_emp extends CI_Migration
{
  public function up()
  {
      $table_name = 'config_emp_school';
  
      $existing_fields = $this->db->list_fields($table_name);
  
      if (!in_array('hide_adding_members', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'hide_adding_members' => array(
                        'type' => 'TINYINT',
                        'constraint' => 3,
                        'default' => 1,
                        'after' => 'prepare_row_level'
              ),
          ));
      }
  
  }

  public function down()
  {
    $fields_to_remove = ['hide_adding_members'];
    $this->dbforge->drop_column('config_emp_school', $fields_to_remove);
  }
}
