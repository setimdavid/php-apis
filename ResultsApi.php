
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

$oneDay = date('d-m-Y',strtotime("-1 days"));
$premiumQuery = "select * from dat_daily_plays a inner join dat_tips_setup b on b.id = a.unique_id 
                    where b.tip_date_format = '" . $oneDay . "'";
$premiumResults = mysqli_query($con, $premiumQuery) or die(mysql_error());

$data = array();

$predType = [
    '3 WAY' => '3 WAY',
    'DOUBLE CHANCE' => 'DC',
    'BOTH TO SCORE' => 'GG',
    'OVER/UNDER 2.5' => 'O/U2.5',
    'OVER/UNDER 1.5' => 'O/U1.5',
    'HT/FT' => 'HT/FT',
    'DRAW NO BET' => 'DNB',
    'CORRECT SCORE' => 'CS',
];

$outCome = [
    '0' => 'pending',
    '1' => 'win',
    '2' => 'loss',
];

while ($row = mysqli_fetch_array($premiumResults)) {
    $singleData = [
        'time' => $row['play_time'],
        'match' => $row['home_team'] . ' - ' . $row['away_team'],
        'predictionType' => $predType[$row['prediction_type']],
        'prediction' => $row['prediction'],
        'odds' => $row['prediction_odds'],
        'country' => $row['country'],
        'outcome' => $row['outcome_results'],
        'predictionStatus' => $outCome[$row['prediction_status']],
    ];
    array_push($data,$singleData);
}

$resultsData = [
	'results' => $data
];

header('Content-Type: application/json');
echo json_encode($resultsData);

?>