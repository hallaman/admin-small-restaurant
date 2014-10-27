<?


function createSalt() {
    $string = md5(uniqid(rand(), true));
    return substr($string, 0, 5);
}

//set session data
function startSession($user_id, $new_session=true) {

	include 'dblib.php';

	if ( $new_session ) {
		session_unset();
	}

	$sql =<<<SQL

		SELECT 	users.id,
				name_first,
				name_last,
				email
		FROM	 users
		JOIN	 user_logins ON user_logins.user_id = users.id
		WHERE	users.id = :user_id

SQL;

	$stmt = $db->prepare($sql);

	$stmt->execute(array('user_id'=> $user_id));
	pdo_error_handling($stmt->errorInfo(), $sql, basename($_SERVER['PHP_SELF']) , __FILE__ , __FUNCTION__ );

	$row = $stmt->fetch();

	if ( $new_session ) {
		session_start();
		session_regenerate_id(true);
	}

	$_SESSION['user_id'] = $row['id'];
	$_SESSION['name_first'] = $row['name_first'];
	$_SESSION['name_last'] = $row['name_last'];
	$_SESSION['email'] = $row['email'];
	$_SESSION['id'] = session_id();
	$_SESSION['last_login'] = $row['last_login'];

	if ( $new_session ) {
		$sql =<<<SQL

			INSERT INTO user_logins (
				user_id,
				ip_address,
				session_id,
				date_created
			)
			VALUES (
				:user_id,
				:ip_address,
				:session_id,
				now()
			)

SQL;

		$stmt = $db->prepare($sql);

		$stmt->execute(array(
			'user_id'=> $user_id,
			'ip_address'=> $_SERVER['REMOTE_ADDR'],
			'session_id'=> session_id()
		));

		pdo_error_handling($stmt->errorInfo(), $sql, basename($_SERVER['PHP_SELF']) , __FILE__ , __FUNCTION__ );

	}


}

function confirmSession() {
	session_start();
	if ( !(isset($_SESSION['email'])) ) {
		header('Location:index.php?notice_good_bad=error&notice=Please login to continue');
	}
}

function pdo_error_handling($error_array, $sql, $access_file, $sql_filename, $function='') {

	$message = 'accessing_filename: ' . $access_file . '<br /><br />' . 'sql_location: ' . $sql_filename . '<br /><br />' . 'function: ' . $function . '<br /><br />' . $error_array[2] . '<br /><br />' . $sql;

	if ( $error_array[2] != null ) {
		send_email('heather.allaman@gmail.com', 'Sunflower Cafe PDO Error: ', $message, 'no_reply@sunflowercafe.com','no_reply@sunflowercafe.com');
		$notice = 'There was an error while trying to process your request.  The site admin has been alerted.';
	}

}

function send_email($to, $subject, $message, $from, $reply_to) {

	$headers = 'From: ' . $from . "\r\n";
	$headers .= 'Reply-To: ' . $reply_to . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

	mail($to, $subject, $message, $headers);
}

function getHeaders() {

	include 'dblib.php';

	$sql =<<<SQL

		SELECT 	*
		FROM	headers

SQL;

	$stmt = $db->prepare($sql);

	$stmt->execute();

	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	return $result;
}

function getMenuInfo($menu_id) {

	include 'dblib.php';

	$sql =<<<SQL

		SELECT 	id,
				meal,
				day

		FROM	menus
		WHERE	id = :menu_id

SQL;

	$stmt = $db->prepare($sql);

	$stmt->execute(array('menu_id'=> $menu_id));
	pdo_error_handling($stmt->errorInfo(), $sql, basename($_SERVER['PHP_SELF']) , __FILE__ , __FUNCTION__ );

	$result = $stmt->fetch(PDO::FETCH_ASSOC);

	return $result;

}

function getMenuDetails($menu_id) {

	include 'dblib.php';

	$sql =<<<SQL

		SELECT 	header_id,
				description,
				menu_id,
				id

		FROM	menu_items
		WHERE	menu_id = :menu_id

SQL;

	$stmt = $db->prepare($sql);

	$stmt->execute(array('menu_id'=> $menu_id));
	pdo_error_handling($stmt->errorInfo(), $sql, basename($_SERVER['PHP_SELF']) , __FILE__ , __FUNCTION__ );

	$result = $stmt->fetchAll();

	return $result;

}

function getTodaysMenu($menu) {

	include 'dblib.php';

	$today = date("Y-m-d");

	$checktime = '2030'; // 8:30 PM

	if( date( 'Hi' ) >= $checktime ) {
    	// Switch to next day
		$today = date("Y-m-d", time() + 86400); // actually tomorrow
	}

	$sql =<<<SQL

	  SELECT   id
	  FROM     menus
	  WHERE    day  = :today
	  AND      meal = :meal

SQL;

	$stmt = $db->prepare($sql);

	$stmt->execute(array('today'=> $today, 'meal'=> $menu));

	$result = $stmt->fetch();

	return $result;
}

function getWeeksMenu($startdate) {

	include 'dblib.php';

	$return_array = array();

	for ($i = 0; $i < 6; $i++) {

		$sql1 =<<<SQL

		  SELECT   id
		  FROM     menus
		  WHERE    day  = :today
		  AND      meal = :meal

SQL;

		$stmt1 = $db->prepare($sql1);

		$stmt1->execute(array('today'=> $startdate, 'meal'=> 'lunch'));

		$result1 = $stmt1->fetch();

		$sql =<<<SQL

			SELECT 	header_id,
					description

			FROM	menu_items
			WHERE	menu_id = :menu_id

SQL;

			$stmt = $db->prepare($sql);

			$stmt->execute(array('menu_id'=> $result1['id']));

			$result = $stmt->fetchAll();

			$this_array = array('day' => $startdate, 'id' => $result1['id'], 'items' => $result);

			array_push($return_array, $this_array);

			$startdate = date('Y-m-d', strtotime($startdate . '+ 1 day'));

	}

	return $return_array;
}


function getUpdate() {

	include 'dblib.php';

	$sql =<<<SQL

	  SELECT   end_date,
	  		   update_text

	  FROM     updates
	  ORDER BY date_submitted 
	  DESC
	  LIMIT    1

SQL;

	$stmt = $db->prepare($sql);

	$stmt->execute();

	$result = $stmt->fetch();

	return $result;
}

function getActivities() {

	include 'dblib.php';

	$sql =<<<SQL

	  SELECT   end_date,
	  		   activity_text

	  FROM     activities
	  ORDER BY date_submitted 
	  DESC
	  LIMIT    1

SQL;

	$stmt = $db->prepare($sql);

	$stmt->execute();

	$result = $stmt->fetch();

	return $result;
}

function check_txnid($tnxid){
	include 'dblib.php';

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

    include 'dblib.php';

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

			$id = $data['item_number'];

			if ($id) {

				sendEmail($id);

				echo $id;

			} else {
				error_log('no id');
			}

			
}

function sendEmail($id) {

	include 'dblib.php';
	require_once "Mail.php";


	$sql =<<<SQL

	  SELECT   *

	  FROM     orders
	  WHERE    id = :id 

SQL;

	$stmt = $db->prepare($sql);

	$stmt->execute(array('id' => $id));

	$result = $stmt->fetch();

	$host = "mail.sunflowercafenashville.com";
	$username = "ordering@sunflowercafenashville.com";
	$password = "Sunflower898";

	// email to ordering@sunflowercafe.com

	 $from = "Sunflower Cafe Online Ordering <ordering@sunflowercafe.com>";
	 $to = "<ordering@sunflowercafe.com>";
	 //$to = "Heather <heather.allaman@gmail.com>";
	 $subject = 'New To Go Order';

	 $body = '
		<html>
		<head>
		  <title>New To Go Order</title>
		  <style>

		  </style>
		</head>
		<body>
		  <p>Order For : '.$result['order_date'].'</p>
		  <p>Contact : '.$result['email'].'</p>
		  <p>'.$result['order_text'].'</p>
		</body>
		</html>
	';
	 
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
	   error_log($mail->getMessage());
	} 


	// email to buyer
					 
	 $from2 = "Sunflower Cafe Online Ordering <ordering@sunflowercafe.com>";
	 $to2 = "<" . $result['email'] . ">";
	 $subject2 = 'Your To Go Order';

	 $body2 = '
		<html>
		<head>
		  <title>Your To Go Order with Sunflower Cafe</title>
		  <style>

		  </style>
		</head>
		<body>
		  <p>Ready for pickup on : '.$result['order_date'].'</p>
		  <p>'.$result['order_text'].'</p>
		</body>
		</html>
	';
	 
	 $headers2 = array (
	 	"MIME-Version"=> '1.0', 
	    "Content-type" => "text/html; charset=iso-8859-1",
	   'From' => $from2,
	   'To' => $to2,
	   'Subject' => $subject2);
	 $smtp2 = Mail::factory('smtp',
	   array ('host' => $host,
	     'auth' => true,
	     'username' => $username,
	     'password' => $password));
	 
	 $mail2 = $smtp2->send($to2, $headers2, $body2);
	 
	if (PEAR::isError($mail2)) {
	   error_log($mail2->getMessage());
	} 
}

?>