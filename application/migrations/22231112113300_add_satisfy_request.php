<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_satisfy_request extends CI_Migration
{
  public function up()
  {
      $table_name = 'requests';
  
      $existing_fields = $this->db->list_fields($table_name);
  
      if (!in_array('satisfy', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'satisfy' => array(
                  'type'       => 'INT',
                  'constraint' => 11,
                  'default'    => 0,
                  'after'      => 'evaluation'
              ),
          ));
      }
  
  }
  
  
  
  

  public function down()
  {
    $fields_to_remove = ['requests'];
    $this->dbforge->drop_column('satisfy', $fields_to_remove);
  }
}