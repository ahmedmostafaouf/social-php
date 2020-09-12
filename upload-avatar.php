<?php 

 session_start();
 // لو فيه سشن موجود ب الاميل ده دخلني لو مش موجود رجعني 
if($_SESSION['email']){ 

 //$nonav = '';
 include 'init.php';
 if($_SERVER['REQUEST_METHOD']=='POST'){
      $name=$_FILES['avatar']['name'];
      $type=$_FILES['avatar']['type'];
      $tmp=$_FILES['avatar']['tmp_name'];
      $size=$_FILES['avatar']['size'];
      $allowed= array("jpg","jpeg","png","gif");
       // end()  last element of array
     //explode('.',name) slice name  
     //strtolower() replace  all word small
     $explode = explode('.',$name);
     $filetype=strtolower(end($explode));
     //in_array(file name ,array name)
     if(!in_array( $filetype, $allowed)){
         $error= " هذا الملف غير مدعوم";
     }else{
           //دي داله بعملها للاسم تغيري اللاسم تطلي رقم قبله عشان لو رفعت الصوره مرتين
      $nename=rand(0,1000) . '_' . $name;
      //ارفع ملف
     // move_uploaded_file(filename,destination);
     move_uploaded_file($tmp,'upload/avatar//'.$nename);
     $id=$_SESSION['uid'];
     $stmt=$con->prepare("INSERT INTO avatar(avatar_name,date, user_id) VALUES (:zname, now(), :zuserid)");
     $stmt->execute(array(
        'zname'=>$nename,
        'zuserid'=>$id
    ));
    if($stmt){
        $secess="تم رفع الصورة بنجاح";
    }
     }
 }
 $id=$_SESSION['uid'];
 $stmt=$con->prepare("SELECT * FROM avatar WHERE user_id=$id ORDER BY avatar_id DESC");
 $stmt->execute();
 $info=$stmt->fetch();

 
?>
<div class="container-fluid">
        <div class="row">
            <div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                <div class=" col-sm-offset-4 col-sm-4">
               <?php
                   if(empty($info['avatar_name'])){
                    echo '<img class="img-responsive img-thumbnail" src="upload/avatar//default-user-image.png">';
                   } else {
                    echo '<img class="img-responsive img-thumbnail" src="upload/avatar//'.$info['avatar_name'].'">';
                   }
                   ?>
                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">
                    <input class="form-control" type="file" name="avatar"  >
                    <button type="submin" class="login-btn btn-block"> تحميل</button>
            
               </form>
               <?php if(isset($error)){?>
                <div class="alert alert-danger text-center"> <?php echo $error;  ?></div>

            <?php   }elseif(isset($secess)){?>
                <div class="alert alert-success text-center"> <?php echo $secess;  ?></div>


               <?php  }?>
                </div> 
            </div>
        </div>
</div>




<?php
 include $tmbl . 'footer.php'; 
}else{
    header('location:login.php');
} 