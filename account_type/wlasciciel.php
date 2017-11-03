<?php
session_start();
?>
<!Doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Witaj Organizatorze</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div id="nav">
    <a href="../index.php">
        <img id="img_logo" src="../img/logo.png" alt="logo" >
    </a>
    <a class="aaa" href="../form/form_addPlace.php">
        <img id="orgaction1" src="../img/dlocation.png" alt="dodaj przestrzen" >
        <span id="texttip1">Nowa przestrzen</span>

    </a>
    <div id="pnav">
        <?php ECHO 'Witaj '.$_SESSION['logged']['login']; ?>
        <a id="reg_link" href="../action/logout.php">wyloguj</a>


    </div>
</div>

<div id="menu">
    <a href="?dec=1">
        <div id="pro_but">
            <img src="../img/projects.png">
            <p>Projekty</p>
        </div>
    </a>
    <a href="?dec=2">
        <div id="loc_but">
            <img src="../img/organiser.png">
            <p>Organizatorzy</p>
        </div>
    </a>
    <a href="?dec=3">
        <div id="org_but">
            <img src="../img/locations.png">
            <p>Przestrzenie</p>
        </div>
    </a>

</div>
<?php
//Pole Komunikatow. Ustawione jesli sa.
if(isset($_SESSION['errno'])){
    if($_SESSION['error']==0){
        ECHO '<p style="padding-top: 8px; margin: 0 0 0 0; background: black; color: green; text-align: center; width: 100%; height: 30px; position: relative;">';
        ECHO $_SESSION['errno'];
        ECHO '</p>';
        unset($_SESSION['errno']);
        unset($_SESSION['error']);
    }
    if($_SESSION['error']==1){
        ECHO '<p style="padding-top: 8px; margin: 0 0 0 0; background: black; color: red; text-align: center; width: 100%; height: 30px; position: relative;">';
        ECHO $_SESSION['errno'];
        ECHO '</p>';
        unset($_SESSION['errno']);
        unset($_SESSION['error']);
    }
}
//========================
if(!isset($_GET["dec"]) || $_GET["dec"]==1){
    ECHO '<div id="choice1">';
    ECHO '<p>Projekty</p>';
    ECHO '</div>';
}
elseif($_GET["dec"]==2){
    ECHO '<div id="choice2">';
    ECHO '<p>Organizatorzy</p>';
    ECHO '</div>';
}
elseif($_GET["dec"]==3){
    ECHO '<div id="choice3">';
    ECHO '<p>Przestrzenie</p>';
    ECHO '</div>';
}

ECHO '<div id="content">';

if(isset($_GET["dec"])){
    $dec=$_GET["dec"];

    if($dec==1){
        $sql = "SELECT * FROM projekty";
        $create= new My_op($db_host, $db_log, $db_pass, $db_name);
        $create->query($sql);
        $test= $create->getAllRows();
        unset($create);
        for($i=0;$i<count($test);$i++){
            ECHO '<div class="przyklad">';

            ECHO '</div>';
        }
    }

    if($dec==2){
        $sql = "SELECT login, email FROM osoby WHERE type='organizator'";
        $create= new My_op($db_host, $db_log, $db_pass, $db_name);
        $create->query($sql);
        $test= $create->getAllRows();
        unset($create);
        //var_dump($test);
        for($i=0;$i<count($test);$i++){
            ECHO '<a href="person.php?login='.$test[$i]['login'].'">';
            ECHO '<div style="height: 40px; width: 100%; float: left; background-color: #3E3E3E;  margin: 10px 0 10px 0;">';
            ECHO '<p style="background-color: black; width: 50%; margin-top: 10px; text-align: right; color: white; float: left;">'.$test[$i]['login']."&nbsp&nbsp&nbsp".'</p>';
            ECHO '<p style="width: 50%; margin-top: 10px; text-align: left; color: white; float: left;">'."&nbsp&nbsp&nbspEmail: ".$test[$i]['email'].'</p>';
            ECHO "</div>";
            ECHO "</a>";
        }

    }

}
else{
    for($i=0;$i<20;$i++){
        Echo '<div class="przyklad"></div>';
    }
}
ECHO '</div>';
?>
<footer>

</footer>


</body>
</html>