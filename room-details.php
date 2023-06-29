<?php
session_start();
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Sona Template">
    <meta name="keywords" content="Sona, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Angels Resort</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Cabin:400,500,600,700&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/flaticon.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
    <header id="menu" class="header-section">
        <div class="top-nav">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <ul class="tn-left">
                            <li><img class="watsapp" src="img/whatsapp.svg" alt="">91-9822793037</li>
                            <li><i class="fa fa-envelope"></i>angelsgoa@gmail.com</li>
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <div class="tn-right">
                            <div class="top-social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-tripadvisor"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="lowernav" class="menu-item room-detailsmenu">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2">
                        <div class="logo">
                            <a href="./index.php">
                                <img src="img/logo1.svg" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header End -->

    <?php 
        require_once "conn.php";
        $_SESSION["booking"] = false;
        // print_r($_POST);
        if (isset($_POST['indate'])) {
            //post data from check availability
            $indate = $_POST['indate'];
            $outdate = $_POST['outdate'];
            $noadults = $_POST['noadults'];
            $nochild = $_POST['nochild'];
            $extrapax = $_POST['extrapax'];
            $rooms = $_POST['rooms'];

            $_SESSION["booking"] = false;
            $_SESSION["indate"] = $indate;
            $_SESSION["outdate"] = $outdate;
            $_SESSION["noadults"] = $noadults;
            $_SESSION["nochild"] = $nochild;
            $_SESSION["extrapax"] = $extrapax;
            $_SESSION["rooms"] = $rooms;

            $extrapaxbasetariff = 1000;
            $gstpercentage = 12;
            $rooms_vacant = true;

            $date1 = strtotime($indate);
            $date2 = strtotime($outdate);
            $diff = $date2 - $date1;
            $days = floor($diff / (60 * 60 * 24));
            $_SESSION["days"] = $days;
            // echo $days;

            $sql_query = "SELECT * FROM rooms_available where date between '$indate' and '$outdate'";
            if ($result = $conn ->query($sql_query)) {
                while ($row = $result -> fetch_assoc()) {
                    // print_r($row);
                    if($rooms_vacant && $row['rooms_available'] > 0 && $row['rooms_available'] >= $rooms){
                        $Id = $row['id'];
                        $date = $row['date'];
                        $rooms_available = $row['rooms_available'];
                        $roombaserate = $row['rate'];
                        $rooms_booked = $row['rooms_booked'];
                    } else {
                        $roombaserate = $row['rate'];
                        $rooms_vacant = false;
                    }
                }     
            }

            $_SESSION["rooms_vacant"] = $rooms_vacant;

            $roomtariff = $roombaserate * $days * $rooms;
            $_SESSION["roomtariff"] = $roomtariff;

            if($extrapax == 1) {
                $extrapaxtariff = $extrapaxbasetariff * $days * $rooms;
            } else {
                $extrapaxtariff = 0;
            }
            $_SESSION["extrapaxtariff"] = $extrapaxtariff;

            $basegrandtotal = $roomtariff + $extrapaxtariff;

            $gsttax = ($gstpercentage / 100) * $basegrandtotal;
            $_SESSION["gsttax"] = $gsttax;

            $grandpayaletotal = $basegrandtotal + $gsttax;
            $_SESSION["grandpayaletotal"] = $grandpayaletotal;

            $pricepernight = $basegrandtotal / ($days * $rooms) ;
            $_SESSION["pricepernight"] = $pricepernight;

        } else {
            $_SESSION["booking"] = true;
        }
    ?>

    <!-- Breadcrumb Section Begin -->
    <div id="breadcrumb" class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Our Rooms</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <a class="bookingmodify" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
    Modify your booking
  </a>

    <div class="currentsearch-section">
        <div id="currentsearch" class="container">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="contact-form">
                <div class="row">
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6">
                        <label for="">Check-in Date:</label>
                        <input name="indate" type="date" value="<?php  if (isset($_SESSION['booking'])) {echo $_SESSION["indate"]; } else { echo $indate; } ?>">
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6">
                        <label for="">Check-out Date:</label>
                        <input name="outdate" type="date" value="<?php  if (isset($_SESSION['booking'])) {echo $_SESSION["outdate"]; } else { echo $outdate; } ?>">
                    </div>
                    <div class="col-lg-1 col-md-6 col-sm-6 col-xs-3">
                        <label for="">Adults:</label>
                        <select name="noadults" class="box">
                            <option <?php if (isset($_SESSION['booking'])) { if($_SESSION["noadults"] == 0){ echo ' selected="selected"'; }} else {if($noadults == 0){ echo ' selected="selected"';}}?> value="0">0</option>
                            <option <?php if (isset($_SESSION['booking'])) { if($_SESSION["noadults"] == 1){ echo ' selected="selected"'; }} else {if($noadults == 1){ echo ' selected="selected"';}}?> value="1">1</option>
                            <option <?php if (isset($_SESSION['booking'])) { if($_SESSION["noadults"] == 2){ echo ' selected="selected"'; }} else {if($noadults == 2){ echo ' selected="selected"';}}?> value="2">2</option>
                        </select>
                    </div>
                    <div class="col-lg-1 col-md-6 col-sm-6 col-xs-3">
                        <label for="">Children:</label>
                        <select name="nochild" class="box">
                            <option <?php if (isset($_SESSION['booking'])) { if($_SESSION["nochild"] == 0){ echo ' selected="selected"'; }} else {if($nochild == 0){ echo ' selected="selected"';}}?> value="0">0</option>
                            <option <?php if (isset($_SESSION['booking'])) { if($_SESSION["nochild"] == 1){ echo ' selected="selected"'; }} else {if($nochild == 1){ echo ' selected="selected"';}}?> value="1">1</option>
                            <option <?php if (isset($_SESSION['booking'])) { if($_SESSION["nochild"] == 2){ echo ' selected="selected"'; }} else {if($nochild == 2){ echo ' selected="selected"';}}?> value="2">2</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-3">
                        <label for="">Extra person:</label>
                        <select name="extrapax" class="box">
                            <option <?php if (isset($_SESSION['booking'])) { if($_SESSION["extrapax"] == 0){ echo ' selected="selected"'; }} else {if($extrapax == 0){ echo ' selected="selected"';}}?> value="0">0</option>
                            <option <?php if (isset($_SESSION['booking'])) { if($_SESSION["extrapax"] == 1){ echo ' selected="selected"'; }} else {if($extrapax == 1){ echo ' selected="selected"';}}?> value="1">1</option>
                        </select>
                    </div>
                    <div class="col-lg-1 col-md-6 col-sm-6 col-xs-3">
                        <label for="">Rooms:</label>
                        <select name="rooms" class="box">
                            <option <?php if (isset($_SESSION['booking'])) { if($_SESSION["rooms"] == 1){ echo ' selected="selected"'; }} else {if($rooms == 1){ echo ' selected="selected"';}}?> value="1">1</option>
                            <option <?php if (isset($_SESSION['booking'])) { if($_SESSION["rooms"] == 2){ echo ' selected="selected"'; }} else {if($rooms == 2){ echo ' selected="selected"';}}?> value="2">2</option>
                            <option <?php if (isset($_SESSION['booking'])) { if($_SESSION["rooms"] == 3){ echo ' selected="selected"'; }} else {if($rooms == 3){ echo ' selected="selected"';}}?> value="3">3</option>
                            <option <?php if (isset($_SESSION['booking'])) { if($_SESSION["rooms"] == 4){ echo ' selected="selected"'; }} else {if($rooms == 4){ echo ' selected="selected"';}}?> value="4">4</option>
                            <option <?php if (isset($_SESSION['booking'])) { if($_SESSION["rooms"] == 5){ echo ' selected="selected"'; }} else {if($rooms == 5){ echo ' selected="selected"';}}?> value="5">5</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                    <label for=""></label>
                        <button class="searchbtn" type="submit">Check Availability</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</p>
<div class="collapse" id="collapseExample">
  <div class="currentsearch-mobsection">
        <div id="currentsearch" class="container">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="contact-form">
                <div class="row">
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6">
                        <label for="">Check-in Date:</label>
                        <input name="indate" type="date" value="<?php  if (isset($_SESSION['booking'])) {echo $_SESSION["indate"]; } else { echo $indate; } ?>">
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6">
                        <label for="">Check-out Date:</label>
                        <input name="outdate" type="date" value="<?php  if (isset($_SESSION['booking'])) {echo $_SESSION["outdate"]; } else { echo $outdate; } ?>">
                    </div>
                    <div class="col-lg-1 col-md-6 col-sm-6 col-xs-3">
                        <label for="">Adults:</label>
                        <select name="noadults" class="box">
                            <option <?php if (isset($_SESSION['booking'])) { if($_SESSION["noadults"] == 0){ echo ' selected="selected"'; }} else {if($noadults == 0){ echo ' selected="selected"';}}?> value="0">0</option>
                            <option <?php if (isset($_SESSION['booking'])) { if($_SESSION["noadults"] == 1){ echo ' selected="selected"'; }} else {if($noadults == 1){ echo ' selected="selected"';}}?> value="1">1</option>
                            <option <?php if (isset($_SESSION['booking'])) { if($_SESSION["noadults"] == 2){ echo ' selected="selected"'; }} else {if($noadults == 2){ echo ' selected="selected"';}}?> value="2">2</option>
                        </select>
                    </div>
                    <div class="col-lg-1 col-md-6 col-sm-6 col-xs-3">
                        <label for="">Children:</label>
                        <select name="nochild" class="box">
                            <option <?php if (isset($_SESSION['booking'])) { if($_SESSION["nochild"] == 0){ echo ' selected="selected"'; }} else {if($nochild == 0){ echo ' selected="selected"';}}?> value="0">0</option>
                            <option <?php if (isset($_SESSION['booking'])) { if($_SESSION["nochild"] == 1){ echo ' selected="selected"'; }} else {if($nochild == 1){ echo ' selected="selected"';}}?> value="1">1</option>
                            <option <?php if (isset($_SESSION['booking'])) { if($_SESSION["nochild"] == 2){ echo ' selected="selected"'; }} else {if($nochild == 2){ echo ' selected="selected"';}}?> value="2">2</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-3">
                        <label for="">Extra person:</label>
                        <select name="extrapax" class="box">
                            <option <?php if (isset($_SESSION['booking'])) { if($_SESSION["extrapax"] == 0){ echo ' selected="selected"'; }} else {if($extrapax == 0){ echo ' selected="selected"';}}?> value="0">0</option>
                            <option <?php if (isset($_SESSION['booking'])) { if($_SESSION["extrapax"] == 1){ echo ' selected="selected"'; }} else {if($extrapax == 1){ echo ' selected="selected"';}}?> value="1">1</option>
                        </select>
                    </div>
                    <div class="col-lg-1 col-md-6 col-sm-6 col-xs-3">
                        <label for="">Rooms:</label>
                        <select name="rooms" class="box">
                            <option <?php if (isset($_SESSION['booking'])) { if($_SESSION["rooms"] == 1){ echo ' selected="selected"'; }} else {if($rooms == 1){ echo ' selected="selected"';}}?> value="1">1</option>
                            <option <?php if (isset($_SESSION['booking'])) { if($_SESSION["rooms"] == 2){ echo ' selected="selected"'; }} else {if($rooms == 2){ echo ' selected="selected"';}}?> value="2">2</option>
                            <option <?php if (isset($_SESSION['booking'])) { if($_SESSION["rooms"] == 3){ echo ' selected="selected"'; }} else {if($rooms == 3){ echo ' selected="selected"';}}?> value="3">3</option>
                            <option <?php if (isset($_SESSION['booking'])) { if($_SESSION["rooms"] == 4){ echo ' selected="selected"'; }} else {if($rooms == 4){ echo ' selected="selected"';}}?> value="4">4</option>
                            <option <?php if (isset($_SESSION['booking'])) { if($_SESSION["rooms"] == 5){ echo ' selected="selected"'; }} else {if($rooms == 5){ echo ' selected="selected"';}}?> value="5">5</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <button class="searchbtn" type="submit">Check Availability</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
    

    <!-- Room Details Section Begin -->
    <section id="roomdetails" class="room-details-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 img-container">
                    <img src="img/room1.jpg" alt="">
                </div>
                <div class="col-lg-6">
                    <div class="room-details-item">
                        
                        <div class="rd-text">
                            <div class="rd-title">
                                <h3>Standard Room</h3>
                                <div class="rdt-right">
                                    <div class="rating">
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star-half_alt"></i>
                                    </div>
                                </div>
                                <p class="f-para">"Comfort and Style Combined: Experience Unparalleled Comfort in our Standard Rooms, Designed to Cater to Your Every Need."</p>
                            </div>
                            <div class="row bookindetails">
                                <div class="col-lg-5 col-sm-4 col-xs-6 bookingdetailsspecific" align="center">
                                <i class="fa fa-calendar" style="font-size:15px;"></i>&nbsp; 
                                    <span>
                                        <?php 
                                        if (isset($_SESSION['booking'])) {
                                            $formattedindate=date_create($_SESSION["indate"]);
                                            $formattedoutdate=date_create($_SESSION["outdate"]);
                                        }else {
                                            $formattedindate=date_create($indate);
                                            $formattedoutdate=date_create($outdate);
                                        }
                                        echo date_format($formattedindate,"D, d M");; ?> - <?php echo date_format($formattedoutdate,"D, d M");
                                        ?>
                                    </span>
                                </div>
                                <div class="col-lg-2 col-sm-3 col-xs-6 bookingdetailsspecific" align="center">
                                    <span>
                                        <?php if (isset($_SESSION['booking'])) { echo $_SESSION["days"]; $days; if($_SESSION["days"] == 1) { ?> Night <?php } else {  ?> Nights <?php }} else {echo $days; if($days == 1) { ?> Night <?php } else {  ?> Nights <?php }} ?>
                                    </span>
                                </div>
                                <div class="col-lg-2 col-sm-3 col-xs-6 bookingdetailsspecific" align="center">
                                    <span>
                                        <?php if (isset($_SESSION['booking'])) { echo $_SESSION["noadults"] + $_SESSION["nochild"] + $_SESSION["extrapax"]; if($_SESSION["noadults"] == 1) { ?> Guest <?php } else {  ?> Guests <?php } } else { echo $noadults + $nochild + $extrapax; if($noadults == 1) { ?> Guest <?php } else {  ?> Guests <?php }}?>
                                    </span>
                                </div>
                                <div class="col-lg-2 col-sm-2 col-xs-6 bookingdetailsspecific" align="center">
                                    <span>
                                        <?php if (isset($_SESSION['booking'])) { echo $_SESSION["rooms"]; if($_SESSION["rooms"] == 1) { ?> Room <?php } else {  ?> Rooms <?php } } else { echo $rooms; if($rooms == 1) { ?> Room <?php } else {  ?> Rooms <?php }} ?>
                                    </span>
                                </div>
                            </div>
                            <div class="row pricedetails">
                                <div class="col-lg-7 col-sm-6 col-xs-12">
                                    <p>Room Details:</p>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td class="r-o">Size:</td>
                                                <td>30 ft</td>
                                            </tr>
                                            <tr>
                                                <td class="r-o">Capacity:</td>
                                                <td>Max Adults 2</td>
                                            </tr>
                                            <tr>
                                                <td class="r-o">Bed:</td>
                                                <td>King Beds</td>
                                            </tr>
                                            <tr>
                                                <td class="r-o">Services:</td>
                                                <td>Wifi, Television, Bathroom,...</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-5 col-sm-6 col-xs-12 pricesection">
                                    <h2>&#8377; <?php if (isset($_SESSION['booking'])) {echo $_SESSION["pricepernight"];}else{echo $pricepernight;}?><span>/ Pernight</span></h2>
                                    <table cellspacing="0" align="right" class="costbreakup">
                                        <tbody>
                                            <tr>
                                                <td class="r-o">Room tariff</td>
                                                <td><span>&#8377;</span><?php if (isset($_SESSION['booking'])) {echo $_SESSION["roomtariff"];}else{echo $roomtariff;} ?></td>
                                            </tr>
                                            <tr>
                                                <td class="r-o">Extra pax Tariff:</td>
                                                <td><span>&#8377;</span><?php if (isset($_SESSION['booking'])) {echo $_SESSION["extrapaxtariff"];}else{echo $extrapaxtariff;} ?></td>
                                            </tr>
                                            <tr>
                                                <td class="r-o">GST 12%:</td>
                                                <td><span>&#8377;</span><?php if (isset($_SESSION['booking'])) {echo $_SESSION["gsttax"];}else{echo $gsttax;} ?></td>
                                            </tr> 
                                            <tr>
                                                <td class="r-o payment">Payable Amount:</td>
                                                <td class="payment"><span>&#8377;</span><?php if (isset($_SESSION['booking'])) {echo $_SESSION["grandpayaletotal"];}else{echo $grandpayaletotal;} ?></td>
                                            </tr>                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <form action="checkout.php">
                                <input type="hidden">
                                <?php
                                if (isset($_SESSION['booking'])){
                                    if ($_SESSION["rooms_vacant"]) {
                                ?>
                                    <button type="submit">Book Now</button>
                                <?php
                                    } else {
                                ?>
                                    <button type="submit" disabled>Sold Out</button>
                                <?php
                                    }
                                }
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <!-- <div class="room-booking">
                        <h3>Your Reservation</h3>
                        <form action="#">
                            <div class="check-date">
                                <label for="date-in">Check In:</label>
                                <input type="text" class="date-input" id="date-in">
                                <i class="icon_calendar"></i>
                            </div>
                            <div class="check-date">
                                <label for="date-out">Check Out:</label>
                                <input type="text" class="date-input" id="date-out">
                                <i class="icon_calendar"></i>
                            </div>
                            <div class="select-option">
                                <label for="guest">Guests:</label>
                                <select id="guest">
                                    <option value="">3 Adults</option>
                                </select>
                            </div>
                            <div class="select-option">
                                <label for="room">Room:</label>
                                <select id="room">
                                    <option value="">1 Room</option>
                                </select>
                            </div>
                            <button type="submit">Check Availability</button>
                        </form>
                    </div> -->
                </div>
            </div>
        </div>
    </section>
    <!-- Room Details Section End -->

     <!-- Testimonial Section Begin -->
 <section id="testimonial" class="testimonial-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title test-section-title">
                    <span>Testimonials</span>
                    <h2>What Customers Say?</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="testimonial-slider owl-carousel">
                    <div class="ts-item">
                        <p>Was amazed to see such a huge space with so many cottages. Very clean and well maintained. Lot of trees and plants around. Attached restaurant served good food. There are options to eat outside as well as this is right next to the main road. 20-30 mins drive from the calagunte Baga anjuna et al beaches but i preferred staying here in peace away from the crowd and mayhem and driving down. Had my own car. Panaji was just 20 mins away. Good service.</p>
                        <div class="ti-author">
                            <div class="rating">
                                <i class="icon_star"></i>
                                <i class="icon_star"></i>
                                <i class="icon_star"></i>
                                <i class="icon_star"></i>
                                <i class="icon_star"></i>
                                <!-- <i class="icon_star-half_alt"></i> -->
                            </div>
                            <h5> - TravelAway111</h5>
                        </div>
                        <img src="img/testimonial-logo.png" alt="">
                    </div>
                    <div class="ts-item">
                        <p>Wonderful & peaceful place to enjoy a good breakfast or full meal. Short but exquisite menu. Ample place for social distance. Soothing Live music in the evening. Excellent service, combined with equally great food. Had Chinese veg and non veg cuisine. Enjoyed it. An evening well spent. Our steward for the evening Mr. Ladu served us well with a beautiful smile. Also pleasently surprised by the complimentary desert. Thank you "Angeles Resort".</p>
                        <div class="ti-author">
                            <div class="rating">
                                <i class="icon_star"></i>
                                <i class="icon_star"></i>
                                <i class="icon_star"></i>
                                <i class="icon_star"></i>
                                <i class="icon_star"></i>
                                <!-- <i class="icon_star-half_alt"></i> -->
                            </div>
                            <h5> - madan d</h5>
                        </div>
                        <img src="img/testimonial-logo.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Testimonial Section End -->

    <!-- Footer Section Begin -->
    <footer class="footer-section">
        <div class="container">
            <div class="footer-text">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="ft-about">
                            <div class="logo">
                                <a href="#">
                                    <img src="img/logo1.svg" alt="">
                                </a>
                            </div>
                            <p>Indulge in Unforgettable Luxury at Angels Resort</p>
                        </div>
                    </div>
                    <div class="col-lg-3 offset-lg-1">
                        <div class="ft-contact">
                            <h6>Contact Us</h6>
                            <ul>
                                <li>91-9822793037 / 91-7083394505</li>
                                <li>angelsgoa@gmail.com</li>
                                <li>Chogm Road, Alto de Porvorim, Bardez - Goa. 403 521, INDIA.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 offset-lg-1">
                        <div class="ft-usefullinks">
                            <h6>Usefull Links</h6>
                            <ul>
                                <li><a class="smoothScroll" href="#services">Facilities</a></li>
                                <li><a class="smoothScroll" href="#rooms">Accomodation</a></li>
                                <li><a class="smoothScroll" href="#reservation">Reservations</a></li>
                                <li><a class="smoothScroll" href="#tariff">Tariff</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-option">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 text-left">
                        <div class="co-text"><p>Angels Resort &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved</a></p></div>
                    </div>
                    <div class="col-lg-6 text-right">
                        <div class="fa-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-tripadvisor"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Search model Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch"><i class="icon_close"></i></div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search model end -->

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.sticky/1.0.3/jquery.sticky.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>