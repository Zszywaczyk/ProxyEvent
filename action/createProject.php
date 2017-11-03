<?php
require_once "../resource/sql_connect.php";
require_once "../resource/My_op.php";
$name=$_POST['name'];
$place_id=$_POST['place_id'];
$date=$_POST['date'];
$img=$_POST['img'];
$max_people=$_POST['max_people'];
$opis=$_POST['opis'];

$id_osoby= $_SESSION['logged']['id'];

//=======================================================
//sprawdzamy czy jest takie id przestrzeni
$sql = "SELECT id FROM miejsca";
$create= new My_op($db_host, $db_log, $db_pass, $db_name);
$create->query($sql);
$test= $create->getAllRows();
unset($create);
$flaga=0;
for($i=count($test)-1;$i>=0;$i--){
    if($test[$i]['id']===$place_id){//jesli istnieje
        $flaga=1;
    }
}
if($flaga==0){//blad
    $_SESSION['errno']="Nie ma takiego ID przestrzeni";
    header("Location: ../form/form_createProject.php");
    exit();
}
//Sprawdza czy ktos nie ustawil czas wczesniej edycja html'a
if(date("Y-m-d")>$date){
    $_SESSION['errno']="Data musi byc ustawiona najwczesniej na jutro";
    header("Location: ../form/form_createProject.php");
    exit();
}

//Sprawdza czy urzytkownik podal poprawnie URL obrazka
if(!preg_match('/^(http|https):\\/\\/[a-z0-9]+([\\-\\.]{1}[a-z0-9]+)*\\.[a-z]{2,5}'.'((:[0-9]{1,5})?\\/.*)?$/i', $img)){
    $_SESSION['errno']='Podane URL obrazka jest nieprawidlowe.';
    header("Location: ../form/form_createProject.php");
    exit();
}

//===========================================================
//stworzenie projektu
$sql = "INSERT INTO projekty (id, id_osoby, id_przestrzeni, name, data, img, miejsca, zajete, opis) VALUES (NULL ,'$id_osoby', '$place_id', '$name', '$date', '$img', '$max_people', '0', '$opis')";
$create= new My_op($db_host, $db_log, $db_pass, $db_name);
$test=$create->query($sql);
unset($create);

if($test==1) {
//jesli zostanie utworzone
    $_SESSION["errno"] = "Miejsce zostale dodane";
    $_SESSION["error"] = 0;
    header("Location: ../account_type/organizator.php");
    exit();
//======
}
else{
    $_SESSION["errno"]= "Wystapił nieznany błąd";
    header("Location: ../form/form_createProject.php");
    exit();
}