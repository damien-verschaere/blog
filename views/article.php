<?php
session_start();
require "../functions/function.php";

var_dump($_GET['article']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require "requires/require_meta.php" ?>
    <title>Articles</title>
</head>
<body>
    <header>
        <?php 
            require "requires/require_Header.php";
        ?>
    </header>


<?php
require "requires/require_Footer.php";
?>
</body>
</html>