<?php include 'dbconnect.php' ?>

<?php
ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require 'vendor/autoload.php';

    use SparkPost\SparkPost;
    use GuzzleHttp\Client;
    use Ivory\HttpAdapter\Guzzle6HttpAdapter;

    $httpAdapter = new Guzzle6HttpAdapter(new Client());
    $sparky = new SparkPost($httpAdapter, ['key'=>getEnv('SPARKPOST_API_KEY')]);


    $date = date("n/j/Y");
    $time = date("H:i");
    $mod_Time = strtotime($time."+ 10 minutes");
    $newTime = date("H:i",$mod_Time);
     
    $sql = "SELECT * FROM event WHERE eventDate='$date' AND eventTime ='$newTime'" ;
    
    $query = mysqli_query($conn,$sql) or die(mysqli_error());
    $count = mysqli_num_rows($query);
   echo"$sql";
    echo"$count";
    echo"fuck u 2";
    if ($count >= 1)
    {
            while($row = mysqli_fetch_array($query))
            {
                    $ID = $row["id"];
                    $schedule_title = $row["title"];
                    $schedule_description = $row["detail"];
                    $eventDate = $row["eventDate"];
                    $evenTime = $row["eventTime"];
                    $userId = $row["user_id"];
                    
                    

                    
                    $search_output = "<ul>
                                <li>
                                    <h4>Tiltle:".$schedule_title."</h4>
                                    <p><b>Date: ".$eventDate."</b></p>
                                    <p><b>Time: ".$evenTime."</b></p>
                                    <p><b>Description: ".$schedule_description."</p>
                                </li><br/>                  
                            </ul>";

                            $sendMail = true;
                        }



                    if($sendMail)
                    {  
                        $users = "SELECT * FROM users WHERE emailconfirm ='1' AND id ='$userId'" ;
                        $queryUsers = mysqli_query($conn,$users) or die(mysqli_error($conn));
                        $userCount = mysqli_num_rows($queryUsers);
                         
                        //$recipients = array();
                            if ($userCount >= 1)
                            {
                                while($rowu = mysqli_fetch_array($queryUsers))
                                {
                                    $to =$rowu['email'];
                                    $msgs="<html><body>".$msg."</body></html>";
                                     $results = $sparky->transmission->send([
                                        'from'=>'testing@' . getEnv('SPARKPOST_SANDBOX_DOMAIN'),
                                        'html'=>$msgs,
                                        'subject'=> 'Calendar Reminder',
                                        'recipients'=>[
                                          ['address'=>['email'=>$to]]
                                        ]
                                    ]);

                                     

                                //$subject ='A-CRM; UpComing Activities';
                                //$msg = $search_output; 
                                //$to = $rowu['email'];

                                //mail($to, $subject, $msg);
                                }   
                            }
                    }

    }

?>