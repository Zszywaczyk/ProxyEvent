<?php
require_once "../resource/My_op.php";
require_once "../resource/sql_connect.php";



//jesli nikt nie jest zalogowany
if(!isset($_SESSION['zalogowany']) || $_SESSION['zalogowany']!=1 || $_SESSION['logged']['type']!=="uczestnik"){
    header("Location: ../index.php");
    exit();
}

$id_projektu=$_GET['id'];
$id_uczestnika=$_SESSION['logged']['id'];

//update points set points = points+1 where uid = 1

//sprawdza czy zajete nie przekracza max miejsc
$sql = "SELECT zajete, miejsca FROM projekty WHERE id='$id_projektu'";
$create= new My_op($db_host, $db_log, $db_pass, $db_name);
$create->query($sql);
$test= $create->getRow();
unset($create);
if($test['zajete'] == $test['miejsca']){
    $_SESSION['error']=1;
    $_SESSION['errno']="Brak miejsc. Damy znac jesli sie zwolni.";
    header("Location: ../account_type/uczestnik.php");
    exit();
}
//sprawdzam czy uczestnik bierze juz udzial w tym wydarzeniu
$flaga=0;
$sql = "SELECT id FROM uczestnictwo WHERE id_uczestnika='$id_uczestnika' AND id_projektu='$id_projektu' ";
$create= new My_op($db_host, $db_log, $db_pass, $db_name);
$create->query($sql);
$test=$create->getAllRows();
if($test!=null){
    $_SESSION['error']=1;
    $_SESSION['errno']="Jestes juz zapisany na to wydarzenie.";
    header("Location: ../account_type/uczestnik.php");
    exit();
}







$sql = "INSERT INTO uczestnictwo (id, id_projektu, id_uczestnika) VALUES (NULL ,'$id_projektu','$id_uczestnika')";
$create= new My_op($db_host, $db_log, $db_pass, $db_name);
$test=$create->query($sql);
unset($create);


$sql = "update projekty set zajete = zajete+1 where id = '$id_projektu'";
$create= new My_op($db_host, $db_log, $db_pass, $db_name);
$test=$create->query($sql);
unset($create);

if($test==1) {
//jesli zostanie utworzone
    $_SESSION["errno"] = "Wydarzenie zostalo zapisane";
    $_SESSION["error"] = 0;
    header("Location: ../account_type/uczestnik.php");
    exit();
//======
}
else{
    $_SESSION["errno"] = "Wydarzenie nie zostalo zapisane";
    $_SESSION["error"] = 1;
    header("Location: ../account_type/uczestnik.php");
    exit();
}

