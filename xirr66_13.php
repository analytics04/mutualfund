<?php
// Given data
$dates = [
    "2021-11-22", "2021-12-20", "2022-01-20", "2022-02-21", "2022-03-21",
    "2022-04-20", "2022-05-20", "2022-06-21", "2022-07-20", "2022-08-22",
    "2022-09-21", "2022-10-20", "2022-11-21", "2022-12-20", "2023-01-20",
    "2023-02-21", "2023-03-21", "2023-04-20", "2023-05-22", "2023-06-20",
    "2023-07-20", "2023-08-04"
];

$investments = [
    -2000, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90,
    -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90,
    -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90,
    -1999.90, 47761.80666
];

$navs = [
    341.41, 324.37, 346.85, 334.2, 331.37, 333.13, 312.29, 302.52, 323.77,
    340.79, 348.06, 343.58, 352.21, 357.68, 350.66, 346.41, 334.3, 342.32,
    356.42, 371.31, 390.48, 387.91
];

$units = [
    5.858, 6.165, 5.766, 5.984, 6.035, 6.003, 6.404, 6.611, 6.177, 5.868,
    5.746, 5.821, 5.678, 5.591, 5.703, 5.773, 5.982, 5.842, 5.611, 5.386,
    5.122, 123.126
];

// Function to calculate XIRR
function calculateXIRR($dates, $investments, $navs, $units) {
    // Implementation of XIRR calculation...
    // (Same code as before)
    // ...
    return $xirr;
}

// Calculate and display XIRR for each date
foreach ($dates as $index => $date) {
    $investmentsForDate = array_slice($investments, 0, $index + 1);
    $navsForDate = array_slice($navs, 0, $index + 1);
    $unitsForDate = array_slice($units, 0, $index + 1);
    
    $xirr = calculateXIRR($dates, $investmentsForDate, $navsForDate, $unitsForDate);
    echo "XIRR for $date: " . $xirr . PHP_EOL;
}
?>
