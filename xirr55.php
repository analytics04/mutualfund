<?php

 $cashflows = [-2000, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90,47761.81];
 $dates = ['2021-11-22', '2021-12-20', '2022-01-20', '2022-02-21', '2022-03-21', '2022-04-20', '2022-05-22', '2022-06-20', '2022-07-20', '2022-08-22', '2022-09-21', '2022-10-20', '2022-11-21', '2022-12-20', '2023-01-20', '2023-02-21', '2023-03-20', '2023-04-22', '2023-05-20', '2023-06-20', '2023-07-22','2023-08-04'];

 function xirr_func($rate, $cashflows, $dates){
     $result = 0.0;
     for ($i = 0; $i < count($cashflows); $i++) {      
         $time_diff = (strtotime($dates[$i]) - strtotime($dates[0])) / (365 * 24 * 60 * 60);
         $result += $cashflows[$i] / pow(1 + $rate, $time_diff);
     }
    }
     return $result;
 
 function calculate_xirr($cashflows, $dates) {
     $xirr = 0.1; // Initial guess for the rate
     $precision = 0.000001; // Desired precision
     $max_iterations = 1000; // Maximum number of iteration
     for ($i = 0; $i < $max_iterations; $i++) {
         $xirr_new = $xirr - xirr_func($xirr, $cashflows, $dates) / xirr_func_derivative($xirr, $cashflows, $dates);      
         if (abs($xirr_new - $xirr) < $precision) {
             return $xirr_new;
         
         $xirr = $xirr_new;
         }
     return null; // XIRR calculation did not converge
 }
}


 function xirr_func_derivative($rate, $cashflows, $dates) {
     $result = 0.0;
     for ($i = 0; $i < count($cashflows); $i++) {
         $time_diff = (strtotime($dates[$i]) - strtotime($dates[0])) / (365 * 24 * 60 * 60);
         $result -= $time_diff * $cashflows[$i] / pow(1 + $rate, $time_diff + 1);
     }
     return $result;
 
 $xirr = calculate_xirr($cashflows, $dates);
 if ($xirr !== null) {
     echo "XIRR: " . ($xirr*100) . "\n";
 } else {
     echo "XIRR calculation did not converge.\n";
 }
 ?>


//$cashflows = [-2000, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.//90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90,47761.81];
//$dates = ['2021-11-22', '2021-12-20', '2022-01-20', '2022-02-21', '2022-03-21', '2022-04-20', '2022-05-22', '2022-06-20', '2022-07-20', //'2022-08-22', '2022-09-21', '2022-10-20', '2022-11-21', '2022-12-20', '2023-01-20', '2023-02-21', '2023-03-20', '2023-04-22', '2023-05-20', //'2023-06-20', '2023-07-22','2023-08-04'];
//$unit = ['5.858','6.165','5.766','5.984','6.035','6.003','6.404','6.611','6.177','5.868','5.746','5.821','5.678'];
//$count =5;
//$rates =0.01;

//function xirr_func($rate, $cashflows, $dates) {
         //$result = 0.0;
         //for ($i = 0; $i < count($cashflows); $i++) {
            
            //$time_diff = (strtotime($dates[$i]) - strtotime($dates[0])) / (365 * 24 * 60 * 60);
            //$result += $cashflows[$i] / pow(1 + $rate, $time_diff);
        //}
    //}
         //return $result;
//function Xirr2($rate, $cashflows, $dates,$unit,$count,$currentnav) {
//    $result = 0.0;
//    $cash =0;
//    $units =0;
//    for ($i = 0; $i < count($count); $i++) {
//        $time_diff = (strtotime($dates[$i]) - strtotime($dates[0])) / (365 * 24 * 60 * 60);
//        $result += $cashflows[$i] / pow(1 + $rate, $time_diff);
//        $cash += $cashflows[$i];
//        $units += $unit[$i];
//        $x = $cash * ($currentnav*$units);
//    }
//    return $x;
//}
//
//print_r(Xirr2($rates,$cashflows, $dates,$unit,$count,'347'))
//?>
//

