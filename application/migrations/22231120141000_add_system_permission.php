<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_system_permission extends CI_Migration
{
  public function up()
  {
      $table_name = 'permission_page';
  
      $existing_fields = $this->db->list_fields($table_name);
  
      if (!in_array('system', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'system' => array(
                  'type'       => 'VARCHAR',
                  'constraint' => 255,
                  'default'    => NULL,
                  'collation'  => 'utf8_general_ci' ,
                  'after'      => 'Icon',
              ),
          ));
      }
}

  public function down()
  {
    $fields_to_remove = ['system'];
    $this->dbforge->drop_column('permission_page', $fields_to_remove);
  }
  
}