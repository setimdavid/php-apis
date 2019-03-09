/ writeLog("Reached Here 2");
        // $premiumQuery = "SELECT jackpot_status,jackpot_end_date,daily_status,daily_end_date,free_tips_end FROM dat_subscriber_details WHERE phone_number = '". $phoneNumber ."'";
        // writeLog($premiumQuery);
        // $premiumResults = mysqli_query($con, $premiumQuery) or die(mysql_error());
        // writeLog("Reached Here 2.3");
        // $foundData = 0;
        // while ($row = mysqli_fetch_array($premiumResults)) {
        //     writeLog("Reached Here 3");
        //     $foundData = 1;
        //     writeLog("Daily Status : " . $row['daily_status']);
        //     writeLog("Daily  : " .  $row['daily_end_date']);
        //     writeLog("Jackpot  : " .  $row['jackpot_end_date']);
        //     writeLog("Free Tips  : " .  $row['free_tips_end']);
        //     $date_now = date("Y-m-d");
        //     if ($row['daily_status'] == 1) {
        //         if ($date_now <= $row['daily_end_date']) {
        //            $status = '00';
        //         }
        //     }
        // }
        // writeLog("Reached Here 4");
        // if ($foundData == 1) {
        //     writeLog("Data found for :" . $phoneNumber);
        // }else{
        //     writeLog("Data not found for :" . $phoneNumber);
        // }