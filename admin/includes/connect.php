<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 1234);
define('DB_NAME', 'gallary');

$connection = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

?>

