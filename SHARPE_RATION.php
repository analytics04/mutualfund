<?php
include ("./standard_daviation1 (1).PHP");

$returns = [7.93,3.90,14.07];
$riskFreeRate = 0.06;


function calculateSharpeRatio($returns, $riskFreeRate){

    // Step 1: Calculate the mean return
    $meanReturn = array_sum($returns) / count($returns);
    echo "Mean Return : ".$meanReturn."<br>";


    // Step 2: Calculate the standard deviation of returns
     $standardDeviation = calculate_annualized_std_deviation($returns);
    echo "Standard Deviation :". $standardDeviation."<br>";

    // Step 3: Calculate the excess return
    $excessReturn = $meanReturn - $riskFreeRate;
    echo "Excess Return : ".$excessReturn."<br>";

    // Step 4: Calculate the Sharpe Ratio
    $sharpeRatio = $excessReturn / floatval($standardDeviation);
    echo "Sharpe Ratio : ".$sharpeRatio;
    

}

?>



    