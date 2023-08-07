<?php
// Example usage:
$historicalNAV = [32.7125,32.6423,32.3493,32.0063,31.7533,31.6636,31.5024,31.3858, 31.0646,30.8916,30.8815,30.6866];
$currentNAV = 32.86;
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

    $cagr = (($currentValueOfUnits[$months - 1] / $totalInvestment) ** (1 / ($months / 12))) - 1;
    $cagrPercentage = round($cagr * 100, 2);

    return $cagrPercentage;
}

$annualizedReturn = calculateSIPReturns($historicalNAV, $currentNAV, $monthlyInvestment);

echo "Annualized Return (CAGR) for the SIP investment: {$annualizedReturn}%";
