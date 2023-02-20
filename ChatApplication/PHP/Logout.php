<?php
  session_start();
  if(isset($_SESSION['unique_id'])){//if user is logged in thr coe to this page
    include_once "config.php";
    $logout_id=mysqli_real_escape_string($conn,$_GET['logout_id']);
      if(isset($logout_id)){ // if logout id is set
       $status="Offline Now";
       $sql=mysqli_query($conn,"UPDATE users SET status='{$status}' where unique_id={$logout_id}");
        if($sql){
            session_unset();
            session_destroy();
            header("location:../home.php");
            
            
        }
      }else{
        header("location:../users.php");
      }
   }else{
    header("location:../home.php");
   }
?>