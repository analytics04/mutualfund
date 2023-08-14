<?php

// Sample data in the format of Date, Value, and Script
$data = [
    ["Date" => "2021-11-22", "Value" => 341.41, "Script" => "S1"],
    ["Date" => "2021-12-20", "Value" => 324.37, "Script" => "S1"],
    // ... more data entries ...
];

// Filtering data for the specific script "S1"
$filteredData = [];
foreach ($data as $entry) {
    if ($entry["Script"] === "S1") {
        $filteredData[] = ["Date" => $entry["Date"], "Value" => $entry["Value"]];
    }
}

// Calculate XIRR using your existing XIRR calculation function
function calculate_xirr($cashflows, $dates) {
    // ... your existing XIRR calculation code ...
}

$cashflows = array_column($filteredData, "Value");
$dates = array_column($filteredData, "Date");
$xirrValue = calculate_xirr($cashflows, $dates);

if ($xirrValue !== null) {
    $xirrPercentage = round($xirrValue * 100, 2);
    $xirrEntry = ["Script" => "S1", "XIRR" => $xirrPercentage];
    
    // Initialize $XIRR array if not already initialized
    if (!isset($XIRR)) {
        $XIRR = [];
    }
    
    $XIRR[] = $xirrEntry;
} else {
    echo "XIRR calculation did not converge or result is undefined.\n";
}

// Display the results or continue further processing
if (isset($XIRR)) {
    print_r($XIRR);
} else {
    echo "No XIRR results available.\n";
}

?>
