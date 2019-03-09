
<?php
    header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST');
	header("Access-Control-Allow-Headers: X-Requested-With");

	$data = array();

	$data = [
		'results' => [
			0 => [
	        	'time' => '12:13', 
	        	'match' => 'PSG vs Lyon', 
	        	'predictionType' => '3 WAY', 
	        	'prediction' => '1',
	        	'country' => 'en'
	        ],
	        1 => [
	        	'country' => 'en',
	        	'time' => '12:45', 
	        	'match' => 'Tottenhum vs Arsenal', 
	        	'predictionType' => '3 WAY', 
	        	'prediction' => '2'
	        ],
		]
        
     ];
	
	echo json_encode($data);

	function writeLog($content) {
        $filePath = "D:\APP\LOGS\API" . DIRECTORY_SEPARATOR . date('Y-m-d');
        if (! file_exists($filePath) === true) {
            mkdir($filePath, '777', true);
        }
        $logFile = $filePath . DIRECTORY_SEPARATOR . 'request.log';
        $file = fopen($logFile, 'a');
        fwrite($file, stripcslashes(date('Y-m-d h:i:s') . ' ' . $_SERVER['PHP_SELF'] . ' ::: ' . $content . PHP_EOL));
        fclose($file);
    }

?>