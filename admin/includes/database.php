<?php
require_once 'admin_config.php';
/* _
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Database{
    public $connection;
    
    function __construct() {
        $this->open_db_connection();
    }

    //connection function
    public function open_db_connection(){
   // $this->connection = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    
   $this->connection = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        if($this->connection->connect_errno){
        die("womething went wrong ". $this->connection->connect_errno );
    }
}

// query function
public function Query($query){
    $result = $this->connection -> Query( $query);
    $this->confirm_query($result);
    return $result;
}

private function confirm_query($result){
     if(!$result){
        die("query failed" . $this->connection->error);
    }
}

public function escape_string($string){
$escaped_string = $this->connection->mysqli_real_escape_string($this->connection,$string);
return $escaped_string;
}
    

}

$database = new Database();
?>

