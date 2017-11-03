<?php
require_once "../resource/sql_connect.php";
require_once "../resource/My_op.php";
$login=$_POST['login'];
$type=$_POST['type'];
$email=$_POST['email'];
$pass=$_POST['pass'];
$pass_rep=$_POST['pass_rep'];

//tu sprawdzic poprawnosc maila, loginu, hasla

//===========================================================
//Czy login jest zajety
$sql = "SELECT login FROM osoby WHERE login='$login'";
$create= new My_op($db_host, $db_log, $db_pass, $db_name);
$create->query($sql);
$test= $create->getRow();
unset($create);
if(isset($test["login"])){
    $_SESSION["errno"]= "Podany LOGIN jest juz zajety.";
    header("Location: ../form_addAccount.php");
    exit();
}
//===========================================================
//czy prawidlowy email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION["errno"]= "Nieprawidlowy Email";
    header("Location: ../form_addAccount.php");
    exit();
}
//===========================================================
//czy podany email jest zajety
$sql = "SELECT email FROM osoby WHERE email='$email'";
$create= new My_op($db_host, $db_log, $db_pass, $db_name);
$create->query($sql);
$test= $create->getRow();
unset($create);
if(isset($test["email"])){
    $_SESSION["errno"]= "Podany EMAIL jest już zajęty.";
    header("Location: ../form_addAccount.php");
    exit();
}
//===========================================================
//czy haslo jest takie same jak powtorzenie hasla
if($pass!==$pass_rep){
    $_SESSION["errno"]= "Powtórz prawidłowo HASŁO";
    header("Location: ../form_addAccount.php");
    exit();
}
//===========================================================
//utworzenie konta
$sql = "INSERT INTO osoby (id, login, password, email, type, active) VALUES (NULL ,'$login', '$pass', '$email', '$type', '1')";
$create= new My_op($db_host, $db_log, $db_pass, $db_name);
$test=$create->query($sql);
unset($create);

if($test==1) {
//jesli zostanie utworzone
    $_SESSION["errno"] = "Konto zostalo utworzone";
    $_SESSION["error"] = 0;
    header("Location: ../index.php");
    exit();
//======
}
else{
    $_SESSION["errno"]= "Wystapił nieznany błąd";
    header("Location: ../form/form_addAccount.php");
    exit();
}