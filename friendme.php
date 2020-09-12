<?php
  session_start();
  include  "init.php";
  ?>
  <div class="container-fluid">
      <div class=" ads col-xs-12 col-sm-12 col-md-3 col-lg-3" >
        <?php include $tmbl . 'ads.php'; ?>
    </div>
        
        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-8" >
         <div class="panel panel-default" >
            <div class="panel-heading" >
                <p> الأصدقاء </p>
            </div>
            <div class="panel-body">
                 <?php
                   $stmt=$con->prepare("SELECT * FROM friends WHERE friend = ".$_SESSION['uid']."");
                   $stmt->execute();
                   $friends=$stmt->fetchAll();
                   
                 ?>
                 <div class="row">
                <?php foreach($friends as $friend){
                      $frienduser=$friend['user'];
                      $stmt=$con->prepare("SELECT * FROM user WHERE user_id =  $frienduser ");
                      $stmt->execute();
                      $info=$stmt->fetch();
                      $stmt=$con->prepare("SELECT * FROM avatar WHERE user_id= $frienduser ORDER BY avatar_id DESC");
                      $stmt->execute();
                      $avatar=$stmt->fetch();
                      ?>
                       <div class="col-sm-6 col-md-4">
                         <div class="thumbnail" style="border: 0px solid #ddd"> 
                         <?php 
             if(empty($avatar['avatar_name'])){
         echo '<img  style="height: 131px;margin-right: auto;margin-left: auto;width: 131px;border-radius: 131px;" src="upload/avatar//default-user-image.png" alt=" " class="text-right">'; 
             }else{
              echo '<img style="height: 131px;margin-right: auto;margin-left: auto;width: 131px;border-radius: 131px;" src="upload/avatar//'.$avatar['avatar_name'].'" alt=" " class="text-right">'; 

             }
          ?>  
                              
                              <div class="caption">
                              <h5 style="size:20px" class="text-center"><strong><?php echo ucfirst( $info['f_name']) . ' ' .ucfirst($info['l_name']); ?></strong></h5>
                              <p class="text-center"><span ><?php echo $info['town']; ?></span> | <span ><?php echo $info['age']; ?> </span> </p>
                                                <div id ="" class="text-center">
                                                      <a href="" class="btn btn-primary" role="button"><i class="fa fa-check"></i></a>
                                                      <a href="inbox.php" class="btn btn-default" role="button"><i class="fa fa-comments"></i></a>
                                                </div>
                              </div>
                         </div>
                        </div>
                        <?php }?>
                  </div>
                   

            </div>
        </div>
  </div>

  <?php include $tmbl . 'footer.php' ?>
