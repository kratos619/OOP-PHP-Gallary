<?php

/* 
 * To change this license heade  r, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 class User {
   
     public $id;
     public $username;
     public $first_name;
     public  $last_name;


     public static function find_all_users(){
         return self::find_this_query("select * from users");
     }
     
     public static function find_user_by_id($id){
         global $database;
         $result_set = self::find_this_query("select * from users where id = $id");
         $found_users = mysqli_fetch_assoc($result_set);
         return $found_users;
     }
     
     public static function find_this_query($sql){
         global $database;
         $result_set = $database->Query($sql);
         return $result_set;
     }
     
     
     
 }

?>