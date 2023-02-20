<?php  
 session_start();
 include_once "config.php";
 $outgoing_id=$_SESSION['unique_id'];
 $sql=mysqli_query($conn,"SELECT * FROM users WHERE enc_type = '{$_SESSION['is_asymmetric']}' AND not unique_id={$outgoing_id}");
 $output="";


 if(mysqli_num_rows($sql)==0){
  $output .="No users are available to chat";
   //include "data.php";
 }
 elseif(mysqli_num_rows($sql)>0){
    include "data.php";
 }
 echo $output;
?>