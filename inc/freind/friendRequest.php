<?php 
session_start();
include '../../connect.php';
    $friendId=isset($_GET['userid'])&& is_numeric($_GET['userid']) ? intval($_GET['userid']) :0;
    $myid = $_SESSION['uid'];
    $insertadd = $con->prepare("INSERT INTO friend_request(frist_user,second_user) VALUES(:frist , :second)");
    $insertadd ->execute(array(
        'frist'=> $myid,
        'second'=> $friendId
     ));
     $stmt = $con->prepare("UPDATE friend_request SET seen=1 WHERE frist_user = " . $_SESSION['uid']. " AND second_user=$friendId");
     $stmt->execute();
?>
 <a href="javascript:void(0)" onclick ="getinfo('inc/freind/friendRequest.php','<?php echo $info['user_id'];?>')" class="btn btn-primary" role="button"><i class="fa fa-check"></i></a>
 <a href="chat.php?friend=<?php echo $info['user_id'] ;?>" class="btn btn-default" role="button"><i class="fa fa-comments"></i></a>
