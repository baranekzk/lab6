
<?php 
include_once('connect.php');
$login=$_POST['login'];
$haslo1=$_POST['haslo1'];
$haslo2=$_POST['haslo2'];
$wys=$_POST['wys'];


if ($wys==1){
	if($login==null || $haslo1==null || $haslo2==null)
		echo ("Wypełnij wszystkie pola!");
	elseif ($haslo1!=$haslo2)
		echo ('Podane hasła sa różne!');
	
	elseif(($login!=null || $haslo1!=null || $haslo2!=null)&&($haslo1==$haslo2)){
		$haslo=md5($haslo1);
	$pytanie = mysqli_query ($polaczenie, "SELECT count(*) FROM z7_users where login='$login'") or die ("Błąd zapytania do bazy: $dbname");

    $row=mysqli_fetch_array($pytanie);

    if ($row[0]==1)
     echo ('Użytkownik o podanym loginie już istnieje wybierz inny!');
    else 
   	mkdir ("./users/katalogi/$login", 0755);
    $result=mysqli_query($polaczenie, "INSERT INTO z7_users (idu,login,haslo,blog) VALUES ('','$login','$haslo','0')");

    
		
	}
}
 ?>

<form method="POST" action="rejkl.php">
<b>Login:</b> <input type="text" name="login"><br><br>
<b>Hasło:</b> <input type="password" name="haslo1"><br>
<b>Powtórz hasło:</b> <input type="password" name="haslo2"><br><br>
<input type="hidden" name="wys" value="1">
<input type="submit" value="Utwórz konto" name="rejestruj">
</form>
</br>
 <a href="javascript:history.back();">Wstecz</A>