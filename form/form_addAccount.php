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
        <p style="padding: 16px 0 16px 0; font-family: Arial, Helvetica, sans-serif; background-color: darkblue;font-size: 18px;">Tworzenie nowego konta</p>
        <form method="post" action="../action/createAcc.php" style="border:1px solid #ccc">
            <label><b>Login</b></label>
            <input id="form_login" type="text" placeholder="Enter Login" name="login" required>

            <label><b>Kim jesteś:</b></label>
            <select id="form_sele" name="type" required>
                <option value="uczestnik">Uczestnik</option>
                <option value="organizator">Organizator</option>
                <option value="wlasciciel przestrzeni">Właściciel przestrzeni</option>
                <option value="wolontariusz">Wolontariusz</option>
            </select>

            <label><b>Email</b></label>
            <input id="form_email" type="text" placeholder="Enter Email" name="email" required>

            <label><b>Hasło</b></label>
            <input id="form_pass" type="password" placeholder="Enter Password" name="pass" required>

            <label><b>Powtórz Hasło</b></label>
            <input id="form_pass" type="password" placeholder="Repeat Password" name="pass_rep" required>
            <input id="form_checkbox" type="checkbox" checked="checked"> Zapamientaj mnie

            <div class="clearfix">
                <button id="form_submit" type="submit" class="signupbtn">Sign Up</button>
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