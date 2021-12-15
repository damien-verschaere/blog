<?php
require "../functions/function.php";
session_start();
echo $_SESSION['id'];
require "requires/require_meta.php";
require "requires/require_Header.php";
?>
<h3 class="titre_profil">Bonjour, bienvenue <?= $_SESSION['login'] ?></h3>

<form class="form_connexion" action="" method="post">
    <label for="login">Login</label></br>
    <input type="text" name="login" placeholder="Login">
    <br>

    <label for="password">Password</label></br>
    <input type="password" name="password" placeholder="Password">
    </br><br>
    
    <input type="submit" name="submit_connexion" value="Connexion">
</form>



<?php
require "requires/require_Footer.php";
?>