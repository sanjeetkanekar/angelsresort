<?php

require('config.php');
require('conn.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

session_start();

require('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

$success = true;

$error = "Payment Failed";

if (empty($_POST['razorpay_payment_id']) === false)
{
    $api = new Api($keyId, $keySecret);

    try
    {
        // Please note that the razorpay order ID must
        // come from a trusted source (session here, but
        // could be database or something else)
        $attributes = array(
            'razorpay_order_id' => $_SESSION['razorpay_order_id'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
        );

        $api->utility->verifyPaymentSignature($attributes);
    }
    catch(SignatureVerificationError $e)
    {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();
    }
}

if ($success === true && isset($_SESSION["OID"]))
{
    $razorpay_order_id = $_SESSION['razorpay_order_id'];
    $razorpay_payment_id = $_POST['razorpay_payment_id'];
    $email = $_SESSION["email"];
    $name = $_SESSION["name"];

    date_default_timezone_set('Asia/Kolkata');
    $added_on = date('Y-m-d h:i:s');

    $sql = "UPDATE razorpay_bookings SET status='success', razorpay_order_id = '$razorpay_order_id', razorpay_payment_id = '$razorpay_payment_id', added_on = '$added_on' where id = '".$_SESSION["OID"]."'";
    
    if($conn -> query($sql)){
        if ($_SESSION["days"] == 1) {
            $updaterooms = "UPDATE rooms_available SET rooms_available = rooms_available - '".$_SESSION["rooms"]."', rooms_booked = rooms_booked + '".$_SESSION["rooms"]."' where date = '".$_SESSION["indate"]."'";
        }else {
            $updaterooms = "UPDATE rooms_available SET rooms_available = rooms_available - '".$_SESSION["rooms"]."', rooms_booked = rooms_booked + '".$_SESSION["rooms"]."' where date >= '".$_SESSION["indate"]."' AND date < '".$_SESSION["outdate"]."'";
        }
        if($conn -> query($updaterooms)){
            $totalperson = $_SESSION["noadults"] + $_SESSION["nochild"] + $_SESSION["extrapax"];
            $adminemail = "sanjeet.kanekar339@gmail.com";
            $mail = new PHPMailer(true);
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'kanekarsanjeet@gmail.com';                     //SMTP username
            $mail->Password   = 'viwlgmocaugzxwub';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you 

            $mail->setFrom('kanekarsanjeet@gmail.com');

            $mail->addAddress($email);     //Add a recipient

            $mail->isHTML(true); 

            $mail->Subject = "Hotel Booking Confirmation";
            $mail->Body    =  
            "<html>
                <body>
                    <p><b>	Dear ".$name.",</b></p>
                    <p>We are delighted to confirm your hotel booking at Angels Resort, Porvorim - Goa! We appreciate your choice and look forward to providing you with a comfortable and enjoyable stay.</p>
                    <p>
                        <b>Booking Details:</b><br>
                        <b>Check-in Date:</b> ".$_SESSION["indate"]."<br>
                        <b>Check-out Date:</b> ".$_SESSION["outdate"]."<br>
                        <b>Room Type:</b> Standard <br>
                        <b>Number of Rooms:</b> ".$_SESSION["rooms"]."<br>
                        <b>Number of Guests:</b> ".$totalperson."
                    </p>
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
                            <b>Contact Number:</b> ".$_SESSION["phone"]."<br>
                            <b>Check-in Date:</b> ".$_SESSION["indate"]."<br>
                            <b>Check-out Date:</b> ".$_SESSION["outdate"]."<br>
                            <b>Room Type:</b> Standard <br>
                            <b>Number of Guests:</b> ".$totalperson."<br>
                            <b>Comments by Customer:</b> ".$_SESSION["comments"]."
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
                                    <div class="fetched-data"><b>Payment ID:</b> <?php echo $_POST['razorpay_payment_id']; ?></div> 
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
        <?php
        }
        else {
            echo "table update failed";
       echo("Error description: " . $conn -> error);
        }
    // } else {
    //     echo "payment insert failed";
    //     echo("Error description: " . $conn -> error);
    // }
    }
}
else
{
    $sql = "UPDATE razorpay_bookings SET status='failed', razorpay_order_id = '$razorpay_order_id', razorpay_payment_id = '$razorpay_payment_id', added_on = '$added_on' where id = '".$_SESSION["OID"]."'";
    if($conn -> query($sql)){
    $html = "<p>Your payment failed</p>
             <p>{$error}</p>";
    }
}

// echo $html;
