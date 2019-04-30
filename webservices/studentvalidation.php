<?php

$db=mysqli_connect('localhost','root','','test');

if($_SERVER['REQUEST_METHOD'] == "POST"){
 // Get data

$data = json_decode(file_get_contents("php://input"));

 $squery = mysqli_query($db,"SELECT * FROM student WHERE email = '$data->email' AND status = 1");

 $sresult = mysqli_num_rows($squery);

 $fquery = mysqli_query($db,"SELECT * FROM student WHERE email = '$data->email' AND code = '$data->code'");

 $result = mysqli_num_rows($fquery);
      
 if (!$sresult>0) {
 	# code...

 if ($result>0) {
    $json = array("status" => 1, "msg" => "Succssfully verified"); 	
    $fquery = mysqli_query($db,"UPDATE student set status=1 WHERE email = '$data->email' AND code = '$data->code'");
  }
  else{
     
     $json = array("status" => 0, "msg" => "Invalid verification code");
  } 

}
else{

	$json = array("status" => 0, "msg" => "Already verified");
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