<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if(isset($_POST["send"])) {
	$mail = new PHPMailer(true);
	$mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'kanekarsanjeet@gmail.com';                     //SMTP username
    $mail->Password   = 'viwlgmocaugzxwub';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you 

    $mail->setFrom('kanekarsanjeet@gmail.com');

    $mail->addAddress($_POST['toemail']);     //Add a recipient

	$mail->isHTML(true); 

	$mail->Subject = "Hotel Booking Confirmation";
    $mail->Body    =  
    "<html>
    	<body>
    		<p><b>	Dear ".$_POST['fname'].",</b></p>
    		<p>We are delighted to confirm your hotel booking at Angels Resort, Porvorim - Goa! We appreciate your choice and look forward to providing you with a comfortable and enjoyable stay.</p>
    		<p>
	    		<b>Booking Details:</b><br>
				<b>Hotel Name:</b> [Hotel Name]<br>
				<b>Check-in Date:</b> [Date]<br>
				<b>Check-out Date:</b> [Date]<br>
				<b>Room Type:</b> [Room Type]<br>
				<b>Number of Guests:</b> [Number of Guests]
			</p>
			<p>If you have any special requests or additional requirements, please let us know, and we will do our best to accommodate them.</p>
			<p>Thank you for choosing Angels Resort for your accommodation needs. Should you need any assistance, please feel free to contact us at [Hotel Contact Information]</p>
			<p>Regards,</p>
			<p>Angels Resort</p>
    	</body>
    </html>";

	try {
    	$mail->send();
    	echo 
	    "
	    <script>
	    alert('mail sent successfully');
	    document.location.href = 'index.php'
	    </script>
	    ";
    } catch (Exception $e) {
    	echo "Mailer Error: " . $mail->ErrorInfo;
	}
}
?>



