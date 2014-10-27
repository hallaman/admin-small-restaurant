// Response from Paypal

	// read the post from PayPal system and add 'cmd'
	$req = 'cmd=_notify-validate';
	foreach ($_POST as $key => $value) {
		$value = urlencode(stripslashes($value));
		$value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);// IPN fix
		$req .= "&$key=$value";
	}

	$dump = var_dump($_POST);

	mail('heather.allaman@gmail.com', 'post', $dump);

	
	// post back to PayPal system to validate
	$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
	$header .= "Host: www.sandbox.paypal.com\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

	$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);

	// assign posted variables to local variables
	$data['item_name']		    = $_POST['item_name'];
	$data['item_number'] 		= $_POST['item_number'];
	$data['payment_status'] 	= $_POST['payment_status'];
	$data['payment_amount'] 	= $_POST["mc_gross"];
	$data['payment_currency']	= $_POST['mc_currency'];
	$data['txn_id']				= $_POST['txn_id'];
	$data['receiver_email'] 	= $_POST['receiver_email'];
	$data['payer_email'] 		= $_POST['payer_email'];
	//$data['custom'] 			= $_POST['custom'];


	if (!$fp) {
		// HTTP ERROR
		error_log('IPN failed with HTTP error.');
		return;
	} else {
		fputs ($fp, $header . $req);
		while (!feof($fp)) {
			$res = stream_get_contents($fp, 1024);
						
			mail('heather.allaman@gmail.com', '0', $res);

			if (strcmp ($res, "VERIFIED") == 0) {

				// Validate payment (Check unique txnid & correct price)
				//$valid_txnid = check_txnid($data['txn_id']);
				//$valid_price = check_price($data['payment_amount'], $data['item_number']);
				//mail('heather.allaman@gmail.com', '0', $valid_txnid);


				// PAYMENT VALIDATED & VERIFIED!
				//if($valid_txnid) {

					$orderid = updatePayments($data);

					//mail('heather.allaman@gmail.com', '0', $data);

					if($orderid) {

						$to  = $_POST['payer_email']; 

						// subject
						$subject = 'Your Order with Sunflower Cafe';

						// message
						$message = '
						<html>
						<head>
						  <title>To Go Order</title>
						  <style>

						  </style>
						</head>
						<body>
						  <p>Order For : '.$date.'</p>
						  <p>'.$order.'</p>
						</body>
						</html>
						';

						// To send HTML mail, the Content-type header must be set
						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

						// Additional headers 
						$headers .= 'To: <' . $_POST['payer_email'] . '>' . "\r\n";

						$headers .= 'From: Sunflower Cafe Online Ordering <ordering@sunflowercafe.com>' . "\r\n";

						// Mail it
						mail($to, $subject, $message, $headers);
					} else {
						// Error inserting into DB
						// E-mail admin or alert user
						mail('heather.allaman@gmail.com', 'db insert error','0');

					}
				// } else {
				// 	// Payment made but data has been changed
				// 	// E-mail admin or alert user

				// mail('heather.allaman@gmail.com', 'data changed','0');

				// }

			} else if (strcmp ($res, "INVALID") == 0) {

				// PAYMENT INVALID & INVESTIGATE MANUALY!
				// E-mail admin or alert user

				mail('heather.allaman@gmail.com', 'invalid','0');


			}

		}
	fclose ($fp);
	}
