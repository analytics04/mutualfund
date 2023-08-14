<?php

// Example data
$dates = [
    21412, 21514, 24505, 22405, 22506 // Dates in numeric format (yyymmdd)
];
$amounts = [
    -3000, -3000, -3000, -3000, -3000 // Corresponding cash flows
];
function xirr($dates, $amounts) {
    $guess = 0.1; // Initial guess for the rate
    $epsilon = 0.0001; // Desired precision

    // Define the function for which we'll find the root
    $func = function($rate) use ($dates, $amounts) {
        $sum = 0;
        for ($i = 0; $i < count($dates); $i++) {
            $sum += $amounts[$i] / pow(1 + $rate, ($dates[$i] - $dates[0]) / 365);
        }
        return $sum;
    };

    $rate = $guess;
    $step = 0.1;

    do {
        $oldRate = $rate;
        $numerator = $func($rate + $step) - $func($rate);
        $denominator = $func($rate + $step) - 2 * $func($rate) + $func($rate - $step);
        if (abs($denominator) < 1e-6) {
            // Avoid division by very small numbers
            $rate -= $step;
        } else {
            $rate -= $step * $numerator / $denominator;
        }
    } while (abs($rate - $oldRate) > $epsilon);

    return $rate;
}

$xirr = xirr($dates, $amounts);
echo "XIRR: " . ($xirr * 100) . "%";
