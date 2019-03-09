<?php
	
	function validateUser($phoneNumber, $passedPassword){
		require('db.php');
		$status = '99';
		$userData = array();
		if ($stmt = $con->prepare('SELECT id,first_name,middle_name,last_name,phone_number,refer_code,refer_status,password FROM dat_subscriber_details WHERE phone_number = ?')) {
            $stmt->bind_param('s', $phoneNumber);
            $stmt->execute(); 
            $stmt->store_result(); 
            // Store the result so we can check if the account exists in the database.
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id,$first_name,$middle_name,$last_name,$phone_number,$refer_code,$refer_status,$password);
                $stmt->fetch();      
                // Account exists, now we verify the password.
                if ($passedPassword === trim($password)) {
                    // Verification success! User has loggedin!
                    $status = '00';
                    $userData = [
			            'firstName' => $first_name,
			            'middleName' => $middle_name,
			            'lastName' => $last_name,
			            'referCode' => $refer_code,
			            'referStatus' => $refer_status
			    	];

                    writeLog($status );
                }
            }
            $stmt->close();
        }
       	$resultsData = [
			'results' => $userData,
			'status' => $status
		];

        writeLog(json_encode($resultsData));
		return $resultsData;

	}
	

    function fetchSportPesa(){
        require('db.php');
        $toDay = date("Y-m-d");
        $sportPesaQuery = "select * from dat_sportpesa_jackpot a INNER JOIN dat_jackpot_setup b on b.id = a.unique_id where b.status = 1 and a.status = 1 and DATE(jackpot_dates) >= '" . $toDay . "'";
        $sportPesaResult = mysqli_query($con,$sportPesaQuery) or die(mysql_error());
        $spJpData = array();
        while ($row = mysqli_fetch_array($sportPesaResult)) {
            for ($i = 1; $i < 18; $i++) {
                $spJpData = [
                    'play_date_time' . $i => $row['play_date_time' . $i],
                    'country' . $i => $row['country' . $i],
                    'match' . $i  => $row['home_team' . $i] . ' VS ' . $row['away_team' . $i],
                    'prediction' . $i => $row['prediction' . $i],
                ];
            }
        }

        $resultsData = [
            'results' => $spJpData
        ];

        return $resultsData;
    }

    function validatePremium($phoneNumber){
        require('db.php');
        $status = '99';
        if ($stmt = $con->prepare('SELECT jackpot_status,jackpot_end_date,daily_status,daily_end_date,free_tips_end FROM dat_subscriber_details WHERE phone_number = ?')) {
            $stmt->bind_param('s', $phoneNumber);
            $stmt->execute(); 
            $stmt->store_result(); 
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($jackpot_status,$jackpot_end_date,$daily_status,$daily_end_date,$free_tips_end);
                $stmt->fetch();
                $date_now = date("Y-m-d");
                if ($daily_status == 1) {
                    if ($date_now <= $daily_end_date ) {
                       $status = '00';
                    }
                }
            }else{
                writeLog("Number data not found : " + $phoneNumber);
            }
            $stmt->close();
        }else{
            writeLog("Connection Error");
        }
        return $status;
    }



    function validateJackpot($phoneNumber){
        require('db.php');
        $status = '99';
        if ($stmt = $con->prepare('SELECT jackpot_status,jackpot_end_date,daily_status,daily_end_date,free_tips_end FROM dat_subscriber_details WHERE phone_number = ?')) {
            $stmt->bind_param('s', $phoneNumber);
            $stmt->execute(); 
            $stmt->store_result(); 
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($jackpot_status,$jackpot_end_date,$daily_status,$daily_end_date,$free_tips_end);
                $stmt->fetch();
                $date_now = date("Y-m-d");
                if ($jackpot_status == 1) {
                    if ($date_now <= $jackpot_end_date ) {
                       $status = '00';
                    }
                }
            }else{
                writeLog("Number data not found : " + $phoneNumber);
            }
            $stmt->close();
        }else{
            writeLog("Connection Error");
        }
        return $status;
    }

    function writeLog($content) {
        $filePath = "D:\APP\LOGS\API";
        if (!file_exists($filePath) === true) {
            mkdir($filePath, '777', true);
        }
        $logFile = $filePath . DIRECTORY_SEPARATOR . 'request.log';
        $file = fopen($logFile, 'a');
        fwrite($file, stripcslashes(date('Y-m-d h:i:s') . ' ' . $_SERVER['PHP_SELF'] . ' ::: ' . $content . PHP_EOL));
        fclose($file);
    }


?>