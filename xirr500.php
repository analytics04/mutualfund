<?php
// Given data
$cashflows = [-2000, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90];
$dates = ['2021-11-22', '2021-12-20', '2022-01-20', '2022-02-21', '2022-03-21', '2022-04-20', '2022-05-22', '2022-06-20', '2022-07-20', '2022-08-22', '2022-09-21', '2022-10-20', '2022-11-21', '2022-12-20', '2023-01-20', '2023-02-21', '2023-03-20', '2023-04-22', '2023-05-20', '2023-06-20', '2023-07-22'];
$nav_values = [341.41, 324.37, 346.85, 334.2, 331.37, 333.13, 312.29, 302.52, 323.77, 340.79, 348.06, 343.58, 352.21, 357.68, 350.66, 346.41, 334.3, 342.32, 356.42, 371.31, 390.48];
$current_nav = 387.91;
$current_date = '2023-08-04';

// Convert dates to timestamps
$cashflow_dates = array_map(function($date) {
    return strtotime($date);
}, $dates);

// Calculate time periods in days
$time_periods = [];
for ($i = 0; $i < count($cashflow_dates) - 1; $i++) {
    $time_periods[] = ($cashflow_dates[$i + 1] - $cashflow_dates[$i]) / (60 * 60 * 24);
}
$time_periods[] = (strtotime($current_date) - $cashflow_dates[count($cashflow_dates) - 1]) / (60 * 60 * 24);

// Calculate cashflows including current value
$cashflows[] = $current_nav - $nav_values[count($nav_values) - 1];

// Calculate XIRR values for different time periods
$one_month_cashflows = array_slice($cashflows, -1);
$three_month_cashflows = array_slice($cashflows, -3);
$six_month_cashflows = array_slice($cashflows, -6);

$one_month_xirr = xirr($one_month_cashflows, $time_periods);
$three_month_xirr = xirr($three_month_cashflows, array_slice($time_periods, -3));
$six_month_xirr = xirr($six_month_cashflows, array_slice($time_periods, -6));

echo "One Month XIRR: " . $one_month_xirr . "\n";
echo "Three Month XIRR: " . $three_month_xirr . "\n";
echo "Six Month XIRR: " . $six_month_xirr . "\n";

// XIRR calculation function
function xirr($cashflows, $time_periods) {
    $guess = 0.1; // Initial guess for IRR
    $xirr = Financial::IRR($cashflows, $time_periods, $guess);
    return $xirr;
}

// Financial class for IRR calculation
class Financial {
    public static function IRR($values, $dates, $guess = 0.1) {
        // Implementation of IRR calculation using Newton-Raphson method
        // You might need to adjust this based on your requirements
        // This is a simplified example for demonstration purposes
        
        $maxIteration = 100;
        $tolerance = 0.001;
        
        $x0 = $guess;
        for ($i = 0; $i < $maxIteration; $i++) {
            $f = 0;
            $fPrime = 0;
            
            for ($j = 0; $j < count($values); $j++) {
                $f += $values[$j] / pow(1 + $x0, $dates[$j] / 365);
                $fPrime -= ($dates[$j] / 365) * $values[$j] / pow(1 + $x0, $dates[$j] / 365 + 1);
            }
            
            $x1 = $x0 - $f / $fPrime;
            if (abs($x1 - $x0) < $tolerance) {
                return $x1;
            }
            
            $x0 = $x1;
        }
        
        return null;
    }
}
?>
