<?php

/* 
 * To change this license heade  r, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 class User {
   
     public function find_all_users(){
         global  $database;
         $result_set = $database->Query("Select * from users");
         return $result_set;
     }
     
     
     
     
 }

?>