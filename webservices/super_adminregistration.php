<?php

$db=mysqli_connect('localhost','root','','test');

if($_SERVER['REQUEST_METHOD'] == "POST"){
 // Get data

$data = json_decode(file_get_contents("php://input"));


 $fquery = mysqli_query($db,"SELECT * FROM super_admin WHERE email LIKE '%$data->email%'");

 $result = mysqli_num_rows($fquery);
        
  $key = '@diu.edu.bd'; 
  
if (strpos($data->email, $key) == true) {  


	
			if($result > 0) { //check if there is already an entry for that username
				$json = array("status" => 0, "error"=> 2, "msg" => "email already exist!!");
			}
 

			else{

 // Insert data into data base
 $query = mysqli_query($db, "INSERT INTO super_admin (name, email, password) VALUES ('$data->name','$data->email','$data->password')");

 if($query){
 $json = array("status" => 1, "msg" => "Successfully Registered");
 }else{
 $json = array("status" => 0, "error"=> 3, "msg" => "Error adding user!");
 }
}

}

else{

	$json = array("status" => 0, "error"=> 1, "msg" => "The mail must be a registered diu email");
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