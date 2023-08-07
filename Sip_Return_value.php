<?php
// Example usage:
$historicalNAV = [32.7125,32.6423, 32.3493,32.0063, 31.7533,31.6636, 31.5024,31.3858, 31.0646, 30.8916, 30.8815, 30.6866];
$currentNAV = 32.86;
$monthlyInvestment =1000;

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
    echo $unitsPurchased;

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