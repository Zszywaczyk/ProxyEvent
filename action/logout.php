<?php
session_start();

session_unset();
$_SESSION['zalogowany']=0;
$_SESSION['error']=0;
$_SESSION['errno']="Poprawnie wylogowano";
ECHO $_SESSION['errno'];
header("Location: ../index.php");