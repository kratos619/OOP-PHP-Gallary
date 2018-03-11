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
     public $password;


     public static function find_all_users(){
         return self::find_this_query("select * from users ");
     }

     public static function find_user_by_id($id){
         global $database;

         $array_result_set = self::find_this_query("select * from users where id = $id");
         
         //$found_users = mysqli_fetch_assoc($result_set);
         if(!empty($array_result_set)){
             $first_item = array_shift($array_result_set);
             return $first_item;
         }else{
             return FALSE;
         }
         return $found_users;
     }
     
     public static function find_this_query($sql){
         global $database;
         $result_set = $database->Query($sql);
         $the_object_array = array();
         while ($row = mysqli_fetch_assoc($result_set)){
             $the_object_array[] = self::instatiation($row);
         }
         return $the_object_array;
     }
     
     public static function instatiation($the_record){
         $user_object = new self();
         
         foreach ($the_record as $the_attribute => $value){
             if($user_object->has_attribute($the_attribute)){
                 $user_object->$the_attribute = $value;
             }
         }
         return $user_object;
     }
     
     private function has_attribute($the_attribute){
        $object_properties = get_object_vars($this);
        return array_key_exists($the_attribute,$object_properties);
     }
     
     public static function  verify_user($username,$password){
         global $database;
         $username = $database->escape_string($username);
         $password = $database->escape_string($password);
         $sql = "select * from users where username = '{$username}' and password = '{$password}'";
         $array_result_set = self::find_this_query($sql);
         
         //$found_users = mysqli_fetch_assoc($result_set);
         if(!empty($array_result_set)){
             $first_item = array_shift($array_result_set);
             return $first_item;
         }else{
             return FALSE;
         }
     }

     public function save(){
         return isset($this->id)? $this->update_data() : $this->create_data();
     }


     //create function to create data to db
     public function create_data() {
         global $database;
         $sql = "INSERT into users(username, first_name, last_name, password) ";
         $sql .= "VALUE ('";
         $sql .= $database->escape_string($this->username) . "', '";
         $sql .= $database->escape_string($this->first_name) . "', '";
         $sql .= $database->escape_string($this->last_name) . "', '";
         $sql .= $database->escape_string($this->password) . "')";

         if($database->Query($sql)){
            $this -> id = $database->the_Insert_Id();
            return true;
         }else{
            return false;
         }


     }

     #update data (Update Methods)
     public function update_data(){
         global $database;

         $sql = "update users set ";
         $sql .= "username = '" . $database->escape_string($this->username) . "' , ";
         $sql .= "first_name = '" . $database->escape_string($this->first_name) . "' , ";
         $sql .= "last_name = '" . $database->escape_string($this->last_name) . "' , ";
         $sql .= "password = '" . $database->escape_string($this->password) . "' ";
         $sql .= " where id =" . $database->escape_string($this->id);
            echo $sql;
         $database->Query($sql);

         return (mysqli_affected_rows($database->connection) == 1) ? true : false;
     }

     #delete method

     public function delete_data() {
         global $database;
            $sql = "delete from users WHERE id  = " . $database->escape_string($this->id) . " limit 1 ";
            $database->Query($sql);
         return (mysqli_affected_rows($database->connection) == 1) ? true : false;

     }

     
     
 } // end of user class

?>