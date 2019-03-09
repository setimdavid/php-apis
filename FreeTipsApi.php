
<?php
require('db.php');
require ('Functions.php');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: X-Requested-With");
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

$phoneNumber = file_get_contents("php://input");
writeLog($phoneNumber);

$data = array();

$toDay = date('d-m-Y');
$premiumQuery = "select * from dat_daily_plays a inner join dat_tips_setup b on b.id = a.unique_id 
                    where a.free_tips = 1 and b.tip_date_format = '" . $toDay . "'";
$premiumResults = mysqli_query($con, $premiumQuery) or die(mysql_error());

$data = array();
while ($row = mysqli_fetch_array($premiumResults)) {
    $singleData = [
        'time' => $row['play_time'],
        'match' => $row['home_team'] . ' VS ' . $row['away_team'],
        'predictionType' => $row['prediction_type'],
        'prediction' => $row['prediction'],
        'odds' => $row['prediction_odds'],
        'country' => $row['country']
    ];
    array_push($data,$singleData);
}

$resultsData = [
	'results' => $data
];

header('Content-Type: application/json');
echo json_encode($resultsData);

?>