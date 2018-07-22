<?php
/**
 * Created by PhpStorm.
 * User: Gaurav
 * Date: 25-03-2018
 * Time: 12:06
 */

class Db_object
{
    protected static $table_name= "users";


    public static function find_all(){
        return static::find_this_query("select * from " . static::$table_name  ." ");
    }

    public static function find_user_by_id($id){
        global $database;

        $array_result_set = static::find_this_query("select * from " . static::$table_name  ."  where id = $id");

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
            $the_object_array[] = static::instatiation($row);
        }
        return $the_object_array;
    }

    private function has_attribute($the_attribute){
        $object_properties = get_object_vars($this);
        return array_key_exists($the_attribute,$object_properties);
    }

    public static function instatiation($the_record){
        $call_class = get_called_class();
        $user_object = new $call_class ;

        foreach ($the_record as $the_attribute => $value){
            if($user_object->has_attribute($the_attribute)){
                $user_object->$the_attribute = $value;
            }
        }
        return $user_object;
    }


}