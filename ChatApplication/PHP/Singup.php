<?php
session_start();
  include_once "config.php";

  if (isset($_GET['verification_code'])||isset($_GET['email'])) {

    //echo $_GET['verification_code'].'<br>'.$_GET['email'];
      
    $sql=mysqli_query($conn,"SELECT * FROM users WHERE email='{$_GET['email']}' AND verification_code = '{$_GET['verification_code']}' LIMIT 1");

    if(mysqli_num_rows($sql)==0){
        echo "Invalid link. Please Try Again";
    } else {

        $sqlupdate=mysqli_query($conn, "UPDATE users SET verification_code = NULL WHERE email = '{$_GET['email']}' LIMIT 1 ");

        if ($sqlupdate) {
            
            $_SESSION['success'] = 'Verification Success'; 
            header('Location: ../singin.php');
        } else {

            echo "Verification Faild";
        }

    }


  } else {

  $fname = mysqli_real_escape_string($conn,$_POST['fname']);
  $lname = mysqli_real_escape_string($conn,$_POST['lname']);
  $email = mysqli_real_escape_string($conn,$_POST['email']);
  $password = sha1(mysqli_real_escape_string($conn,$_POST['password']));


      if (isset($_POST['enctype'])) {

          if ($_POST['enctype']=='sym') {

            $enctype = 0;

          } elseif ($_POST['enctype']=='asym') {

            $enctype = 1;


            $config = array (

            'config' => 'C:\xampp\htdocs\chatapp\openssl.cnf',
            'default_mid' => 'sha512',
            'privet_key_bits' => 512,
            'privet_key_type' => OPENSSL_KEYTYPE_RSA,

            );

            $keypair = openssl_pkey_new($config);

            openssl_pkey_export($keypair, $privkey, null, $config);

            $publickey = openssl_pkey_get_details($keypair);

            $pubkey = $publickey['key'];

          } else {

            echo "Invalid Encryption Method";

          }
      } else {

        echo "Please Select Encryption Method";

     }



   
  if(!empty($fname) && !empty($lname) && !empty($email)&& !empty($password)){
    //Check user email is valid or not
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){//if email is valid
     // check that email already exist
     $sql=mysqli_query($conn,"SELECT email FROM users WHERE email='{$email}'");
     if(mysqli_num_rows($sql)>0){// if email already exist
        echo "$email - This Email already exit!";
     }else{
         // chech user upload file or not
         if(isset($_FILES['image'])){
            $img_name=$_FILES['image']['name'];// getting user uploaded image name
            $img_type = $_FILES['image']['type'];
            $tmp_name=$_FILES['image']['tmp_name'];// this tempoty name is used to save/move file in our folder
            
            //explode image and get the last extension like jpg png
            $img_explode= explode('.',$img_name);
            $img_ext = end($img_explode); // get the extension of an user uploaded image file

            $extensions=["png","jpeg","jpg"];

            if(in_array($img_ext, $extensions)===true){
                $time=time();// this will return current time
                $new_img_name=$time.$img_name;

                if(move_uploaded_file($tmp_name,"Image/".$new_img_name)){
                    $random_id=rand(time(),100000000);
                    $status="Active Now";
                    

                    $verification_code = mt_rand(10000,99999);

                    //insert all user data inside table


                if ($enctype==1) {
                    $sql2=mysqli_query($conn,"INSERT INTO users(unique_id,fname,lname,email,password,verification_code,img,priv_key,pub_key,enc_type,status)
                    VALUES({$random_id},'{$fname}','{$lname}','{$email}','{$password}', '{$verification_code}', '{$new_img_name}','{$privkey}','{$pubkey}','{$enctype}','{$status}')");

                } else {


                    $sql2=mysqli_query($conn,"INSERT INTO users(unique_id,fname,lname,email,password,verification_code,img,enc_type,status)
                    VALUES({$random_id},'{$fname}','{$lname}','{$email}','{$password}', '{$verification_code}', '{$new_img_name}','{$enctype}','{$status}')");
                }
                  
                  if($sql2){//if these data inserted
                    $sql3=mysqli_query($conn, "SELECT * FROM users where email ='{$email}'");
                    if(mysqli_num_rows($sql3)>0){
                        $row=mysqli_fetch_assoc($sql3);


        $verification_code_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]?verification_code=".$verification_code.'&email='.$email;

        $to             = $email;
        $mail_subject   = 'VERIFICATION LINK ';

        $email_body     = 

        '<p>Dear '.$fname.',</br> Your Verification Link. Please Click On Link Below And Verify Your Account</p>
        <p>Click Here For Verify: <a href="'.$verification_code_link.'">'.$verification_code_link.'</a></p>';

        $header         = "From: {$email}\r\nContent-Type: text/html;";
        $send_mail_result = mail($to, $mail_subject, $email_body, $header);



                        $_SESSION['success'] = 'Registered successfully. Check Your email inbox'; 


                            //using thie session we used user unique_id in other php file
                            echo "success";
                    }
                  }
                  else{
                    echo "Something went wrong!";
                  }
                }
                
            }
            else{
                echo "plase select an image file - jpeg, jpg, png!";
            }
         }else{
            echo "Please Select an Image";
         }
     }
    }else{
        echo "$email - This is not a Valid Email";
    }
    
  }else{
    echo "All input field are Required!";
  }

  }
  ?>