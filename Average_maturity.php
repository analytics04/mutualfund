<?php

$facevalue = [1000, 3000, 5000];
$time_to_maturity = [3, 4, 5];

function average_maturity($facevalue, $time_to_maturity)
{
    $weighted_total = 0;
    $total_facevalue = array_sum($facevalue); // Calculate the total face value

    for ($i = 0; $i < count($facevalue); $i++) {
        $weighted_total += $facevalue[$i] * $time_to_maturity[$i];
    }

    $average_M = $weighted_total / $total_facevalue;

    return $average_M;
}

echo "AVM: " .ROUND(average_maturity($facevalue, $time_to_maturity),1)." "."YEARS";

?>
