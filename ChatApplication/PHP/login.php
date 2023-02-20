<?php
session_start();
include_once "config.php";

$email = mysqli_real_escape_string($conn,$_POST['email']);
$password = sha1(mysqli_real_escape_string($conn,$_POST['password']));

if(!empty ($email) && !empty ($password)){
    //echo "SELECT * FROM users WHERE (email='{$email}' AND password='{$password}') AND verification_code = NULL";
    //chech user entered email and password match
    $sql=mysqli_query($conn,"SELECT * FROM users WHERE (email='{$email}' AND password='{$password}') AND verification_code IS NULL");
    if(mysqli_num_rows($sql)>0){
        $row= mysqli_fetch_assoc($sql);
        $status="Active Now";
        $sql=mysqli_query($conn,"UPDATE users SET status='{$status}' where unique_id={$row['unique_id']}");
         if($sql){
            $_SESSION['unique_id']=$row['unique_id'];//using thie session we used user unique_id in other php file
            $_SESSION['is_asymmetric'] = $row['enc_type']; // if enc_type = 1 asymmetric enable userlist
            echo "success";
         }
      
    }
    else{
        echo "Email or Password is Incorrect";
    }

}else{
    echo "All input field are required!";
}

?>