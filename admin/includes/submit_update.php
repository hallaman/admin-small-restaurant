<?php
if ( isset($_POST['menu'])) {
	$menu = $_POST['menu'];
} else if ( isset($_POST['id'])) {
	$id = $_POST['id'];
}

include_once 'dblib.php';
include_once 'lib.php';

confirmSession();
	
// var_dump($_POST);exit;

try {
	
$sql2 =<<<SQL

	INSERT INTO updates (
				end_date,
				update_text,
				date_submitted
	)
	VALUES		(:date,
				 :update,
				 now()
	)

SQL;

	$stmt2 = $db->prepare($sql2);

	$stmt2->execute(array(
		':date'  => $_POST['date'],
		':update'=> $_POST['update']
	));

	



} catch ( PDOException $e ) {
	$good_or_bad = 'error';
	$notice = $e->getMessage();
	header('Location: ../updates.php?notice_good_bad=error&notice='.$notice);
	exit;
}

$good_or_bad = 'success';
$notice = 'The update is updated';
header('Location: ../updates.php?notice_good_bad=success&notice='.$notice);
exit;

?>

