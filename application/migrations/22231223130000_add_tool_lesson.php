<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_tool_lesson extends CI_Migration
{
  public function up()
  {
      $table_name = 'lesson_prep';
  
      $existing_fields = $this->db->list_fields($table_name);
  
      if (!in_array('teacher_tools', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'teacher_tools' => array(
                  'type' => 'LONGTEXT',
                  'after' => 'Image',
                  'default'    => NULL
              ),
          ));
      }
  
      if (!in_array('clerical', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'clerical' => array(
                  'type' => 'LONGTEXT',
                  'after' => 'teacher_tools',
                  'default'    => NULL
              ),
          ));
      }

      if (!in_array('why_learn', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'why_learn' => array(
                  'type' => 'LONGTEXT',
                  'after' => 'clerical',
                  'default'    => NULL
              ),
          ));
      }
      if (!in_array('what_learn', $existing_fields)) {
        $this->dbforge->add_column($table_name, array(
            'what_learn' => array(
                'type' => 'LONGTEXT',
                'after' => 'why_learn',
                'default'    => NULL
            ),
        ));
    }
    if (!in_array('how_learn', $existing_fields)) {
        $this->dbforge->add_column($table_name, array(
            'how_learn' => array(
                'type' => 'LONGTEXT',
                'after' => 'what_learn',
                'default'    => NULL
            ),
        ));
    }
    if (!in_array('what_if_learn', $existing_fields)) {
        $this->dbforge->add_column($table_name, array(
            'what_if_learn' => array(
                'type' => 'LONGTEXT',
                'after' => 'how_learn',
                'default'    => NULL
            ),
        ));
    }
  }

  public function down()
  {
    $fields_to_remove = ['teacher_tools', 'clerical', 'why_learn','what_learn', 'how_learn', 'what_if_learn'];
    $this->dbforge->drop_column('lesson_prep', $fields_to_remove);
  }
  
}