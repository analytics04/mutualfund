<?PHP
function calculateExpenseRatio($totalExpenses, $fundAssets)
{
    // Calculate the expense ratio as a percentage
    $expenseRatio = ($totalExpenses / $fundAssets) * 100;
    
    return $expenseRatio;
}

// Total expenses of the mutual fund
$totalExpenses = 250000;

// Fund assets of the mutual fund
$fundAssets = 10000000;

// Calculate the expense ratio
$expenseRatio = calculateExpenseRatio($totalExpenses, $fundAssets);

// Output the result
echo "Expense Ratio: " . $expenseRatio . "%";
?>