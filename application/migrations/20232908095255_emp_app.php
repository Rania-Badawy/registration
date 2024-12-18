<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_emp_app extends CI_Migration {

        public function up()
        {
            $fields = array(
                'currentResidence' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                    'default' => NULL,
                ),
            );

            $this->dbforge->modify_column('emp_application', $fields);
        }


}