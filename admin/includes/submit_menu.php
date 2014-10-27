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
	if ( !isset($id) ) {
		$sql =<<<SQL

			INSERT INTO menus (
						day,
						meal,
						date_submitted
			)
			VALUES		(:day,
						 :meal,
						 now()
			)

SQL;

		$stmt = $db->prepare($sql);

		$stmt->execute(array(
			':day' 	      => $_POST['date'],
			':meal' 	  => $_POST['meal']
		));

		$menuid = $db->lastInsertId('id');

	} else {
		$menuid = $id;

		$sql =<<<SQL

		DELETE   
		FROM    menu_items
		WHERE   menu_id = :menu_id

SQL;

		$stmt = $db->prepare($sql);

		$stmt->execute(array(
			':menu_id' 	=> $menuid
		));

	}

	$count = count($_POST['headings']);

	for ($i = 0; $i < $count; $i++) {

   		$sql2 =<<<SQL

		INSERT INTO menu_items (
					menu_id,
					header_id,
					description,
					date_submitted
		)
		VALUES		(:menu_id,
					 :header_id,
					 :description,
					 now()
		)

SQL;

		$stmt2 = $db->prepare($sql2);

		$stmt2->execute(array(
			':menu_id' 	  => $menuid,
			':header_id'  => $_POST['headings'][$i],
			':description'=> $_POST['items'][$i]
		));
	} 

	



} catch ( PDOException $e ) {
	$good_or_bad = 'error';
	$notice = $e->getMessage();
	header('Location: menu.php?notice_good_bad=error&notice='.$notice);
	exit;
}

$good_or_bad = 'success';
$notice = 'The menu is updated';
header('Location: ../menu.php?notice_good_bad=success&notice='.$notice);
exit;

?>

