<?php
 session_start();
 include 'init.php';
 if($_SESSION['email']){
     if($_SERVER['REQUEST_METHOD']=='POST'){
         $uid=$_SESSION['uid'];
        $fname=$_POST['fname'];
        $lname=$_POST['lname'];
        $email=$_POST['email'];
        $town=$_POST['town'];
        $gender=$_POST['gender'];
        $pass='';
        if(empty($_POST['new-password'])){
            $pass=$_POST['old-password'];
        }else{
            $pass= sha1($_POST['new-password']);
        }
        $formerrors=array();
        if(strlen($fname) < 4 )
         {
          $formerrors[] = '<div class = "alert alert-danger"> Frist name cant be less than <strong> 4 char </strong> </div> ' ;
         }
         if(strlen($lname) < 4 )
         {
          $formerrors[] = '<div class = "alert alert-danger"> Last name cant be less than <strong> 4 char </strong> </div> ' ;
         }
         if(empty($fname))
         { 
           $formerrors[] = '<div class = "alert alert-danger"> Frist name cant be <strong> empty </strong> </div>' ;
         } 
         if(empty($lname))
         { 
           $formerrors[] = '<div class = "alert alert-danger"> Last name cant be <strong> empty </strong> </div>' ;
         }
         if(empty($email))
         { 
           $formerrors[] = '<div class = "alert alert-danger"> Email cant be <strong> empty </strong> </div>' ;
         } 
         if(empty($town))
         { 
           $formerrors[] = '<div class = "alert alert-danger"> Town cant be <strong> empty </strong>  </div>' ;
         }
        
        
           $stmt =$con->prepare("UPDATE user SET f_name=? , l_name=? , email=?, password=?,town=?,gender=? WHERE user_id=?");
           $stmt->execute(array(
            $fname,
            $lname,
            $email,
            $pass,
            $town,
            $gender,
            $uid
           ));
           $successmsg="Congraits You Are Edit Profile";
         
     }
     $uid=$_SESSION['uid'];
     $stmt =$con->prepare("SELECT * FROM user WHERE user_id=?");
     $stmt->execute(array($uid));
     $info= $stmt -> fetch();

     ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-offset-3 col-md-6">
                    <div class="panel panel-default" >
                            <div class="panel-heading">
                                <p> تعديل البيانات الشخصية </p>  
                            </div>
                                <div class="panel-body" >
                                <form class = "form-horizontal" action = "<?php echo $_SERVER['PHP_SELF']; ?>" method="POST"> 
                 <!-- start user name faild -->
                        <div class="form-group">
                            <div class="col-sm-10">
                                <input type= "text" name="fname" class="form-control" value="<?php echo  $info['f_name'] ?>"/>
                            </div>
                            <label class = "col-sm-2 control-label">الاسم الاول </label>
                        </div>
                  <!-- end user name faild -->
                   <!-- start user name faild -->
                   <div class="form-group">
                            <div class="col-sm-10">
                                <input type= "text" name="lname" class="form-control" value="<?php echo  $info['l_name'] ?>" />
                            </div>
                            <label class = "col-sm-2 control-label">الاسم الأخير </label>

                        </div>
                  <!-- end user name faild -->
                   <!-- start email faild -->
                   <div class="form-group form-group-lg>">
                            <div class="col-sm-10">
                                <input type= "email" name="email" class="form-control" value="<?php echo  $info['email'] ?>" />
                            </div>
                            <label class = "col-sm-2 control-label">البريد الالكترونى</label>
                        </div>
                  <!-- end email faild -->
                  <!-- start password faild -->
                    <div class="form-group form-group-lg>">
                            <div class="col-sm-10"> 
                               <input type= "hidden" name="old-password"  value="<?php echo $info['password'] ?>"/> 
                                <input type= "password" name="new-password" class="form-control"   autocomplete="new-password" />
                            </div>
                            <label class = "col-sm-2 control-label">الرقم السرى</label>
                        </div>
                  <!-- end password faild -->
                  <!-- start full name faild -->
                    <div class="form-group form-group-lg>">
                            <div class="col-sm-10">
                                <input type= "text" name="town" class="form-control"value="<?php echo  $info['town'] ?>"  />
                            </div>
                            <label class = "col-sm-2 control-label">المدينة</label>
                        </div>
                  <!-- end Fullname faild -->
                   <!-- start full name faild -->
                   <div class="form-group form-group-lg>">
                            <div class="col-sm-10">
                               <select class="form-control" name="gender">
                                   <option value="اعزب">اعزب</option>
                                   <option value="خاطب / مخطوب"> خاطب / مخطوب</option>
                                   <option value="متزوجه / متزوج">متزوج / متزوجة</option>
                                   <option value="مطلقة / مطلق"> مطلق / مطلقة</option>
                               </select>
                            </div>
                            <label class = "col-sm-2 control-label">الحالة الاجتماعيه</label>
                        </div>
                  <!-- end Fullname faild -->
                    <!-- start button faild -->
                    <div class="form-group>">
                            <div class=" col-sm-10">
                                  <button class="login-btn btn-block" type="submit">حفظ</button>
                            </div>
                        </div>
                  <!-- start button faild -->
                 </form>
                </div>
                <div class="the-errors text-center">
                    <?php 
		  if(!empty($formerrors))
		  {
			  foreach($formerrors as $errors){
				echo "<div class='container'>";
				echo '<div class="nice-message"> '.  $errors .' </div>';
			echo "</div>"; 
			  }
		  }
		  if(isset($successmsg)){
			echo "<div class='container'>";
			echo '<div class="succss-message"> '.  $successmsg .' </div>';
		echo "</div>"; 
			  
		  }
		?>
        </div>
                                </div>
           
                    </div>
            
            </div>
        
        
        </div>

    </div> 

<?php }else{
    header("loaction:login.php");
 }

 ?>
<?php include $tmbl . 'footer.php' ?>