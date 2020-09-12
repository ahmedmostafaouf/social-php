<?php 
    session_start();
    include 'init.php';
   
?>

<div class="continer-fluid">
    <div class="col-xs-12 col-md-offset-1 col-sm-12 col-md-10 col-lg-10" >
         <div class="panel panel-default" >
            <div class="panel-heading" >
                <p> الصور الشخصية </p>
            </div>
            <div class="panel-body">
                <?php
                $id=isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
                $stmt = $con->prepare("SELECT * FROM avatar WHERE user_id=$id ORDER BY avatar_id DESC");
                $stmt ->execute();
                $avatars=$stmt->fetchAll();
                foreach($avatars as $avatar){
                ?>
                <div class="col-sm-3">
                <?php
                    echo '<a href="galary.php?userid='.$id.'">';
                         echo '<img style="height:210px;width:100%; margin-bottom:10px" class="img-responsive img-thumbnail" src="upload/avatar//'.$avatar['avatar_name'].'">';
                    echo '</a>';
                 ?>
                </div>
                <?php }?>
            </div>
                
        </div>
        
    </div> 
    

</div>

<?php include $tmbl . 'footer.php' ?>