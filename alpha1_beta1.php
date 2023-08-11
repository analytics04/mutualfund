<?php
$mutualFundReturn =  0.1407;
$benchmarkReturn =  0.0500;
$riskFreeReturn = 0.06;

function calculateBeta($mutualFundReturn, $benchmarkReturn, $riskFreeReturn) {
    

    // Check if both arrays have the same number of elements
    if (count($mutualFundReturn) !== count($benchmarkReturn)) {
        return "Arrays must have the same number of elements.";
    }

    // Calculate beta for each data point in the arrays
    //for ($i = 0; $i < count($mutualFundReturn); $i++) {
        // Check if the denominator is zero to avoid division by zero error
       // if ($benchmarkReturn[$i] - $riskFreeReturn == 0) {
           // $beta[] = "Undefined";
        //} 
        
           $beta = ($mutualFundReturn - $riskFreeReturn) / ($benchmarkReturn - $riskFreeReturn);
        
}
 return $beta;
 
function calculateAlpha($mutualFundReturn, $benchmarkReturn, $beta, $riskFreeReturn) {
    

    // Check if all arrays have the same number of elements
    if (count($mutualFundReturn) !== count($benchmarkReturn) || count($mutualFundReturn) !== count($beta)) {
        return "Arrays must have the same number of elements.";
    }

    // Calculate alpha for each data point in the arrays
    //for ($i = 0; $i < count($mutualFundReturn); $i++) {
        $alpha = ($mutualFundReturn - $riskFreeReturn) - (($benchmarkReturn- $riskFreeReturn) * $beta);
    }

    return $alpha;


$beta = calculateBeta($mutualFundReturn, $benchmarkReturn, $riskFreeReturn);
$alpha = calculateAlpha($mutualFundReturn, $benchmarkReturn, $beta, $riskFreeReturn);

// Print the results
echo "Beta: ";
print_r($beta);
echo "Alpha: ";
print_r($alpha);
