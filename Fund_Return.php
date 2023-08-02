<?php
// Example usage:
$riskFreeRate = 5; // Risk-free rate in India (5%)
$beta = 1.26; // Beta calculated previously (1.26)
$benchmarkReturn = 54; // Return for the applicable benchmark index (54%)

function calculateFundReturn($riskFreeRate, $beta, $benchmarkReturn) {
    // Calculate the numerator (Beta × (Benchmark return - Risk-free rate))
    $numerator = $beta * ($benchmarkReturn - $riskFreeRate);
    
    // Calculate Fund return (Risk-free rate + numerator)
    $fundReturn = $riskFreeRate + $numerator;
    
    return $fundReturn;
}

$fundReturn = calculateFundReturn($riskFreeRate, $beta, $benchmarkReturn);
echo "Fund return: " . number_format($fundReturn, 2) . "%";