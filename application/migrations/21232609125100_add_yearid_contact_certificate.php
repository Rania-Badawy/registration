<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_yearid_contact_certificate extends CI_Migration
{
  public function up()
  {
      $table_name = 'contact_certificate';
  
      $existing_fields = $this->db->list_fields($table_name);
  
      if (!in_array('yearID', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'yearID' => array(
                  'type' => 'INT',
                  'constraint' => 11,
                  'after' => 'motherMobile',
                  'default' => 0,
              ),
          ));
      }
  }
  
  public function down()
  {
    $fields_to_remove = ['yearID'];
    $this->dbforge->drop_column('contact_certificate', $fields_to_remove);
  }
}
