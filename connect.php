<?php 
//Połączenie z bazą danych
$dbhost="localhost"; $dbuser="hbaranow"; $dbpassword="6MP9f9ww6k"; $dbname="hbaranow_strona";
$polaczenie = mysqli_connect ($dbhost, $dbuser, $dbpassword);
mysqli_select_db ($polaczenie, $dbname);
if (!$polaczenie) {
echo "Błąd połączenia z MySQL." . PHP_EOL;
echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
echo "Error: " . mysqli_connect_error() . PHP_EOL;
exit;
}
?>