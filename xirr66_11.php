<?php

require 'vendor/autoload.php'; // Make sure you have the Financial library installed

use Fannkuch\Financial as Financial;

// Given data
$cashFlows = array(
    array("date" => "2021-11-22", "amount" => 2000),
    array("date" => "2021-12-20", "amount" => 1999.90),
    array("date" => "2022-01-20", "amount" => 1999.90)
);

// Convert data into Financial library format
$cashFlowData = [];
foreach ($cashFlows as $flow) {
    $cashFlowData[] = ['date' => strtotime($flow["date"]), 'amount' => $flow["amount"]];
}

// Calculate XIRR using Financial library
$xirr = Financial::xirr($cashFlowData);

// Convert XIRR to percentage
$xirrPercentage = $xirr * 100;

echo "XIRR: " . round($xirrPercentage, 2) . "%";

?>
