<?php
session_start();
$nonav="";
if(isset($_SESSION['email'])){
    header('location:index.php');
}
include 'init.php';
if($_SERVER['REQUEST_METHOD']=="POST"){
    $email = $_POST['email'];
    $password = sha1($_POST['pass']);
    $stmt=$con->prepare("SELECT user_id ,email,password FROM user WHERE email=? AND password=?");
    $stmt->execute(array($email,$password));
    $get =$stmt->fetch();
    $count = $stmt->rowCount();
    if($count>0){
        $_SESSION['email']=$email;
        $_SESSION['uid']=$get['user_id'];
        header('location:index.php');
    }
}

?>
<section class="login-page">
<div class="container " >

<div class="col-sm-offset-3 col-sm-6" >
    <div class="login-form">
        <h3 class="text-center"> Login </h3>
        <form aciton="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="form-horizontal">
            <div  class="form-group">
                <lable > Email </lable>                
                <input style="border-radius:50px" class="form-control" type="text" name="email" placeholder="type your email" >
            </div>
            <div class="form-group">
               <label > Password </label>
               <input style="border-radius:50px" class="form-control" type="password" name="pass" placeholder="type your password" >
            </div>
            <div class="form-group" >
               <button style="border-radius:50px" class="form-control login-btn" type="submit" >login</button>
            </div>
        </form>
        <div class="form-group">
            <a href="sign-up.php" class="sign-up-link" style="text-decoration:none"> Sign Up </a>
        </div>
    </div>
</div>
</div>
</section>