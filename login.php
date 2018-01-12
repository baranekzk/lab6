<?php 
include_once('connect.php');
$login=$_POST['login'];
$haslo1=$_POST['haslo1'];
$wys=$_POST['wys'];
$czas = date("Y-m-d H:i:s");
ini_set('allow_url_fopen',1);
$ipaddress = $_SERVER["REMOTE_ADDR"];
function ip_details($ip) {
$json = file_get_contents ("http://ipinfo.io/{$ip}/geo");
$details = json_decode ($json);
return $details;
}
$details = ip_details($ipaddress);
$details -> region; 
$details -> country; 
$details -> city; 
$loc = $details -> loc; 
$ip = $details -> ip; 

if ($wys==1){
    if($login==null || $haslo1==null)
        echo ("Wypełnij wszystkie pola!");
    
    elseif($login!=null || $haslo1!=null){
        if (isset($_POST['zapamietaj'])) {
            /* Set cookie to last 1 year */
            setcookie('username', $_POST['username'], time()+60*60*24*365, '/account', 'www.example.com');
            setcookie('password', md5($_POST['password']), time()+60*60*24*365, '/account', 'www.example.com');
        
        } else {
            /* Cookie expires when browser closes */
            setcookie('username', $_POST['username'], false, '/account', 'www.example.com');
            setcookie('password', md5($_POST['password']), false, '/account', 'www.example.com');
        }
        $haslo=md5($haslo1);
    $pytanie = mysqli_query ($polaczenie, "SELECT count(*) FROM z7_users where login='$login' AND haslo='$haslo'") or die ("Błąd zapytania do bazy: $dbname");
    $pytanie2 = mysqli_query ($polaczenie, "SELECT count(*) FROM z7_users where login='$login'") or die ("Błąd zapytania do bazy: $dbname");
    $pytanie1 = mysqli_query ($polaczenie, "SELECT * FROM z7_users where login='$login'") or die ("Błąd zapytania do bazy: $dbname");

    $row=mysqli_fetch_array($pytanie);
    $row2=mysqli_fetch_array($pytanie2);

    $row1=mysqli_fetch_array($pytanie1);
    if ($row1[3]>=3){
        echo ("Użytkownik $row1[1] został zablokowany z powodu zbyt duzej ilosci błędnie wpisanych haseł");
    }

        else{
    if ($row[0]==1){

     echo ('Użytkownik zalogowany');
    

        $result=mysqli_query($polaczenie, "INSERT INTO `z7_logi` (idl, idu, blog, plog, data) VALUES ('','$row1[0]','0','1','$czas')");
        $result1=mysqli_query($polaczenie, "UPDATE z7_users SET blog=0 WHERE idu='$row1[0]'");
        
    $location= "users/index.php?idk=$row1[0]"; 
    echo $location;

    header("Location: $location");
 }
 else if($row2[0]==1){
    $result=mysqli_query($polaczenie, "INSERT INTO `z7_logi` (idl, idu, blog, plog, data) VALUES ('','$row1[0]','1','0','$czas')");
    $sum=$row1[3]+1;
     $result1=mysqli_query($polaczenie, "UPDATE z7_users SET blog=$sum WHERE idu='$row1[0]'");
    
        echo ('Błędnie wpisane hasło!');


    }
  else if($row2[0]==0)
        echo ('Brak użytkownika o takim loginie lub błędnie wpisane hasło!');
    }
}
}
 ?>

<form method="POST" action="login.php">
<b>Login:</b> <input type="text" name="login"><br><br>
<b>Hasło:</b> <input type="password" name="haslo1"><br>
Zapamietaj: <input type="checkbox" name="zapamietaj" value="1"><br>
<input type="hidden" name="wys" value="1">

<input type="submit" value="Zaloguj" name="Logowanie">
</form>
