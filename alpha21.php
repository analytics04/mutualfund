<?php
$mutualFundReturn = 14.07;
$benchmarkReturn = 13.02;
$riskFreeReturn = 6.0;
$beta = 1.15;
function calculateAlpha($mutualFundReturn, $benchmarkReturn, $beta, $riskFreeReturn) {
    // Calculate alpha using the given formula
    $alpha = ($mutualFundReturn - $riskFreeReturn) - ($benchmarkReturn - $riskFreeReturn) * $beta;
    return $alpha;
}


$alpha = calculateAlpha($mutualFundReturn, $benchmarkReturn, $beta, $riskFreeReturn);
echo $alpha;
