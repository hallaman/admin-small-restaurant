<?
// functions.php
function check_txnid($tnxid){
	include_once '../admin/includes/dblib.php';
	include_once '../admin/includes/lib.php';

	$valid_txnid = true;
    //get result set
    $sql =<<<SQL

	SELECT 	* 
	FROM    payments
	WHERE   txnid = :txnid

SQL;

	$stmt = $db->prepare($sql);

	$stmt->execute(array(
		'txnid'      => $tnxid
	));

	$row = $stmt -> fetch(PDO::FETCH_ASSOC);

	if($row) {
        $valid_txnid = false;
	}
    return $valid_txnid;
}

function check_price($price, $id){
    $valid_price = false;
 	/*
	you could use the below to check whether the correct price has been paid for the product
	if so uncomment the below code

	$sql = mysql_query("SELECT amount FROM `products` WHERE id = '$id'");
    if (mysql_numrows($sql) != 0) {
		while ($row = mysql_fetch_array($sql)) {
			$num = (float)$row['amount'];
			if($num == $price){
				$valid_price = true;
			}
		}
    }
	return $valid_price;
	*/
	return true;
}

function updatePayments($data) {
    include_once '../admin/includes/dblib.php';
	include_once '../admin/includes/lib.php';

	try {
	    $sql =<<<SQL

				INSERT INTO payments (
							txnid,
							payment_amount,
							payment_status,
							order_id,
							createdtime
				)
				VALUES		(:txnid,
							 :payment_amount,
							 :payment_status,
							 :order_id,
							 :createdtime
				)

SQL;

		$stmt = $db->prepare($sql);

		$stmt->execute(array(
			':txnid' 	          => $data['txn_id'],
			':payment_amount' 	  => $data['payment_amount'],
			':payment_status' 	  => $data['payment_status'],
			':order_id' 	      => $data['item_number'],
			':createdtime' 	      => date("Y-m-d H:i:s")
		));

		$id = $db->lastInsertId('id');

		if ($id) {

			sendEmail($data['payer_email']);

			echo $id;

		}

		

	} catch ( PDOException $e ) {
		echo 'error';
		exit;
	}
}

function sendEmail() {
	require_once "Mail.php";
					 
	 $from = "";
	 $to = "<" . $data['payer_email'] . ">";
	 $subject = 'Your To Go Order';

	 $body = '
		<html>
		<head>
		  <title>Your To Go Order </title>
		  <style>

		  </style>
		</head>
		<body>
		  <p>Order For : '.$date.'</p>
		  <p>'.$order.'</p>
		</body>
		</html>
	';
	 
	 $host = "";
	 $username = "";
	 $password = "";
	 
	 $headers = array (
	 	"MIME-Version"=> '1.0', 
	    "Content-type" => "text/html; charset=iso-8859-1",
	   'From' => $from,
	   'To' => $to,
	   'Subject' => $subject);
	 $smtp = Mail::factory('smtp',
	   array ('host' => $host,
	     'auth' => true,
	     'username' => $username,
	     'password' => $password));
	 
	 $mail = $smtp->send($to, $headers, $body);
	 
	 if (PEAR::isError($mail)) {
	   //echo("<p>" . $mail->getMessage() . "</p>");
	   mail('heather.allaman@gmail.com', 'email', $mail->getMessage());

	  } else {
	   //echo("<p>Message successfully sent!</p>");
	  	mail('heather.allaman@gmail.com', 'email', 'sent ' . $data['payer_email']);

	  }
}

?>