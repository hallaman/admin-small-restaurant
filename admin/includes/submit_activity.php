<?php

include_once 'dblib.php';
include_once 'lib.php';

confirmSession();
	
// var_dump($_POST);exit;

// if (isset($_FILES['file'])) {

// 	define ("MAX_SIZE","8000");

// 	$errors = 0;

// 	$image = $_FILES["file"]["name"];
// 	$uploadedfile = $_FILES['file']['tmp_name'];

// 	if ($image) {

// 		$filename = stripslashes($_FILES['file']['name']);
// 	    $extension = getExtension($filename);
// 		$extension = strtolower($extension);

// 		if (($extension != "jpg") && ($extension != "jpeg") 
// 			&& ($extension != "png") && ($extension != "gif")) {
			
// 			$err_msg = 'Unknown Image extension';
// 			$errors = 1;

// 		} else {

// 			$size=filesize($_FILES['file']['tmp_name']);

// 			if ($size > MAX_SIZE*1024) {

// 				$err_msg = "You have exceeded the size limit";
// 				$errors = 1;

// 			}

// 			if($extension=="jpg" || $extension=="jpeg" ) {

// 				$uploadedfile = $_FILES['file']['tmp_name'];
// 				$src = imagecreatefromjpeg($uploadedfile);

// 			} else if($extension=="png") {

// 				$uploadedfile = $_FILES['file']['tmp_name'];
// 				$src = imagecreatefrompng($uploadedfile);

// 			} else {
// 				$src = imagecreatefromgif($uploadedfile);
// 			}

// 			list($width,$height)=getimagesize($uploadedfile);

// 			$newwidth=665;
// 			$newheight=($height/$width)*$newwidth;
// 			$tmp=imagecreatetruecolor($newwidth,$newheight);

// 			$newwidth1=25;
// 			$newheight1=($height/$width)*$newwidth1;
// 			$tmp1=imagecreatetruecolor($newwidth1,$newheight1);

// 			imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,
// 			$width,$height);

// 			imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1, 
// 			$width,$height);

// 			// $filename = "images/". $_FILES['file']['name'];
// 			// $filename1 = "images/small". $_FILES['file']['name'];

// 			$filename = "../../images/activity.". $extension;
// 			$filename1 = "../../images/activity_thumb.". $extension;

// 			imagejpeg($tmp,$filename,100);
// 			imagejpeg($tmp1,$filename1,100);

// 			imagedestroy($src);
// 			imagedestroy($tmp);
// 			imagedestroy($tmp1);
// 		}
		
// 	}

// } else {

// 	$errors = 1;
// 	$err_msg = 'No file chosen.';
// }

// if ($errors) {

// 	$good_or_bad = 'error';
// 	$notice = $err_msg;
// 	header('Location: ../activities.php?notice_good_bad=error&notice='.$notice);
// 	exit;

// } else {


	try {
	
$sql2 =<<<SQL

	INSERT INTO activities (
				end_date,
				activity_text,
				date_submitted
	)
	VALUES		(:date,
				 :activity,
				 now()
	)

SQL;

	$stmt2 = $db->prepare($sql2);

	$stmt2->execute(array(
		':date'  => $_POST['date'],
		':activity'  => $_POST['activity']
	));


} catch ( PDOException $e ) {
	$good_or_bad = 'error';
	$notice = $e->getMessage();
	header('Location: ../activities.php?notice_good_bad=error&notice='.$notice);
	exit;
}

$good_or_bad = 'success';
$notice = 'The activity is updated';
header('Location: ../activities.php?notice_good_bad=success&notice='.$notice);
exit;


// }

function getExtension($str) {

	$i = strrpos($str,".");
	if (!$i) { return ""; } 
	$l = strlen($str) - $i;
	$ext = substr($str,$i+1,$l);
	return $ext;
}
?>

