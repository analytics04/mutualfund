<?php

$cashflows = [-2000, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, 47761.81];
$dates = ['2021-11-22', '2021-12-20', '2022-01-20', '2022-02-21', '2022-03-21', '2022-04-20', '2022-05-22', '2022-06-20', '2022-07-20', '2022-08-22', '2022-09-21', '2022-10-20', '2022-11-21', '2022-12-20', '2023-01-20', '2023-02-21', '2023-03-20', '2023-04-22', '2023-05-20', '2023-06-20', '2023-07-22', '2023-08-04'];

function calculate_monthly_xirr($cashflows, $dates) {
    $monthly_xirrs = [];

    for ($i = 0; $i < count($cashflows); $i++) {
        $cashflow = [$cashflows[$i]];
        $date = [$dates[$i]];

        $xirr = calculate_xirr($cashflow, $date);
        if ($xirr !== null) {
            $monthly_xirrs[$dates[$i]] = $xirr;
        } else {
            $monthly_xirrs[$dates[$i]] = "XIRR calculation did not converge.";
        }
    }

    return $monthly_xirrs;
}

function calculate_xirr($cashflows, $dates) {
    // Your existing XIRR calculation function
}

$monthly_xirrs = calculate_monthly_xirr($cashflows, $dates);
foreach ($monthly_xirrs as $date => $xirr) {
    echo "Date: $date, XIRR: " . ($xirr * 100) . "\n";
}
?>