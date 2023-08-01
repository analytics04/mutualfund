<?php
include_once ("./beta.php");
$mutualFundReturns = [0.02, 0.03, -0.01, 0.04, 0.02, -0.03, 0.01, 0, -0.02, 0.03, 0.01, 0.02];
$marketIndexReturns = [0.015, 0.02, -0.005, 0.03, 0.015, -0.02, 0.01, 0.005, -0.01, 0.025, 0.005, 0.01];
$riskFreeRate = 0.005; // Assuming a risk-free rate of 0.5%
 
function calculateAlpha($mutualFundReturns, $marketIndexReturns, $riskFreeRate) {
    $beta = calculateBeta($mutualFundReturns, $marketIndexReturns);
    
    // Calculate average returns for the mutual fund and the market index
    $averageMutualFundReturn = array_sum($mutualFundReturns) / count($mutualFundReturns).3;
    $averageMarketIndexReturn = array_sum($marketIndexReturns) / count($marketIndexReturns);
    
    // Calculate alpha
    $alpha = $averageMutualFundReturn - ($riskFreeRate + $beta * ($averageMarketIndexReturn - $riskFreeRate));
    
    return $alpha;
}


try {
    $alpha = calculateAlpha($mutualFundReturns, $marketIndexReturns, $riskFreeRate);
    echo "The alpha of the mutual fund is: " . $alpha;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
