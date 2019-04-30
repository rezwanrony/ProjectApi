<?php

use PHPMailer\PHPMailer\PHPMailer;

$db=mysqli_connect('localhost','root','','test');

if($_SERVER['REQUEST_METHOD'] == "POST"){
 // Get data

$data = json_decode(file_get_contents("php://input"));

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');
$email= 'iamrezwanrony@gmail.com';
$code= random_int(100000,999999);



 $fquery = mysqli_query($db,"SELECT * FROM student WHERE email LIKE '%$data->email%'");

 $result = mysqli_num_rows($fquery);
        
  $key = '@diu.edu.bd'; 
  
if (strpos($data->email, $key) == true) {  


	
			if($result > 0) { //check if there is already an entry for that username
				$json = array("status" => 0, "msg" => "email already exist!!");
			}
 

			else{

				require 'vendor/autoload.php';
//Create a new PHPMailer instance
$mail = new PHPMailer;
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->Username = 'rezwan35-982@diu.edu.bd';
$mail->Password = 'khuljasimsim982';
  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication                       // SMTP password
$mail->Port = 587;                             
$mail->SMTPSecure = 'tls';
//Tell PHPMailer to use SMTP
$mail->From = "iamrezwanrony@gmail.com";
$mail->FromName = "SWEProjectandthesis";

//To address and name
$mail->addAddress($data->email, "Recepient Name");
//$mail->addAddress("recepient1@example.com"); //Recipient name is optional

//Address to which recipient will reply

//CC and BCC
$mail->addCC("cc@example.com");
$mail->addBCC("bcc@example.com");

//Send HTML or Plain Text email
$mail->isHTML(true);

$mail->Subject = "Signup | Verification";
$mail->Body = "Thanks for signing up!
Your account has been created, you can verify your account with the following verification code.</br>
 
 
Please use this verification code to activate your account.
Verification code=$code
 
";
$mail->AltBody = "This is the plain text version of the email content";

 // Insert data into data base
 $query = mysqli_query($db, "INSERT INTO student (name, email, password, phone ,address, code) VALUES ('$data->name','$data->email','$data->password','$data->phone','$data->address', $code)");

 if($query){

if(!$mail->send()) 
{
    $json = array("status" => 0, "msg" => "mail sent error");
} 
else 
{
    $json = array("status" => 1, "msg" => "Successfully Registered, a verification code is sent to your email");


}
 
 }else{
 $json = array("status" => 0, "msg" => "Error adding user!");
 }
}

}

else{

	$json = array("status" => 0, "msg" => "The email must be a registered diu email");
}

}

else{
 $json = array("status" => 0, "msg" => "Request method not accepted");
}

 
mysqli_close($db);
 
/* Output header */
 header('Content-type: application/json');
 echo json_encode($json);



?>