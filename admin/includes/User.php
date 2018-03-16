<?php

/* 
 * To change this license heade  r, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 class User {
        protected static $table_name= "users";
protected static $db_tables_fields = array('username',"first_name","last_name","password");

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

     # return all properties regarding to this class eg id,username, password,etc
     protected function properties(){
         $properties = array();
         foreach (self::$db_tables_fields as $values){
             if(property_exists($this,$values)){
                 $properties[$values] = $this->$values;
             }
         }
         return $properties;
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


     //create function to create data to user db

     /**
      * @return implode function return string(85) "username = 'chanchal23',first_name = 'Chanchal',last_name = 'Ingle',password = '1234'"
      */
     public function create_data() {
         global $database;
         $properties = $this->properties();
         $sql = "INSERT into " . self::$table_name . "(" . implode(",",array_keys($properties)) . ")";
         $sql .= "VALUE ('" . implode("','",array_values($properties)) . "')";

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

         $properties = $this->properties();
         $properties_pairs = array();
         foreach ($properties as $key => $value ){
             $properties_pairs[] = "{$key} = '{$value}'";
         }
         $sql = "update " . self::$table_name . " set ";
         $sql .= implode(",",$properties_pairs);
         $sql .= " where id =" . $database->escape_string($this->id);
//            echo $sql;
//             // $implode = implode(",",$properties_pairs);
//             echo "<pre>";
//            echo var_dump($implode);
//            echo "</pre>";
         $database->Query($sql);

         return (mysqli_affected_rows($database->connection) == 1) ? true : false;
     }

     #delete method

     public function delete_data() {
         global $database;
            $sql = "delete from " . self::$table_name . " WHERE id  = " . $database->escape_string($this->id) . " limit 1 ";
            $database->Query($sql);
         return (mysqli_affected_rows($database->connection) == 1) ? true : false;

     }

     
     
 } // end of user class

?>