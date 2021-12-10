<?php

session_start();

require "requires/require_Header.php";

require "../functions/function.php";

?>
<form method="get" action="">
<?php
affiche_all_articles();
?>
</form>



<?php
require "requires/require_Footer.php";
?>