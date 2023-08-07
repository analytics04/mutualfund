<?php
$investments = array(100, 300, 600, 1200);
$finalNavs = array(102, 310, 620, 1250);

function calculateSIPReturnsAndAnnualized($investments, $finalNavs) {
    $timePeriods = count($investments);
    $sipReturns = array();

    // Calculate SIP returns for different time periods
    for ($i = 0; $i < $timePeriods; $i++) {
        $sipReturns[] = ($finalNavs[$i] - $investments[$i]) / $investments[$i];
    }

    // Calculate annualized returns
    $annualizedReturns = array();
    for ($i = 0; $i < $timePeriods; $i++) {
        $annualizedReturns[] = pow(1 + $sipReturns[$i], 12 / ($i + 1)) - 1;
    }

    return array(
        'SIPReturns' => $sipReturns,
        'AnnualizedReturns' => $annualizedReturns,
    );
}


$result = calculateSIPReturnsAndAnnualized($investments, $finalNavs);

echo " sip return :"$result;
