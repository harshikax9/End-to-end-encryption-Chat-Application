<?php
session_start();
if(isset($_SESSION['unique_id'])){// id user is logged in
    header("location: users.php");
}
?>



<?php include_once "header.php"; ?>

 <body>
   <div class="wrapper">
    <section class="form singup">
     <header>Realtime Chat Appliction</header>
     <form action="#" enctype="multipart/form-data" autocomplete="off">
        <div class="error-txt"></div>
        <div class="name-details">
            <div class="field input">
                <label>First Name</label>
                <input type="text" name="fname" placeholder="First Name" required>
            </div>
            <div class="field input ">
                <label>Last Name</label>
                <input type="text" name="lname" placeholder="Last Name" required>
            </div>
            </div>
            <div class="field input">
                <label>Email Address</label>
                <input type="text" name="email" placeholder="Enter Your Email" required>
            </div>
            <div class="field input">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter New Password" required>
                <i class="fas fa-eye"></i>
            </div>
            <div class="field image" required>
                <label>Select Image</label>
                <input type="file" name="image">
            </div>



            <p>Please Select Your Encryption Method</p>

                <input type="radio" id="sym" name="enctype" value="sym" checked required>
                <label for="sym">Symmetric </label><br>
                <input type="radio" id="asym" name="enctype" value="asym" required>
                <label for="asym">Asymmetric </label><br>


            <div class="field button">
                <!-- <input type="submit" value="Continue To Chat"> -->
                <button type="submit" id="load">Sign Up</button>

            </div>
       

     </form>
     <div class="link">Already Signed Up?<a href="singin.php">Login Now</a></div>
    </section>


   </div>

   <script src="Javascript/pass-show-hide.js"></script>
   <script src="Javascript/singup.js"></script>
  
 </body>
</html>