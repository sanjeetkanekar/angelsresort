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
        <title>Angels Resort Goa India</title>
        <!-- Google Font -->
        <link href="https://fonts.googleapis.com/css?family=Lora:400,700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Cabin:400,500,600,700&display=swap" rel="stylesheet">
        <!-- Css Styles -->
        <link rel="stylesheet" href="https://cdn.usebootstrap.com/bootstrap/4.4.1/css/bootstrap.min.css" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css">
        <link rel="stylesheet" href="css/flaticon.css" type="text/css">
        <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
        <link href="https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/assets/owl.carousel.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/nice-select.css" type="text/css">
        <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
        <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
        <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
        <link href="css/datetime.css" rel="stylesheet" type="text/css">
        <link href="css/t-datepicker-blue.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="css/style.css" type="text/css">
    </head>
    <body>
        <!-- Page Preloder -->
        <!-- <div id="preloder">
            <div class="loader"></div>
        </div> -->
        <!-- Modal -->
        <div class="modal fade" id="mydateModal" role="dialog">
            <div class="modal-dialog">
                <!--Pay Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update Your Selection</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="contact-form">
                        <div class="modal-body">
                            <div class="t-datepicker col-lg-12">
                                <div class="t-check-in"></div>
                                <div class="t-check-out"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" name="dateupdate" class="btn btn-default" onclick="dateupdatevalue()">Update</button>
                        </div>
                    </form>
                </div>
            </div>
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
                                    <a target="_blank" href="https://www.facebook.com/pages/Angels-Resort-Goa/280846135283215"><i class="fa fa-facebook"></i></a>
                                    <!-- <a href="#"><i class="fa fa-twitter"></i></a>
                                        <a href="#"><i class="fa fa-tripadvisor"></i></a> -->
                                    <a target="_blank" href="https://www.instagram.com/angels_resort_goa/"><i class="fa fa-instagram"></i></a>
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
                                <img src="img/angels_logo.svg" alt="">
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
            if (isset($_POST['t-start'])) {
                //post data from check availability
                $indate = $_POST['t-start'];
                $outdate = $_POST['t-end'];
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
            
                // $extrapaxbasetariff = 1000;
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
                        if($rooms_vacant && $row['rooms_available'] >= $rooms){
                            // $Id = $row['id'];
                            // $date = $row['date'];
                            // $rooms_available = $row['rooms_available'];
                            if ($days == 1) {
                                $roombaserate = $row['rate'];
                                $extrapaxbasetariff = $row['extra_pax'];
                                break;
                            }
                            $roombaserate = $row['rate'];
                            $extrapaxbasetariff = $row['extra_pax'];
                            // $rooms_booked = $row['rooms_booked'];
                        } else {
                            $roombaserate = $row['rate'];
                            $extrapaxbasetariff = $row['extra_pax'];
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
                            <input type="text" id="myindate" class="mydate" onclick="openModal()" name="t-start" value="<?php  if (isset($_SESSION['booking'])) {echo $_SESSION["indate"]; } else { echo $indate; } ?>" readonly>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6">
                            <label for="">Check-out Date:</label>
                            <input name="t-end" id="myoutdate" type="text" class="mydate" onclick="openModal()" value="<?php  if (isset($_SESSION['booking'])) {echo $_SESSION["outdate"]; } else { echo $outdate; } ?>" readonly>
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
                            <button class="searchbtn" type="submit">Update Booking</button>
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
                                <input type="text" id="myindate1" class="mydate" onclick="openModal()" name="t-start" value="<?php  if (isset($_SESSION['booking'])) {echo $_SESSION["indate"]; } else { echo $indate; } ?>" readonly>
                            </div>
                            <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6">
                                <label for="">Check-out Date:</label>
                                <input name="t-end" id="myoutdate1" type="text" class="mydate" onclick="openModal()" value="<?php  if (isset($_SESSION['booking'])) {echo $_SESSION["outdate"]; } else { echo $outdate; } ?>" readonly>
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
                        <img src="img/gallery/gallery2.jpg" alt="">
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
                                                <!-- <tr>
                                                    <td class="r-o">Size:</td>
                                                    <td>30 ft</td>
                                                    </tr> -->
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
                </div>
            </div>
        </section>
        <!-- Room Details Section End -->
        <!-- Testimonial Section Begin -->
        <section id="testimonial" class="testimonial-section spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <span>Testimonials</span>
                            <h2>What Customers Say?</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <div class="testimonial-slider owl-carousel">
                            <div class="ts-item">
                                <p>Lovely place. Rooms n service was excellent. Girish at the receptionist was the best. Always smiling n greeting people. Moreover. The owner Mr. REBELLO N his manager Mr.shankar were very good n friendly. Highly recommended n will definitely come back again.</p>
                                <div class="ti-author">
                                    <div class="rating">
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <!-- <i class="icon_star-half_alt"></i> -->
                                    </div>
                                    <h5> - Joyce Passanha</h5>
                                </div>
                                <!-- <img src="img/testimonial-logo.png" alt=""> -->
                            </div>
                            <div class="ts-item">
                                <p>Superb place to stay in Goa. very clean place. very polite staff. good bar and good food served. outside the place everything available easily at your reach. pls. Thanks for a good managerial staff who look to the nitty nitty things of their guests.</p>
                                <div class="ti-author">
                                    <div class="rating">
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <!-- <i class="icon_star-half_alt"></i> -->
                                    </div>
                                    <h5> - Sunil Menezes</h5>
                                </div>
                                <!-- <img src="img/testimonial-logo.png" alt=""> -->
                            </div>
                            <div class="ts-item">
                                <p>We have been regular guests at this resort since 2014 and we love it. It has always been a great experience. Good cleanliness, hygiene, great food, beautiful property.</p>
                                <div class="ti-author">
                                    <div class="rating">
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <!-- <i class="icon_star-half_alt"></i> -->
                                    </div>
                                    <h5> - Meenakshi Gokhale</h5>
                                </div>
                                <!-- <img src="img/testimonial-logo.png" alt=""> -->
                            </div>
                            <div class="ts-item">
                                <p>My experience with angels resort was awesome and very positive. I strongly recommend this place to my friends and family. Food was great but I prefer to try local delegacy if you order curry of any type ask them to make it in coconut curry it was delicious 😋</p>
                                <div class="ti-author">
                                    <div class="rating">
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <!-- <i class="icon_star-half_alt"></i> -->
                                    </div>
                                    <h5> - Sharta Power</h5>
                                </div>
                                <!-- <img src="img/testimonial-logo.png" alt=""> -->
                            </div>
                            <div class="ts-item">
                                <p>This place is situated at a prime spot in Porvorim. It was my first time exploring Angel's resort this Easter, and I was wowed by the way this facility has been maintained. A shout-out to my friend Charlotte Rodrigues for introducing me to this heaven!!.</p>
                                <div class="ti-author">
                                    <div class="rating">
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <!-- <i class="icon_star-half_alt"></i> -->
                                    </div>
                                    <h5> - Olson Pereira</h5>
                                </div>
                                <!-- <img src="img/testimonial-logo.png" alt=""> -->
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
                                    <a href="index.php">
                                    <img src="img/angels_footerlogo.svg" alt="">
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
                                    <li>Angels Resort, Chogm Road, Alto de Porvorim, Bardez - Goa. 403 521, INDIA.</li>
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
                    <div class="col-lg-4 text-left">
                            <div class="co-text">
                                <p>
                                    Powered By <a href="https://dcove.co.in/" target="_blank">DCOVE</a>
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-4" style="text-align:center;">
                            <div class="co-text">
                                <p>
                                    Angels Resort &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved</a>
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 text-right">
                            <div class="fa-social">
                                <a target="_blank" href="https://www.facebook.com/pages/Angels-Resort-Goa/280846135283215"><i class="fa fa-facebook"></i></a>
                                <a target="_blank" href="https://www.instagram.com/angels_resort_goa/"><i class="fa fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Footer Section End -->
        <!-- Js Plugins -->
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="https://cdn.usebootstrap.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.sticky/1.0.3/jquery.sticky.min.js"></script>
        <script src="js/jquery.nice-select.min.js"></script>
        <script src="js/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/SlickNav/1.0.10/jquery.slicknav.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/owl.carousel.min.js"></script>
        <script src="js/t-datepicker.min.js"></script>
        <script src="js/main.js"></script>
        <script>
            $(document).ready(function(){
               // Call global the function
               $('.t-datepicker').tDatePicker({
                 // options here
               });
             });
        </script>
        <script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-36251023-1']);
            _gaq.push(['_setDomainName', 'jqueryscript.net']);
            _gaq.push(['_trackPageview']);
            
            (function() {
              var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
              ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
              var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
            
        </script>
    </body>
</html>