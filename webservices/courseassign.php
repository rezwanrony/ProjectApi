<?php

//use PHPMailer\PHPMailer\PHPMailer;

$db=mysqli_connect('localhost','root','','test');

if($_SERVER['REQUEST_METHOD'] == "POST"){
 // Get data

$data = json_decode(file_get_contents("php://input"));

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
 // Insert data into data base
 $query = mysqli_query($db, "INSERT INTO course_assign (course_id, teacher_id, section) VALUES ('$data->course_id','$data->teacher_id','$data->section')");


 if($query){ 

    $json = array("status" => 1, "msg" => "Course successfully taken");

 
 }else{
 $json = array("status" => 0, "msg" => "Error in taking course!");
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