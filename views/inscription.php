<?php
session_start();


require "../functions/function.php";
require "requires/require_Header.php";
?>
    <main>
        <form action="inscription.php" method="post">
            <input type="text" placeholder="login" name=login>
            <input type="email" placeholder="email" name="email">
            <input type="password" placeholder="password" name="password">
            <input type="password" placeholder="confirm password" name="password2">
            <input type="submit" name="inscription">
            <?php inscription()?>
        </form>
    </main>
    
<?php
require "requires/require_Footer.php";
?>