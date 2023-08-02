<?php
$mutualFundReturns = [0.02, 0.03, -0.01, 0.04, 0.02, -0.03, 0.01, 0, -0.02, 0.03, 0.01, 0.02];
$marketIndexReturns = [0.015, 0.02, -0.005, 0.03, 0.015, -0.02, 0.01, 0.005, -0.01, 0.025, 0.005, 0.01];

function calculateBeta($mutualFundReturns, $marketIndexReturns) {
    // Step 1: Check if the data arrays have the same length
    if (count($mutualFundReturns) !== count($marketIndexReturns)) {
        throw new Exception("Data arrays must have the same length.");
    }
    
    // Step 2: Calculate the average returns for both the mutual fund and the market index
    $averageMutualFundReturn = array_sum($mutualFundReturns) / count($mutualFundReturns);
    $averageMarketIndexReturn = array_sum($marketIndexReturns) / count($marketIndexReturns);
    
    // Step 3: Calculate the covariance
    $covariance = 0;
    for ($i = 0; $i < count($mutualFundReturns); $i++) {
        $covariance += ($mutualFundReturns[$i] - $averageMutualFundReturn) * ($marketIndexReturns[$i] - $averageMarketIndexReturn);
    }
    $covariance /= count($mutualFundReturns);
    
    // Step 4: Calculate the variance of the market index returns
    $varianceMarketIndex = 0;
    for ($i = 0; $i < count($marketIndexReturns); $i++) {
        $varianceMarketIndex += pow(($marketIndexReturns[$i] - $averageMarketIndexReturn), 2);
    }
    $varianceMarketIndex /= count($marketIndexReturns);
    
    // Step 5: Calculate beta
    $beta = $covariance / $varianceMarketIndex;
    
    return $beta;
}
try {
    $beta = calculateBeta($mutualFundReturns, $marketIndexReturns);
    echo "The beta of the mutual fund is: " . $beta;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}