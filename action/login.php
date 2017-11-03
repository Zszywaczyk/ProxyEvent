<?php
require_once "../resource/sql_connect.php";
require_once "../resource/My_op.php";

$login = $_POST['login'];
$passw = $_POST['passw'];

//sprawdzamy czy konto o podanym loginie istnieje
$sql = "SELECT login FROM osoby WHERE login='$login'";
$create= new My_op($db_host, $db_log, $db_pass, $db_name);
$create->query($sql);
$test= $create->getRow();
unset($create);
if(!isset($test["login"])){
    $_SESSION["errno"]= "Konto o podanym LOGINIE nie istnieje.";
    $_SESSION["error"]=1;
    header("Location: ..\index.php");
    exit();
}

//sprawdzamy czy haslo zgadza sie z loginem
$sql = "SELECT * FROM osoby WHERE login='$login'";
$create= new My_op($db_host, $db_log, $db_pass, $db_name);
$create->query($sql);
$test= $create->getRow();
if($passw!==$test['password']){
    $_SESSION["errno"]= "Podane HASLO nie pasuje do loginu.";
    $_SESSION["error"]=1;
    unset($create);
    header("Location: ..\index.php");
    exit();
}

//logujemy
if($test['type']==="uczestnik"){
    $_SESSION['logged']=$test;
    $_SESSION['zalogowany']=1;
    header("Location: ..\account_type\uczestnik.php");
    exit();
}
if($test['type']==="organizator"){
    $_SESSION['logged']=$test;
    $_SESSION['zalogowany']=1;
    header("Location: ..\account_type\organizator.php");
    exit();
}
if($test['type']==="wlasciciel przestrzeni"){
    $_SESSION['logged']=$test;
    $_SESSION['zalogowany']=1;
    header("Location: ..\account_type\wlasciciel.php");
    exit();
}
if($test['type']==="wolontariusz"){
    $_SESSION['logged']=$test;
    $_SESSION['zalogowany']=1;
    header("Location: ..\account_type\wolontariusz.php");
    exit();
}