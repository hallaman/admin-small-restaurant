<?php
//Define where to get db credentials and make connection

// $server = 'localhost';
// $login = 'sunfloz3_admin';
// $password = '5unf10w3r898';
// $database = 'sunfloz3_admin';

$server = 'localhost';
$login = 'root';
$password = 'root';
$database = 'sunfloz3_admin';

// Define DSN
$dsn = 'mysql:host=' . $server . ';dbname=' . $database . ';';

// We try catch to stop app failures
try {
    $db = new PDO($dsn, $login, $password);
} 
catch(PDOException $e) {
    echo 'CANNOT CONNECT USING PDO!';
}


?>