<?php

$returns = array(23.85,
20.04,
30.13
);

// Step 1: Calculate average daily return (Rp)
$averageReturn = array_sum($returns) / count($returns);

// Step 2: Calculate standard deviation (σp)
$standardDeviation = sqrt(array_sum(array_map(function ($return) use ($averageReturn) {
    return pow($return - $averageReturn, 2);
}, $returns)) / count($returns));

// Step 3: Calculate Sharpe Ratio
$sharpeRatio = ($averageReturn / $standardDeviation);


echo "Average Daily Return (Rp): $averageReturn\n";
echo "Standard Deviation (σp): $standardDeviation\n";
echo "Sharpe Ratio: $sharpeRatio\n";

?>
