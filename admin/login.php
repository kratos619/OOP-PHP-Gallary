<?php require_once 'init.php'; ?>
<?php 
if ($session->is_signed_in()){
    redirect_to("index.php");
}

if(isset($_POST['submit'])){
    $username = trim($_POST['username']) ;
    $password = trim($_POST['password']);

    
    # method to check db use
    $user_found = User::verify_user($username,$password);
    
    
    
    if($user_found){
        $session->login($user_found);
        redirect_to("index.php");
    }else{
        $the_message = "Your Pssword or username are incorrect";
    }
    
}else{
   $username= "";
   $password="";
}



?>