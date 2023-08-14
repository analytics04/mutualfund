<?php
function calculateXIRR($cashflows, $dates, $targetDate, $guess = 0.1, $maxIterations = 1000, $tolerance = 0.001) {
    $iterations = 0;
    $x0 = $guess;

    do {
        $fValue = 0;
        $fDerivative = 0;

        for ($i = 0; $i < count($cashflows); $i++) {
            $days = strtotime($dates[$i]) - strtotime($targetDate);
            $fValue += $cashflows[$i] / pow(1 + $x0, $days / 365);
            $fDerivative -= ($days / 365) * $cashflows[$i] / pow(1 + $x0, $days / 365 + 1);
        }

        $x1 = $x0 - $fValue / $fDerivative;
        $diff = abs($x1 - $x0);

        $x0 = $x1;

        $iterations++;
    } while ($diff > $tolerance && $iterations < $maxIterations);

    return $x0;
}

$cashflows = [-2000, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, 47761.81];
$dates = ['2021-11-22', '2021-12-20', '2022-01-20', '2022-02-21', '2022-03-21', '2022-04-20', '2022-05-22', '2022-06-20', '2022-07-20', '2022-08-22', '2022-09-21', '2022-10-20', '2022-11-21', '2022-12-20', '2023-01-20', '2023-02-21', '2023-03-20', '2023-04-22', '2023-05-20', '2023-06-20', '2023-07-22', '2023-08-04'];

foreach ($dates as $date) {
    $xirr = calculateXIRR($cashflows, $dates, $date);
    echo "Date: $date, XIRR: " . ($xirr * 100) . "%\n";
}
?>
