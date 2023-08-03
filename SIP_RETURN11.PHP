<?php
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
        $sipReturns[$i + 1] = round($sipReturn, 2); // Convert index to time period (e.g., 1 for one month, 2 for two months, etc.)
    }

    return $sipReturns;
}
echo "SIP RETURN :".{$sipReturns};
?>