<?php 
    include '../../connect.php';
    $postId=isset($_GET['postid'])&& is_numeric($_GET['postid']) ? intval($_GET['postid']) :0;
    $userId=isset($_GET['userid'])&& is_numeric($_GET['userid']) ? intval($_GET['userid']) :0;

    $insertdeslike = $con->prepare("DELETE FROM likes WHERE post= $postId AND user=$userId");
    $insertdeslike->execute();
  
?>


<a href="javascript:void(0)"  onclick="insertLike('inc/postLike/like.php?postid=<?php echo $postId ?>&userid=<?php echo $userId ?>','<?php echo $postId; ?>')" class="btn btn-default"> Like <i class="fas fa-thumbs-up"></i></a>
