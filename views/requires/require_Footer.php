
<nav class="navbar_footer">
        <a href="articles.php">
            <span class="large_a">Article</span>
        </a>
        <div class="cesure_navbar_footer"></div>
    <a href="profil.php">
        <span class="large_a">Mon Profil</span>
    </a>
    <div class="cesure_navbar_footer"></div>
    <?php if(droit_user()=='modo'){?> <!-- PAGE DESTINEE AU MODERATEUR -->
        <a href="creer-article.php">
            <span class="large_a">Nouvel Article</span>
        </a>
        <div class="cesure_navbar_footer"></div>
    <?php } 
        elseif(droit_user()=='admin'){?> <!-- PAGE DESTINEE AU ADMINISTRATEUR -->
        <a href="admin.php">
            <span class="large_a">Administrateur</span>
        </a>
        <div class="cesure_navbar_footer"></div>
    <?php } ?>
    <section>
    <a href="deconnexion.php">
        <span class="large_a">Se deconnecter</span>
    </a>
</section>