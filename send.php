<?php 
/* $filepath = "chatlog.txt";
$msg = $_POST['m'] . "\n";
file_put_contents($filepath,$msg,FILE_APPEND); 
// get data */
session_start();
include "connect.php";
if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $msg  = $_POST['msg'];
        $friend = $_POST['other'];
        $myid   = $_SESSION['uid'];
         
        if($friend>$myid)
        {
            $chatid = $friend.$myid;

        }elseif($myid > $friend){
            $chatid = $myid.$friend;
        }
        $formerrors=array();
      if(empty($msg))
      { 
      $formerrors[]= " لا يوجد رساله يا بيه ";
      }
      if(empty($formerrors)){
          //Insert user info  database
      $stmt = $con->prepare("INSERT INTO chat(chat_id,sender,other,msg,time,date) VALUES (:zchat,:zsender,:zother,:zmsg,now(),now())");
      $stmt->execute(array( 'zchat' =>  $chatid,'zsender' => $myid , 'zother' => $friend  , 'zmsg' => $msg ));
      }
      $stmt = $con->prepare("SELECT 
                                    chat.*, user.*  
                            FROM 
                                    chat
                            INNER JOIN 
                                        user
                            ON 
                                        user.user_id= chat.sender 
                            WHERE
                                        chat.chat_id=$chatid 
                            ORDER BY 
                                        chat.time               
                                    ");
                                    // هجيب البيانات دي
                                    $stmt->execute();
                                    // هحط البيات الي هتطلع ف متغيركده هيجيب البيانات كلها من الداتا بيز وهيعرضها
                                    $chatbox = $stmt->fetchAll(); 

                                    foreach($chatbox as $chat){
                                        if($chat['sender']==$_SESSION['uid']){
                                              // استعلام جدول اليوزر عشان اجيب الاسم
                                              $stmt = $con->prepare("SELECT * FROM user WHERE user_id=". $chat['sender']."");
                                              $stmt->execute();
                                              $userinfo = $stmt->fetch();  
                                          ?>    
                             <!-- start  by me --> 
                               <li class="by-me margin-bottom-10" >
                                  <div class="avatar pull-left" > 
                                    <img height="50px" width="50px" src="upload\avatar\ahmed.jpg"   >
                                  </div>
                                  <div class="content" >
                                     <div class="chat-meta" > <?php echo  $userinfo['f_name'].' '. $userinfo['l_name'] ?> <span class="pull-right"> <?php echo $chat['time'] ?> </span></div>
                                     <div class="clearfix" > <?php echo $chat['msg'] ?> </div>
                                  </div> 
                               </li>
                             <!-- end by me -->
                                        <?php } elseif($chat['other']== $_SESSION['uid']){?>
                            
                             <!-- start  by other -->
                               <li class="by-other margin-bottom-10" >
                                 <div class="avatar pull-right" > 
                                    <img height="50px" width="50px" src="img.jpg" >
                                  </div>
                                  <div class="content" >
                                     <div class="chat-meta" > <?php echo $chat['time'] ?> <span class="pull-right"> <?php echo $chat['f_name'].' '.$chat['l_name'] ?> </span></div>
                                     <div class="clearfix" > <?php echo $chat['msg'] ?> </div>
                                  </div> 
                               </li>
                             <!-- end  by other -->
                                        <?php } }
    }
      



?>


