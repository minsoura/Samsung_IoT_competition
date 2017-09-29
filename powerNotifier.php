  <?php

    if($_SERVER['REQUEST_METHOD']=='POST'){


    define('HOST', "mysql.hostinger.kr");
    define('USER', "u414143907_andro");
    define('PW', "m2m3m5m2");
    define('DB', "u414143907_andro");
    $con= mysqli_connect(HOST,USER,PW,DB) or die("Unable to Connect");
    include_once "coolsms.php";

    $powerConsumed = $_POST['powerConsumed'];
    $deviceID = $_POST['deviceID'];
    $thresholdValue = 1000;
    $powerConsumedIN_KWH = round($powerConsumed/1000, 2) ;


                            if( $powerConsumed >= $thresholdValue){



                            $apikey = 'NCS577FB8897260F'; 
                            $apisecret = '6BF5FF5F0C47558EFD6C3C6EC2544105'; 


                            $rest = new coolsms($apikey, $apisecret);

                            $options = new stdClass();
                            $options->timestamp = (string) time();
                            $options->to = '01025899276';
                            $options->from = '01025899276';
                            $options->type = 'SMS';
                            $options->text = '[T.N.T]'.$deviceID.'번 장비 전력 초과: '.$powerConsumedIN_KWH. 'KWH';
                            $options->app_version = 'T.N.T';  

                            $result = $rest->send($options);

                            }

                           


}



?>