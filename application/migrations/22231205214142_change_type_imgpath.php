<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Change_type_imgpath extends CI_Migration
{
  public function up()
    {
        $fields = array(
            'ImagePath' => array(
                'type' => 'TEXT',
                'null' => true,
                'default' => NULL,
                'collation' => 'utf8_general_ci',
            ),
        );

        $this->dbforge->modify_column('cms_details', $fields);
    }
}