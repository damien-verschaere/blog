
<nav class="navbar_footer">
        <a href="articles.php">
            <span class="large_a">Articles</span>
        </a>
        <div class="cesure_navbar_footer"></div>
    <?php
        if(droit_user()=='none'){
            ?>
            <a href="inscription.php">
            <span class="large_a">S'inscrire</span>
            </a>
            <div class="cesure_navbar_footer"></div>
            <a href="connexion.php">
            <span class="large_a">Se connecter</span>
            </a>
            <div class="cesure_navbar_footer"></div>
            <a href="https://github.com/damien-verschaere/blog">
            <span class="large_a">Github</span>
            </a>
            <?php
            }
        if(droit_user()!='none'){
    ?>
        <a href="profil.php">
            <span class="large_a">Mon Profil</span>
        </a>
    <div class="cesure_navbar_footer"></div>
    <?php if((droit_user()=='modo')||(droit_user()=='admin')){?> <!-- PAGE DESTINEE AU MODERATEUR -->
        <a href="creer-article.php">
            <span class="large_a">Nouvel Article</span>
        </a>
        <div class="cesure_navbar_footer"></div>
        <a href="https://github.com/damien-verschaere/blog">
            <span class="large_a">Github</span>
            </a>
        <div class="cesure_navbar_footer"></div>
    <?php } 
        elseif(droit_user()=='admin'){?> <!-- PAGE DESTINEE AU ADMINISTRATEUR -->
        <a href="admin.php">
            <span class="large_a">Administrateur</span>
        </a>
        <div class="cesure_navbar_footer"></div>
        <a href="https://github.com/damien-verschaere/blog">
            <span class="large_a">Github</span>
            </a>
        <div class="cesure_navbar_footer"></div>
    <?php } 
    ?>
    <section>
    <a href="requires/deconnexion.php">
        <span class="large_a">Se deconnecter</span>
    </a>
    </section>
    <?php
    }
    ?>