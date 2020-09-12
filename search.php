<?php 

session_start();
if($_SESSION['email']){

 //$nonav = '';
 include 'init.php';
?>

<div class="container-fluid">
    <div class="  ads col-xs-12 col-sm-12 col-md-3 col-lg-3" >
        <?php include $tmbl . 'ads.php'; ?>
    </div>
    <div class=" col-xs-12 col-sm-12 col-md-9 col-lg-9" >
        <?php include $tmbl . 'search-control.php'; ?>
    </div>
    <div class=" col-xs-12 col-sm-12 col-md-6 col-lg-6" >
         <div class="panel panel-default" >
            <div class="panel-heading">
                    <p>  الأعضاء </p> 
            </div>
            <div class="panel-body" >
                <?php 
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    $minAge = $_POST['minAage'];
                    $maxAge = $_POST['maxAage'];
                    $town = $_POST['town'];
                    $gender =$_POST['gender'];
                    $stmt = $con->prepare("SELECT * FROM user where age >= $minAge and age <= $maxAge or (CONVERT(`town` USING utf8) LIKE '%$town%') or gender=$gender ");
                    $stmt->execute();
                    $infos = $stmt->fetchAll();
          }else{
              header("loaction:index.php");
          }
                ?>
              <div class="row">
                  <?php foreach($infos as $info){ ?>
                  <div class="col-sm-6 col-md-4">
                    <div class="thumbnail" style="border: 0px solid #ddd;">
                    <?php
                        echo '<a href="profile.php?uid='.$info['user_id'].'">';
                        $stmt=$con->prepare("SELECT * FROM avatar WHERE user_id=".$info['user_id'] ."  ORDER BY avatar_id DESC");
                        $stmt->execute();
                        $avatar=$stmt->fetch();
                        if(empty($avatar)){
                          echo '< style="height: 131px;margin-right: auto;margin-left: auto;width: 131px;border-radius: 131px;" img src="themes/img/default-user-image.png" alt="...">';
                        }else{
                          echo '<img style="height: 131px;margin-right: auto;margin-left: auto;width: 131px;border-radius: 131px;" src="upload/avatar//'.$avatar['avatar_name'].'" alt=" " class="text-right">'; 
                        }
                        ?>
                     
                      <div class="caption">
                        <h5 class="text-center"><strong><?php echo $info['f_name'] . ' ' .  $info['l_name']; ?></strong></h5>
                        <p class="text-center"><span ><?php echo $info['town'] ?></span> | <span ><?php echo $info['age'] ?></span> </p>
                          <p class="text-center"><a href="#" class="btn btn-primary" role="button"><i class="fa fa-user-plus"></i></a> <a href="#" class="btn btn-default" role="button"><i class="fa fa-comments"></i></a></p>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
              </div>
            </div>
         </div>
    </div>
    <div class=" col-xs-12 col-sm-12 col-md-3 col-lg-3" >
        <?php include $tmbl . 'buttons.php'; ?>
    </div>
</div>


<?php
include $tmbl . 'footer.php';
}else{
    header('location:login.php');
}