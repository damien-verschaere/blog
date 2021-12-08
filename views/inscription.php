<?php
session_start();

require "requires/require_Header.php";

require "../functions/function.php";

?>
    <main>
        <form action="inscription.php" method="post">
            <input type="text" placeholder="login" name=login>
            <input type="email" placeholder="email" name="email">
            <input type="password" placeholder="password" name="password">
            <input type="submit" name="inscription">
            <?php inscription()?>
            test
        </form>
    </main>
    
<?php
require "requires/require_Footer.php";
?>