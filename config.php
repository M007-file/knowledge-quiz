<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
/*define('DB_SERVER', 'mysql6.ebola.cz');
define('DB_USERNAME', 'koplpro_turtledo');
define('DB_PASSWORD', 'Jdr8XC2W3M');
define('DB_NAME', 'koplpro_services');*/

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'kviz');
$salt = "aTdNZv#Rj@Z77FQ8oIj0u#8QTM!7uOM8";
 
/* Tell mysqli to throw an exception if an error occurs */
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

/* Attempt to connect to MySQL database */
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
if($mysqli -> connect_errno){ // Check connection
    echo "CHYBA: Nelze se připojit. " . $mysqli -> connect_error;
    exit();
}
?>