<?php
$returns = [13.590,6.562,17.509];
function calculateStandardDeviation($returns)
{
    // Step 1: Calculate the mean
    $mean = array_sum($returns) / count($returns);
    echo "mean :".$mean."<br>";

    // Step 2: Calculate the difference between each return and the mean
    $differences = array_map(function ($return) use ($mean) {
        return $return - $mean;
    }, $returns);
    //echo"differences :".floatval($differences)."<br>";
    var_dump($differences);

    // Step 3: Square each difference
    $squaredDifferences = array_map(function ($difference) {
        return $difference * $difference;
    }, $differences);

    // Step 4: Calculate the variance
    $variance = array_sum($squaredDifferences) / count($returns)-1;

    // Step 5: Annualize the variance
    $annualized_variance = $variance * 12; // Assuming the returns are monthly


    // Step 6: Calculate the standard deviation
    $standardDeviation = sqrt($annualized_variance);

    return $standardDeviation;
}
$standardDeviation = calculateStandardDeviation($returns);
echo "Standard deviation: " . round($standardDeviation, 2) . "%";
