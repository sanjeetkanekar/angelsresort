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
        <!-- Breadcrumb Section Begin -->
        <div class="breadcrumb-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcrumb-text">
                            <h2>Checkout</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Breadcrumb Section End -->
        <!-- checkout Section starts -->
        <div class="checkout-section">
            <div class="container">
                <div class="modify-section">
                    <a href="room-details.php">
                        <span class="backicon">
                            <svg xmlns="http://www.w3.org/2000/svg" id="chevron" viewBox="0 0 8 14">
                                <path d="M.68-.04c.173 0 .346.066.48.2L8 7l-6.84 6.84a.677.677 0 01-.96 0 .677.677 0 010-.96L6.08 7 .2 1.12a.675.675 0 010-.96c.13-.134.305-.2.48-.2z"></path>
                            </svg>
                        </span>
                        &nbsp;
                        <span>Modify your booking</span>
                    </a>
                </div>
                <div class="row">
                    <div class="col-lg-5 checkoutleftsection">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <img src="img/gallery/gallery2.jpg" alt="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 rating">
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star-half_alt"></i>
                                </div>
                                <br>
                                <div class="col-lg-6 bldtxt" > Standard Room</div>
                                <div class="col-lg-6 bldtxt righttext"> <?php echo $_SESSION["days"]; if($_SESSION["days"] == 1) { ?> Night <?php } else {  ?> Nights <?php } ?></div>
                            </div>
                            <div class="row roomdetails">
                                <div class="col-lg-7 calendar bldlowertxt">
                                    <i class="fa fa-calendar" style="font-size:15px;"></i>&nbsp; 
                                    <span>
                                    <?php 
                                        $formattedindate=date_create($_SESSION["indate"]);
                                        $formattedoutdate=date_create($_SESSION["outdate"]);
                                        echo date_format($formattedindate,"D, d M");?> - <?php echo date_format($formattedoutdate,"D, d M"); 
                                        ?>
                                    </span>
                                </div>
                                <div class="col-lg-5 bldlowertxt righttext">
                                    <span>
                                    <?php echo $_SESSION["noadults"] + $_SESSION["nochild"] + $_SESSION["extrapax"]; if($_SESSION["noadults"] == 1) { ?> Guest <?php } else {  ?> Guests <?php } ?>
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 pricesection">
                                    <table cellspacing="0" class="costbreakup">
                                        <tbody>
                                            <tr>
                                                <td class="r-o">Room tariff</td>
                                                <td class="r-b"><span>&#8377;</span><?php echo $_SESSION["roomtariff"]; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="r-o">Extra pax Tariff:</td>
                                                <td class="r-b"><span>&#8377;</span><?php echo $_SESSION["extrapaxtariff"]; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="r-o lastprice">GST 12%:</td>
                                                <td class="r-b lastprice"><span>&#8377;</span><?php echo $_SESSION["gsttax"]; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="r-o payment">Payable Amount:</td>
                                                <td class="payment ammount"><span>&#8377;</span><?php echo $_SESSION["grandpayaletotal"]; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 checkoutrightsection">
                        <form action="paylater.php" method="post">
                            <div class="formtitle">Enter Your Details</div>
                            <div class="formsubtitle"><span>We will use these details to share your booking information</span></div>
                            <div class="row chkoutformsection">
                                <div class="col-lg-12">
                                    <label for="fname"><i class="fa fa-user"></i> Full Name</label>
                                    <input type="text" id="fname" name="name" placeholder="John M. Doe">
                                </div>
                                <div class="col-lg-6">
                                    <label for="email"><i class="fa fa-envelope"></i> Email</label>
                                    <input type="text" id="email" name="email" placeholder="john@example.com">
                                </div>
                                <div class="col-lg-6">
                                    <label for="email"><i class="fa fa-phone"></i> Phone</label>
                                    <input type="text" id="number" name="phone" placeholder="9989888900">
                                </div>
                                <div class="col-lg-12">
                                    <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
                                    <input type="text" id="adr" name="address" placeholder="542 W. 15th Street">
                                </div>
                                <div class="col-lg-12">
                                    <label for="adr"><i class="fa fa-comments"></i> Comments</label>
                                    <textarea id="cmt" name="comments" class="comments"></textarea>
                                </div>
                                <input type="hidden" name="payableamount" id="payableamount" value="<?php echo $_SESSION["grandpayaletotal"];?>">
                                <div class="checkoutbtn">
                                    <input type="submit" value="Book Now and Pay Later" class="btn">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- checkout Section ends -->
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
    </body>
</html>