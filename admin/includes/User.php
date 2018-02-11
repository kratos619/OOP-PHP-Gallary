<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 class User {
     
     public $id;
     public $username;
     public  $first_name;
     public $last_name;


     public static function find_all_users(){
         global $database;
         
         $result_set = $database->Query("select * from users");
         return $result_set;
     }
     
     public static function find_user_by_id($id){
         global $database;
        $find_user_by_id = self::find_this_query("select * from users where id = {$id}");
       $user_found  = mysqli_fetch_assoc($find_user_by_id);
       return $user_found;
     }
     
     public static function find_this_query($sql){
         global $database;
         $result_set = $database->Query($sql);
         return $result_set;
         
     }
     
     public static function instatiation($find_user_by_id){
                 $user = new self;
                        $user->id = $find_user_by_id['id'];
                        $user->username = $find_user_by_id['username'];
                        $user->first_name = $find_user_by_id['first_name'];
                        $user->last_name = $find_user_by_id['last_name'];
                        return $user;
     }
     
 }

?>