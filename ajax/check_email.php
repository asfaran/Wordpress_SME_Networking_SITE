<?php
$email = $_POST['contact_email'];

if(email_exists($email)){
	$response->result = true;
} else {
	$response->result = false;
}

echo json_encode($response);
?>