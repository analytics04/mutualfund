<?PHP
//$cashflows = [-2,000,1,999.90,1,999.90,1,999.90,1,999.90,1,999.90,1,999.90,1,999.90,1,999.90,1,999.90,1,999.90,1,999.90,1,999.90,1,999.90,1,999.90,1,999.90,1,999.90,1,999.90,1,999.90,1,999.90,1,999.90];
//$dates = ['2022-11-21','2022-12-20','2022-01-20','2022-02-21','2022-03-21','2022-04-20','2022-05-20','2022-06-21','2022-07-20','2022-08-22','2022-09-21','2022-10-20','2022-11-21','2022-12-20','2023-01-20','2023-02-21','2023-03-21','2023-04-20','2023-05-22','2023-06-20','2023-07-20'];



function xirr($cashflows, $dates) {
    $guess = 0.1; // Initial guess for the rate of return
    $maxIterations = 100;
    $tolerance = 0.0001;
    
    $i = 0;
    $rate = $guess;
    $prevRate = $guess;
    
    do {
        $rate = $prevRate - xirrNPV($cashflows, $dates, $prevRate) / xirrDerivative($cashflows, $dates, $prevRate);
        
        if (abs($rate - $prevRate) < $tolerance) {
            return $rate;
        }
        
        $prevRate = $rate;
        $i++;
    } while ($i < $maxIterations);
    
    return null; // If convergence doesn't occur
}

function xirrNPV($cashflows, $dates, $rate) {
    $npv = 0;
    for ($i = 0; $i < count($cashflows); $i++) {
        $npv += $cashflows[$i] / pow(1 + $rate, xirrDaysDiff($dates[$i], $dates[0]) / 365);
    }
    return $npv;
}

function xirrDerivative($cashflows, $dates, $rate, $h = 0.0001) {
    $xirrPlusH = xirrNPV($cashflows, $dates, $rate + $h);
    $xirrMinusH = xirrNPV($cashflows, $dates, $rate - $h);
    return ($xirrPlusH - $xirrMinusH) / (2 * $h);
}

function xirrDaysDiff($date1, $date2) {
    $diff = strtotime($date1) - strtotime($date2);
    return $diff / (60 * 60 * 24);
}

//Example cash flows and dates
$cashflows = [2,000,1,999.90,1,999.90,1,999.90,1,999.90,1,999.90,1,999.90,1,999.90,1,999.90,1,999.90,1,999.90,1,999.90,1,999.90,1,999.90,1,999.90,1,999.90,1,999.90,1,999.90,1,999.90,1,999.90,1,999.90];
$dates = ['2022-11-21','2022-12-20','2022-01-20','2022-02-21','2022-03-21','2022-04-20','2022-05-20','2022-06-21','2022-07-20','2022-08-22','2022-09-21','2022-10-20','2022-11-21','2022-12-20','2023-01-20','2023-02-21','2023-03-21','2023-04-20','2023-05-22','2023-06-20','2023-07-20'];

$xirr = xirr($cashflows, $dates);

if ($xirr !== null) {
    echo "Calculated XIRR: " . ($xirr * 100) . "%";
} else {
    echo "XIRR calculation did not converge.";
}