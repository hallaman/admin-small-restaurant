<?php
include_once 'includes/dblib.php';
include_once 'includes/lib.php';

$email = $_POST['email'];
$password = $_POST['password'];


$sql =<<<SQL

	SELECT 	id,
			name_first,
			name_last,
			email,
			password,
			salt
	FROM	    users
	WHERE	email = :email

SQL;

$stmt = $db->prepare($sql);

$stmt->execute(array(
	'email'	=> $_POST['email']
));

pdo_error_handling($stmt->errorInfo(), $sql, basename($_SERVER['PHP_SELF']) , __FILE__ , __FUNCTION__ );

$count = $stmt->rowCount();
$row = $stmt->fetch();

//make sure there is only one record with this email and then check password match
if ( $count == 1 ) {
	$hash = hash('sha256', $row['salt'] . $password);

	if ( $hash == $row['password'] ) {
		startSession($row['id']);
		header('Location:menu.php');		
		exit;

	}
	else {
		header('Location: index.php?notice_good_bad=error&notice=Incorrect Password Entered.  Please try again.');
		exit;

	}
	
}
else {
    header('Location: index.php?notice_good_bad=error&notice=An account with this email address does not exist.  Please try again.');
    exit;
}

?>