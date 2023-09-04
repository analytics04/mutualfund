<?php
if (isset($_GET['sid'])) {
    require_once("../modules/library.php");
    $d = mysqli_real_escape_string($conn, $_GET['sid']);
    $sid = $_GET['sid'];
    echo "<pre>";
    echo (set_reaSearch($d));
    echo "</pre>";
}

function set_reaSearch($sid)
{
    // Array that store return value
    $res = array();

    $isin = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'], "SELECT isin_no FROM `mf_scheme` WHERE id=$sid;"))['isin_no'];
    // echo $isin;

    // api to fetch Ratios 
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://mfapi.advisorkhoj.com/getSchemeInfoNew?key=99b39d35-3c8c-4f4e-a9c9-79a897d32d3f&isin=' . $isin,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/xml',
            'Cookie: ASP.NET_SessionId=z11ngsqvz2mkjbsjcsqebjpd'
        ),
    ));
    $response = json_decode(curl_exec($curl), true);
    // echo "<pre>";
    // var_dump($response);
    // echo "</pre>";






    $today = date("Y-m-d");
    $preday = date("Y-m-d", strtotime($today . "-1 day"));
    $currentNav = get_mynav($sid, $preday);
    $currentYear = (int) date("Y");
    if ($currentNav['nav_value'] != "-1") {

        $currentNavVal = $currentNav['nav_value'];

        $dalyNavArray = array();
        $daliyReturns = array();
        $monthlyNavArray = array();
        $monthlyNAVReturns = array();
        $yearlyReturns = array();

        // sql to fetch initial value of scheme
        $initialNAV = mysqli_fetch_assoc(mysqli_query($GLOBALS['nav_con'], "SELECT * FROM `nav_" . $currentYear . "` WHERE scheme_id= $sid ORDER by nav_date LIMIT 1;"))['nav_value'];

        // sql to fetch monthly NAV since inception
        $sql = "SELECT DATE_FORMAT(nav_date, '%Y-%m') AS month,nav_value,nav_date FROM(SELECT nav_date,nav_value FROM nav_2004 where scheme_id = '$sid'  UNION SELECT nav_date,nav_value FROM nav_2005 where scheme_id = '$sid' UNION SELECT nav_date,nav_value FROM nav_2006 where scheme_id = '$sid'  UNION SELECT nav_date,nav_value FROM nav_2007 where scheme_id = '$sid' UNION SELECT nav_date,nav_value FROM nav_2008 where scheme_id = '$sid'  UNION SELECT nav_date,nav_value FROM nav_2009 where scheme_id = '$sid' UNION SELECT nav_date,nav_value FROM nav_2010 where scheme_id = '$sid' UNION SELECT nav_date,nav_value FROM nav_2011 where scheme_id = '$sid' UNION SELECT nav_date,nav_value FROM nav_2012 where scheme_id = '$sid' UNION SELECT nav_date,nav_value FROM nav_2013 where scheme_id = '$sid' UNION SELECT nav_date,nav_value FROM nav_2014 where scheme_id = '$sid' UNION SELECT nav_date,nav_value FROM nav_2015 where scheme_id = '$sid' UNION SELECT nav_date,nav_value FROM nav_2016 where scheme_id = '$sid' UNION SELECT nav_date,nav_value FROM nav_2017 where scheme_id = '$sid' UNION SELECT nav_date,nav_value FROM nav_2018 where scheme_id = '$sid' UNION SELECT nav_date,nav_value FROM nav_2019 where scheme_id = '$sid' UNION SELECT nav_date,nav_value FROM nav_2020 where scheme_id = '$sid' UNION SELECT nav_date,nav_value FROM nav_2021 where scheme_id = '$sid' UNION SELECT nav_date,nav_value FROM nav_2022 where scheme_id = '$sid' UNION SELECT nav_date,nav_value FROM nav_2023 where scheme_id = '$sid') AS nav_data GROUP BY month ORDER BY month DESC;";
        $run = mysqli_query($GLOBALS['nav_con'], $sql) or die(mysqli_error($GLOBALS['nav_con']));
        $all_monthly_result = mysqli_fetch_all($run);
        foreach ($all_monthly_result as $key => $value) {
            array_push($monthlyNavArray, $value[1]);
        }

        // calculating Monthly Returns
        for ($i = 1; $i < (count($monthlyNavArray) - 1); $i++) {
            if ($monthlyNavArray[$i + 1] <= 0) {
                continue;
            }
            $re = (($monthlyNavArray[$i] - $monthlyNavArray[$i + 1]) / $monthlyNavArray[$i + 1]) * 100;
            array_push($monthlyNAVReturns, $re);
        }

        // sql to fetch daily NAV for prv 3 year
        $dalysql = "SELECT DATE_FORMAT(nav_date, '%Y-%m-%d') AS month,nav_value FROM(SELECT nav_date,nav_value FROM nav_2020 where scheme_id = '$sid' UNION SELECT nav_date,nav_value FROM nav_2021 where scheme_id = '$sid' UNION SELECT nav_date,nav_value FROM nav_2022 where scheme_id = '$sid' UNION SELECT nav_date,nav_value FROM nav_2023 where scheme_id = '$sid') AS nav_data WHERE nav_date BETWEEN '" . date('Y-m-d', strtotime("-" . date('d') . " day -3 year")) . "' and '" . date('Y-m-d', strtotime("-" . date('d') . " day")) . "'GROUP BY month ORDER BY month;";

        $run = mysqli_query($GLOBALS['nav_con'], $dalysql) or die(mysqli_error($GLOBALS['nav_con']));
        $daliy_result = mysqli_fetch_all($run);
        foreach ($daliy_result as $key => $value) {
            array_push($dalyNavArray, $value[1]);
        }

        // Calculating dalily NAV returns for pre 3 year
        for ($i = 1; $i < count($dalyNavArray) - 1; $i++) {
            if ($dalyNavArray[$i] <= 0) {
                continue;
            }
            $re = (($dalyNavArray[$i + 1] - $dalyNavArray[$i]) / $dalyNavArray[$i]) * 100;
            array_push($daliyReturns, $re);
        }


        // used by PE/PB ratio
        $bookValuePerShare = 20.00;
        $earningsPerShare = 20;

        // used by shareRatio and shortenRatio 
        $riskFreeRate = 0.06;

        // used by CAGR 
        // $initialvalue = 10000;
        // $periodOfInvestment = 5;
        // $presentValue = 15000;


        // calculating value to show in JSON
        $prv_1_day = get_nav_in($sid, $currentNav, 1);
        $prv_1_monthe = get_nav_in($sid, $currentNav, 30 * 1);
        $prv_2_monthe = get_nav_in($sid, $currentNav, 30 * 2);
        $prv_3_monthe = get_nav_in($sid, $currentNav, 30 * 3);
        $prv_4_monthe = get_nav_in($sid, $currentNav, 30 * 4);
        $prv_5_monthe = get_nav_in($sid, $currentNav, 30 * 5);
        $prv_6_monthe = get_nav_in($sid, $currentNav, 30 * 6);
        $prv_7_monthe = get_nav_in($sid, $currentNav, 30 * 7);
        $prv_8_monthe = get_nav_in($sid, $currentNav, 30 * 8);
        $prv_9_monthe = get_nav_in($sid, $currentNav, 30 * 9);
        $prv_10_monthe = get_nav_in($sid, $currentNav, 30 * 10);
        $prv_11_monthe = get_nav_in($sid, $currentNav, 30 * 11);
        $prv_12_monthe = get_nav_in($sid, $currentNav, 30 * 12);
        $prv_1_year = CalculateCAGR($sid, $currentNav, 1);
        array_push($yearlyReturns, $prv_1_year);
        $prv_2_year = CalculateCAGR($sid, $currentNav, 2);
        array_push($yearlyReturns, $prv_2_year);
        $prv_3_year = CalculateCAGR($sid, $currentNav, 3);
        array_push($yearlyReturns, $prv_3_year);
        $prv_4_year = CalculateCAGR($sid, $currentNav, 4);
        $prv_5_year = CalculateCAGR($sid, $currentNav, 5);
        $prv_10_year = CalculateCAGR($sid, $currentNav, 10);

        $sip_return_pre_1 = calculate_xirr($currentNav, $all_monthly_result, 3);
        $sip_return_pre_3 = calculate_xirr($currentNav, $all_monthly_result, 3);
        $sip_return_pre_6 = calculate_xirr($currentNav, $all_monthly_result, 6);
        $sip_return_pre_1Y = calculate_xirr($currentNav, $all_monthly_result, 12);
        $sip_return_pre_2Y = calculate_xirr($currentNav, $all_monthly_result, (12 * 2));
        $sip_return_pre_3Y = calculate_xirr($currentNav, $all_monthly_result, (12 * 3));
        $sip_return_pre_5Y = calculate_xirr($currentNav, $all_monthly_result, (12 * 5));
        $sip_return_pre_10Y = calculate_xirr($currentNav, $all_monthly_result, (12 * 10));

        $valMean = array_sum($dalyNavArray) / count($dalyNavArray);
        $returnsMean = array_sum($daliyReturns) / count($daliyReturns);
        $stdDev = calculateStandardDeviation($daliyReturns, $returnsMean);

        // $beta  = calculateBeta($prv_3_year, $benchmarkReturn, $riskFreeRate);

        $res['status'] = true;
        $res["current"] = $currentNav;
        $res["double"] = get_nav_mul($sid);
        $res["triple"] = get_nav_mul($sid, 3);
        $res["1day"] =  !$prv_1_day ? "-" : number_format($prv_1_day, 3);
        $res["1M"] = !$prv_1_monthe ? "-" : number_format($prv_1_monthe, 3);
        $res["3M"] = !$prv_3_monthe ? "-" : number_format($prv_3_monthe, 3);
        $res["6M"] = !$prv_6_monthe ? "-" : number_format($prv_6_monthe, 3);
        $res["1_year"] = !$prv_1_year ? "-" : number_format($prv_1_year, 3);
        $res["3_year"] = !$prv_3_year ? "-" : number_format($prv_3_year, 3);
        $res["5_year"] = !$prv_5_year ? "-" : number_format($prv_5_year, 3);
        $res["10_year"] = !$prv_10_year ? "-" : number_format($prv_10_year, 3);
        $res["YTD"] = calculateYTDRetrun($initialNAV, $currentNav['nav_value']);
        $res["annualReturns"] = array(
            "prv_1_year" => !$prv_1_year ? "-" : number_format($prv_1_year, 3),
            "prv_2_year" => !$prv_2_year ? "-" : number_format($prv_2_year, 3),
            "prv_3_year" => !$prv_3_year ? "-" : number_format($prv_3_year, 3),
            "prv_4_year" => !$prv_4_year ? "-" : number_format($prv_4_year, 3),
            "prv_5_year" => !$prv_5_year ? "-" : number_format($prv_5_year, 3),
            "prv_10_year" => !$prv_10_year ? "-" : number_format($prv_10_year, 3),
        );
        $res["monthlyReturns"] = array(
            "prv_1_monthe" => !$prv_1_monthe ? "-" : number_format($prv_1_monthe, 3),
            "prv_2_monthe" => !$prv_2_monthe ? "-" : number_format($prv_2_monthe, 3),
            "prv_3_monthe" => !$prv_3_monthe ? "-" : number_format($prv_3_monthe, 3),
            "prv_4_monthe" => !$prv_4_monthe ? "-" : number_format($prv_4_monthe, 3),
            "prv_5_monthe" => !$prv_5_monthe ? "-" : number_format($prv_5_monthe, 3),
            "prv_6_monthe" => !$prv_6_monthe ? "-" : number_format($prv_6_monthe, 3),
            "prv_7_monthe" => !$prv_7_monthe ? "-" : number_format($prv_7_monthe, 3),
            "prv_8_monthe" => !$prv_8_monthe ? "-" : number_format($prv_8_monthe, 3),
            "prv_9_monthe" => !$prv_9_monthe ? "-" : number_format($prv_9_monthe, 3),
            "prv_10_monthe" => !$prv_10_monthe ? "-" : number_format($prv_10_monthe, 3),
            "prv_11_monthe" => !$prv_11_monthe ? "-" : number_format($prv_11_monthe, 3),
            "prv_12_monthe" => !$prv_12_monthe ? "-" : number_format($prv_12_monthe, 3),
        );
        $res['sip'] = array(
            'sip_double' => sip_double($monthlyNavArray, 2),
            'sip_trippel' => sip_double($monthlyNavArray, 3),
            'sip_returns' => array(
                'pre_1' => !$sip_return_pre_3 ? "-" : number_format($sip_return_pre_1, 2),
                'pre_3' => !$sip_return_pre_3 ? "-" : number_format($sip_return_pre_3, 2),
                'pre_6' => !$sip_return_pre_6 ? "-" : number_format($sip_return_pre_6, 2),
                'pre_1Y' => !$sip_return_pre_1Y ? "-" : number_format($sip_return_pre_1Y, 2),
                'pre_2Y' => !$sip_return_pre_2Y ? "-" : number_format($sip_return_pre_2Y, 2),
                'pre_3Y' => !$sip_return_pre_3Y ? "-" : number_format($sip_return_pre_3Y, 2),
                'pre_5Y' => !$sip_return_pre_5Y ? "-" : number_format($sip_return_pre_5Y, 2),
                'pre_10Y' => !$sip_return_pre_10Y ? "-" : number_format($sip_return_pre_10Y, 2),
            )
        );
        $res['performanceRatios'] = array();
        $res['performanceRatios']["standardDev"] = number_format($stdDev, 2);

        // "sharpRatio" => number_format(calculateSharpeRatio($yearlyReturns, $riskFreeRate, $stdDev), 2),

        if (isset($response['risk_statistics_list'][0]['sharpratio_cm_3year'])) {
            $res['performanceRatios']["sharpRatio"] = $response['risk_statistics_list'][0]['sharpratio_cm_3year'];
        } else {
            $res['performanceRatios']["sharpRatio"] = "-";
        }
        if (isset($response['risk_statistics_list'][0]['shortino_ratio'])) {
            $res['performanceRatios']["shortenRatio"] = $response['risk_statistics_list'][0]['shortino_ratio'];
        } else {
            $res['performanceRatios']["shortenRatio"] = "-";
        }
        if (isset($response['risk_statistics_list'][0]['beta_cm_1year'])) {
            $res['performanceRatios']["beta"] = $response['risk_statistics_list'][0]['beta_cm_1year'];
        } else {
            $res['performanceRatios']["beta"] = "-";
        }

        // "alpha" => calculateAlpha($prv_3_year, $benchmarkReturn, $beta, $riskFreeRate),

        if (isset($response['risk_statistics_list'][0]['alpha_cm_1year'])) {
            $res['performanceRatios']["alpha"] = $response['risk_statistics_list'][0]['alpha_cm_1year'];
        } else {
            $res['performanceRatios']["alpha"] = "-";
        }
        $res['performanceRatios']["mean"] = (!count($dalyNavArray) < 2) ? number_format($valMean, 3) : "-";
        if (isset($response['expense_ratio_percentage'])) {
            $res['performanceRatios']["expenseRatio"] = $response['expense_ratio_percentage'];
        } else {
            $res['performanceRatios']["expenseRatio"] = "-";
        }
        if (isset($response['risk_statistics_list'][0]['yield_to_maturity'])) {
            $res['performanceRatios']["yieldToMaturity"] = $response['risk_statistics_list'][0]['yield_to_maturity'];
        } else {
            $res['performanceRatios']["yieldToMaturity"] = "-";
        }

        // "modifiedDuration" => $response['risk_statistics_list'][0][''],

        if (isset($response['risk_statistics_list'][0]['average_maturity'])) {
            $res['performanceRatios']["avrageMaturity"] = $response['risk_statistics_list'][0]['average_maturity'];
        } else {
            $res['performanceRatios']["avrageMaturity"] = "-";
        }

        // "priceToEarnRatio" => calculatePERatio($currentNavVal, $earningsPerShare),
        // "priceToBookRatio" => calculatePBRatio($currentNavVal, $bookValuePerShare),

        $res['historicReturn'] = historicReturn($sid);
        $res['allMonthlyReturn'] = $all_monthly_result;
    } else {
        $res['status'] = false;
        $res['scheme_id'] = $currentNav['scheme_id'];
        $res['message'] = "Scheme is Closed";

        //!Update status to false 


    }
    return json_encode($res, JSON_PRETTY_PRINT);
}

function get_nav_mul($sid, $plu = 2)
{
    $today = date("Y-m-d");
    $cnav = get_mynav($sid, $today);
    $halfNavA = $cnav['nav_value'] / $plu - 4;
    $halfNavB = $cnav['nav_value'] / $plu;
    $year = +date("Y");
    $sql = "SELECT * FROM nav_" . $year . " where nav_value between '$halfNavA' and '$halfNavB' and scheme_id = '$sid'";
    for ($i = $year; $i > 2004; $i--) {
        # code...
        $sql .= "UNION
        SELECT * FROM nav_" . $i . " where nav_value between '$halfNavA' and '$halfNavB' and scheme_id = '$sid'";
    }
    $sql .= "ORDER BY nav_date DESC,`nav_value` DESC limit 2";
    $data = mysqli_query($GLOBALS['nav_con'], $sql);
    $date = $data->fetch_array();
    if ($data->num_rows > 0) {
        $d = date_create($date['nav_date']);

        $check = date_diff(date_create($today), $d)->format("%y yrs %m m");
        if ($check == "0 yrs 0 m") {
            return "-";
        } else {
            return $check;
        }
    } else {
        return "-";
    }
}

function get_nav_in($sid, $cNAV, $days)
{
    $today = date("Y-m-d");
    $prev_date = date('Y-m-d', strtotime($today . "-$days day"));
    $year = date("Y");
    if ($days == 1) {
        $prv_date = date('Y-m-d', strtotime($cNAV['nav_date'] . " -1 day"));
        $pNAV = get_mynav($sid, $prv_date);
        // if no record found
        if ($pNAV['nav_value'] == -1) {
            return 0;
        }
        // if current and previous record is same 
        if ($cNAV['nav_value'] - $pNAV['nav_value'] == 0) {
            return "0";
        }
        $ans = (($cNAV['nav_value'] - $pNAV['nav_value']) / $pNAV['nav_value']) * 100;
        // $ans =  POW($cNAV['nav_value'] / $pNAV['nav_value'], (1 / $days / 360)) - 1;
        return  $ans;
    } else {
        $pNAV = get_mynav($sid, $prev_date);
        // if no record found
        if ($pNAV['nav_value'] == -1) {
            return 0;
        }
        // if current and previous record is same 
        if ($cNAV['nav_value'] - $pNAV['nav_value'] == 0) {
            return $cNAV['nav_value'];
        }
        $ans = (($cNAV['nav_value'] - $pNAV['nav_value']) / $pNAV['nav_value']) * 100;
        return $ans;
    }
}

function get_mynav($sch, $date)
{
    $nav = null;
    $d = date_create($date);
    $year = $d->format("Y");
    $table_name = "nav_" . "$year";
    $query = "SELECT scheme_id,nav_date,nav_value FROM $table_name WHERE scheme_id='$sch' and DATE(nav_date +   INTERVAL 10 DAY) >= '$date' AND DATE(nav_date + INTERVAL 10 DAY) <= '$date' + INTERVAL 10 DAY order by nav_date desc";
    $nav = mysqli_query($GLOBALS['nav_con'], $query)->fetch_assoc();
    // when no data found - switch status to false 
    if ($nav == null) {
        $nav = array("nav_date" => date_create("now")->format("Y-m-d"), "nav_value" => -1, "scheme_id" => $sch);
    }
    return $nav;
}

function calculateSharpeRatio($returns, $riskFreeRate, $stdDev)
{
    $meanSun = 0;
    for ($i = 0; $i < count($returns); $i++) {
        echo "<pre>";
        // var_dump($returns[$i]);
        echo "<pre>";
        $meanSun += $returns[$i];
    }
    $mean = $meanSun / count($returns);


    // echo "mean is :" . $mean . "<br>";

    if (count($returns) < 2) {
        return "-";
    }

    // Calculate the excess return
    $excessReturn = $mean - $riskFreeRate;
    // echo "ExcessReturn : " . $excessReturn . "<br>";

    // Calculate the Sharpe Ratio
    if ($stdDev == 0 or $stdDev == 0.0) {
        return "-";
    }

    $sharpeRatio = $excessReturn / floatval($stdDev);
    return $sharpeRatio;
}

function calculateSortinoRatio($returns, $riskFreeRate)
{
    // when no element in array is 1 
    if (count($returns) < 2) {
        return "-";
    }
    // Calculate the mean return
    $meanReturn = array_sum($returns) / count($returns);
    // when array element is equla to mean of array
    if ($returns[0] == $meanReturn) {
        return "-";
    }
    // Calculate the downside standard deviation
    $downsideDeviation = calculateDownsideDeviation($returns);
    // Calculate the excess return
    $excessReturn = $meanReturn - $riskFreeRate;
    // Calculate the Sortino Ratio
    $sortinoRatio = $excessReturn / floatval($downsideDeviation);
    return number_format($sortinoRatio, 3);
}

function calculateDownsideDeviation($returns)
{
    if (count($returns) < 2) {
        return "-";
    }
    // Calculate the average return
    $averageReturn = array_sum($returns) / count($returns);
    if ($returns[0] == $averageReturn) {
        return "-";
    }
    // Identify the negative returns

    $negativeReturns = array_filter($returns, function ($return) use ($averageReturn) {
        return $return < $averageReturn;
    });
    // Calculate the squared differences

    $squaredDifferences = array_map(function ($return) use ($averageReturn) {
        return pow($return - $averageReturn, 2);
    }, $negativeReturns);
    // Calculate the mean squared difference
    $meanSquaredDiff = array_sum($squaredDifferences) / count($squaredDifferences);
    // Calculate the downside deviation
    $downsideDeviation = sqrt($meanSquaredDiff);
    return number_format($downsideDeviation, 3);
}

function calculatePERatio($marketPrice, $earningsPerShare)
{
    return number_format($marketPrice / $earningsPerShare, 3);
}

function calculatePBRatio($marketPrice, $bookValuePerShare)
{
    return number_format(($marketPrice / $bookValuePerShare), 3);
}

function  CalculateCAGR($sid, $currentNAV, $PRIODOFINVESTMENT)
{
    $prv_date = date('Y-m-d', strtotime($currentNAV['nav_date'] . " -$PRIODOFINVESTMENT year"));
    $pevNav = get_mynav($sid, $prv_date);
    if ($pevNav['nav_value'] <= 0) {
        return 0;
    }
    // echo "Current NAV : " . $currentNAV['nav_value'] . " and Previwes NAV is " . $pevNav['nav_value'] . " for ".$PRIODOFINVESTMENT." Year <br>";
    $cagr = (POW($currentNAV['nav_value'] / $pevNav['nav_value'], 1 / $PRIODOFINVESTMENT) - 1) * 100;
    if ($cagr <= 0) {
        return 0;
    }
    return number_format($cagr, 3);
}

function historicReturn($sid)
{
    // fetching name of Scheme 
    $sqlName = "SELECT scheme_names FROM `mf_scheme` WHERE id=$sid;";
    $run = mysqli_query($GLOBALS['conn'], $sqlName);
    if ($run) {
        $respose['name'] = str_replace("'", "&#39;", mysqli_fetch_array($run)['scheme_names']);
    }
    // fetching NAV data of Scheme
    $currentDate = date("Y-m-d");
    $date = $currentDate;
    $presentDateYear = date_format(date_create($date), "Y");
    $lastDate = date("Y-m-d", strtotime($date . "-6 month"));
    $lastDateYear = date_format(date_create($lastDate), "Y");
    if ($lastDateYear == $presentDateYear) {
        $sql = "SELECT nav_date,nav_value FROM `nav_$lastDateYear` WHERE `nav_date` > $lastDate and `scheme_id` = $sid ORDER BY `nav_date` ASC;";
    } else {
        $sql = "SELECT nav_date,nav_value FROM `nav_$presentDateYear` WHERE `nav_date` < $date and `scheme_id` = $sid  UNION SELECT * FROM `nav_$lastDateYear` WHERE `nav_date` > $lastDate and `scheme_id` = $sid ORDER BY `nav_date`  ASC";
    }
    $run = mysqli_query($GLOBALS['nav_con'], $sql);
    if ($run) {
        $respose['nav_data'] = mysqli_fetch_all($run);
    }
    return $respose;
}

function calculateYTDRetrun($initialNAV, $currentNAV)
{
    // Calculate YTD return
    $ytdReturn = (($currentNAV - $initialNAV) / $initialNAV) * 100;
    return number_format($ytdReturn, 3);
}

function sip_double($monthlyNavArray, $times)
{
    $investment_monthly = 10000;
    $total_investment = 1;
    $totla_current_val = 1;
    $month = 0;
    $year = 0;
    $months = 0;
    for ($i = 0; $i < count($monthlyNavArray); $i++) {
        if (($total_investment * $times) < $totla_current_val) {
            return (int) $year . " Year " . (int)$months . " Month";
        }
        $total_investment += $investment_monthly;
        if ($monthlyNavArray[$i] <= 0) {
            continue;
        } else {
            $totla_current_val += $monthlyNavArray[0] * ($investment_monthly / $monthlyNavArray[$i]);
            $month++;
            $year = (int)$month / 12;
            $months = (int)$month % 12;
        }
    }
    return "-";
}

function calculateSIPReturns($monthlyNavArray, $currentNav, $duration)
{
    $sipAmount = 1000;
    if (count($monthlyNavArray) <= $duration) {
        return 0;
    }
    // Initialize variables to store total units and current value of units
    $totalUnits = 0;
    $currentValueOfUnits = 0;
    // Calculate SIP investments and units purchased for each month
    for ($i = 1; $i <= $duration; $i++) {
        $nav = $monthlyNavArray[$i];
        $unitsPurchased = $sipAmount / $nav;
        $totalUnits += $unitsPurchased;
    }

    $currentValueOfUnits = $currentNav['nav_value'] * $totalUnits;

    $return =  (($currentValueOfUnits - ($sipAmount * $duration)) / ($sipAmount * $duration)) * 100;
    // echo "Current value : " . $currentValueOfUnits . " for " . $duration . " months, Total Investemnt : " . $sipAmount * $duration . " and Return : " . $return . " <br>";
    // echo "Returns : " . $return . "<br>";

    return $return;
}

function calculateStandardDeviation($daliyReturns, $returnsMean)
{
    // Step 2: Calculate the variance
    $variance = 0;
    foreach ($daliyReturns as $return) {
        $variance += pow($return - $returnsMean, 2);
    }
    $variance /= count($daliyReturns);

    // Step 4: Calculate the annualized standard deviation
    $annualized_std_deviation = sqrt($variance * 248);


    return $annualized_std_deviation;
}

function calculate_xirr($currentNav, $monthlyNav, $duration)
{
    if ($currentNav['nav_value'] < 0 || count($monthlyNav) < $duration) {
        return 0;
    }

    $dateArray = array();
    $valueArray = array();
    $investAmt = 0;
    $unitPurchase = 0;
    $count = 0;
    // echo "<pre>";
    // var_dump($monthlyNav);
    // echo "</pre>";

    foreach ($monthlyNav as $key => $value) {
        if ($count == $duration) {
            break;
        }
        array_push($dateArray, ($value[2]));
        array_push($valueArray, (-3000));
        // var_dump($value[1]);
        $unitPurchase += (3000 / $value[1]);
        $investAmt += 3000;
        $count++;
    }
    $currentValue = ($unitPurchase * $currentNav['nav_value']);
    array_push($valueArray, (float)($currentValue));
    array_push($dateArray, ($currentNav['nav_date']));
    $ans = calculate_xirr_main($valueArray, $dateArray) * 100;
    return $ans;
}

function xirr_func($rate, $cashflows, $dates)
{
    $result = 0.0;
    for ($i = 0; $i < count($cashflows); $i++) {
        $time_diff = (strtotime($dates[$i]) - strtotime($dates[0])) / (365 * 24 * 60 * 60);
        $result += $cashflows[$i] / pow(1 + $rate, $time_diff);
    }
    return $result;
}

function xirr_func_derivative($rate, $cashflows, $dates)
{
    $result = 0.0;
    for ($i = 0; $i < count($cashflows); $i++) {
        $time_diff = (strtotime($dates[$i]) - strtotime($dates[0])) / (365 * 24 * 60 * 60);
        $result -= $time_diff * $cashflows[$i] / pow(1 + $rate, $time_diff + 1);
    }
    return $result;
}

function calculate_xirr_main($cashflows, $dates)
{
    $xirr = 0.1; // Initial guess for the rate
    $precision = 0.000001; // Desired precision
    $max_iterations = 1000; // Maximum number of iterations
    for ($i = 0; $i < $max_iterations; $i++) {
        $xirr_new = $xirr - xirr_func($xirr, $cashflows, $dates) / xirr_func_derivative($xirr, $cashflows, $dates);
        if (abs($xirr_new - $xirr) < $precision) {
            return $xirr_new;
        }
        $xirr = $xirr_new;
    }
    return null; // XIRR calculation did not converge
}
