<?php
  session_start();
  include 'init.php';
  // لو انا جاي عن طريق الفاربل البيدج سواء الكومنت او البوست هيطبعهولي غير كده هيطبع الهوم عادي يعني قسمت صفحتي 
  $page=isset($_GET['page']) ?  $_GET['page'] : 'posts';//انا جاي عن طريق ايه عت طريق البوست ولا الكومنت 
                if ($page == 'posts') {
                    if($_SERVER['REQUEST_METHOD']=="POST"){
                            $content=$_POST['posts'];
                            $myId=$_SESSION['uid'];
                            $date=date("y M,d");
                            $time = date("h:i:A");
                            $dayOfYear=date('ymd');
                            $stmt=$con->prepare("INSERT INTO posts(user_id,content,date,time,day)
                            VALUES (:userId,:content,:date,:time,:day)");
                            $stmt->execute(array(
                                'userId'=>$myId,
                                'content'=>$content,
                                'date'   =>$date,
                                'time'   =>$time,
                                'day'    =>$dayOfYear
                            ));  
                }
  
  }elseif ($page == 'comments') {
    if($_SERVER['REQUEST_METHOD']=="POST"){
          $userid  = $_POST['userID'];
          $postid  = $_POST['postID'];
          $content = $_POST['comments'];
          $time = date("h:i:A");
          $date=date("y/M,d");
          $stmt=$con->prepare("INSERT INTO comments(user,post_id,content,time,date) VALUES (:user,:post,:con,:time,:date) ");
          $stmt->execute(array(
              'user' => $userid,
              'post' => $postid,
              'con'  => $content,
              'time' => $time,
              'date' => $date
          ));
    }
  }
?>
  <div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-5 col-lg-4 col-xl-4">
            <?php  include $tmbl.'ads.php';?>
        </div>
        <div class="col-sm-12 col-md-7 col-lg-8 col-xl-8">
            <form action="?page=posts" method="POST">
                 <textarea name="posts" class="form-control" ></textarea>
                 <script>
                        CKEDITOR.replace( 'posts' );
                </script>
                 <button class="btn btn-primary btn-block"> <i class="fa fa-edit"></i>اضافة منشور</button>
            </form>
        </div>

    </div>  

    <div class="row">
        <?php
                 $stmt = $con->prepare("SELECT * FROM posts ORDER BY post_id DESC");
                 $stmt->execute();
                 $contentInfo=$stmt->fetchAll();
             foreach($contentInfo as $info){ 

                $avaCoID=$info['user_id'];
                $stmt =$con->prepare("SELECT * FROM avatar WHERE user_id = $avaCoID ORDER BY avatar_id DESC");
                $stmt->execute();
                $avatar =$stmt->fetch();
            /*............................ users.........................    */
            // id bta3 sa7b el post
            $myuser=$info['user_id'];
            $stmt = $con->prepare("SELECT * FROM user WHERE user_id=$myuser");
            $stmt ->execute();
            $myname= $stmt->fetch();
            /* .............................Time ..............................*/
            $pDate = $info['day'];
            $today = date('ymd');
               $dayAgo =  $today- $pDate   ; 
               if($dayAgo==0){
                   $postDate =' Today ';
               }elseif($dayAgo == 1){
                $postDate = ' Yesterday ';
               }
              elseif ($dayAgo == 2) {
                $postDate = ' Two days ago  ';
               }
               elseif($dayAgo > 2)
               {  
                
                   if ($dayAgo == 7) {
                       $postDate = ' Since a week ';
                       
                   }
                   elseif($dayAgo > 7){
                       $postDate = $info['date'];

                   }else{
                        $postDate=    $dayAgo . ' days ' . ' Ago ';
                   }  
             
               }
            ?>
        <div class="full-post col-md-offset-5 col-md-7">
            <!--..................................................... post Header........................................................ -->
            <div class="media">
                <div class="media-left">
                    <a href="#">
                    <img style="height:50px;width:50px;border-radius:50px;margin-left:5px;padding:0px" class="media-object" src="upload\avatar\\<?php if(empty($avatar['avatar_name'])){echo 'default-user-image.png';}else{ echo $avatar['avatar_name'];}?>" alt="...">
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading"><?php echo ucfirst($myname['f_name']) . ' ' . ucfirst($myname['l_name']); ?>  <br>  <span> <?php echo  $postDate . ' at ' . $info['time'] ;  ?> </span></h4>
                    <?php echo $info['content']; ?>
                </div>
            </div>
            <hr>
            <?php
            $postID=$info['post_id'];
               $countOfLike = $con->prepare("SELECT * FROM likes WHERE post =$postID");
               $countOfLike ->execute();
               $LikeCount=$countOfLike->rowCount();
            ?>
            <p class="text-right" style="direction:rtl" >   <?php echo $LikeCount ;?>  اشخاص اعجبه بهذا المنشور</p>

             <!--........................................................ post buttons................................................ -->
                <div class="btn-group btn-group-justified" role="group" aria-label="...">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default">Share <i class="fas fa-share"></i></button>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default">comment <i class="far fa-comment-alt"></i> </button>
                    </div>
                    <div id="<?php echo $info['post_id']; ?>" class="btn-group" role="group">
                    <?php 
                          $postId = $info['post_id'];
                          $userId =$_SESSION['uid'];
                           $stmt = $con->prepare("SELECT * FROM likes WHERE post= $postId AND user=$userId");
                           $stmt->execute();
                           $count=$stmt->rowCount(); 
                           if($count >0){?>
                        <a  href="javascript:void(0)"  onclick="insertLike('inc/postLike/deslike.php?postid=<?php echo $postId ?>&userid=<?php echo $userId ?>','<?php echo $postId; ?>')" class="btn btn-default"> <i style ="color:#5e5ee8; font-size: 27px;"class="fa fa-thumbs-up"></i></a>    
                       
                         <?php }else{ ?>
                        <a href="javascript:void(0)"  onclick="insertLike('inc/postLike/like.php?postid=<?php echo $postId ?>&userid=<?php echo $userId ?>','<?php echo $postId; ?>')" class="btn btn-default"> Like <i class="fas fa-thumbs-up"></i></a>

                           <?php } ?>
                    </div>
                </div>
               
                <hr>
         <!--..............................................headar el comment..............................................................-->
                        <?php
                            $postId=$info['post_id'];
                            $stmt = $con->prepare("SELECT * FROM comments WHERE post_id=  $postId ORDER BY content_id DESC");
                            $stmt->execute();
                            $comments=$stmt->fetchAll();
                            foreach($comments as $comment){
                                $avaCoID=$comment['user'];
                                $stmt =$con->prepare("SELECT * FROM avatar WHERE user_id = $avaCoID ORDER BY avatar_id DESC");
                                $stmt->execute();
                                $avatar =$stmt->fetch();
                                 /*............................ users.........................    */
            // id bta3 sa7b el post
            $myuser=$comment['user'];
            $stmt = $con->prepare("SELECT * FROM user WHERE user_id=$myuser");
            $stmt ->execute();
            $myname= $stmt->fetch();
            /* .............................Time ..............................*/
            $cDate = $info['day'];
            $today = date('ymd');
               $dayAgo =  $today- $cDate   ; 
               if($dayAgo==0){
                   $commentDate =' Today ';
               }elseif($dayAgo == 1){
                $commentDate = ' Yesterday ';
               }
              elseif ($dayAgo == 2) {
                $commentDate = ' Two days ago  ';
               }
               elseif($dayAgo > 2)
               {  
                
                   if ($dayAgo == 7) {
                    $commentDate = ' Since a week ';
                       
                   }
                   elseif($dayAgo > 7){
                    $commentDate = $info['date'];

                   }else{
                    $commentDate =    $dayAgo . ' days ' . ' Ago ';
                   }  
             
               }
                        ?>
         <div class="media">
                <div class="media-left">
                    <a href="#">
                    <img style="height:30px;width:30px;border-radius:30px;margin-left:5px;padding:0px" class="media-object" src="upload\avatar\\<?php if(empty($avatar['avatar_name'])){echo 'default-user-image.png';}else{ echo $avatar['avatar_name'];}?>" alt="...">
                    </a>
                </div>
                <div class="media-body media-comment">
                    <h6 class="media-heading"><?php echo ucfirst($myname['f_name']) . ' ' . ucfirst($myname['l_name']); ?>  <br>  <span class="comment-span"> <?php echo   $commentDate. ' at ' . $info['time'] ;  ?></h6>
                         <?php echo $comment['content']; ?>
                </div>
        </div>
        <?php } ?>
        <!--.......................................................form el comment.................... . . . . .............................-->
        <hr>
        <form action="?page=comments" method="POST" >
            <input type="hidden" name="userID" value="<?php echo $_SESSION['uid']; ?>" />
            <input type="hidden" name="postID" value="<?php  echo $info['post_id'] ; ?>" />

           <textarea name="comments" class="form-control"></textarea>
           <button class="btn btn-primary " type="submit">Comment</button>
       </form>
        </div>   
    </div>
    <?php }?> 
  </div>
  <script>
function insertLike(page,postId) {
       var xmlhttp;
       if(window.XMLHttpRequest) {
         xmlhttp = new XMLHttpRequest();
       } else {  
         xmlhttp = new ActiveXobject("Microsoft.XMLHTTP");
       } 
         
       xmlhttp.onreadystatechange = function() { 
         
         if(this.readyState == 4 & this.status == 200) { 
           document.getElementById(postId).innerHTML = this.responseText;
         }
       } 
       xmlhttp.open("GET",page,true);
       xmlhttp.send();
     } 
                               
</script>
  <?php include $tmbl . 'footer.php' ?>
