<?php
// Given data
$dates = [
    "2021-11-22", "2021-12-20", "2022-01-20","2023-08-04"
];

$investments = [
    -2000, -1999.90, -1999.90,6900.531 
];

$navs = [
    341.41, 324.37, 346.85
];

$units = [
    5.858, 6.165, 5.766
];
$current_nav = 387.91;
$sum_unit= 17.789;

// Function to calculate XIRR
function calculateXIRR($dates, $investments, $navs, $units) {
    $guess = 0.1; // Starting guess for XIRR
    $maxIterations = 1000;
    $tolerance = 0.0001;
    
    $guess1 = $guess;
    $guess2 = $guess - 0.1;
    
    $f1 = 0;
    $f2 = 0;
    
    for ($i = 0; $i < count($dates); $i++) {
        $f1 += $investments[$i] / pow(1 + $guess1, (strtotime($dates[$i]) - strtotime($dates[0])) / (60 * 60 * 24));
        $f2 += $investments[$i] / pow(1 + $guess2, (strtotime($dates[$i]) - strtotime($dates[0])) / (60 * 60 * 24));
    }
    
    
    }
    
    $xirr = $guess1 - $f1 * ($guess1 - $guess2) / ($f1 - $f2);
    
    $iteration = 0;
    while (abs($f1) > $tolerance && $iteration < $maxIterations) {
        $xirr = $guess1 - $f1 * ($guess1 - $guess2) / ($f1 - $f2);
        $guess2 = $guess1;
        $guess1 = $xirr;
        
        $f1 = 0;
        for ($i = 0; $i < count($dates); $i++) {
            $f1 += $investments[$i] / pow(1 + $guess1, (strtotime($dates[$i]) - strtotime($dates[0])) / (60 * 60 * 24));
        }
        for ($i = 0; $i < count($dates); $i++) {
            $f1 += $navs[$i] * $units[$i] / pow(1 + $guess1, (strtotime($dates[$i]) - strtotime($dates[0])) / (60 * 60 * 24));
        }
        
        $iteration++;
    }
    
    return $xirr;
}

// Calculate XIRR
$xirr = calculateXIRR($dates, $investments, $navs, $units);
echo "XIRR: " . $xirr;
?>
