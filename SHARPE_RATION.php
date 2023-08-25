<?php
include("./standareddaviation_14aug.php");
//$STD_V = 15.25;

$returns = [20.6,
16.3,
26.63
];

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

calculateSharpeRatio($returns, $riskFreeRate)
?>



    