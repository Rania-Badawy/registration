
<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_zoom_setting extends CI_Migration
{
  public function up()
  {
      $table_name = 'zoom_settings';
  
      $existing_fields = $this->db->list_fields($table_name);
  
      if (!in_array('updated_at', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
               'updated_at' => array(
               'type' => 'TIMESTAMP', 
               'default' => null,
               'null' => false
              ),
          ));
      }
  
  }
  

  public function down()
  {
    $fields_to_remove = ['updated_at'];
    $this->dbforge->drop_column('zoom_settings', $fields_to_remove);
  }
}