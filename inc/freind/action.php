<?php 
session_start();
   include '../../connect.php';
   $action = isset($_GET['action'])&& is_numeric($_GET['action'])?intval($_GET['action']):0;
   $user = isset($_GET['user'])&& is_numeric($_GET['user'])?intval($_GET['user']):0;
   if($action == 1){
   // هعمل ابديت لل الاستاتيوس معني كده انو قبل الدعوه
   $stmt = $con->prepare("UPDATE friend_request SET status = 1 WHERE frist_user=$user AND second_user= ". $_SESSION['uid'] ." ");
   $stmt->execute();
   if($stmt){
   $stmt = $con->prepare("INSERT INTO friends(user,friend) VALUES(:user,:friend)");
   $stmt->execute(array(
     'user' => $_SESSION['uid'],
     'friend'=>$user 
   ));
   $stmt = $con->prepare("INSERT INTO friends(user,friend) VALUES(:user,:friend)");
   $stmt->execute(array(
     'user'  => $user,
     'friend'=> $_SESSION['uid']
   ));
}
   }elseif($action==2){
    $stmt = $con->prepare("UPDATE friend_request SET status=2 WHERE frist_user=$user AND second_user= ". $_SESSION['uid'] ." ");
    $stmt->execute();
   }
?>