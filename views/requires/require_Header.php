<?php
 droit_user();
 /**REGLE DE COMPORTEMENT */
 if(isset($_POST['open_navbar'])){//Premier Input pour ouvrir ou fermer la barre de navigation
    $_SESSION['onpen_navbar'] = $_POST['open_navbar'];
 }
 elseif(empty($_SESSION['open_navbar'])) {
     $_SESSION['open_navbar'] = 'close';
 }
 if(isset($_POST['size_navbar'])){
    $_SESSION['size_navbar'] = $_POST['size_navbar'];//DEuxième input qui influ sur le CSS
 }
 elseif(empty($_SESSION['size_navbar'])) {
    $_SESSION['size_navbar'] = 'large';
 }
?>
<section class="navbar_header"><!-- << Section Barre header -->
    <!-- DIVISION LOGO & ICON BURGER -->
    <div class='primo_div_header'>
        <?php 
        if(isset($_SESSION['id'])){
            if((empty($_POST['open_navbar'])) || ($_SESSION['onpen_navbar']=='close')){ ?>
            <!-- FORMULAIRE POUR OUVRIR LA NAVBARRE -->
            <form>
                <button  action="" formmethod="post" type="submit" name="open_navbar" value="open"><i class="fa-solid fa-bars"></i></button>
            </form>
            <?php }
            else {?>
            <!-- FORMULAIRE POUR FERMER LA NAVBARRE -->
            <form>
                <button  action="" formmethod="post" type="submit" name="open_navbar" value="close"><i class="fa-solid fa-bars"></i></button>
            </form>
            <?php }
        } ?>
           <!-- LOGO DE RETOUR -->
        <a href="accueil.php"><img class="logo_navabar_header" src="..\assets\img\beblog_logo_nav.png" alt="Logo de l'entreprise beblog"></a>
    </div>
    <?php if(droit_user()=='none'){?>
        <!-- DIVISION DE DROITE, CONNEXION OU INSCRIPTION -->
    <div class="connect">
        <a class="a_inscription_header" href="inscription.php">S'inscrire</a>
        <a class="a_connexion_header" href="connexion.php">
            <div class="button_connexion_header">
                <p>connexion<p>
            </div>
        </a>
    </div>
    <?php }
        else{ ?>
        <!-- DIVISION DE DROITE, LOGIN OU Photo de profil -->
        <div class='primo_div_header'>
            <h3><?=$_SESSION['login']?></h3>
            <div class="contour_icon_user_header">
                <div class="icon_user_header">
                <?php affichage_miniature() ?>
                </div>
            </div>
        </div>
    <?php } ?> 
</section>
            <!-- SI LE FORME EST OPEN -->
<?php if(isset($_SESSION['onpen_navbar']) && $_SESSION['onpen_navbar']=='open'){?>
<nav class="<?=$_SESSION['size_navbar']?>_nav_verticale_header">
    <section class="all_a_nav_vertical_header">
        <section class="navbar_section_art_header"><!-- SECTION DESTINEE A LA NAVIGATION -->
            <div class="cesure_navbar_vertical_header"></div>
            <a href="categories.php">
                <span class="smal_a"><i class="fas fa-tag"></i></span>
                <span class="large_a">Catégories</span>
            </a>
            <div class="cesure_navbar_vertical_header"></div>
            <a href="articles.php">
                <span class="smal_a"><i class="fa-solid fa-newspaper"></i></span>
                <span class="large_a">Articles</span>
            </a>
            <div class="cesure_navbar_vertical_header"></div>
        </section>
        <section class="navbar_section_user_header"><!-- SECTION DESTINEE A L'UTILISATEUR -->
        <a href="profil.php">
            <span class="smal_a"><i class="fa-solid fa-user"></i></span>
            <span class="large_a">Mon Profil</span>
        </a>
        <div class="cesure_navbar_vertical_header"></div>
        <?php if(droit_user()=='modo'||(droit_user()=='admin')){?> <!-- PAGE DESTINEE AU MODERATEUR -->
            <a href="creer-article.php">
                <span class="smal_a"><i class="fa-solid fa-square-plus"></i></span>
                <span class="large_a">Nouvel Article</span>
            </a>
            <div class="cesure_navbar_vertical_header"></div>
        <?php } 
            if(droit_user()=='admin'){?> <!-- PAGE DESTINEE AU ADMINISTRATEUR -->
            <a href="admin.php">
                <span class="smal_a"><i class="fa-solid fa-unlock-keyhole"></i></span>
                <span class="large_a">Administrateur</span>
            </a>
            <div class="cesure_navbar_vertical_header"></div>
        <?php } ?>
        </section>
        <section>
        <a href="requires/deconnexion.php">
            <span class="smal_a"><i class="fa-solid fa-right-from-bracket"></i></span>
            <span class="large_a">Se deconnecter</span>
        </a>
        <div class="cesure_navbar_vertical_header"></div>
        </section>
    </section>
        <section class="section_form_navbar_vert_header">
        <!-- FORMULAIRE POUR CHOISIR L'ETAT DE LECTURE -->
        <?php if(empty($_POST['size_navbar']) || ($_SESSION['size_navbar']=='large')){ ?>
        <form>
        <button  action="" formmethod="post" type="submit" name="size_navbar" value="small"><i class="fa-solid fa-angles-left"></i></button>
        </form>
        <?php }
        else{ ?>
        <form>
        <button  action="" formmethod="post" type="submit" name="size_navbar" value="large"><i class="fa-solid fa-angles-right"></i></button>
        </form>
        <?php } ?>
        </section>
</nav>
<?php } ?>
