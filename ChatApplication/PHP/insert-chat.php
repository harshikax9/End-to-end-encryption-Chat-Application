<?php
session_start();
if(isset($_SESSION['unique_id'])){
    include_once "config.php";


    // Store the cipher method
    $ciphering = "AES-128-CTR";
      
    // Use OpenSSl Encryption method
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;

    $outgoing_id = mysqli_real_escape_string($conn, $_POST['outgoing_id']);
    $incoming_id=mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $message=mysqli_real_escape_string($conn, $_POST['message']);


if ($_SESSION['is_asymmetric']==0) {
    $sql=mysqli_query($conn,"SELECT * FROM messages WHERE (incoming_msg_id = '{$incoming_id}' AND outgoing_msg_id = '{$outgoing_id}') OR (incoming_msg_id = '{$outgoing_id}' AND outgoing_msg_id = '{$incoming_id}') LIMIT 1");
    $chatInfo  = mysqli_fetch_array($sql);

    if(mysqli_num_rows($sql)==1){ 
        $encKey =  $chatInfo['enc_key'];
        
    } else {
        $encKey = uniqid();
    }

    // Non-NULL Initialization Vector for encryption
    $encryption_iv = '1234567891011121';
          
    // Use openssl_encrypt() function to encrypt the data
    $encryption = openssl_encrypt($_POST['message'], $ciphering, $encKey, $options, $encryption_iv);

    if(!empty($message)){
        $sql= mysqli_query($conn,"INSERT INTO  messages (incoming_msg_id, outgoing_msg_id, msg, enc_key)
                         values ({$incoming_id},{$outgoing_id},'{$encryption}','{$encKey}')" ) or die() ;
    }

} else {


    $sql=mysqli_query($conn,"SELECT pub_key FROM users WHERE unique_id = '{$incoming_id}' AND enc_type = 1 LIMIT 1");

    $reciverINFO  = mysqli_fetch_array($sql);



    $pubkey     =   $reciverINFO['pub_key'];
    openssl_public_encrypt($message, $encrypted, $pubkey);

    $encrypted_hex_mg = bin2hex($encrypted);


    if(!empty($message)){
        $sql= mysqli_query($conn,"INSERT INTO  messages (incoming_msg_id, outgoing_msg_id, msg)
                         values ({$incoming_id},{$outgoing_id},'{$encrypted_hex_mg}')" ) or die() ;
    }


}


}
else
{
    header("../login.php");
}
?>
