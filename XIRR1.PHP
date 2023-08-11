<?PHP

// Example data
$cashFlows = array(2000, 1999.90, 1999.90,1999,1999,1999,1999,1999,1999,1999.0,1999.0,1999.0); // Replace with all cash flows
$dates = array("22-11-2021", "20-12-2021", "20-01-2022","21-02-2022","20-03-2022","20-04-2022","21-05-2022","21-06-2022","20-07-2022","21-08-2022","21-09-2022","20-10-2022"); // Replace with all dates
$currentNAV = 387.91;

function calculateXIRR($cashFlows, $dates, $currentNAV, $initialGuess = 0.1, $tolerance = 0.000001, $maxIterations = 100) {
    $guessRate = $initialGuess;

    for ($iteration = 0; $iteration < $maxIterations; $iteration++) {
        $sumPresentValues = 0;

        for ($i = 0; $i < count($cashFlows); $i++) {
            $days = (strtotime($dates[$i]) - strtotime($dates[0])) / (60 * 60 * 24);
            $presentValue = $cashFlows[$i] / pow(1 + $guessRate, $days / 365);
            $sumPresentValues += $presentValue;
        }

        $newGuessRate = $guessRate + ($sumPresentValues / $currentNAV);
        
        if (abs($sumPresentValues - $currentNAV) < $tolerance) {
            return $guessRate;
        }

        $guessRate = $newGuessRate;
    }

    return null; // Return null if convergence wasn't achieved
}

// Example data
//$cashFlows = array(2000, 1999.90, 1999.90); // Replace with all cash flows
//$dates = array("22-11-2021", "20-12-2021", "20-01-2022"); // Replace with all dates
//$currentNAV = 389.91;

$xirr = calculateXIRR($cashFlows, $dates, $currentNAV);

if ($xirr !== null) {
    echo "Calculated XIRR: " . ($xirr * 100) . "%";
} else {
    echo "XIRR calculation did not converge.";
}
?>