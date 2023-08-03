<?php
// Example usage:
$historicalNAV = [50, 52, 49, 55, 58, 60, 62, 66, 68, 70, 75, 80];
$currentNAV = 85;
$monthlyInvestment = 10000;

function calculateSIPReturns($historicalNAV, $currentNAV, $monthlyInvestment) {
    $months = count($historicalNAV);
    $totalInvestment = 0;
    $totalUnits = 0;
    $currentValueOfUnits = [];

    for ($i = 0; $i < $months; $i++) {
        $investmentAmount = $monthlyInvestment;
        $nav = $historicalNAV[$i];
        $unitsPurchased = $investmentAmount / $nav;

        $totalInvestment += $investmentAmount;
        $totalUnits += $unitsPurchased;

        $currentValueOfUnits[$i] = $currentNAV * $totalUnits;
    }

    $sipReturns = [];
    for ($i = 0; $i < $months; $i++) {
        $sipReturn = ($currentValueOfUnits[$i] - $totalInvestment) / $totalInvestment * 100;
        $timePeriod = $i + 1; // Convert index to time period (e.g., 1 for one month, 2 for two months, etc.)
        $sipReturns[$timePeriod] = round($sipReturn, 2);
    }

    return $sipReturns;
}

$sipReturns = calculateSIPReturns($historicalNAV, $currentNAV, $monthlyInvestment);

// Display SIP returns for different durations
foreach ($sipReturns as $timePeriod => $sipReturn) {
    echo "SIP Return for {$timePeriod} month(s): {$sipReturn}%<br>";
}
?>