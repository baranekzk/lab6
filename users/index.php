<html>
<head>
<title>:)</title>
</head>
<body>
	<form action="index.php?idk=<?php echo $idu; ?>" method="POST" ENCTYPE="multipart/form-data">
 <input type="file" name="plik"/>
 <input type="hidden" name="wyslij" value="1">
 <input type="submit" value="Wyślij plik"/>
 </form>
</body>
</html>
	<?php 
	include_once("../connect.php");
	$idu=$_GET['idk'];
	$wyslij=$_POST['wyslij'];
	$pytanie = mysqli_query ($polaczenie, "SELECT * FROM z7_logi where idu='$idu' ORDER BY data DESC LIMIT 1 ") or die ("Błąd zapytania do bazy: $dbname"); 
	$row1=mysqli_fetch_array($pytanie);
	$pytanie1 = mysqli_query ($polaczenie, "SELECT * FROM z7_users where idu='$idu'") or die ("Błąd zapytania do bazy: $dbname"); 
	$row2=mysqli_fetch_array($pytanie1);

	Echo ("Ostatnie błędne logowanie: $row1[4]");
if($wyslij==1){
$plik_tmp = $_FILES['plik']['tmp_name']; 
$plik_nazwa = $_FILES['plik']['name']; 
$plik_rozmiar = $_FILES['plik']['size']; 
$katalog="katalogi/$row2[1]";

if(is_uploaded_file($plik_tmp)) { 
     move_uploaded_file($plik_tmp, "$katalog/$plik_nazwa"); 
    echo "Plik: <strong>$plik_nazwa</strong> o rozmiarze 
    <strong>$plik_rozmiar bajtów</strong> został przesłany na serwer!"; 
    $result=mysqli_query($polaczenie, "INSERT INTO z7_pliki (idp,idu,nazwa,adres) VALUES ('','$idu','$plik_nazwa','$katalog/$plik_nazwa')");

} 
}
$pytanie3 = mysqli_query ($polaczenie, "SELECT * FROM z7_pliki where idu='$idu'") or die ("Błąd zapytania do bazy: $dbname"); 
	
echo'<table> <tr><td>NAZWA</td><td>POBIERZ</td></tr>';
	while($row3=mysqli_fetch_array($pytanie3)){

	echo ("<tr><td>$row3[2]</td><td> <form action=index.php?idk=$idu; method=post>
   <input type=hidden name=cos id=cos value=$row3[3] >
   <br><input type=submit name=pobierz value=pobierz>
   </form><//tr>");
}
echo '</table>';
 
if(isset($_POST['pobierz']))
{
$file = $_POST['cos'];  
 
    //First, see if the file exists
    if (!is_file($file)) { die("<b>404 File not found!</b>"); }
 
    //Gather relevent info about file
    $len = filesize($file);
    $filename = basename($file);
    $file_extension = strtolower(substr(strrchr($filename,"."),1));
 
    //This will set the Content-Type to the appropriate setting for the file
    switch( $file_extension ) {
          case "pdf": $ctype="application/pdf"; break;
      case "exe": $ctype="application/octet-stream"; break;
      case "zip": $ctype="application/zip"; break;
      case "doc": $ctype="application/msword"; break;
      case "xls": $ctype="application/vnd.ms-excel"; break;
      case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
      case "gif": $ctype="image/gif"; break;
      case "png": $ctype="image/png"; break;
      case "jpeg":
      case "jpg": $ctype="image/jpg"; break;
      case "mp3": $ctype="audio/mpeg"; break;
      case "wav": $ctype="audio/x-wav"; break;
      case "mpeg":
      case "mpg":
      case "mpe": $ctype="video/mpeg"; break;
      case "mov": $ctype="video/quicktime"; break;
      case "avi": $ctype="video/x-msvideo"; break;
 
      //The following are for extensions that shouldn't be downloaded (sensitive stuff, like php files)
      
 
      default: $ctype="application/force-download";
    }
 
    //Begin writing headers
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
    header("Content-Description: File Transfer");
    
    //Use the switch-generated Content-Type
    header("Content-Type: $ctype");
 
    //Force the download
    @$header="Content-Disposition: attachment; filename=".$filename.";";
    header($header );
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: ".$len);
    @readfile($file);
    exit;
}

	?>

