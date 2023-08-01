<?php
$returns = [5.0,
9.2,
12.4,16.07,10.6,9.37,8.74,8.51,13.74,13.47,10.81,22.54];

function calculate_annualized_std_deviation($returns) {
    // Step 1: Calculate the average return (mean)
    $mean = array_sum($returns) / count($returns);

    // Step 2: Calculate the variance
    $variance = 0;
    foreach ($returns as $return) {
        $variance += pow($return - $mean, 2);
    }
    $variance /= count($returns);

    // Step 3: Annualize the variance
    $annualized_variance = $variance * 12; // Assuming the returns are monthly

    // Step 4: Calculate the annualized standard deviation
    $annualized_std_deviation = sqrt($annualized_variance);

    return $annualized_std_deviation;
}

echo calculate_annualized_std_deviation($returns);