<?php
session_start();
?>
<!Doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Stworz konto</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body style="background-color: purple;">
<a id="aform_back" href="../index.php">
    <div id="form_back">
        <p>Powrot do storny glownej</p>
    </div>
</a>
<div id="form_cont">
    <div id="fform">
        <p style="padding: 16px 0 16px 0; font-family: Arial, Helvetica, sans-serif; background-color: darkblue;font-size: 18px;">Tworzenie projektu</p>
        <form method="post" action="../action/createProject.php" style="border:1px solid #ccc">
            <label><b>Nazwa projektu</b></label>
            <input id="form_login" type="text" placeholder="Project name" name="name" required>
            <label><b>Wybierz przestrzen i podaj ID</b></label>
            <input id="form_pass" type="number" min="0" step="1" placeholder="Place ID" name="place_id" required>
            <label><b>Termin</b></label><?php //tutaj ustawiamy minimalnie nastepny dzien
                $min_date=date("Y");
                $min_date.="-";
                $min_date.=date("m");
                $min_date.="-";
                if((date("d")+1) <10){
                    $min_date.="0";
                    $min_date.=date("d")+1;
                }
                else{
                    $min_date.=date("d")+1;
                }
            ECHO '<input id="form_passw" min="'.$min_date.'" type="date" name="date" required>';
            ?>
            <label><b>URL obrazka reprezentujacego</b></label>
            <textarea style="max-width: 100%; max-height: 80px;" id="form_email" type="text" placeholder="IMG source" name="img" required></textarea>

            <label><b>Maksymalna liczba osób</b></label>
            <input id="form_pass" min="5" type="number" step="1" lang="en-US" placeholder="Max people" name="max_people" required>
            <label><b>Opis</b></label>
            <textarea style="max-width: 100%; max-height: 80px;" id="form_email" type="text" placeholder="Project description" name="opis" required></textarea>


            <div class="clearfix">
                <button id="form_submit" type="submit" class="signupbtn">Stwórz</button>
            </div>
        </form>
        <?php
        if(isset($_SESSION['errno'])){
            ECHO '<p style="color: red">'.$_SESSION['errno'].'</p>';
            unset($_SESSION['errno']);
        }
        ?>
    </div>
</div>

</body>
</html>