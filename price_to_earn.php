
<?php
$marketPrice = 500;
$earningsPerShare = 20;

function calculatePERatio($marketPrice, $earningsPerShare)
{
    // Calculate the P/E ratio
    $peRatio = $marketPrice / $earningsPerShare;
    
    return $peRatio;
}

echo calculatePERatio($marketPrice,$earningsPerShare);