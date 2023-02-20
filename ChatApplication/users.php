<?php 
session_start();
if(!isset($_SESSION['unique_id'])){
 header("location:singin.php");
}
//$_SESSION['unique_id']='';
?>

<?php include_once "header.php"; ?>
 <body>
   <div class="wrapper">
    <section class="users">
        <header>

        <?php 
        include_once "php/config.php";
    
          $sql=mysqli_query($conn,"SELECT * FROM users WHERE unique_id={$_SESSION['unique_id']}");
          if(mysqli_num_rows($sql)>0){
            $row=mysqli_fetch_assoc($sql);
          }
        ?>
            <div class="content">
                <img src="php/Image/<?php echo $row['img']?>" alt="">
                <div class="details">
                    <span><?php echo $row['fname']. " " .$row['lname'] ?></span>
                    <p><?php echo $row['status']?></p>
                </div>
            </div>
            <a href="php/Logout.php?logout_id=<?php echo $row['unique_id']?>" class="Logout">Logout</a>
        </header>
        <div class="Search">
            <span class="text">Select an user to Start Chat</span>
            <input type="text" placeholder="Eneter Name to Search...">
            <button><i class="fas fa-search"></i></button>
        
        </div>
        <div class="user-list">
           
           
        </div>
    </section>
   </div>
   <script src="Javascript/users.js"></script>
 </body>
</html>