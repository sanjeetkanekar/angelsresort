<?php
 require_once "conn.php";

 $yearEnd = date('Y-m-d', strtotime('Dec 31'));
 echo $yearEnd;

 $currentdate = date('Y-m-d');
 echo $currentdate;

 $start_date = date_create('2023-06-29');
$end_date = date_create('2024-01-1');

 $interval = new DateInterval('P1D');

 $date_range = new DatePeriod($start_date, $interval, $end_date);

foreach ($date_range as $date) {
    // echo $date->format('Y-m-d') . "\n";
    $testdate = $date->format('Y-m-d');
    $updaterooms = "INSERT INTO rooms_available (date) VALUES ('$testdate')";
    $conn -> query($updaterooms);
}
?>