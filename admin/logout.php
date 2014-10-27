<?

function logout() {
	session_start();
    $_SESSION = array(); //destroy all of the session variables
    session_destroy();
	session_unset();
}

logout();
header('Location:index.php?notice_good_bad=good&notice=You have successfully logged out.');

?>