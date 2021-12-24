<?php
session_start();
require "../functions/function.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require "requires/require_meta.php" ?>
    <title>Article</title>
</head>
<body>
    <header>
        <?php 
            require "requires/require_Header.php";
        ?>
    </header>
    <main class="main_center">
        <section class="section_articles">
            <div class="bloc_affiche_article">
            <?php
                affiche_self_article();
                post_commentaire_article();
            ?>
            </div>
            <?php
                    if (!isset($_SESSION['id'])){
            ?>

            <div class="message_commentaire_article">
                <p class="texte_commentaire_article">
                    Veuillez vous <a class="hyperliens" href="inscription.php">inscrire</a> ou vous <a class="hyperliens" href="connexion.php">connectez</a> afin de poster un commentaire.
                </p>
            </div> 
            <?php
                    } else {
            ?>
            <form method="post" action="">
                <textarea name="commentaire_article" class="textarea_commentaire_article" placeholder="Veuillez entrez votre commentaire" wrap="hard" rows="6" cols="50" ></textarea>
                </br>
                <input class="input_commentaire" type="submit" name="submit_commentaire_article" value="Envoyer">
            </form>
            <?php
                    }
                affiche_commentaires_article();
                info_barre();
            ?>
            
        </section>
    </main>

    <?php
        require "requires/require_Footer.php";
    ?>
</body>
</html>