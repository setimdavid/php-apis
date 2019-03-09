
<?php
	require ('Functions.php');

	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST');
	header("Access-Control-Allow-Headers: X-Requested-With");
	header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

	$postData = file_get_contents("php://input");
	writeLog($postData);
	$explData = explode("::::",$postData);

	$phoneNumber = $explData[0];
	$password = $explData[1];

	$response = validateUser($phoneNumber,$password);

	writeLog(json_encode($response));

	header('Content-Type: application/json');
	echo json_encode($response);

?>