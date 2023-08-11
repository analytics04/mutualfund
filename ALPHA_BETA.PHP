<?php

// Example usage:
$mutualFundReturn = 14.07;
$benchmarkReturn = 13.02;
$riskFreeReturn = 6.0;
$beta = 0;
$alpha =0;

function calculateBeta($mutualFundReturn, $benchmarkReturn, $riskFreeReturn) {
    
    // Check if the denominator is zero to avoid division by zero error
    if ($benchmarkReturn - $riskFreeReturn == 0) {
        return "Undefined";
    }

    // Calculate beta using the given formula
    $beta = ($mutualFundReturn - $riskFreeReturn) / ($benchmarkReturn - $riskFreeReturn);
    return $beta;
}
$beta = calculateBeta($mutualFundReturn, $benchmarkReturn, $riskFreeReturn);
function calculateAlpha($mutualFundReturn, $benchmarkReturn, $beta, $riskFreeReturn) {
    // Calculate alpha using the given formula
    $alpha = ($mutualFundReturn - $riskFreeReturn) - ($benchmarkReturn - $riskFreeReturn) * round($beta,2);
    return $alpha;
}

$alpha = calculateAlpha($mutualFundReturn, $benchmarkReturn, $beta, $riskFreeReturn);

echo "Beta: " . $beta . PHP_EOL . '<br>';
echo "Alpha: " . $alpha . PHP_EOL;