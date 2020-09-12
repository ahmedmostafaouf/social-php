<?php
session_start();
include 'init.php';
$id = isset($_GET['friend']) && is_numeric($_GET['friend']) ? intval($_GET['friend']) : 0;
 $byme = $_SESSION['uid'];

    $stmt =  $con->prepare("SELECT * FROM user WHERE user_id= $id");
    $stmt->execute();
    $info = $stmt->fetch();
    $stmt = $con->prepare("SELECT * FROM avatar WHERE user_id=$id ORDER BY avatar_id DESC");
    $stmt->execute();
    $avatarother = $stmt->fetch();
    $stmt = $con->prepare("SELECT * FROM avatar WHERE user_id=$byme ORDER BY avatar_id DESC");
    $stmt->execute();
    $avatarme = $stmt->fetch();

    $sender = $_SESSION['uid'];
    $other  =isset($_GET['friend']) && is_numeric($_GET['friend']) ? intval($_GET['friend']) : 0;
   
    //عملت عمود بحيث يجمع الرسايل الي جاي من السيندر والازر ويجمعهم ف اي دي واحد عشان اما اجي اجلبه 
   //كمان هنا عشان نوحد الشات اي دي يبقي هنعمل جمله ايف 
   if($sender > $other){
    $chatID = $sender.$other;
   }
   else{
      $chatID= $other.$sender;
   }
    // code insert 
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $msg    = $_POST['msg'];
     
        
      //Insert user info  database
      $stmt = $con->prepare("INSERT INTO chat(chat_id,sender,other,msg,time,date) VALUES (:zchat,:zsender,:zother,:zmsg,now(),now())");
      $stmt->execute(array( 'zchat' => $chatID,'zsender' => $sender , 'zother' => $other  , 'zmsg' => $msg ));
    }
    //اجلب البيانات بتاعتي 
     $stmt = $con->prepare("SELECT 
                                    chat.*, user.*  
                            FROM 
                                    chat
                            INNER JOIN 
                                        user
                            ON 
                                        user.user_id = chat.sender 
                            WHERE
                                        chat.chat_id=$chatID 
                            ORDER BY 
                                        chat.time               
                                    ");
                                    // هجيب البيانات دي
                                    $stmt->execute();
                                    // هحط البيات الي هتطلع ف متغيركده هيجيب البيانات كلها من الداتا بيز وهيعرضها
                                    $chatbox = $stmt->fetchAll(); 
                                    ?> 
<div class="informations ">
<div class="continer-fluid">
    <div class="col-xs-12  postss col-sm-12 col-md-9 col-lg-9" >
         <div class="panel panel-default" >
            <div class="panel-heading text-center" >
                <p> الرسائل </p>
            </div>
            <div class="panel-body">
            <div class="scroll">
                <ul class="chat">
                <?php
                        foreach($chatbox as $chat){
                            if($chat['sender']==$_SESSION['uid']){ ?>
                    <!-- Start by me-->
                    <li class="by-me">
                        <div class="avatar pull-left">
                            <img class="img-responsive img-thumbnail right" src="upload/avatar//<?php echo $avatarme['avatar_name'] ?>">
                        </div>
                        <div class="content">
                            <div class="chat-meta">
                            <?php echo $chat['f_name'] ?> <span class="pull-right"> <?php echo $chat['time'] ?>  </span>
                            </div>
                            <div class="clearfix">
                            <?php echo $chat['msg'] ?>
                            </div>
                        </div>
                    </li> 
                     <!-- end by me-->  
                            <?php } elseif($chat['sender']==$id){ ?> 
                      <!-- Start by other-->
                    <li class="by-other">
                            <div class="avatar pull-right">
                                    <img class="img-responsive img-thumbnail left" src="upload/avatar//ahmed.jpg">
                                </div>
                                <div class="content">
                                    <div class="chat-meta">
                                    <?php echo $chat['time'] ?><span  class="pull-right"> <?php echo $chat['f_name'] ?> </span>
                                    </div>
                                    <div class="clearfix">
                                    <?php echo $chat['msg'] ?>
                                    </div>
                                </div>
                    </li> 
                     <!-- end by other-->
                        <?php } 
                        } ?>
                      </ul>
                     
                      </div>
                      <form action="<?php echo $_SERVER['PHP_SELF'] .'?friend='. $id?>" method="POST"  class="form-inline">
                                <div class="form-group">
                                   <input class="form-control"  name="msg" type="text" >     
                               </div>
                               <button class="btn btn-info" type="submit"> Send</button>
                          </form>
                      </div>

                </div>    
            </div>
            
        </div>
    </div> 
    <div class="col-xs-12  col-sm-12 col-md-3 col-lg-3" >
        <div class="panel panel-default" >
            <div class="panel-heading text-center" >
                <p>  الصورة الشخصية </p>
            </div>
            <div class="panel-body">
                <img class="img-responsive img-thumbnail" src="upload/avatar//<?php echo $avatarother['avatar_name'] ?>" >
           
                <div class="btn-group btn-group-justified" role="group" aria-label="...">
                  <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default"><i class="fa fa-user-plus"></i></button>
                  </div>
                  <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default"><i class="fa fa-comments"></i></button>
                  </div>
                  <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default"><i class="fa fa-heart"></i></button>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12  col-sm-12 col-md-3 col-lg-3" >
         <div class="panel panel-default" >
            <div class="panel-heading text-center" >
                <p> Items </p>
            </div>
            <div class="panel-body">
            
                   
            </div>
        </div>
    </div>  
    <div class="col-xs-12  col-sm-12 col-md-3 col-lg-3" >
        <div class="panel panel-default" >
            <div class="panel-heading text-center" >
                <p>  المعلموات الشخصية </p>
            </div>
            <div class="panel-body">
            <h4 class="text-center"><strong>  <?php echo ucfirst( $info['f_name'] ).' ' .ucfirst($info['l_name']); 
                
                ?></strong></h4>
                <ul class="list-unstyled" >
                    <li ><span >  السن </span> | <?php echo $info['age'] ;?> </li>
                    <li ><span >  المدينة </span> | <?php echo $info['town']; ?> </li>
                    <li ><span >  الحالة الإجتماعية </span> | <?php echo $info['gender']; ?></li>
                </ul>
            </div>
        </div>   
    </div>
    </div>
    </div>
<?php
    include $tmbl . 'footer.php' ; 
  ?>


