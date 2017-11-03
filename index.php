<?php
    session_start();
    require_once "resource/My_op.php";
    require_once "resource/sql_connect.php";
?>
<!Doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>PE Zaloguj sie po wiecej!</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div id="nav">
    <a href="index.php">
        <img id="img_logo" src="img/logo.png" alt="logo" >
    </a>
    <div id="pnav">
        <form action="action/login.php" method="post">
            <a id="reg_link" href="form/form_addAccount.php">stworz konto...</a>
            lub
            <button type="submit" id="button" onclick="" >Zaloguj</button>
            <input name="login" id="inp_usr" type="text" placeholder="Username">
            <input name="passw" id="inp_pas" type="password" placeholder="Password">
        </form>
    </div>
    <a id="pas_rec" href="pasrecover.php">Zapomnialem hasla</a>
</div>

<div id="menu">
    <a href="?dec=1">
    <div id="pro_but">
        <img src="img/projects.png">
        <p>Projekty</p>
    </div>
    </a>
    <a href="?dec=2">
    <div id="loc_but">
        <img src="img/organiser.png">
        <p>Organizatorzy</p>
    </div>
    </a>
    <a href="?dec=3">
    <div id="org_but">
        <img src="img/locations.png">
        <p>Przestrzenie</p>
    </div>
    </a>

</div>
<?php
//Pole Komunikatow. Ustawione jesli sa.
if(isset($_SESSION['errno'])){
    if (isset($_SESSION['error'])) {
        if ($_SESSION['error'] == 0) {
            ECHO '<p style="padding-top: 8px; margin: 0 0 0 0; background: black; color: green; text-align: center; width: 100%; height: 30px; position: relative;">';
            ECHO $_SESSION['errno'];
            ECHO '</p>';
        }
        if ($_SESSION['error'] == 1) {
            ECHO '<p style="padding-top: 8px; margin: 0 0 0 0; background: black; color: red; text-align: center; width: 100%; height: 30px; position: relative;">';
            ECHO $_SESSION['errno'];
            ECHO '</p>';
        }
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
                for($i=count($test)-1;$i>=0;$i--){
                    ECHO '<div class="przyklad">';
                    ECHO '<p style="text-align: center; color: white; background-color: #0E0E0E; margin: 0 0 0 0; padding: 16px 0 16px 0;"><b>'.$test[$i]['name'].'</b></p>';
                    ECHO '<img style="height: 200px; max-width: 329px; margin: 5px auto; display: block;" src="'.$test[$i]['img'].'">';
                    $opis_projekty=$test[$i]['opis'];
                    if(strlen($opis_projekty)>100){
                        $opis_projekty=substr($opis_projekty,0,90);
                        $opis_projekty.="... czytaj dalej>>";
                    }
                    ECHO '<p style="text-align: center; color: white; background-color: #5B5B5B; margin: 0 0 0 0; padding: 16px 0 16px 0;font-size: 13px;">'.$opis_projekty.'</p>';
                    $map="map".$i;
                    ECHO '<div id="'.$map.'" style="max-width:329px; margin: 5px auto; display: block; height:150px;background:yellow"></div>';

                    $sql = "SELECT NS_loc, WE_loc FROM miejsca WHERE id=".'"'.$test[$i]['id_przestrzeni'].'"';
                    $create= new My_op($db_host, $db_log, $db_pass, $db_name);
                    $create->query($sql);
                    $lok= $create->getRow();
                    unset($create);
                    //poczatek echo
                    ECHO "<script>
                    function myMap() {
                    var mapOptions = {
                        center: new google.maps.LatLng($lok[NS_loc], $lok[WE_loc]),
                        zoom: 14,
                        mapTypeId: google.maps.MapTypeId.HYBRID
                    };
                    var map = new google.maps.Map(document.getElementById(\"$map\"), mapOptions);
                            var marker = new google.maps.Marker({
                              position: {lat: $lok[NS_loc], lng: $lok[WE_loc]},
                              map: map
                            });     
                    }
                    </script>
                    <script src=\"https://maps.googleapis.com/maps/api/js?key=AIzaSyBlp-vacFl7wA8OPdqtqZGDtERDkskAmZk&callback=myMap\"></script>";
                    //koniec echo
                    ECHO '<p style="float:left; display: inline; width: 41%;text-align: center; color: dodgerblue; background-color: #5B5B5B; margin: 0 0 0 0; padding: 16px 0 16px 0;font-size: 13px;">'."Zainteresowanie: ".$test[$i]['zajete'].'</p>';
                    ECHO '<p style="float: left; width: 22%; text-align: center; color: dodgerblue; background-color: #404040; margin: 0 0 0 0; padding: 16px 0 16px 0;font-size: 13px;">'.$test[$i]['data'].'</p>';
                    ECHO '<p style="float: left; width: 37%; text-align: center; color: dodgerblue; background-color: #5B5B5B; margin: 0 0 0 0; padding: 16px 0 16px 0;font-size: 13px;">'."Max: ".$test[$i]['miejsca'].'</p>';
                    ECHO '<a style=" text-decoration: none;" href="projekt.php?id='.$test[$i]['id'].'"><p style="clear: both; text-align: center; color: white; background-color: #5B5B5B; margin: 60px 0 0 0; padding: 16px 0 16px 0;font-size: 20px; font-family: Arial, Helvetica, sans-serif;"><b>'."Wiecej info".'</b></p></a>';
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
            if($dec==3){
                $sql = "SELECT * FROM miejsca";
                $create= new My_op($db_host, $db_log, $db_pass, $db_name);
                $create->query($sql);
                $test= $create->getAllRows();
                unset($create);
                for($i=count($test)-1;$i>=0;$i--){
                    ECHO '<div class="przyklad">';
                    ECHO '<p style="text-align: center; color: white; background-color: #0E0E0E; margin: 0 0 0 0; padding: 16px 0 16px 0;"><b>'.$test[$i]['id'].". ".$test[$i]['name'].'</b></p>';
                    ECHO '<img style="height: 200px; max-width: 329px; margin: 5px auto; display: block;" src="'.$test[$i]['img'].'">';
                    $opis_projekty=$test[$i]['opis'];
                    if(strlen($opis_projekty)>100){
                        $opis_projekty=substr($opis_projekty,0,90);
                        $opis_projekty.="... czytaj dalej>>";
                    }
                    ECHO '<p style="text-align: center; color: white; background-color: #5B5B5B; margin: 0 0 0 0; padding: 16px 0 16px 0;font-size: 13px;">'.$opis_projekty.'</p>';
                    $map="map".$i;
                    ECHO '<div id="'.$map.'" style="max-width:329px; margin: 5px auto; display: block; height:150px;background:yellow"></div>';

                    //poczatek echo
                    ECHO "<script>
                    function myMap() {
                    var mapOptions = {
                        center: new google.maps.LatLng(".$test[$i]['NS_loc'].", ".$test[$i]['WE_loc']."),
                        zoom: 14,
                        mapTypeId: google.maps.MapTypeId.HYBRID
                    };
                    var map = new google.maps.Map(document.getElementById(\"$map\"), mapOptions);
                            var marker = new google.maps.Marker({
                              position: {lat: ".$test[$i]['NS_loc'].", lng: ".$test[$i]['WE_loc']."},
                              map: map
                            });     
                    }
                    </script>
                    <script src=\"https://maps.googleapis.com/maps/api/js?key=AIzaSyBlp-vacFl7wA8OPdqtqZGDtERDkskAmZk&callback=myMap\"></script>";
                    //koniec echo
                    ECHO '<a style=" text-decoration: none;" href="przestrzen.php?id='.$test[$i]['id'].'"><p style="clear: both; text-align: center; color: white; background-color: #5B5B5B; top: 400px;margin: 0px 0 0 0; padding: 16px 0 16px 0;font-size: 20px; font-family: Arial, Helvetica, sans-serif;"><b>'."Wiecej info".'</b></p></a>';
                    ECHO '</div>';

                }
            }

        }
        else{
            $sql = "SELECT * FROM projekty";
            $create= new My_op($db_host, $db_log, $db_pass, $db_name);
            $create->query($sql);
            $test= $create->getAllRows();
            unset($create);
            for($i=count($test)-1;$i>=0;$i--){
                ECHO '<div class="przyklad">';
                ECHO '<p style="text-align: center; color: white; background-color: #0E0E0E; margin: 0 0 0 0; padding: 16px 0 16px 0;"><b>'.$test[$i]['name'].'</b></p>';
                ECHO '<img style="height: 200px; max-width: 329px; margin: 5px auto; display: block;" src="'.$test[$i]['img'].'">';
                $opis_projekty=$test[$i]['opis'];
                if(strlen($opis_projekty)>100){
                    $opis_projekty=substr($opis_projekty,0,90);
                    $opis_projekty.="... czytaj dalej>>";
                }
                ECHO '<p style="text-align: center; color: white; background-color: #5B5B5B; margin: 0 0 0 0; padding: 16px 0 16px 0;font-size: 13px;">'.$opis_projekty.'</p>';
                $map="map".$i;
                ECHO '<div id="'.$map.'" style="max-width:329px; margin: 5px auto; display: block; height:150px;background:yellow"></div>';

                $sql = "SELECT NS_loc, WE_loc FROM miejsca WHERE id=".'"'.$test[$i]['id_przestrzeni'].'"';
                $create= new My_op($db_host, $db_log, $db_pass, $db_name);
                $create->query($sql);
                $lok= $create->getRow();
                unset($create);
                ECHO <<< END
<script>
function myMap() {
var mapOptions = {
    center: new google.maps.LatLng($lok[NS_loc], $lok[WE_loc]),
    zoom: 14,
    mapTypeId: google.maps.MapTypeId.HYBRID
}
var map = new google.maps.Map(document.getElementById("$map"), mapOptions);
        var marker = new google.maps.Marker({
          position: {lat: $lok[NS_loc], lng: $lok[WE_loc]},
          map: map
        });     
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBlp-vacFl7wA8OPdqtqZGDtERDkskAmZk&callback=myMap"></script>
END;
                ECHO '<p style="float:left; display: inline; width: 41%;text-align: center; color: dodgerblue; background-color: #5B5B5B; margin: 0 0 0 0; padding: 16px 0 16px 0;font-size: 13px;">'."Zainteresowanie: ".$test[$i]['zajete'].'</p>';
                ECHO '<p style="float: left; width: 22%; text-align: center; color: dodgerblue; background-color: #404040; margin: 0 0 0 0; padding: 16px 0 16px 0;font-size: 13px;">'.$test[$i]['data'].'</p>';
                ECHO '<p style="float: left; width: 37%; text-align: center; color: dodgerblue; background-color: #5B5B5B; margin: 0 0 0 0; padding: 16px 0 16px 0;font-size: 13px;">'."Max: ".$test[$i]['miejsca'].'</p>';
                ECHO '<a style=" text-decoration: none;" href="projekt.php?id='.$test[$i]['id'].'"><p style="clear: both; text-align: center; color: white; background-color: #5B5B5B; margin: 60px 0 0 0; padding: 16px 0 16px 0;font-size: 20px; font-family: Arial, Helvetica, sans-serif;"><b>'."Wiecej info".'</b></p></a>';
                ECHO '</div>';

            }
        }
ECHO '</div>';
?>
<footer>

</footer>


</body>
</html>