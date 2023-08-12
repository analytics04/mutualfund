<?php
function newton($initial_guess, $func, $func_prime, $max_iterations = 1000, $tolerance = 1e-6) {
    $guess = $initial_guess;
    
    for ($i = 0; $i < $max_iterations; $i++) {
        $f_value = $func($guess);
        $f_prime_value = $func_prime($guess);
        
        $new_guess = $guess - $f_value / $f_prime_value;
        
        if (abs($new_guess - $guess) < $tolerance) {
            return $new_guess;
        }
        
        $guess = $new_guess;
    }
    
    return null; // Return null if the method doesn't converge
}

$cashflows = [-2000, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90];
$dates = ['2021-11-22', '2021-12-20', '2022-01-20', '2022-02-21', '2022-03-21', '2022-04-20', '2022-05-22', '2022-06-20', '2022-07-20', '2022-08-22', '2022-09-21', '2022-10-20', '2022-11-21', '2022-12-20', '2023-01-20', '2023-02-21', '2023-03-20', '2023-04-22', '2023-05-20', '2023-06-20', '2023-07-22'];
$nav_values = [341.41, 324.37, 346.85, 334.2, 331.37, 333.13, 312.29, 302.52, 323.77, 340.79, 348.06, 343.58, 352.21, 357.68, 350.66, 346.41, 334.3, 342.32, 356.42, 371.31, 390.48];
$current_nav = 387.91;

$date_objects = array_map(function ($date) {
    return DateTime::createFromFormat('Y-m-d', $date);
}, $dates);

$units = array_map(function ($cashflow, $nav) {
    return $cashflow / $nav;
}, $cashflows, $nav_values);

$current_price = $current_nav * array_sum($units);

function difference_rate($rate, $date_objects, $cashflows) {
    $sum = 0;
    for ($i = 0; $i < count($date_objects); $i++) {
        $days = $date_objects[$i]->diff($date_objects[0])->days;
        $sum += $cashflows[$i] / pow(1 + $rate, $days / 365);
    }
    return $sum;
}

function difference_rate_prime($rate, $date_objects, $cashflows) {
    $sum = 0;
    for ($i = 0; $i < count($date_objects); $i++) {
        $days = $date_objects[$i]->diff($date_objects[0])->days;
        $sum -= ($days / 365) * $cashflows[$i] / pow(1 + $rate, $days / 365 + 1);
    }
    return $sum;
}

$xirr_values = [];
foreach ($date_objects as $i => $date) {
    $rate_guess = 0.1;
    $xirr = newton($rate_guess, 'difference_rate', 'difference_rate_prime', 1000, 1e-6);
    $xirr_values[] = $xirr;
}

foreach ($xirr_values as $i => $xirr) {
    echo "XIRR for " . $date_objects[$i]->format('F Y') . ": " . ($xirr * 100) . "%\n";
}
?>