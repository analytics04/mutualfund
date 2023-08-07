<?php

$INITIALVALUE = 35.22;
$PRESENTVALUE = 23.21;
$PRIODOFINVESTMENT = 5;

FUNCTION  CalculateCAGR($PRESENTVALUE,$INITIALVALUE,$PRIODOFINVESTMENT){

    $CAGR =  POW($PRESENTVALUE /$INITIALVALUE,(1/$PRIODOFINVESTMENT)) - 1;
     // Convert CAGR to a percentage
     $cagrPercentage = $CAGR * 100;

     return $cagrPercentage;

}

$cagr = calculateCAGR($INITIALVALUE, $PRESENTVALUE, $PRIODOFINVESTMENT);
echo "CAGR is approximately: " . round($cagr, 2) . "%";
