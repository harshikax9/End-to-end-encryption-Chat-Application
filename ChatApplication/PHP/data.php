<?php 
$outgoing_id=$_SESSION['unique_id']; 

while($row=mysqli_fetch_assoc($sql)){
    $sql2="SELECT * FROM  messages WHERE (incoming_msg_id = {$row['unique_id']}
    or outgoing_msg_id={$row['unique_id']}) AND (outgoing_msg_id = {$outgoing_id}
    or incoming_msg_id={$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";
$query2=mysqli_query($conn,$sql2);
$row2=mysqli_fetch_assoc($query2);
if(mysqli_num_rows($query2)>0){
    $result=$row2['msg'];
}else{
    $result = "No Message Available";
}

//trimming message if word are more than 28
(strlen($result)>28) ? $msg = substr($result, 0, 28).'...': $msg= $result; 

//adding you: text before msg if login id send msg
if(isset($row2['outgoing_msg_id'])){
    ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "You: " : $you = "";
}else{
    $you = "";
}


    //check user online or offline

    ($row['status']=="Offline Now") ? $offline ="offline": $offline="";

    $output .='<a href="chat.php?user_id='.$row['unique_id'].'">
    <div class="content">
        <img src="PHP/Image/'. $row['img'] .'" alt="">
        <div class="details">
        <span>'.$row['fname']. " " .$row['lname'].'</span>
        <p>'.$you .'</p>
        </div>
    </div>
    <div class="status-dot '.$offline.'"><i class="fas fa-circle"></i></div>
   </a>';
}

?>