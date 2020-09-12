<?php 
    session_start();
    include  "init.php";
    $id = isset($_GET['friend']) && is_numeric($_GET['friend']) ? intval($_GET['friend']) : 0;

    $stmt =  $con->prepare("SELECT * FROM user WHERE user_id= $id");
    $stmt->execute();
    $info = $stmt->fetch();

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
<section class="main-chat-section" >
    <div class="container" >
        <div class="row"  >
            <div class="left-item  col-lg-8 col-md-6 col-sm-12 d-sm-none d-md-block ">
                
                <div class="scroll" id ="ss" style="height:500px;">
                <script>
                setInterval(function(){
                 $('#Success').load('Refchat.php?friend=<?php echo $other; ?>');
                 $('#ss').animate({ scrollTop:"100000" },6000);
                },3000);
                </script>
             
             <ul class="chats" id="Success" >
             <?php
                        foreach($chatbox as $chat){
                            if($chat['sender']==$_SESSION['uid']){ 
                              ?>    
                 <!-- start  by me --> 
                   <li class="by-me margin-bottom-10" >
                      <div class="avatar pull-left" > 
                      <?php
                      $avaCoID=$_SESSION['uid'];
                      $stmt =$con->prepare("SELECT * FROM avatar WHERE user_id = $avaCoID ORDER BY avatar_id DESC");
                      $stmt->execute();
                      $avatar =$stmt->fetch();
                      ?>
                        <img height="50px" width="50px" src="upload\avatar\<?php if(empty($avatar['avatar_name'])){echo 'default-user-image.png';}else{ echo $avatar['avatar_name'];}?> "   >
                      </div>
                      <div class="content" >
                         <div class="chat-meta" > <?php echo $chat['f_name']. ' '.$chat['l_name'] ?> <span class="pull-right"> <?php echo $chat['time'] ?> </span></div>
                         <div class="clearfix" > <?php echo $chat['msg'] ?> </div>
                      </div> 
                   </li>
                 <!-- end by me -->
                            <?php } elseif($chat['sender']==$id){?>
                
                 <!-- start  by other -->
                   <li class="by-other margin-bottom-10" >
                     <div class="avatar pull-right" > 
                     <?php
                      $avaCoID=$id;
                      $stmt =$con->prepare("SELECT * FROM avatar WHERE user_id = $avaCoID ORDER BY avatar_id DESC");
                      $stmt->execute();
                      $avatar =$stmt->fetch();
                      ?>
                        <img height="50px" width="50px" src="upload\avatar\\<?php if(empty($avatar['avatar_name'])){echo 'default-user-image.png';}else{ echo $avatar['avatar_name'];}?>" >
                      </div>
                      <div class="content" >
                         <div class="chat-meta" > <?php echo $chat['time'] ?> <span class="pull-right"> <?php echo $chat['f_name'].' '. $chat['l_name'] ?> </span></div>
                         <div class="clearfix" > <?php echo $chat['msg'] ?> </div>
                      </div> 
                   </li>
                 <!-- end  by other -->
                            <?php } }?> 
                 </ul> 
             </div> 
             <div style="padding-top: 15px;" class="row" >
                <div class="col-lg-offset-1 col-lg-10 chat-form" >
                    <form  id="Chat" enctype="multipart/form-data" >
                      <div class="form-group" > 
                        <input type="hidden" name="other" value="<?php echo $other;?>" >  
                          <textarea class="form-control" id="msg" name="msg" rows="5" ></textarea>
                      </div>
                      <button id="sendbtn" type="submit" name="submit" class="btn btn-block btn-primary"> <i class="fa fa-paper-plane" ></i> </button>
                    </form>
                 </div>
             </div> 
            </div>
            <?php 
            //استعلامه يجبلي من الداتا بيز من جدول الشات 
                 $stmt=$con->prepare("SELECT DISTINCT chat_id,sender,other FROM chat WHERE sender=".$_SESSION['uid']. "");
                 $stmt->execute();
                 $infos = $stmt->fetchAll();   
            ?>
            <div class="right-item  overflow-auto col-lg-4 col-md-6 col-sm-12" >
                <?php foreach($infos as $info){ 
                        $stmt = $con->prepare("SELECT * FROM chat WHERE sender=". $info['other']." ORDER BY id DESC ");
                        $stmt->execute();
                        $chat = $stmt->fetch(); 
                        
                        // استعلام جدول اليوزر عشان اجيب الاسم
                        $stmt = $con->prepare("SELECT * FROM user WHERE user_id=". $info['other']."");
                        $stmt->execute();
                        $user = $stmt->fetch();     
                ?>
                <a href="inbox.php?friend=<?php echo $user['user_id'];?>" >
                    <div  <?php if($info['other']==$other){ echo "style='background-color:#ddd;'"; }  ?> class="row users-messages text-right"> 
                        <div class="col-md-8 user-item" > 
                            <h6 style="direction:rtl;color:#286090;font-weight: 700;font-size:20px;margin:0" > <?php echo $user['f_name'] . ' '.  $user['l_name'] ?>  </h6> 
                            <p style="color: #99999b; font-weight: bold;margin:0" >.. <?php mb_internal_encoding("UTF-8");echo mb_substr($chat['msg'],0,30)  ?></p>
                            <p style="margin:0" class="time" > <?php echo $chat['time'] ?> </p>

                        </div>
                        <div class="col-md-4 user-img" >
                        <?php
                      $avaCoID=$id;
                      $stmt =$con->prepare("SELECT * FROM avatar WHERE user_id = $avaCoID ORDER BY avatar_id DESC");
                      $stmt->execute();
                      $avatar =$stmt->fetch();
                      ?>
                        <img height="50px" width="50px" src="upload\avatar\\<?php if(empty($avatar['avatar_name'])){echo 'default-user-image.png';}else{ echo $avatar['avatar_name'];}?>" >
                          
                        </div>
                    </div> 
                </a> 
                <?php }?>
            </div>
        </div>
    </div>
</section>

	<!-- Jquery JS -->
    <?php include $tmbl . 'footer.php' ?>