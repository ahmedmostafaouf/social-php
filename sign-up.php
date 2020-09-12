<?php
session_start();
$nonav="";
if(isset($_SESSION['email'])){
    header('location:index.php');
}
include 'init.php';
if($_SERVER['REQUEST_METHOD']=="POST"){
    $formErrors=array();
    $fristname = filter_var($_POST['fname'],FILTER_SANITIZE_STRING);
    $lasname   =filter_var($_POST['lname'],FILTER_SANITIZE_STRING);
    $email     = $_POST['email'];
    $password  =$_POST['password'];
    $password2 = $_POST['password2'];
    $sex       =$_POST['sex'];
    $birth     = $_POST['birthDay'];
              $agenow =date('Y');
    $age       =  $agenow - $birth;

    $pass1 = sha1($_POST['password']);
    $pass2 = sha1($_POST['password2']);
    // ههبعت الباص وان والباص تو ولو هما مش شبه بعض اعمل كذا 
     if($pass1!==$pass2){
      $formErrors[]="Sorry password is not match";
     }
 
 if(isset($_POST['email'])){
    $FilterEmail=filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
    if(filter_var($FilterEmail , FILTER_VALIDATE_EMAIL)!= true){
     $formErrors[]="This Email IS Not Valid";
    }
}

   //check if user insert in database
  // $check = checkitem("UserName" , "user" ,$username);
  $stmt=$con->prepare("SELECT email FROM user WHERE email=?");
  $stmt->execute(array($email));
  $count = $stmt -> rowCount();
   if($count==1)
   {
    $formErrors[] = "Sorry email IS Exist";
   }
   if(empty($formErrors)){
    $stmt=$con->prepare("INSERT INTO  user(f_name,l_name,sex,email,password,birthday,age)VALUES(:fname,:lname,:sex,:email,:pass,:bday,:age)");
    $stmt->execute(array(
      'fname'=>$fristname,
      'lname'=>$lasname,
      'sex'  =>$sex,
      'email'=>$email,
      'pass' =>sha1($password),
      'bday' =>$birth,
      'age'  =>$age
    ));
    if($stmt){
        header("location:login.php");
    }
}
}

?>
<section class="login-page">
<div class="container " >

<div class="col-sm-offset-3 col-sm-6" >
    <div class="login-form">
        <i class="fas fa-smile" style="font-size: 38px;margin-bottom:9px;margin-top: -14px;padding-left:199px;color: #ff5656;"></i>
        <h3 class="text-center" style="margin-top:-12px;font-size:29px;margin-bottom:6px;color:#ff5656;"> Sign Up </h3>
        <form aciton="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="form-horizontal">
        <div class="form-group">
                <div class="col-sm-12 margin-bottom-12">
                <input
                pattern=".{4,}"
                title="First Name Must Be 4 char"
                style="border-radius:50px"
                class="form-control"
                type="text"
                name="fname"
                placeholder="type your First Name" >
                </div>
                <div class="col-sm-12 margin-bottom-12">
                <input 
                pattern=".{4,}"
                title="Last Name Must Be 4 char"
                style="border-radius:50px" 
                class="form-control" 
                type="text" 
                name="lname"
                 placeholder="type your Last Name" >
                </div>
                <div class="col-sm-12 margin-bottom-12">
                <input style="border-radius:50px" class="form-control" type="email" name="email" placeholder="type your Email" required >
                </div>
                <div class="col-sm-12 margin-bottom-12">
                <input  minlength="4" style="border-radius:50px" class="form-control" type="password" name="password" placeholder="type your password" required >
                </div>
                <div class="col-sm-12 margin-bottom-12">
                <input minlength="4" style="border-radius:50px" class="form-control" type="password" name="password2" placeholder="type Confirm  password" required >
                </div>
                <div class="col-sm-6 margin-bottom-12">
                <input style="border-radius:50px" class="form-control" type="date" name="birthDay" required >
                </div> 
                <div class="col-sm-6 margin-bottom-12">
                           <select  style="border-radius:50px" name="sex" class="form-control">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                           </select>
                </div>
                <div>
                   <button style="border-radius:50px" class="form-control login-btn margin-bottom-12" type="submit" >Sign Up</button>
                        <?php if(!empty($formErrors)){
                            foreach($formErrors as $errors){
                        ?>
                    <div class="col-sm-12 alert alert-danger text center" style="padding: 13px;border-radius: 9px;color: #f73b37;background-color: #000;border-color: #e65252;margin-bottom: 11px;border: 0px solid #bd131300;" >
                            <p class="text-center"> <?php echo $errors ?> </p>
                                <?php }
                                    } ?>
                    </div>
                 </div>     
        </form>
       
        <div class="form-group">
            <a href="Login.php" class="login-up-link" style="text-decoration:none;padding-left: 120px;"> Login With My Email </a>
        </div>
      
    </div>
</div>


</div>

</section>