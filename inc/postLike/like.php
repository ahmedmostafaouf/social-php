<?php
    include '../../connect.php';
    $postId=isset($_GET['postid'])&& is_numeric($_GET['postid']) ? intval($_GET['postid']) :0;
    $userId=isset($_GET['userid'])&& is_numeric($_GET['userid']) ? intval($_GET['userid']) :0;
    $insertlike = $con->prepare("INSERT INTO likes(post,user) VALUES(:post , :user)");
    $insertlike ->execute(array(
       'post'=>$postId,
       'user'=>$userId
    ));
    ?>
     <a  href="javascript:void(0)"  onclick="insertLike('inc/postLike/deslike.php?postid=<?php echo $postId ?>&userid=<?php echo $userId ?>','<?php echo $postId; ?>')" class="btn btn-default"> <i style ="color:#5e5ee8; font-size: 27px;"class="fa fa-thumbs-up"></i></a>

    