<?php
$calculateStandardDeviation='';
$returns = [15,12,20,-5,10];
function calculateStandardDeviation($returns)
{
    // Step 1: Calculate the mean

    $mean = array_sum($returns) / count($returns);
    echo "mean :".$mean.

    // Step 2: Calculate the squared differences from the mean

    $squaredDifferences = array_map(function($returns) use ($mean) {
        return pow($returns - $mean, 2);
    }, $returns);

    echo "squared difference :". $squaredDifferences.


    // Step 3: Calculate the variance

    $variance = array_sum($squaredDifferences) / (count($returns)-1);


     // Step 3: Annualize the variance
     $annualized_variance = $variance * 12; // Assuming the returns are monthly

    // Step 4: Calculate the standard deviation

    return $standardDeviation = sqrt($annualized_variance)."<br>";
    // console.log($standardDeviation);
    // console.log("1");
}
echo calculateStandardDeviation($returns);
?>