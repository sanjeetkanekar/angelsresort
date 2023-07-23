<?php
require_once "conn.php";
if (!isset($_POST['baseprice_val'])) {
    $fromdate = $_POST['fromdate_val'];
    $todate = $_POST['todate_val'];
    $sql_query = "SELECT * FROM rooms_available where date between '$fromdate' and '$todate'";
    if ($result = $conn ->query($sql_query)) {
    while ($row = $result -> fetch_assoc()) {?>
    <tr>
        <td><?php echo $row['date']; ?></td>
        <td><?php echo $row['total_rooms']; ?></td>
        <td><?php echo $row['rate']; ?></td>
        <td><?php echo $row['extra_pax']; ?></td>
    </tr>
<?php
} } } else { 
    $fromdate = $_POST['fromdate_val'];
    $todate = $_POST['todate_val'];
    $baseprice = $_POST['baseprice_val'];
    $extraprice = $_POST['extraprice_val'];
    $totalrooms = $_POST['totalrooms_val'];

    $sql_queryrooms = "SELECT * FROM rooms_available where date between '$fromdate' and '$todate'";
    $result = $conn ->query($sql_queryrooms);
    while ($row = $result -> fetch_assoc()) {
        $date = $row['date'];
        $daysdifference = abs ($totalrooms  - $row['total_rooms']);
        if ($row['rooms_available'] < $row['total_rooms'] && $totalrooms > $row['total_rooms']) {
            $sql_updatequery = "UPDATE rooms_available SET rooms_available = rooms_available + '$daysdifference', rate = '$baseprice' , extra_pax = '$extraprice' , total_rooms = '$totalrooms' where date = '$date'";
            $conn -> query($sql_updatequery);
        }
        else if ($row['rooms_available'] < $row['total_rooms'] && $totalrooms < $row['total_rooms']) {
            $sql_updatequery = "UPDATE rooms_available SET rooms_available = rooms_available - '$daysdifference', rate = '$baseprice' , extra_pax = '$extraprice' , total_rooms = '$totalrooms' where date = '$date'";
            $conn -> query($sql_updatequery);
        }
        else {
            $sql_updatequery = "UPDATE rooms_available SET rooms_available = '$totalrooms', rate = '$baseprice' , extra_pax = '$extraprice' , total_rooms = '$totalrooms' where date = '$date'";
            $conn -> query($sql_updatequery);
        }
    }

    if ($conn -> query($sql_updatequery)) {
        $sql_query = "SELECT * FROM rooms_available where date between '$fromdate' and '$todate'";
        if ($result = $conn ->query($sql_query)) {
            while ($row = $result -> fetch_assoc()) {?>
            <tr>
                <td><?php echo $row['date']; ?></td>
                <td><?php echo $row['total_rooms']; ?></td>
                <td><?php echo $row['rate']; ?></td>
                <td><?php echo $row['extra_pax']; ?></td>
            </tr>
<?php
            }
        }
    } 
}
?>