<?php


$db=mysqli_connect('localhost','datalibrary','Cis@360#','datalibr_roni');

if($_SERVER['REQUEST_METHOD'] == "POST"){
 // Get data

$data = json_decode(file_get_contents("php://input"));

 $squery = mysqli_query($db,"SELECT * FROM student WHERE email = '$data->email' AND status = 1");

 $sresult = mysqli_num_rows($squery);

 $fquery = mysqli_query($db,"SELECT * FROM student WHERE email = '$data->email' AND password = '$data->password'");

 $result = mysqli_num_rows($fquery);

 if ($sresult>0) {
	 
	 while ($row=mysqli_fetch_array($squery)) {

            $student = array();
            $student["name"] = $row["name"];
            $student["email"] = $row["email"];
            $student["phone"] = $row["phone"];
			$student["address"] = $row["address"];
			
            	
            }
 	# code...
        
 if ($result>0) {
    $json = array("status" => 1, "msg" => "Succssfully logged in","StudentData"=> [$student]); 	
  }
  else{
     
     $json = array("status" => 0, "msg" => "Invalid credentials");
  } 

}
else{

	$json = array("status" => 0, "msg" => "You are not verified yet");
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