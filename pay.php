<?php

require('config.php');
require('conn.php');
require('razorpay-php/Razorpay.php');
session_start();

if (isset($_POST["name"]) && isset($_POST["payableamount"])) {
    $email = $_SESSION["email"] = $_POST["email"];
    $name = $_SESSION["name"] = $_POST["name"];
    $phone = $_SESSION["phone"] = $_POST["phone"];
    $_SESSION["comments"] = $_POST["comments"];
    $payamount = $_SESSION["payableamount"] = $_POST["payableamount"];
    date_default_timezone_set('Asia/Kolkata');
    $added_on = date('Y-m-d h:i:s');

    $sql = "INSERT INTO razorpay_bookings (customer_name, customer_email, customer_phone, booking_amount, added_on, status) VALUES ('$name', '$email',  $phone , $payamount ,'$added_on','pending')";
    if($conn -> query($sql)){
        $_SESSION['OID'] = mysqli_insert_id($conn);
    } else {
        echo("Error description: " . $conn -> error);
    }
}
// Create the Razorpay Order

use Razorpay\Api\Api;

$api = new Api($keyId, $keySecret);

//
// We create an razorpay order using orders api
// Docs: https://docs.razorpay.com/docs/orders
//
$orderData = [
    'receipt'         => 3456,
    'amount'          => $_POST["payableamount"] * 100, // 2000 rupees in paise
    'currency'        => 'INR',
    'payment_capture' => 1 // auto capture
];

$razorpayOrder = $api->order->create($orderData);

$razorpayOrderId = $razorpayOrder['id'];

$_SESSION['razorpay_order_id'] = $razorpayOrderId;

$displayAmount = $amount = $orderData['amount'];

if ($displayCurrency !== 'INR')
{
    $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
    $exchange = json_decode(file_get_contents($url), true);

    $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
}

$data = [
    "key"               => $keyId,
    "amount"            => $amount,
    "name"              => "Angels Resort",
    "description"       => "",
    "image"             => "img/logo1.svg",
    "prefill"           => [
    "name"              => $_POST["name"],
    "email"             => $_POST["email"],
    "contact"           => $_POST["phone"],
    ],
    "notes"             => [
    "address"           => $_POST["address"],
    "merchant_order_id" => "12312321",
    ],
    "theme"             => [
    "color"             => "#F37254"
    ],
    "order_id"          => $razorpayOrderId,
];

if ($displayCurrency !== 'INR')
{
    $data['display_currency']  = $displayCurrency;
    $data['display_amount']    = $displayAmount;
}

$json = json_encode($data);
?>
<form action="verify.php" method="POST">
<script language="JavaScript">
  window.addEventListener('load', function () {
    document.querySelector(".razorpay-payment-button").style.visibility= 'hidden';
    document.querySelector(".razorpay-payment-button").click();
});

</script>
  <script
    src="https://checkout.razorpay.com/v1/checkout.js"
    data-key="<?php echo $data['key']?>"
    data-amount=1
    data-currency="INR"
    data-name="<?php echo $data['name']?>"
    data-image="<?php echo $data['image']?>"
    data-description="<?php echo $data['description']?>"
    data-prefill.name="<?php echo $data['prefill']['name']?>"
    data-prefill.email="<?php echo $data['prefill']['email']?>"
    data-prefill.contact="<?php echo $data['prefill']['contact']?>"
    data-notes.shopping_order_id="3456"
    data-order_id="<?php echo $data['order_id']?>"
    <?php if ($displayCurrency !== 'INR') { ?> data-display_amount="<?php echo $data['display_amount']?>" <?php } ?>
    <?php if ($displayCurrency !== 'INR') { ?> data-display_currency="<?php echo $data['display_currency']?>" <?php } ?>
  >
  </script>
  <!-- Any extra fields to be submitted with the form but not sent to Razorpay -->
  <input type="hidden" name="shopping_order_id" value="3456">
</form>

<script>
  window.addEventListener('load', function () {
  document.getElementById("btn").click();
})
</script>
