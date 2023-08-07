<?php
$sipAmount = 5000;
$historicalNavData = [32.7125,32.6423,32.3493,32.0063,31.7533,31.6636,31.5024,31.3858, 31.0646,30.8916,30.8815,30.6866];
$currentNav = 32.86;
function calculateSIPReturns($sipAmount, $historicalNavData, $currentNav) {
    // Calculate total number of months for SIP
    $totalMonths = count($historicalNavData);

    // Initialize variables to store total units and current value of units
    $totalUnits = 0;
    $currentValueOfUnits = 0;

    // Calculate SIP investments and units purchased for each month
    for ($i = 0; $i < $totalMonths; $i++) {
        $nav = $historicalNavData[$i];
        $unitsPurchased = $sipAmount / $nav;
        $totalUnits += $unitsPurchased;
    }

    // Calculate current value of units based on current NAV
    $currentValueOfUnits = $currentNav * $totalUnits;

    // Calculate SIP returns for different time periods
    $returns = array();
    $returns['one_month'] = (($currentValueOfUnits - $sipAmount) / $sipAmount) * 100;
    $returns['three_months'] = (($currentValueOfUnits - ($sipAmount * 3)) / ($sipAmount * 3)) * 100;
    $returns['six_months'] = (($currentValueOfUnits - ($sipAmount * 6)) / ($sipAmount * 6)) * 100;
    $returns['one_year'] = (($currentValueOfUnits - ($sipAmount * 12)) / ($sipAmount * 12)) * 100;

    return $returns;
}

$sipReturns = calculateSIPReturns($sipAmount, $historicalNavData, $currentNav);

echo "One Month SIP Return: " . round($sipReturns['one_month'], 2) . "%<br>";
echo "Three Months SIP Return: " . round($sipReturns['three_months'], 2) . "%<br>";
echo "Six Months SIP Return: " . round($sipReturns['six_months'], 2) . "%<br>";
echo "One Year SIP Return: " . round($sipReturns['one_year'], 2) . "%<br>";
?>