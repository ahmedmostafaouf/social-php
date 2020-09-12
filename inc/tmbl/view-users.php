<div class="panel panel-default" >
    <div class="panel-heading">
            <p>  الأعضاء </p> 
    </div>
    <div class="panel-body" >
      <?php
     
     
      if(isset($_GET['page']))
      {
       $page= $_GET['page'];
      }else{
        $page=1;
      }
      $num_ber_page=3;//عدد الاعضاء ف الصفحه الواحدة
      $from=($page-1)*$num_ber_page; // انا واقف ف رقم الصفحه يعني  4-1 واقف ف صفحه رقم اربعه

            $stmt = $con->prepare("SELECT * FROM user LIMIT $from,$num_ber_page");
            $stmt->execute();
            $infos = $stmt->fetchAll();
      ?>
     <div class="row">
       <?php  foreach($infos as $info){  ?>
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
            
           
               <?php echo '</a>';?>
              
                <div class="caption">
                <h5 class="text-center"><strong><?php echo $info['f_name'].' '.$info['l_name']; ?></strong></h5>
                <p class="text-center"><span ><?php echo $info['town']; ?></span> | <span ><?php echo $info['age']; ?></span> </p>
                  <div id ="<?php echo $info['user_id'] ;?>" class="text-center">
                  <a href="javascript:void(0)" onclick ="getinfo('inc/freind/friendRequest.php?userid=<?php echo $info['user_id'] ;?>','<?php echo $info['user_id'];?>')" class="btn btn-primary" role="button"><i class="fa fa-user-plus"></i></a>
                  <a href="chat.php?friend=<?php echo $info['user_id'] ;?>" class="btn btn-default" role="button"><i class="fa fa-comments"></i></a>
                  </div>
              </div>
            </div>
          </div>
   
       <?php }?>
       <nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item"><a class="page-link" href="index.php?page=<?php if(($page-1)>0){ echo $page-1;}elseif(($page-1)<=0){echo '1';} ?>">Previous</a></li>
    <?php
         $stmt=$con->prepare("SELECT user_id FROM user");
         $stmt->execute();
         $totalusers=$stmt->rowCount();
         $totalpages= ceil($totalusers/$num_ber_page);
         for($i=1;$i<=$totalpages;$i++){
     ?>
    <li class="page-item"><a class="page-link" href="index.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
         <?php }?>
   
    <li class="page-item"><a class="page-link" href="index.php?page=<?php if(($page+1)<$totalpages){ echo $page+1;}elseif(($page+1)>=$totalpages){echo $totalpages;} ?>">Next</a></li>
  </ul>
</nav>
      </div>
    </div>
</div>