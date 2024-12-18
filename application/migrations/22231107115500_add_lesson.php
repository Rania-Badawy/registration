<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_lesson extends CI_Migration
{
  public function up()
  {
      $table_name = 'lesson_prep';
  
      $existing_fields = $this->db->list_fields($table_name);
  
      if (!in_array('Learning_intentions', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'Learning_intentions' => array(
                  'type' => 'VARCHAR',
                  'constraint' => 255,
                  'after' => 'Reviews',
              ),
          ));
      }
  
      if (!in_array('Assessment_opportunities', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'Assessment_opportunities' => array(
                  'type' => 'VARCHAR',
                  'constraint' => 255,
                  'after' => 'Aims',
              ),
          ));
      }
 
  if (!in_array('Differentiation_opportunities', $existing_fields)) {
    $this->dbforge->add_column($table_name, array(
        'Differentiation_opportunities' => array(
            'type' => 'VARCHAR',
            'constraint' => 255,
            'after' => 'Aids',
        ),
    ));
}

if (!in_array('Plenary_reflection', $existing_fields)) {
    $this->dbforge->add_column($table_name, array(
        'Plenary_reflection' => array(
            'type' => 'VARCHAR',
            'constraint' => 255,
            'after' => 'stratigy',
        ),
    ));
}
}

  public function down()
  {
    $fields_to_remove = ['Learning_intentions', 'Assessment_opportunities','Differentiation_opportunities','Plenary_reflection'];
    $this->dbforge->drop_column('lesson_prep', $fields_to_remove);
  }
  
}