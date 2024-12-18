<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_user_changed extends CI_Migration
{
  public function up()
  {
      $table_name = 'contact';
  
      $existing_fields = $this->db->list_fields($table_name);
  
      if (!in_array('user_changed', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'user_changed' => array(
                  'type'       => 'tinyint',
                  'constraint' => 2,
                  'after'      => 'updated_by',
                  'default'    => 0,
                
              ),
          ));
      }
  
  }
  
  
  
  

  public function down()
  {
    $fields_to_remove = ['user_changed'];
    $this->dbforge->drop_column('contact', $fields_to_remove);
  }
}