<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');


$db=mysqli_connect('localhost','datalibrary','Cis@360#','datalibr_roni');


if($_SERVER['REQUEST_METHOD'] == "POST"){
    // Get data


    $data = json_decode(file_get_contents("php://input"));

    //SMTP needs accurate times, and the PHP time zone MUST be set
    //This should be done in your php.ini, but this is how to do it if you don't have access to that
    date_default_timezone_set('Etc/UTC');
    $email= 'iamrezwanrony@gmail.com';
    $code= mt_rand(100000,999999);
    //$code = 123456;

            $to = $data->email; // note the comma
            // Subject
            $subject = 'Verification Code';
            // Message
            $message = "Thanks for signing up! 
                        Your account has been created, you can verify your account with the following verification code.</br>
                        Please use this verification code to activate your account.
                        Verification code=$code";

            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=iso-8859-1';
            // Additional headers
            $headers[] = 'From:rezwan35-982@diu.edu.bd';

            $mail_sent = mail($to, $subject, $message, implode("\r\n", $headers));

                if(!$mail_sent)
                {
                    $json = array("status" => 0, "msg" => "mail sent error");
                }
                else
                {
                    $json = array("status" => 1, "msg" => "Another verification code is sent to your email");
                    $fquery = mysqli_query($db,"UPDATE student set code = $code WHERE email = '$data->email'");

                }

        }
            //End Mail Part
            // Insert data into data base
           
else{
    $json = array("status" => 0, "msg" => "Request method not accepted");
}


mysqli_close($db);

/* Output header */
header('Content-type: application/json');
echo json_encode($json);



?>