<?php
include ("./STANDARD_DAVIATION.PHP");

$returns = [1,2,3,4,5,6];
$riskFreeRate = 5;


function calculateSharpeRatio($returns, $riskFreeRate){

    // Step 1: Calculate the mean return
    $meanReturn = array_sum($returns) / count($returns);
    echo "Mean Return : ".$meanReturn."<br>";


    // Step 2: Calculate the standard deviation of returns
     $standardDeviation = calculateStandardDeviation($returns);
    echo "Standard Deviation :". $standardDeviation."<br>";

    // Step 3: Calculate the excess return
    $excessReturn = $meanReturn - $riskFreeRate;
    echo "Excess Return : ".$excessReturn."<br>";

    // Step 4: Calculate the Sharpe Ratio
    $sharpeRatio = $excessReturn / floatval($standardDeviation);
    echo "Sharpe Ratio : ".$sharpeRatio ."<br>";
    
    //return $sharpeRatio;
}
calculateSharpeRatio($returns,$riskFreeRate);
?>



    