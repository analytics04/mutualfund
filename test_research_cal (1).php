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
    $res = array();
    $today = date("Y-m-d");
    $preday = date("Y-m-d", strtotime($today . "-1 day"));
    $currentNav = get_mynav($sid, $preday);
    $currentYear = (int) date("Y");
    $initialNAV = mysqli_fetch_assoc(mysqli_query($GLOBALS['nav_con'], "SELECT * FROM `nav_" . $currentYear . "` WHERE scheme_id= $sid ORDER by nav_date LIMIT 1;"))['nav_value'];

    $sql = "
        SELECT
        DATE_FORMAT(nav_date, '%Y-%m') AS month,
        nav_value
        FROM
            (
                SELECT
                    nav_date,
                    nav_value
                FROM
                    nav_2004
                where
                    scheme_id = '$sid'
                UNION
                SELECT
                    nav_date,
                    nav_value
                FROM
                    nav_2005
                where
                    scheme_id = '$sid'
                UNION
                SELECT
                    nav_date,
                    nav_value
                FROM
                    nav_2006
                where
                    scheme_id = '$sid'
                UNION
                SELECT
                    nav_date,
                    nav_value
                FROM
                    nav_2007
                where
                    scheme_id = '$sid'
                UNION
                SELECT
                    nav_date,
                    nav_value
                FROM
                    nav_2008
                where
                    scheme_id = '$sid'
                UNION
                SELECT
                    nav_date,
                    nav_value
                FROM
                    nav_2009
                where
                    scheme_id = '$sid'
                UNION
                SELECT
                    nav_date,
                    nav_value
                FROM
                    nav_2010
                where
                    scheme_id = '$sid'
                UNION
                SELECT
                    nav_date,
                    nav_value
                FROM
                    nav_2011
                where
                    scheme_id = '$sid'
                UNION
                SELECT
                    nav_date,
                    nav_value
                FROM
                    nav_2012
                where
                    scheme_id = '$sid'
                UNION
                SELECT
                    nav_date,
                    nav_value
                FROM
                    nav_2013
                where
                    scheme_id = '$sid'
                UNION
                SELECT
                    nav_date,
                    nav_value
                FROM
                    nav_2014
                where
                    scheme_id = '$sid'
                UNION
                SELECT
                    nav_date,
                    nav_value
                FROM
                    nav_2015
                where
                    scheme_id = '$sid'
                UNION
                SELECT
                    nav_date,
                    nav_value
                FROM
                    nav_2016
                where
                    scheme_id = '$sid'
                UNION
                SELECT
                    nav_date,
                    nav_value
                FROM
                    nav_2017
                where
                    scheme_id = '$sid'
                UNION
                SELECT
                    nav_date,
                    nav_value
                FROM
                    nav_2018
                where
                    scheme_id = '$sid'
                UNION
                SELECT
                    nav_date,
                    nav_value
                FROM
                    nav_2019
                where
                    scheme_id = '$sid'
                UNION
                SELECT
                    nav_date,
                    nav_value
                FROM
                    nav_2020
                where
                    scheme_id = '$sid'
                UNION
                SELECT
                    nav_date,
                    nav_value
                FROM
                    nav_2021
                where
                    scheme_id = '$sid'
                UNION
                SELECT
                    nav_date,
                    nav_value
                FROM
                    nav_2022
                where
                    scheme_id = '$sid'
                UNION
                SELECT
                    nav_date,
                    nav_value
                FROM
                    nav_2023
                where
                    scheme_id = '$sid'
            ) AS nav_data
        GROUP BY
            month
        ORDER BY
            month DESC;";
    $run = mysqli_query($GLOBALS['nav_con'], $sql) or die("Unable to run Query");
    $result = mysqli_fetch_all($run);
    $monthlyNavArray = array();
    foreach ($result as $key => $value) {
        array_push($monthlyNavArray, $value[1]);
    }

    if ($currentNav['nav_value'] != "-1") {

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


        $prv_1_year = get_nav_in($sid, $currentNav, 360 * 1);
        $prv_2_year = get_nav_in($sid, $currentNav, 360 * 2);
        $prv_3_year = get_nav_in($sid, $currentNav, 360 * 3);
        $prv_4_year = get_nav_in($sid, $currentNav, 360 * 4);
        $prv_5_year = get_nav_in($sid, $currentNav, 360 * 5);

        $prv_10_year = get_nav_in($sid, $currentNav, 360 * 10);


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
            "prv_1_monthe" => !$prv_1_monthe ? "-" : num_format($prv_1_monthe, 3),
            "prv_2_monthe" => !$prv_2_monthe ? "-" : num_format($prv_2_monthe, 3),
            "prv_3_monthe" => !$prv_3_monthe ? "-" : num_format($prv_3_monthe, 3),
            "prv_4_monthe" => !$prv_4_monthe ? "-" : num_format($prv_4_monthe, 3),
            "prv_5_monthe" => !$prv_5_monthe ? "-" : num_format($prv_5_monthe, 3),
            "prv_6_monthe" => !$prv_6_monthe ? "-" : num_format($prv_6_monthe, 3),
            "prv_7_monthe" => !$prv_7_monthe ? "-" : num_format($prv_7_monthe, 3),
            "prv_8_monthe" => !$prv_8_monthe ? "-" : num_format($prv_8_monthe, 3),
            "prv_9_monthe" => !$prv_9_monthe ? "-" : num_format($prv_9_monthe, 3),
            "prv_10_monthe" => !$prv_10_monthe ? "-" : num_format($prv_10_monthe, 3),
            "prv_11_monthe" => !$prv_11_monthe ? "-" : num_format($prv_11_monthe, 3),
            "prv_12_monthe" => !$prv_12_monthe ? "-" : num_format($prv_12_monthe, 3),
        );

        $res['sip'] = array(
            'sip_double' => sip_double($monthlyNavArray, 2),
            'sip_trippel' => sip_double($monthlyNavArray, 3),
            'sip_returns' => "returns"
        );
        $res['performanceRatios'] = performanceRatios($sid, $currentNav);
        $res['historicReturn'] = historicReturn($sid);
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
        return date_diff(date_create($today), $d)->format("%y yrs %m m");
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
            return $cNAV['nav_value'];
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


function performanceRatios($sid, $currentNav)
{
    // store previous years return 
    $preNavRtn = array();

    //?for year wise 
    $y = (int)date("y");
    for ($i = ($y - 1); $i > ($y - 5); $i--) {
        if (!get_nav_in($sid, $currentNav, 360 * ($y - $i))) {
            break;
        }
        array_push($preNavRtn, get_nav_in($sid, $currentNav, 360 * ($y - $i)));
    }


    // used by PE/PB ratio
    $currentNavVal = $currentNav['nav_value'];
    $bookValuePerShare = 20.00;
    $earningsPerShare = 20;

    // used by shareRatio and shortenRatio 
    $riskFreeRate = 2;

    // used by CAGR 
    $initialvalue = 10000;
    $periodOfInvestment = 5;
    $presentValue = 15000;

    // Return Result
    $returnArr = array();

    $returnArr["standardDeviation"] = calculateStandardDeviation($preNavRtn);
    $returnArr["sharpRatio"] = calculateSharpeRatio($preNavRtn, $riskFreeRate);
    $returnArr["shortenRatio"] = calculateSortinoRatio($preNavRtn, $riskFreeRate);
    $returnArr['mean'] = (!count($preNavRtn) < 2) ? number_format(array_sum($preNavRtn) / count($preNavRtn), 3) : "-";
    $returnArr["priceToEarnRatio"] = calculatePERatio($currentNavVal, $earningsPerShare);
    $returnArr["priceToBookRatio"] = calculatePBRatio($currentNavVal, $bookValuePerShare);
    $returnArr["CAGR"] = CalculateCAGR($presentValue, $initialvalue, $periodOfInvestment);
    return $returnArr;
}


function calculateStandardDeviation($returns)
{
    // if no. of element in $return is 1  
    if (count($returns) < 2) {
        return "-";
    }

    // Calculate the mean
    $mean = array_sum($returns) / count($returns);

    // Calculate the squared differences from the mean
    $squaredDifferences = array_map(function ($return) use ($mean) {
        return ($return - $mean) ** 2;
    }, $returns);

    // Calculate the variance
    $variance = array_sum($squaredDifferences) / (count($returns));

    // Calculate the standard deviation
    return number_format(sqrt($variance), 3);
}


function calculateSharpeRatio($returns, $riskFreeRate)
{
    if (count($returns) < 2) {
        return "-";
    }

    // Calculate the mean return
    $meanReturn = array_sum($returns) / count($returns);

    // Calculate the standard deviation of returns
    $standardDeviation = calculateStandardDeviation($returns);

    // Calculate the excess return
    $excessReturn = $meanReturn - $riskFreeRate;

    // Calculate the Sharpe Ratio
    if ($standardDeviation == 0 or $standardDeviation == 0.0) {
        return "-";
    }
    $sharpeRatio = $excessReturn / floatval($standardDeviation);

    return number_format($sharpeRatio, 3);
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


function  CalculateCAGR($PRESENTVALUE, $INITIALVALUE, $PRIODOFINVESTMENT)
{
    $CAGR =  POW($PRESENTVALUE / $INITIALVALUE, (1 / $PRIODOFINVESTMENT)) - 1;
    return number_format($CAGR, 3);
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
        $sql = "SELECT * FROM `nav_$lastDateYear` WHERE `nav_date` > $lastDate and `scheme_id` = $sid ORDER BY `nav_date` ASC;";
    } else {
        $sql = "SELECT * FROM `nav_$presentDateYear` WHERE `nav_date` < $date and `scheme_id` = $sid UNION SELECT * FROM `nav_$lastDateYear` WHERE `nav_date` > $lastDate and `scheme_id` = $sid ORDER BY `nav_date`  ASC";
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
        $totla_current_val += $monthlyNavArray[0] * ($investment_monthly / $monthlyNavArray[$i]);
        $month++;
        $year = (int)$month / 12;
        $months = (int)$month % 12;
    }
    return "-";
}
