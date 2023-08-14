<?php

// Given data
$cashFlows = array(
    array("date" => "2021-11-22", "amount" => -2000),
    array("date" => "2021-12-20", "amount" => -1999.90),
    array("date" => "2022-01-20", "amount" => -1999.90)
);

// Initial guess rate
$guessRate = 20; // A reasonable initial guess rate

// Maximum number of iterations
$maxIterations = 1000;

// Tolerance level
$tolerance = 0.000001;

// Convert dates to days from the first cash flow date
$firstDate = strtotime($cashFlows[0]["date"]);
foreach ($cashFlows as &$flow) {
    $flow["days"] = (strtotime($flow["date"]) - $firstDate) / (60 * 60 * 24);
}

// XIRR calculation using the Newton-Raphson method
function calculateXIRR($guessRate, $cashFlows) {
    $npv = 0;
    $derivative = 0;
    
    foreach ($cashFlows as $flow) {
        $pv = $flow["amount"] / pow(1 + $guessRate, $flow["days"] / 365);
        $npv += $pv;
        $derivative += -$flow["days"] * $pv / (365 * pow(1 + $guessRate, $flow["days"] / 365 + 1));
    }
    
    return $guessRate - $npv / $derivative;
}

// Iteratively improve the guess rate
for ($i = 0; $i < $maxIterations; $i++) {
    $newGuessRate = calculateXIRR($guessRate, $cashFlows);
    
    // Check for convergence
    if (abs($newGuessRate - $guessRate) < $tolerance) {
        $xirr = $newGuessRate;
        break;
    }
    
    $guessRate = $newGuessRate;
}

// Convert XIRR to percentage
$xirrPercentage = $xirr * 100;

echo "XIRR: " . round($xirrPercentage, 2) . "%";

?>
