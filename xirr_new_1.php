<?php

define('FINANCIAL_MAX_ITERATIONS', 100);
define('FINANCIAL_ACCURACY', 1.0e-6);

class FinancialCalculator
{
    public function DATEDIFF($datepart, $startdate, $enddate)
    {
        // The DATEDIFF function implementation remains unchanged.
    }

    public function XNPV($rate, $values, $dates)
    {
        // The XNPV function implementation remains unchanged.
    }

    public function XIRR($values, $dates, $guess = 0.1)
    {
        // The XIRR function implementation remains unchanged.
    }
}

$calculator = new FinancialCalculator;

$values = array(-2000, -1999, -1999, -1999, -1999, -1999, -1999, -1999, -1999);
$dates = array(
    mktime(0, 0, 0, 11, 22, 2021),
    mktime(0, 0, 0, 12, 20, 2021),
    mktime(0, 0, 0, 01, 20, 2022),
    mktime(0, 0, 0, 02, 21, 2022),
    mktime(0, 0, 0, 03, 21, 2022),
    mktime(0, 0, 0, 04, 21, 2022),
    mktime(0, 0, 0, 05, 21, 2022),
    mktime(0, 0, 0, 06, 20, 2022),
    mktime(0, 0, 0, 07, 20, 2022)
);

$xirr = $calculator->XIRR($values, $dates, 0.5);
var_dump($xirr);

?>
