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
        <p style="padding: 16px 0 16px 0; font-family: Arial, Helvetica, sans-serif; background-color: darkblue;font-size: 18px;">Dodawanie przestrzeni</p>
        <form method="post" action="../action/createPlace.php" style="border:1px solid #ccc">
            <label><b>Nazwa przestrzeni</b></label>
            <input id="form_login" type="text" placeholder="Place name" name="name" required>

            <label><b>Zrodlo obrazka</b></label>
            <textarea style="max-width: 100%; max-height: 80px;" id="form_email" type="text" placeholder="IMG source" name="img" required></textarea>

            <label><b>Opis</b></label>
            <textarea style="max-width: 100%; max-height: 80px;" id="form_email" type="text" placeholder="Place description" name="opis" required></textarea>

            <label><b>Wspolzedna Y (NS)</b></label>
            <input id="form_pass" max="85" min="-85" type="number" step="0.00000001" lang="en-US" placeholder="North-South coordinate" name="loc_ns" required>
            <label><b>Wspolzedna X (WE)</b></label>
            <input id="form_pass" max="180" min="-180" type="number" step="0.00000001" lang="en-US" placeholder="West-East coordinate" name="loc_we" required>

            <div class="clearfix">
                <button id="form_submit" type="submit" class="signupbtn">Dodaj</button>
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