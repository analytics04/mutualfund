<?php
// Example usage:
$initialInvestment = 35.22;
$finalInvestment = 23.21;
$holdingPeriodYears = 5;
function calculateCAGR($initialInvestment, $finalInvestment, $holdingPeriodYears) {
    // Calculate the total return
    $totalReturn = ($finalInvestment - $initialInvestment) / $initialInvestment;
    
    // Calculate CAGR
    $cagr = pow(1 + $totalReturn, 1 / $holdingPeriodYears) - 1;
    
    // Convert CAGR to a percentage
    $cagrPercentage = $cagr * 100;
    
    return $cagrPercentage;
}

// Example usage:
$initialInvestment = 10000;
$finalInvestment = 15000;
$holdingPeriodYears = 2;

$cagr = calculateCAGR($initialInvestment, $finalInvestment, $holdingPeriodYears);
echo "CAGR is approximately: " . round($cagr, 2) . "%";