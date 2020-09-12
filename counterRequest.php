<?php
 session_start();
 include 'connect.php';
 $stmt =  $con->prepare("SELECT * FROM friend_Request WHERE second_user =".$_SESSION['uid'] ." AND seen=0 ");
 $stmt->execute();
 $count=$stmt->rowCount();
 if($count>0)
 {
?>
<i  class="badge badge-danger" style= "background-color:red"> <?php echo $count; ?></i>
 <?php }?>