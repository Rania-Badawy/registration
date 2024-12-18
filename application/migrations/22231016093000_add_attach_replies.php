<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_attach_replies extends CI_Migration
{
  public function up()
  {
      $table_name = 'replies';
  
      $existing_fields = $this->db->list_fields($table_name);
  
      if (!in_array('attachment', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'attachment' => array(
                  'type'       => 'VARCHAR',
                  'constraint' => 255,
                  'after'      => 'reply',
                  'default'    => NULL,
                
              ),
          ));
      }
  
  }
  
  
  
  

  public function down()
  {
    $fields_to_remove = ['attachment'];
    $this->dbforge->drop_column('replies', $fields_to_remove);
  }
}