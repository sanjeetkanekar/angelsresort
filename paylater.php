<?php
require('conn.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

session_start();

if (isset($_POST["name"]) && isset($_POST["payableamount"])) {
    $email = $_SESSION["email"] = $_POST["email"];
    $name = $_SESSION["name"] = $_POST["name"];
    $phone = $_SESSION["phone"] = $_POST["phone"];
    $_SESSION["comments"] = $_POST["comments"];
    $payamount = $_SESSION["payableamount"] = $_POST["payableamount"];
    date_default_timezone_set('Asia/Kolkata');
    $added_on = date('Y-m-d h:i:s');
    $booking_id = $_SESSION["booking_id"] = "angels".uniqid();
    $formattedindate=date_create($_SESSION["indate"]);
    $formattedoutdate=date_create($_SESSION["outdate"]);
    $emailindate = date_format($formattedindate,"d-M-Y");
    $emailoutdate = date_format($formattedoutdate,"d-M-Y");

    $sql = "INSERT INTO razorpay_bookings (booking_id, customer_name, customer_email, customer_phone, booking_amount, added_on, status) VALUES ('$booking_id', '$name', '$email',  $phone , $payamount ,'$added_on','pending')";
    if($conn -> query($sql)){
        if ($_SESSION["days"] == 1) {
            $updaterooms = "UPDATE rooms_available SET rooms_available = rooms_available - '".$_SESSION["rooms"]."', rooms_booked = rooms_booked + '".$_SESSION["rooms"]."' where date = '".$_SESSION["indate"]."'";
        }else {
            $updaterooms = "UPDATE rooms_available SET rooms_available = rooms_available - '".$_SESSION["rooms"]."', rooms_booked = rooms_booked + '".$_SESSION["rooms"]."' where date >= '".$_SESSION["indate"]."' AND date < '".$_SESSION["outdate"]."'";
        }
        if($conn -> query($updaterooms)){
            $totalperson = $_SESSION["noadults"] + $_SESSION["nochild"] + $_SESSION["extrapax"];
            $adminemail = "info@dcove.co.in";
            $mail = new PHPMailer(true);
            $mail->isSMTP();   
            $mail->SMTPSecure = 'ssl';                                         //Send using SMTP
            $mail->Host       = 'mail.dcove.co.in';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'info@dcove.co.in';                     //SMTP username
            $mail->Password   = 'Dc11In22$$##';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you 

            $mail->setFrom('info@dcove.co.in');

            $mail->addAddress($email);     //Add a recipient
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => false
                )
            );

            $mail->isHTML(true); 

            $mail->Subject = "Hotel Booking Confirmation";
            $mail->Body    =  
            "<html>
                <body>
                    <p><b>	Dear Sir/Madam ,</b></p>
                    <p>We are delighted to confirm your hotel booking at Angels Resort, Porvorim - Goa! We appreciate your choice and look forward to providing you with a comfortable and enjoyable stay.</p>
                    <p>
                        <b>Booking Details</b><br>
                        <hr>
                        <b>Booking ID:</b> ".$booking_id."<br>
                        <b>Check-in Date:</b> ".$emailindate."<br>
                        <b>Check-out Date:</b> ".$emailoutdate."<br>
                        <b>Number of Nights:</b> ".$_SESSION["days"]."<br>
                        <b>Room Type:</b> Standard <br>
                        <b>Number of Rooms:</b> ".$_SESSION["rooms"]."<br><br>
                        <b>Traveller Details</b><br>
                        <hr>
                        <b>Number of Travellers:</b> ".$totalperson."<br>
                        <b>Number of Adults:</b> ".$_SESSION["noadults"]."<br>
                        <b>Number of Children:</b> ".$_SESSION["nochild"]."<br><br>
                        <b>Room Tariff Details</b><br>
                        <hr>
                        <b>Room Tariff:</b> Rs. ".$_SESSION["roomtariff"]."<br>
                        <b>Extra Pax Tariff:</b> Rs. ".$_SESSION["extrapaxtariff"]."<br>
                        <b>GST 12%:</b> Rs. ".$_SESSION["gsttax"]."<br>
                        <b>Total amount payable on checkin:</b> Rs. ".$_SESSION["grandpayaletotal"]."
                        <br><br>
                    </p>
                    <p><b>*Booking on Room Basis only (Breakfast charged at the actual)</b></p>
                    <p>If you have any special requests or additional requirements, please let us know, and we will do our best to accommodate them.</p>
                    <p>Thank you for choosing Angels Resort for your accommodation needs. Should you need any assistance, please feel free to contact us at 91-9822793037</p>
                    <p>Regards,</p>
                    <p>Angels Resort</p>
                </body>
            </html>";
            try {
                $mail->send();
                $mail->ClearAllRecipients();
                $mail->Subject = "Booking Confirmation - Customer Name: ".$name."";
                $mail->isHTML(true); 
                $mail->Body= 
                "<html>
                    <body>
                        <p><b>	Dear Admin,</b></p>
                        <p>The details of the booking are as follows:</p>
                        <p>
                            <b>Customer Name:</b> ".$name."<br>
                            <b>Booking Details</b><br>
                            <hr>
                            <b>Booking ID:</b> ".$booking_id."<br>
                            <b>Check-in Date:</b> ".$emailindate."<br>
                            <b>Check-out Date:</b> ".$emailoutdate."<br>
                            <b>Number of Nights:</b> ".$_SESSION["days"]."<br>
                            <b>Room Type:</b> Standard <br>
                            <b>Number of Rooms:</b> ".$_SESSION["rooms"]."<br><br>
                            <b>Traveller Details</b><br>
                            <hr>
                            <b>Number of Travellers:</b> ".$totalperson."<br>
                            <b>Number of Adults:</b> ".$_SESSION["noadults"]."<br>
                            <b>Number of Children:</b> ".$_SESSION["nochild"]."<br><br>
                            <b>Room Tariff Details</b><br>
                            <hr>
                            <b>Room Tariff:</b> Rs. ".$_SESSION["roomtariff"]."<br>
                            <b>Extra Pax Tariff:</b> Rs. ".$_SESSION["extrapaxtariff"]."<br>
                            <b>GST 12%:</b> Rs. ".$_SESSION["gsttax"]."<br>
                            <b>Total amount payable on checkin:</b> Rs. ".$_SESSION["grandpayaletotal"]."
                        </p>
                    </body>
                </html>";
                
                $mail->addAddress($adminemail);
                $mail->Send();

            } catch (Exception $e) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            }
            ?>

            <!DOCTYPE html>
            <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Document</title>
                    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
                    <link rel="stylesheet" href="css/style.css" type="text/css">
                </head>
                <body>
                    <div class="modal fade" id="paymentsuccessModal" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <p>
                                        <svg viewBox="0 0 512 512" width="100" title="check-circle">
                                            <path d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z"></path>
                                        </svg>
                                    </p>
                                    <h4 class="modal-title">Your Booking is Confirmed</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="fetched-data"><b>Booking ID:</b> <?php echo $booking_id; ?></div> 
                                    <div class="fetched-data"><b>Check-In Date:</b> <?php echo $emailindate; ?></div>
                                    <div class="fetched-data"><b>Check-Out Date:</b> <?php echo $emailoutdate; ?></div>
                                </div>
                                <div class="modal-footer">
                                    <button id="payclosebtn" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
                    <script src="js/bootstrap.min.js"></script>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                                $('#paymentsuccessModal').modal('show');
                            });
                        document.getElementById("payclosebtn").onclick = function () {
                            window.location = "index.php";
                        };
                    </script>
                </body>
            </html>
<?php   } else {
            echo("Error description: " . $conn -> error);
        }
    }
    else
    {
        echo("Error description: " . $conn -> error);
    }
}
