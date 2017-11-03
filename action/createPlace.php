<?php
require_once "../resource/sql_connect.php";
require_once "../resource/My_op.php";
$name=$_POST['name'];
if(!isset($_POST['name'])){ $_SESSION['errno']="Niewypelnione pole name"; header("Location: ../form/form_addPlace.php"); exit(); }
$img=$_POST['img'];
if(!isset($_POST['img'])){ $_SESSION['errno']="Niewypelnione pole img"; header("Location: ../form/form_addPlace.php"); exit(); }
$opis=$_POST['opis'];
if(!isset($_POST['opis'])){ $_SESSION['errno']="Niewypelnione pole opis"; header("Location: ../form/form_addPlace.php"); exit(); }
$ns=$_POST['loc_ns'];
if(!isset($_POST['loc_ns'])){ $_SESSION['errno']="Niewypelnione pole NS"; header("Location: ../form/form_addPlace.php"); exit(); }
$we=$_POST['loc_we'];
if(!isset($_POST['loc_we'])){ $_SESSION['errno']="Niewypelnione pole WE"; header("Location: ../form/form_addPlace.php"); exit(); }

$id_osoby= $_SESSION['logged']['id'];

//===========================================================
//Sprawdza czy urzytkownik podal poprawnie URL obrazka
if(!preg_match('/^(http|https):\\/\\/[a-z0-9]+([\\-\\.]{1}[a-z0-9]+)*\\.[a-z]{2,5}'.'((:[0-9]{1,5})?\\/.*)?$/i', $img)){
    $_SESSION['errno']='Podane URL obrazka jest nieprawidlowe.';
    header("Location: ../form/form_addPlace.php");
    exit();
}

//Sprawdza czy dlugosc NS jest odpowiednia <-85, 85>
if($ns>85 || $ns< -85){
    $_SESSION['errno']='Podana dlugosc NS jest wieksza od 85 lub mniejsza niz -85';
    header("Location: ../form/form_addPlace.php");
    exit();
}

//Sprawdza czy dlugosc WE jest odpowiednia <-180, 180>
if($we>180 || $we< -180){
    $_SESSION['errno']='Podana dlugosc NS jest wieksza od 85 lub mniejsza niz -85';
    header("Location: ../form/form_addPlace.php");
    exit();
}

//===========================================================
//dodanie miejsca
$sql = "INSERT INTO miejsca (id, id_osoby, name, img, opis, NS_loc, WE_loc) VALUES (NULL ,'$id_osoby', '$name', '$img', '$opis', '$ns', '$we')";
$create= new My_op($db_host, $db_log, $db_pass, $db_name);
$test=$create->query($sql);
unset($create);

if($test==1) {
//jesli zostanie utworzone
    $_SESSION["errno"] = "Miejsce zostale dodane";
    $_SESSION["error"] = 0;
    header("Location: ../account_type/wlasciciel.php");
    exit();
//======
}
else{
    $_SESSION["errno"]= "Wystapił nieznany błąd";
    header("Location: ../form/form_addPlace.php");
    exit();
}