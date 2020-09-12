<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href=" <?php  echo $_SERVER['PHP_SELF'] ?>">Face LOok</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      
      <form action="search-name.php" method="POST" class="navbar-form navbar-left">
        <div class="form-group">
          <input name="pharase" type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> بحث </button>
      </form>
      <ul class="nav navbar-nav navbar-right">
      <script>
                 setInterval(function(){
                 $('#requestCounter').load('counterRequest.php');
                },3000);
                </script>
      <li class="dropdown">
      <a href="friendRequest.php" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-group" style="color:white;" ></i><span id="requestCounter" ></span></a>
      <ul class="dropdown-menu" style="width:250px;">
      <?php
           $stmt = $con->prepare("SELECT * FROM  friend_request WHERE second_user=". $_SESSION['uid']." AND status = 0");
           $stmt->execute();
           $reqcount =$stmt->rowCount();
           $requests = $stmt->fetchAll();
           if($reqcount>0){
           foreach($requests as $request){
            $stmt=$con->prepare("SELECT * FROM user WHERE user_id= ".$request['frist_user']."");
            $stmt->execute();
            $userinfo=$stmt->fetch();
            $stmt=$con->prepare("SELECT * FROM avatar WHERE user_id=".$request['frist_user']." ORDER BY avatar_id DESC");
            $stmt->execute();
            $info=$stmt->fetch();
       ?>
          <li id="<?php echo $userinfo['user_id']?>" style="margin:0 15px;text-align:center;">
          <?php 
             if(empty($info['avatar_name'])){
         echo '<img style=" margin-top:5px; height:30px;width:30px;border-radius:30px;margin-left:5px;padding:0px" class="img-responsive img-thumbnail" src="upload/avatar//default-user-image.png" alt=" " class="text-right">'; 
             }else{
              echo '<img style=" margin-top:5px; height:30px;width:30px;border-radius:30px;margin-left:5px;padding:0px" class="img-responsive img-thumbnail" src="upload/avatar//'.$info['avatar_name'].'" alt=" " class="text-right">'; 

             }
          ?>
          <h5 class="text-center"><b> <?php echo $userinfo['f_name'] . ' '. $userinfo['l_name'] ; ?> </b></h5> 
              <div class="btn-group" role="group" aria-label="...">
                 <button type = "button"  onclick ="getinfo('inc/freind/action.php?action=1&user=<?php echo $userinfo['user_id']?>','<?php echo $userinfo['user_id']?>')" class="btn btn-success"> accept </button>
                 <button type = "button"  onclick ="getinfo('inc/freind/action.php?action=2&user=<?php echo $userinfo['user_id']?>','<?php echo $userinfo['user_id']?>')" class="btn btn-danger"> Reject </button>
              </div>
              </li>
           <?php }}else{?>
              <li style="margin:15px;text-align:center;"> لا يوجد صداقة حتى الأن</li>
           <?php }?>
              </ul>
              </li>
              <!--     فنكشن بتعمل ريفرش كل فتره  -->
      <script>
                 setInterval(function(){
                 $('#msgCounter').load('counter.php');
                },3000);
                </script>
          <li><a href="inbox.php"><i  class="fa fa-comments-o"> </i> <span id="msgCounter" ></span> الرسائل </a></li>
          <li><a href="index.php"><i class="fa fa-home" ></i> الرئيسية </a></li>
        <li class="dropdown">
        <?php
        $myid=$_SESSION['uid'];
             $stmt=$con->prepare("SELECT * FROM user WHERE user_id= $myid");
             $stmt->execute();
             $row=$stmt->fetch();
             $id=$_SESSION['uid'];
             $stmt=$con->prepare("SELECT * FROM avatar WHERE user_id=$myid ORDER BY avatar_id DESC");
             $stmt->execute();
             $info=$stmt->fetch();
        ?>
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> 
          <?php
           echo ucfirst($row['f_name']) .' ' .ucfirst($row['l_name']);
           if(empty($info['avatar_name'])){
            echo '<img  style="height:30px;width:30px;border-radius:30px;margin-left:5px;padding:0px" class="img-responsive img-thumbnail" src="upload/avatar//default-user-image.png">';
           } else {
            echo '<img style="height:30px;width:30px;border-radius:30px;margin-left:5px;padding:0px" class="img-responsive img-thumbnail" src="upload/avatar//'.$info['avatar_name'].'">';
           }
         
           
           
           ?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
              <li><a href="edit.php"><i class="fa fa-edit" ></i> تعديل الحساب </a></li>
            <li><a href="myProfile.php"><i class="fa fa-user"></i> الصفحة الشخصية </a></li>
            <li role="separator" class="divider"></li>
            <li><a href="logout.php"><i class="fa fa-sign-out"></i> الخروج </a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>