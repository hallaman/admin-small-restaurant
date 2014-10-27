<?
include_once '../admin/includes/dblib.php';
include_once '../admin/includes/lib.php';

$email = $_POST['email'];
$date  = $_POST['date'];
$order = $_POST['order'];
$total = $_POST['total'];

try {
	$sql =<<<SQL

	INSERT INTO orders (
				email,
				order_date,
				order_text,
				total,
				date_added
	)
	VALUES		(:email,
				 :order_date,
				 :order,
				 :total,
				 now()
	)

SQL;

	$stmt = $db->prepare($sql);

	$stmt->execute(array(
		'email'      => $email,
		'order_date' => $date,
		'order'      => $order,
		'total'      => $total
	));

	$insertid = $db->lastInsertId('id');

	echo $insertid;

	
} catch ( PDOException $e ) {
	echo 'error';
	exit;
}


?>