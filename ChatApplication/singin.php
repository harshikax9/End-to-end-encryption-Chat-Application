<?php
session_start();
if(isset($_SESSION['unique_id'])){// id user is logged in
    header("location: users.php");
}

 //echo __FILE__."?code=";

//echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]?verification_code=";
?>

<?php include_once "header.php"; ?>

 <body>
   <div class="wrapper">
    <section class="form login">
     <header>Realtime Chat Appliction</header>
     <form action="#">

        <?php if (!empty($_SESSION['success'])) {?><div class="success-txt"><?php echo $_SESSION['success']; ?></div><?php } $_SESSION['success'] = ''; ?>
        
        <div class="error-txt"></div>
        
            <div class="field input">
                <label>Email Address</label>
                <input type="text" name="email" placeholder="Enter Your Email">
            </div>
            <div class="field input">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter Your Password">
                <i class="fas fa-eye"></i>
            </div>
           
            <div class="field button">
                <!-- <input type="submit" value="Continue To Chat"> -->
                <button type="submit">Continue To Chat</button>
            </div>
       

     </form>
     <div class="link">Not Yet Signed Up?<a href="Home.php">Signup</a></div>
    </section>


   </div>

   <script src="Javascript/pass-show-hide.js"></script>
   <script src="Javascript/login.js"></script>
 </body>
</html>