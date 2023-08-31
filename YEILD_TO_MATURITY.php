----YIELD TO MATURITY---
<?php

// Face value of the bond
$faceValue = 1000;

// Coupon rate (annual interest rate) of the bond
$couponRate = 6;

// Market price of the bond
$marketPrice = 900;

// Years to maturity of the bond
$yearsToMaturity = 10;

function calculateYieldToMaturity($faceValue, $couponRate, $marketPrice, $yearsToMaturity)
{
    // Calculate the annual coupon payment
    $couponPayment = $faceValue * ($couponRate / 100);

    // Calculate the total number of coupon payments
    $totalCouponPayments = $yearsToMaturity * ($couponPayment);

    // Calculate the future value of the bond
    $futureValue = $faceValue;

    // Calculate the yield to maturity formula
    $YTM = ($couponPayment + (($faceValue - $marketPrice)/$yearsToMaturity))/(($faceValue + $marketPrice)/2);

    // Convert to percentage
    $YTM *= 100;

    return $YTM;
}

// Calculate the Yield to Maturity
$yieldToMaturity = calculateYieldToMaturity($faceValue, $couponRate, $marketPrice, $yearsToMaturity);

// Output the result
echo "Yield to Maturity: " . $yieldToMaturity . "%";
?>

//Yield to Maturity = [Annual Interest + {(FV-Price)/Maturity}] / [(FV+Price)/2]

