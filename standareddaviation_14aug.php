<?php
$returns = [15,12,20,-5,10];

function calculate_annualized_std_deviation($returns) {
    // Step 1: Calculate the average return (mean)
    $mean = array_sum($returns) / count($returns);
    echo "mean :" .$mean."<br>";

    // Step 2: Calculate the variance
    $variance = 0;
    foreach ($returns as $return) {
        $variance += (pow($return - $mean, 2));
    }
    $variance /= count($returns)-1;

     //Step 3: Annualize the variance
    //$annualized_variance = $variance * 4; // Assuming the returns are monthly

    // Step 4: Calculate the annualized standard deviation
    $annualized_std_deviation = sqrt( $variance);

    return $annualized_std_deviation;
}

echo calculate_annualized_std_deviation($returns);