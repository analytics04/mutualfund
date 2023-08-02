<?php

// Example usage:
$mutualFundReturn = 20;
$benchmarkReturn = 15;
$riskFreeReturn = 10;

function calculateBeta($mutualFundReturn, $benchmarkReturn, $riskFreeReturn) {
    // Check if the denominator is zero to avoid division by zero error
    if ($benchmarkReturn - $riskFreeReturn == 0) {
        return "Undefined";
    }

    // Calculate beta using the given formula
    $beta = ($mutualFundReturn - $riskFreeReturn) / ($benchmarkReturn - $riskFreeReturn);
    return $beta;
}

function calculateAlpha($mutualFundReturn, $benchmarkReturn, $beta, $riskFreeReturn) {
    // Calculate alpha using the given formula
    $alpha = ($mutualFundReturn - $riskFreeReturn) - (($benchmarkReturn - $riskFreeReturn) * $beta);
    return $alpha;
}

$beta = calculateBeta($mutualFundReturn, $benchmarkReturn, $riskFreeReturn);
$alpha = calculateAlpha($mutualFundReturn, $benchmarkReturn, $beta, $riskFreeReturn);

echo "Beta: " . $beta . PHP_EOL;
echo "Alpha: " . $alpha . PHP_EOL;