<?php

$marketPrice = 100.00;

$bookValuePerShare = 20.00;


function calculatePBRatio($marketPrice, $bookValuePerShare)
{
    // Calculate the P/B ratio
    $pbRatio = $marketPrice / $bookValuePerShare;
    
    return $pbRatio;
}

echo calculatePBRatio($marketPrice,$bookValuePerShare);
?>