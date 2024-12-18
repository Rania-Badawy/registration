<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_active_system_permission extends CI_Migration
{
  public function up()
  {
      $table_name = 'permission_page';
  
      $existing_fields = $this->db->list_fields($table_name);
  
      if (!in_array('active_system', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'active_system' => array(
                  'type'       => 'TINYINT',
                  'constraint' => 3,
                  'default'    => 1,
                  'collation'  => 'utf8_general_ci' ,
                  'after'      => 'system',
              ),
          ));
      }
}

  public function down()
  {
    $fields_to_remove = ['active_system'];
    $this->dbforge->drop_column('permission_page', $fields_to_remove);
  }
  
}