<?php
require 'config/Database.php';
$database = new Database();
$db = $database->dbConnect();

$response = array();
if($_SERVER['REQUEST_METHOD'] == "GET"){
 // Get data

$result = mysqli_query($db, "SELECT * FROM course");


        // check for empty result
        if (mysqli_num_rows($result) > 0) {

            $response["status"] = 1;
            $response["desc"] = "Successfully fetched";

            $response["course"] = array();

            while ($row=mysqli_fetch_array($result)) {

            $course = array();
            $course["id"] = $row["id"];
            $course["course_code"] = $row["course_code"];
            $course["course_name"] = $row["course_name"]; 
            	# code...
              array_push($response["course"], $course);
            }
    
           
            // success
            
 
            // user node

            // echoing JSON response
            echo json_encode($response);

        } else {
            // no product found
            $response["success"] = 0;
            $response["message"] = "No course found";
 
            // echo no users JSON
            echo json_encode($response);
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

