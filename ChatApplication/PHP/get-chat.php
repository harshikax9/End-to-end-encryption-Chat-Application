<?php
session_start();
if(isset($_SESSION['unique_id'])){
    include_once "config.php";

    $outgoing_id = mysqli_real_escape_string($conn, $_POST['outgoing_id']);
    $incoming_id=mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $output="";

    $sql= "SELECT * FROM messages
       left JOIN users ON users.unique_id=messages.incoming_msg_id
     WHERE (outgoing_msg_id={$outgoing_id} AND incoming_msg_id={$incoming_id})
     or (outgoing_msg_id={$incoming_id} AND incoming_msg_id={$outgoing_id}) ORDER BY msg_id";

     $query=mysqli_query($conn,$sql);
     if(mysqli_num_rows($query)>0){
        while ($row = mysqli_fetch_assoc($query)){

/*SHOW CHAT*/

if ($_SESSION['is_asymmetric']==0) {
    // Store the cipher method
    $ciphering = "AES-128-CTR";
      
    // Use OpenSSl Encryption method
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;

// Non-NULL Initialization Vector for encryption
    $decryption_iv = '1234567891011121';
// Use openssl_encrypt() function to encrypt the data
    $decryption=openssl_decrypt ($row['msg'], $ciphering, $row['enc_key'], $options, $decryption_iv);


}

            if($row['outgoing_msg_id']=== $outgoing_id)
            {


            if ($_SESSION['is_asymmetric']==1) {
                $sql=mysqli_query($conn,"SELECT priv_key FROM users WHERE unique_id = '{$incoming_id}' AND enc_type = 1 LIMIT 1");
                $rViewmg  = mysqli_fetch_array($sql);

                $hex2binCHAT = hex2bin($row['msg']);

                openssl_private_decrypt($hex2binCHAT, $decryption, $rViewmg['priv_key']);
            }


               $output .='<div class="chat outgoin">
                          <div class="details">
                          <p>'. $decryption .'</p>
                          <i style="font-size: 0.775em;">'.$row['datetime'].'</i>
                          </div>
                          </div>';
            }
            else{// he is a msg receiver

                if ($_SESSION['is_asymmetric']==1) {

                    $hex2binCHAT = hex2bin($row['msg']);
                    openssl_private_decrypt($hex2binCHAT, $decryption, $row['priv_key']);

                }

                $output .='<div class="chat incoming">
                <div class="details">
                <img src="php/image/'.$row['img'].'">
                   <p>'. $decryption .'</p>
                   <i style="font-size: 0.775em;">'.$row['datetime'].'</i>
               </div>
            </div>';
              }
        }
        echo $output;
     }
}
else
{
    header("../login.php");
}

?>

