<?php
$historicalNAV = [30.8815,30.8916,31.0646,31.3858,31.5024,31.6582,31.7533,32.0063,32.3493,32.6423,32.7125,32.8724];
$currentNAV = 32.8884;
$monthlyInvestment = 1000;

function calculateSIPReturns($historicalNAV, $currentNAV, $monthlyInvestment) {
    $months = count($historicalNAV);
    $totalInvestment = 0;
    $totalUnits = 0;
    $currentValueOfUnits = [];

    for ($i = 0; $i < $months; $i++) {
        $investmentAmount = $monthlyInvestment;
        $nav = $historicalNAV[$i];
        $unitsPurchased = $investmentAmount / $nav;
        echo round($unitsPurchased,2).",";

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
//echo "SIP RETURN :".calculateSIPReturns($historicalNAV, $currentNAV, $monthlyInvestment);
var_dump(calculateSIPReturns($historicalNAV, $currentNAV, $monthlyInvestment));
?>