<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$hook['post_controller_constructor'][]  = array(
                                'class'    => 'MyClass',
                                'function' => 'Myfunction',
                                'filename' => 'myclass.php',
                                'filepath' => 'hooks'
                                );
