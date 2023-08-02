<?php
// Example usage:
$fundReturn = 67; // Current return for the fund (67%)
$benchmarkReturn = 54; // Return for the applicable benchmark index (54%)
$riskFreeRate = 5; // Risk-free rate in India (5%)

function calculateBeta($fundReturn, $benchmarkReturn, $riskFreeRate) {
    // Calculate the numerator (Fund return - Risk-free rate)
    $numerator = $fundReturn - $riskFreeRate;
    
    // Calculate the denominator (Benchmark return - Risk-free rate)
    $denominator = $benchmarkReturn - $riskFreeRate;
    
    // Calculate Beta
    $beta = $numerator / $denominator;
    
    return $beta;
}
$beta = calculateBeta($fundReturn, $benchmarkReturn, $riskFreeRate);
echo "Beta: " . number_format($beta, 2);