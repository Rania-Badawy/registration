<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_blog extends CI_Migration
{

        public function up()
        {
                $table_name = 'testblog';

        }

        public function down()
        {
                $this->dbforge->drop_table('blog');
        }
}