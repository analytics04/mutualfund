<?php
$present_date = strtotime("2023-08-04");

$cashflows = [-2000, -1999.90, -1999.90, /* ... other cashflows ... */];
$dates = ['2021-11-22', '2021-12-20', '2022-01-20', /* ... other dates ... */];
$nav_values = [341.41, 324.37, 346.85, /* ... other NAV values ... */];
$current_nav = 387.91;

$units = [];
for ($i = 0; $i < count($cashflows); $i++) {
    $units[] = $cashflows[$i] / $nav_values[$i];
}

$current_price = $current_nav * array_sum($units);

function calculateXIRR($cashflows, $dates, $units, $current_price) {
    global $present_date;
    $xirr_values = [];
    for ($i = 0; $i < count($cashflows); $i++) {
        $days_diff = ($present_date - strtotime($dates[$i])) / (60 * 60 * 24); // Convert to days
        $xirr = $cashflows[$i] / ($current_price * (1 + $days_diff / 365));
        $xirr_values[] = $xirr;
    }
    return $xirr_values;
}

$cashflows_one_month = [-2000,2272.38];
$dates_one_month = ['2021-11-22','2023-08-04'];
$units_one_month = [$units[0]];

$cashflows_two_months = [-2000,-1999.90,4663.30];
$dates_two_months = ['2021-12-20', '2022-01-20','2023-08-04'];
$units_two_months = [$units[0], $units[1]];

$xirr_one_month = calculateXIRR($cashflows_one_month, $dates_one_month, $units_one_month, $current_price);
$xirr_two_months = calculateXIRR($cashflows_two_months, $dates_two_months, $units_two_months, $current_price);

echo "XIRR for one month: " . implode(", ", $xirr_one_month) . "\n";
echo "XIRR for two months: " . implode(", ", $xirr_two_months) . "\n";
?>