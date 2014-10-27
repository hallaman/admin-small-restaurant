<?

// Include Functions
include_once '../admin/includes/lib.php';


// PayPal settings
$paypal_email = '';
$return_url = '/payment-successful.php';
$cancel_url = '/payment-cancelled.php';
$notify_url = '/includes/payments.php';

$item_name = 'Online Order';
$item_amount = $_POST["total-cost"];

$tax = (9.25*($item_amount/100));
// work out the amount of vat
$tax = round($tax, 2);

// Check if paypal request or response
if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])){

	// Firstly Append paypal account to querystring
	$querystring .= "?business=".urlencode($paypal_email)."&";

	// Append amount& currency (£) to quersytring so it cannot be edited in html

	//The item name and amount can be brought in dynamically by querying the $_POST['item_number'] variable.
	$querystring .= "item_name=".urlencode($item_name)."&";
	$querystring .= "amount=".urlencode($item_amount)."&";
	$querystring .= "tax=".urlencode($tax)."&";

	//loop for posted values and append to querystring
	foreach($_POST as $key => $value){
		$value = urlencode(stripslashes($value));
		$querystring .= "$key=$value&";
	}

	// Append paypal return addresses
	$querystring .= "return=".urlencode(stripslashes($return_url))."&";
	$querystring .= "cancel_return=".urlencode(stripslashes($cancel_url))."&";
	$querystring .= "notify_url=".urlencode($notify_url);

	// Append querystring with custom field
	//$querystring .= "&custom=".USERID;

	// Redirect to paypal IPN
	//header('location:https://www.sandbox.paypal.com/cgi-bin/webscr'.$querystring);
	header('location:https://www.paypal.com/cgi-bin/webscr'.$querystring);
	exit();

} else {

	// read the post from PayPal system and add 'cmd'
	$req = 'cmd=_notify-validate';

	foreach ($_POST as $key => $value) {
		$value = urlencode(stripslashes($value));
		$req .= "&$key=$value";
	}

	// post back to PayPal system to validate
	$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
	//$header .= "Host: www.sandbox.paypal.com\r\n";
	$header .= "Host: www.paypal.com\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
	//$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);
	$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);


	// assign posted variables to local variables
	$data['item_name']		    = $_POST['item_name'];
	$data['item_number'] 		= $_POST['item_number'];
	$data['payment_status'] 	= $_POST['payment_status'];
	$data['payment_amount'] 	= $_POST["mc_gross"];
	$data['payment_currency']	= $_POST['mc_currency'];
	$data['txn_id']				= $_POST['txn_id'];
	$data['receiver_email'] 	= $_POST['receiver_email'];
	$data['payer_email'] 		= $_POST['payer_email'];

	//mail('heather.allaman@gmail.com', 'post', $txn_id);

	if (!$fp) {
	// HTTP ERROR
	} else {
		fputs ($fp, $header . $req);
		while (!feof($fp)) {
			$res = fgets ($fp, 1024);

			//mail('heather.allaman@gmail.com', 'stream', $res);

			if (strcmp ($res, "VERIFIED") == 0) {
				// check the payment_status is Completed
				// check that txn_id has not been previously processed
				// check that receiver_email is your Primary PayPal email
				// check that payment_amount/payment_currency are correct
				// process payment
				// Validate payment (Check unique txnid & correct price)
				$valid_txnid = check_txnid($data['txn_id']);
				//$valid_price = check_price($data['payment_amount'], $data['item_number']);
				//mail('heather.allaman@gmail.com', '0', $valid_txnid);


				// PAYMENT VALIDATED & VERIFIED!
				if($valid_txnid) {

					$orderid = updatePayments($data);

					
					if($orderid) {


					}
				}
			} else if (strcmp ($res, "INVALID") == 0) {
			// log for manual investigation
			}
		}
		fclose ($fp);
	}

}
?>