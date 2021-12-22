<?php
    /*Fonction de connexion à la base de données */
    function connexion_BDD(){
        $connexion = mysqli_connect('localhost', 'root', '', 'blog');
        mysqli_set_charset($connexion, 'utf8');
        return $connexion;
    }
    function select_all_categories_BDD(){
        $requete=mysqli_query(connexion_BDD(),"SELECT * FROM `categories`");
        $result=mysqli_fetch_all($requete,MYSQLI_ASSOC);
        return $result;
    }
    function select_miniature_BDD(){
        $id_data = $_SESSION['id'];
        $verif_icon = mysqli_query(connexion_BDD(),"SELECT `icon` FROM `utilisateurs` WHERE `id`='$id_data'");
        $result_icon =  mysqli_fetch_assoc($verif_icon);
        $src_miniature = $result_icon['icon'];
        return $src_miniature;
    }
    /*------------------- Donner les droit pour l'affichage------------------- */
    function droit_user(){
        if(!isset($_SESSION['id_droits'])){
            $droit_user = 'none';
        }
        elseif($_SESSION['id_droits']=='42'){
            $droit_user = 'modo';
        }
        elseif($_SESSION['id_droits']=='1337'){
            $droit_user = 'admin';
        }
        elseif($_SESSION['id_droits']=='1'){
            $droit_user = 'user';
        }
        return  $droit_user;
    }
    /*----------------------------PAGE INSCRIPTION------------------------------- */
    function inscription(){
            
        
        if ( isset($_POST['inscription'])){
            $login = htmlspecialchars ( $_POST['login'] );
            $email = htmlspecialchars ( $_POST['email'] );
            $password = htmlspecialchars( $_POST['password'] );
            $password2 = $_POST['password2'];
            $icon = $_POST['icon'];
            $droit = 1;

            if ( empty($login)) {
                echo $_SESSION['error_validation'] ='champ login vide';
        }
        elseif (empty($email)) {
            echo  $_SESSION['error_validation'] = "veuillez remplir le champ email ";;
        }
        elseif ( empty($password)) {
            echo  $_SESSION['error_validation']="remplissez le champ password "; 
        }
        elseif ($password != $password2) {
            echo  $_SESSION['error_validation'] = " Les passwords ne correspondent pas .";
        }
        elseif (!empty($login)) {
            $veriflogin = mysqli_query(connexion_BDD(),"SELECT login FROM utilisateurs WHERE login= '$login'");
            if ( mysqli_num_rows($veriflogin) == 1) {
                echo $_SESSION['error_validation']="Le login existe deja ";
            }
            else {
                
                $cryptage = password_hash($password,PASSWORD_DEFAULT);
                $requete = mysqli_query(connexion_BDD()," INSERT INTO utilisateurs (`login`,`password`,`email`,`id_droits`,`icon`) VALUES ('$login','$cryptage','$email','$droit','$icon')");
                header('location:' . 'connexion.php');
            }
        }
        }
    }
#affiche les 3 premiers articles de la page index
    function affiche_article(){
        $req=mysqli_query(connexion_BDD(),"SELECT `id` ,`titre`,`introduction`,`article`,`date`,`image_article`,`id_categorie` FROM `articles` order by date DESC LIMIT 3 ");
        $result=mysqli_fetch_all($req,MYSQLI_ASSOC);
        foreach ($result as $key) {
            $requete_categories = mysqli_query(connexion_BDD(),"SELECT * FROM categories WHERE id= '$key[id_categorie]'");
            $resultat_categorie=mysqli_fetch_array($requete_categories,MYSQLI_ASSOC);
            echo "<div class=.global_accueil>";
            echo "<a class=href href= article.php?article=".$key['id'].">";
            echo "<div class=".$resultat_categorie['style']."_a_background_categories >";
            echo "<div class=titre_accueil>";
            echo "<h4>". strtoupper( $key['titre'])."</h4>";
            echo "</div>";
            echo "<div class=content_img_categoriese >";
            echo "<img src=".$key['image_article'].">";
            echo "</div>";
            echo "<div class=footer_affiche_accueil>";
            echo "<h4>". $key['introduction']."</h4>";
            echo "<p>".$key['date']."</p>";
            echo "</div>";
            echo "</div>";
            echo "</a>";
            echo "</div>";
            
        }
      
    }

function affiche_article_com(){
    $requete=mysqli_query(connexion_BDD(),"SELECT a.id,a.titre,a.introduction,a.article,a.date,a.id_categorie,a.image_article,tmp.commentaire FROM articles a INNER JOIN ( SELECT id_article, COUNT(*) commentaire FROM commentaires GROUP BY id_article ) tmp ON a.id = tmp.id_article ORDER BY commentaire DESC LIMIT 3");
    $resultat=mysqli_fetch_all($requete,MYSQLI_ASSOC);
    foreach ($resultat as $key) {
        $requete_categories = mysqli_query(connexion_BDD(),"SELECT * FROM categories WHERE id= '$key[id_categorie]'");
        $resultat_categorie=mysqli_fetch_array($requete_categories,MYSQLI_ASSOC);
        echo "<div class=.global_accueil>";
            echo "<a class=href href= article.php?article=".$key['id'].">";
            echo "<div class=".$resultat_categorie['style']."_a_background_categories >";
            echo "<div class=titre_accueil>";
            echo "<h4>". strtoupper( $key['titre'])."</h4>";
            echo "</div>";
            echo "<div class=content_img_categoriese >";
            echo "<img src=".$key['image_article'].">";
            echo "</div>";
            echo "<div class=footer_affiche_accueil>";
            echo "<h4>". $key['introduction']."</h4>";
            echo "<p>".$key['date']."</p>";
            echo "</div>";
            echo "</div>";
            echo "</a>";
            echo "</div>";
    }

    
}
      /*----------------------------PAGE CREER ARTICLE------------------------------- */

    

function affiche_categorie(){
     $requete = mysqli_query(connexion_BDD(),"SELECT * FROM categories");
     $result = mysqli_fetch_all($requete,MYSQLI_ASSOC);
     foreach ($result as $key ) {
         echo "<option value=".$key['id'].">".$key['nom']."</option>";
     }
     
 }
 function creer_article(){
    if (isset($_POST['creer'])) {
        $categorie=$_POST['categorie'];
        $titre=addslashes(htmlspecialchars($_POST['titre']));
        $titreBDD=addslashes(htmlspecialchars($_POST['titre']));
        $description=addslashes(htmlspecialchars($_POST['description']));
        $article=addslashes(htmlspecialchars($_POST['article']));
        $space=" ";
        $replace="";
        $outString=str_replace($space,$replace,$titreBDD);
        $titreBDD=$outString;
   
        
            if (isset($_FILES['image_article']) ){
                $filename = $_FILES['image_article']['tmp_name']; // On récupère le nom du fichier
                    $tailleMax = 5242880; // Taille maximum 5 Mo
                    // 2mo  = 2097152
                    // 3mo  = 3145728
                    // 4mo  = 4194304
                    // 5mo  = 5242880
                    // 7mo  = 7340032
                    // 10mo = 10485760
                    // 12mo = 12582912
                    $extensionsValides = array('jpg','jpeg','png','JPG'); // Format accepté
                    if ($_FILES['image_article']['size'] <= $tailleMax){ // Si le fichier et bien de taille inférieur ou égal à 5 Mo
                        
                        $extensionUpload = strtolower(substr(strrchr($_FILES['image_article']['name'], '.'), 1)); // Prend l'extension après le point, soit "jpg, jpeg ou png"
 
                        if (in_array($extensionUpload, $extensionsValides)){ // Vérifie que l'extension est correct
                            
                            $dossier = "../assets/images_article" .$categorie . "/"; // On se place dans le dossier de la personne 
                            if (!is_dir($dossier)){ // Si le nom de dossier n'existe pas alors on le crée

                                mkdir($dossier);

                            }
                            $nom = uniqid(rand()) ; // Permet de générer un nom unique à la photo
                            $chemin = "../assets/images_article" .$categorie . "/" . $nom . "." . $extensionUpload; // Chemin pour placer la photo
                            $resultat = move_uploaded_file($_FILES['image_article']['tmp_name'], $chemin); // On fini par mettre la photo dans le dossier
                            if ($resultat){ // Si on a le résultat alors on va comprésser l'image
                                    
                                    $verif_ext = getimagesize("../assets/images_article" .$categorie . "/" . $nom . "." . $extensionUpload);
                                    
                                    // Vérification des extensions avec la liste des extensions autorisés
                                                  
                                        // J'enregistre le chemin de l'image dans filename
                                        $filename = "../assets/images_article" .$categorie . "/" . $nom . "." . $extensionUpload;
                                        
                                        // Vérification des extensions que je souhaite prendre
                                        if($extensionUpload == 'jpg' || $extensionUpload == 'png' || $extensionUpload == "JPG"|| $extensionUpload == "gif" ){
                                            
                                            // Content type
                                            
                                        echo '<script language="Javascript">document.location.replace("accueil.php")</script>';

                                            
                                            
                                        }
                                        
                                       
                                    }
                                } 
                            }
                            
                        }
                    }
                    error_reporting(E_ERROR | E_PARSE);
                mysqli_query(connexion_BDD(),"INSERT INTO articles(id, titre, introduction, article, id_utilisateur, id_categorie, date,image_article) VALUES ( NULL,'$titre','$description','$article','$_SESSION[id]','$categorie',NOW(),'$filename')"); 
                }
                    
                
            



    /*----------------------------PAGE CONNEXION------------------------------- */
    /*Fonction de verification des informations de connexion */
    function verif_user_connexion(){
        /*Variable de récupération des messages d'erreur */
        $message_erreur = "";

        /*Si l'user envoie le formulaire */
        if (isset($_POST['submit_connexion'])){

            /*Sécurisation des données entrer dans le formulaire */
            $login = htmlspecialchars($_POST['login']);
            $password = htmlspecialchars($_POST['password']);

            /*Requete SQL sélectionnant le login et le password correspondant à ceux entrer en formulaire */
            $requete_user_connexion = mysqli_query(connexion_BDD(), "SELECT * FROM utilisateurs where login = '$login'");
            $result_user_connexion = mysqli_fetch_array($requete_user_connexion, MYSQLI_ASSOC);

            /* Si les champs sont correctement remplis */
            if ( !empty ($_POST['login']) && !empty ($_POST['password'])){
                /*Si le login est reconnu en base de données */
                if ( $login = $result_user_connexion['login']){
                    //Si le mot de passe est reconnu en base de données alors la connexion a lieu
                    if (password_verify($password, $result_user_connexion['password'])){
                        $_SESSION['login'] = $login;
                        $_SESSION['id'] = $result_user_connexion['id'];
                        $_SESSION['id_droits'] = $result_user_connexion['id_droits'];
                        header("location: accueil.php");
                    } else {
                        $message_erreur = "Mot de passe incorrect";
                        echo $message_erreur;
                    }
    
                } else {
                    $message_erreur = "Login incorrect";
                    echo $message_erreur;
                }
            } else {
                $message_erreur = "Veuillez remplir les champs vides";
                echo $message_erreur;
            }
        }
    }
    

/*----------------------------PAGE ARTICLES------------------------------- */

function affiche_all_articles(){
        

    //On selectionne la totalité des infos des catégories afin des les afficher dans nos inputs
    $requete_categories = mysqli_query(connexion_BDD(),"SELECT * FROM categories");

    //on récupere le résultat en gardant le nom de nos index
    $result_categories = mysqli_fetch_all($requete_categories, MYSQLI_ASSOC);
        
        //Puis on boucle de l'index du résultat de notre requête afin de créer le nombre d'input équivalent au nombre de catégorie
        $p = 0;
        while(isset($result_categories[$p])){
        ?>
            <button type="submit" name="categories" value="<?= $result_categories[$p]['id']?>"><?= $result_categories[$p]['nom']?></button>
        <?php
            $p++;
        }
        ?>
        <form method="post" action="">
            <input type="submit" name="all" value="Tous">
        </form>
        <?php
    //Si une catégorie est définie
    if (isset($_GET['categories'])){
            
            //Alors on récupere la valeur de l'url et on l'assimile à notre variable 'id de categorie'
            $id_categories_get = $_GET['categories'];
            //Afin de préparer la pagination, on choisit un nombre d'article à afficher sur notre page
            $nombre_articles_categories = 5;
            
            //On compte le nombre total d'articles ou '$id' correspond à l'id de catégorie connu en base de donnée
            //Afin de n'afficher que le nombre de page pour les articles concernés
            //Sans sa la pagination sera faite pour des articles dont la catégorie ne correspond pas et cela créera des pages vides
            $count_total_articles_categories = mysqli_query(connexion_BDD(),"SELECT COUNT(*) AS nombre_articles_cat FROM articles WHERE id_categorie = '$id_categories_get'");

            //On récupere le nombre total d'articles correspondant à la catégorie
            $nombre_categories = mysqli_fetch_array($count_total_articles_categories,MYSQLI_ASSOC);

            //Puis calcule le nombre de page en divisant 'le nombre d'articles total' par 'le nombre d'articles par page'
            //On utilise la fonction systême ceil afin d'arrondir au chiffre entier supérieur qui créera une page de plus même pour 1 message
            $nombre_pages = ceil($nombre_categories['nombre_articles_cat'] / $nombre_articles_categories);
        ?>
        <?php
            //Si une page est définie
            if (isset($_GET['page'])){
                
                //On récupere le numéro de page inscrit dans l'adresse 
                $page = $_GET['page'];
            //Si elle n'existe pas alors c'est la premiére fois qu'on charge la page donc on affiche la 1ere
            } else {
                $page = 1;
            }
            //On calcule que l'affichage qui devra être présent en page 1 est le résultat de page - 1 * 'nombre article'
            //Exemple = $page 1 - 1 = 0 / 0 * 5 = 0 alors on commence l'affichage à partir de l'article 0
            //$page2 - 1 = 1 / 1 * 5 = 5 alors on commence l'affichage à partir de l'article 5
            $premier_affichage_categories = ($page -1) * $nombre_articles_categories;
            //Puis on réalise une requête qui récuperera tout des tables articles user et categorie classé par date DESC et ayant pour limites de select les articles à afficher réclamer auparavant
            $affichage_articles_categories = mysqli_query(connexion_BDD(), "SELECT a.id as id_articles, a.titre, a.introduction, a.article, a.date, u.id as id_utilisateur, u.login, c.id as id_categorie, c.nom, c.style FROM articles as a INNER JOIN utilisateurs as u ON id_utilisateur=u.id INNER JOIN categories as c ON id_categorie = c.id WHERE `id_categorie` = '$id_categories_get' ORDER BY `date` DESC LIMIT $premier_affichage_categories, $nombre_articles_categories ");
            //Puis on boucle sur le résultat de la requete afin d'afficher les articles comme souhaité
            while($result_affiche_articles_categories = mysqli_fetch_array($affichage_articles_categories, MYSQLI_ASSOC)){

                if($result_affiche_articles_categories['id_categorie']=='2'){
                    $font_awesome = '<i class="fas fa-microscope"></i>';
                }
                elseif($result_affiche_articles_categories['id_categorie']=='1'){
                    $font_awesome = '<i class="fas fa-heartbeat"></i>';
                }
                elseif($result_affiche_articles_categories['id_categorie']=='3'){
                    $font_awesome = '<i class="fas fa-newspaper"></i>';
                }
                else{
                    $font_awesome = '<i class="fas fa-newspaper"></i>';
                }

                $id_article = $result_affiche_articles_categories['id_articles'];
                $requete_count_commentaire_article = mysqli_query(connexion_BDD(),"SELECT COUNT(*) FROM commentaires INNER JOIN articles ON commentaires.id_article = articles.id WHERE articles.id = $id_article");
                $result_count_commentaire_article = mysqli_fetch_array($requete_count_commentaire_article,MYSQLI_ASSOC);
                
        ?>
        <form class="<?= $result_affiche_articles_categories['style'] ?>_a_background_categories" style="border-radius: 8px;" method="get" action="">
            <a class="articles_affichage" href="../views/article.php?article=<?=$result_affiche_articles_categories['id_articles']?>">
                <article class="presentation_articles">
                    <section class="article_header_aricles">
                        <p class="categorie_affiche_articles"><?=$font_awesome?>  <?= htmlspecialchars ($result_affiche_articles_categories['nom']) ?></p>
                        <div class="div_count_com">
                            <p class="count_commentaire_article"><i class="fa-solid fa-comments"> <?= $result_count_commentaire_article['COUNT(*)'] ?></i></p>
                        </div>
                    </section>
                    <h2 class="titre_affiche_articles"><?= htmlspecialchars($result_affiche_articles_categories['titre']) ?></h2>
                    <div class="over_articles">
                        <h2 class="titre_affiche_articles"><?= htmlspecialchars($result_affiche_articles_categories['titre']) ?></h2>
                        <h3 class="introdruction_affiche-articles"><?= htmlspecialchars($result_affiche_articles_categories['introduction']) ?></h3>
                    </div>
                    <p class="user_affiche_articles"> Posté par <?= htmlspecialchars($result_affiche_articles_categories['login']) ?> le <?= htmlspecialchars($result_affiche_articles_categories['date']) ?></p>
                    <input type="hidden" name="ID" class="ID" value="<?= htmlspecialchars($result_affiche_articles_categories['id_articles']) ?> ">
                </article>
            </a>
        </form>

        <?php
            //Puis on boucle sur le nombre de page afin d'écrire les href à toutes les pages
            }
            echo "Page : ";
            $t = 0;
            for ($t = 1 ; $t <= $nombre_pages; $t++){
                echo '<a href="articles.php?categories='.$id_categories_get.'&page=' . $t . '">' . $t . '</a> ';
            }
    } elseif(!isset($_GET['categories']) || isset($_POST['all'])) {

        //On définit le nombre d'articles qu'il y aura par pages
        $nombre_articles_page = 5;
        //On effectue une requête qui compte le nombre d'articles en BDD
        $count_total_articles = mysqli_query(connexion_BDD(), "SELECT COUNT(*) AS nombre_articles FROM articles");
        //On récupere le résultat de cette requête
        $nombre = mysqli_fetch_array($count_total_articles);
        // On déclare que le nombre de page sera le résultat de la division du 'nombre d'articles' par le 'nombre d'articles par page'
        // Grace à la fonction ceil on arrondie à l'entier supérieur ce qui nous permet de créer une nouvelle page même si elle ne contient qu'un article
        $nombre_pages = ceil($nombre['nombre_articles'] / $nombre_articles_page);

        //Des que l'utilisateur choisit une page
        if (isset($_GET['start'])){
            //Alors on récupere le numéro de page inscrit dans l'adresse 
            $page = $_GET['start'];
        //Si elle n'existe pas alors c'est la premiére fois qu'on charge la page donc on affiche la 1ere
        } else {
            $page = 1;
        }

        $premier_affichage = ($page - 1 ) * $nombre_articles_page;
        //Puis on réalise une requête qui récupere tout dans le table 'articles' et 'utilisateurs' ainsi que 'categories' classé par date récente 
        $affiche_articles = mysqli_query(connexion_BDD(), "SELECT a.id as id_articles, a.titre, a.introduction, a.article, a.date, u.id as id_utilisateur, u.login, c.id as id_categorie, c.nom, c.style FROM articles as a INNER JOIN utilisateurs as u ON id_utilisateur=u.id INNER JOIN categories as c ON id_categorie = c.id ORDER BY `date` DESC LIMIT $premier_affichage,$nombre_articles_page");

            //Puis on boucle sur le résultat afin d'afficher tous les élément voulu de l'article en base de données
            while($result_affiche_articles = mysqli_fetch_array($affiche_articles, MYSQLI_ASSOC)){
                if($result_affiche_articles['id_categorie']=='2'){
                    $font_awesome = '<i class="fas fa-microscope"></i>';
                }
                elseif($result_affiche_articles['id_categorie']=='1'){
                    $font_awesome = '<i class="fas fa-heartbeat"></i>';
                }
                elseif($result_affiche_articles['id_categorie']=='3'){
                    $font_awesome = '<i class="fas fa-newspaper"></i>';
                }
                else{
                    $font_awesome = '<i class="fas fa-newspaper"></i>';
                }
                $id_article = $result_affiche_articles['id_articles'];
                $requete_count_commentaire_article = mysqli_query(connexion_BDD(),"SELECT COUNT(*) FROM commentaires INNER JOIN articles ON commentaires.id_article = articles.id WHERE articles.id = $id_article");
                $result_count_commentaire_article = mysqli_fetch_array($requete_count_commentaire_article,MYSQLI_ASSOC);
                
?>
<form class="<?= $result_affiche_articles['style'] ?>_a_background_articles" style="border-radius: 8px;" method="get" action="">
    <a class="articles_affichage" href="../views/article.php?article=<?=$result_affiche_articles['id_articles']?>">
        <article class="presentation_articles">
            <section class="article_header_aricles">
                <p class="categorie_affiche_articles"><?=$font_awesome?>  <?= htmlspecialchars($result_affiche_articles['nom']) ?></p>
                <div class="div_count_com">
                    <p class="count_commentaire_article"><i class="fa-solid fa-comments"> <?= $result_count_commentaire_article['COUNT(*)'] ?></i></p>
                </div>
            </section>
            <h2 class="titre_affiche_articles"><?= htmlspecialchars($result_affiche_articles['titre']) ?></h2>
            <div class="over_articles">
                <h2 class="titre_affiche_articles"><?= htmlspecialchars($result_affiche_articles['titre']) ?></h2>
                <h3 class="introdruction_affiche-articles"><?= htmlspecialchars($result_affiche_articles['introduction']) ?></h3>
            </div>
            <p class="user_affiche_articles"> Posté par <?= htmlspecialchars($result_affiche_articles['login']) ?> le <?= htmlspecialchars($result_affiche_articles['date']) ?></p>
            <input type="hidden" id="ID" name="ID" value="<?php echo $result_affiche_articles['id_articles']?>">
        </article>
    </a>
</form>
<?php           
    
            }
         //Puis on boucle sur le nombre de page afin d'écrire les href à toutes les pages
        echo "Page : ";
        $i = 0;
        for ($i = 1 ; $i <= $nombre_pages; $i++){
            echo '<a href="articles.php?start=' . $i . '">' . $i . '</a> ';
        }
    }
}

            /*----------------------------PAGE ARTICLE------------------------------- */
            function affiche_self_article(){

                $id_article = $_GET['article'];
        
                //requête de récupération des informations d'affichage de l'article concerné, formatage de la date à la sortie pour un meilleur affichage à l'user.
                $requete_self_article = mysqli_query(connexion_BDD(),"SELECT titre, introduction, article, image_article, DATE_FORMAT(date, '%d/%m/%Y') AS 'datefr' , DATE_FORMAT(date, '%H:%i:%s') AS 'heurefr' FROM articles WHERE id = $id_article");
                $result_self_article = mysqli_fetch_array($requete_self_article, MYSQLI_ASSOC);
        
                //requête de récupération des informations de l'user ayant posté cet article
                $requete_self_article_user = mysqli_query(connexion_BDD(), "SELECT u.id, u.login FROM articles AS a INNER JOIN utilisateurs AS u ON u.id = id_utilisateur WHERE a.id = $id_article ");
                $result_self_article_user = mysqli_fetch_array($requete_self_article_user, MYSQLI_ASSOC);
        
                //requête de récupération des informations de la catégorie de l'article
                $requete_self_article_categorie = mysqli_query(connexion_BDD(), "SELECT c.id , c.nom FROM categories AS c INNER JOIN articles AS a ON c.id = a.id_categorie WHERE a.id = $id_article ");
                $result_self_article_categorie = mysqli_fetch_array($requete_self_article_categorie, MYSQLI_ASSOC);
        
                $requete_count_commentaire_article = mysqli_query(connexion_BDD(),"SELECT COUNT(*) FROM commentaires INNER JOIN articles ON commentaires.id_article = articles.id WHERE articles.id = $id_article");
                $result_count_commentaire_article = mysqli_fetch_array($requete_count_commentaire_article,MYSQLI_ASSOC);
                        
                ?>
                    <div class="affiche_self_article">
                        <article class="presentation_self_article" >
                            <h2 class="affiche_self_article_categorie"><?= htmlspecialchars($result_self_article_categorie['nom']) ?></h2>
                            <h2 class="titre_self_article"><?= htmlspecialchars($result_self_article['titre']) ?></h2>
                            <h3 class="introduction_self_article"><?= htmlspecialchars($result_self_article['introduction']) ?></h3>
                            <img class="image_self_article" src="<?= $result_self_article['image_article'] ?>">
                            <p class="contenu_article"><?= nl2br($result_self_article['article'] )?></p>
                            <p class="login_date_article">Posté par <?= htmlspecialchars($result_self_article_user['login']) ?> le <?= htmlspecialchars($result_self_article['datefr']) ?> à <?= htmlspecialchars($result_self_article['heurefr']) ?></p>
                            <p class="count_commentaire_article"><i class="fa-solid fa-comments"> <?= $result_count_commentaire_article['COUNT(*)'] ?></i></p>
                                    
                        </article>
                    </div>
                <?php 
                }
            function affiche_commentaires_article() {   
                        
                $id_article = $_GET['article'];
        
                //requête de récupération des informations des commentaires liés à l'article
                $requete_self_article_commentaire = mysqli_query(connexion_BDD(), "SELECT c.commentaire, c.date FROM `articles` AS a INNER JOIN `commentaires` AS c ON a.id = c.id_article WHERE a.id = '$id_article' ORDER BY `date` DESC");
                $result_self_article_commentaire = mysqli_fetch_all($requete_self_article_commentaire, MYSQLI_ASSOC);
        
                $requete_login_article_commentaire = mysqli_query(connexion_BDD(), "SELECT u.id, u.login FROM `utilisateurs` AS `u` INNER JOIN `commentaires` AS c ON u.id = c.id_utilisateur WHERE u.id = c.id_utilisateur AND c.id_article = '$id_article'");
                $result_login_article_commentaire = mysqli_fetch_all($requete_login_article_commentaire, MYSQLI_ASSOC);
               


                $x = 0;
                $i = 0;
                    while ( isset ( $result_self_article_commentaire[$i]). isset ($result_login_article_commentaire[$x])){
                        ?>
                            <div class="affiche_commentaires_article">
                                <p class="commentaires_article"><?= $result_self_article_commentaire[$i]['commentaire'] ?> </p>
                                <p class="date_commentaires_articles">Posté le <?= $result_self_article_commentaire[$i]['date'] ?></p>
                                <p class="login_commentaire_article">Par <?= $result_login_article_commentaire[$x]['login'] ?></p>
                                
                            </div>
                        <?php
                        $i ++;
                    $x++;
                    }
                }
                    
            function post_commentaire_article(){
        
                $echo = "";
                $error = "";
        
                //On récupere l'id de l'article en URL afin de s'en servir en requête
                $id_article = $_GET['article'];
        
                //Si l'user poste un commentaire
                if ( isset ( $_POST['submit_commentaire_article'] )){
        
                    //Si le textarea est bien rempli
                    if ( !empty ( $_POST['commentaire_article'] )){
        
                        $com_article = addslashes($_POST['commentaire_article']);
        
                        //Alors on insert le commentaire en base de données et prévient l'user du bon déroulement
                        $requete_insert_commentaire_article = mysqli_query(connexion_BDD(), "INSERT INTO `commentaires`(`commentaire`, `id_article`, `id_utilisateur`, `date`) VALUES ('$com_article','$id_article','$_SESSION[id]',NOW())");
        
                        $echo = ' <a class="echo"> Votre commentaire a été envoyer avec succés </a>';
                        echo $echo;
                        mysqli_close(connexion_BDD());
                        
                    } else {
                        $error = '<a class="message_erreur"> Erreur, <br> Veuillez remplir le champ </a>';
                        echo $error;
                    }
                }
            }
    //------------------------- BARRE D'INFO------------------------//
        function info_barre(){
            if(isset($_SESSION['info_update'])) //Si la variable de session existe alors envoyer le message
            {
                ?>      
                <div class="info_update">
                <img src="..\assets\img\beblog_gif_validation.gif?date=<?php echo date('Y-m-d-H-i-s');?>" alt="validation"/>
                <p><b><?=$_SESSION['info_update']?><b></p>
                </div>
                <?php
                unset($_SESSION['info_update']); //Supression de la variable de session après son jeux afin qu'elle ne s'affiche pas à chaque réactulaisation
            } 
                elseif(isset($_SESSION['error_validation']))
            {
                ?>
                <div class="info_update">
                <img src="..\assets\img\beblog_icon_error.png" alt="validation"/>
                <p><b><?=$_SESSION['error_validation']?></b><p>
                </div>
                <?php
                $localisation_erreur = 'error_user';
                unset($_SESSION['error_validation']);
            }
        }

    //----------------------------PAGE ADMIN -----------------------------//
    function infos_blog_admin(){
        $requete_nbr_articles = mysqli_query(connexion_BDD(), "SELECT COUNT(*) FROM articles");
        $result_nbr_articles = mysqli_fetch_array($requete_nbr_articles);
        
        $requete_nbr_users = mysqli_query(connexion_BDD(), "SELECT COUNT(*) FROM utilisateurs");
        $result_nbr_users = mysqli_fetch_array($requete_nbr_users);

        $requete_nbr_cat = mysqli_query(connexion_BDD(), "SELECT COUNT(*) FROM categories");
        $result_nbr_cat = mysqli_fetch_array($requete_nbr_cat);

        ?>
        <div class="conteneur_infos_admin">
            <div class="nbr_articles_admin">
                <h3 class="articles_admin">Articles</h3>
                <i class="fas fa-newspaper"></i>
                <p class="nbr_articles_admin"><?= $result_nbr_articles['COUNT(*)'] ?></p>
            </div>
            <div class="nbr_users_admin">
                <h3 class="users_admin">Utilisateurs</h3>
                <i class="fas fa-users"></i>
                <p class="nbr_users_admin"><?= $result_nbr_users['COUNT(*)'] ?></p>
            </div>
            <div class="nbr_cat_admin">
                <h3 class="cat_admin">Catégories</h3>
                <i class="far fa-bookmark"></i>
                <p class="nbr_cat_admin"><?= $result_nbr_cat['COUNT(*)'] ?></p>
            </div>
        </div>
        <?php
    }


    function all_articles_admin(){
           
        $display1 = "none";

        //requête affichage des articles page admin ordonnée par date de publication les plus récentes
        $affiche_articles_admin = mysqli_query(connexion_BDD(), "SELECT a.id, a.titre, a.introduction, a.article, a.id_categorie, a.date, c.style FROM articles AS a INNER JOIN categories AS c ON a.id_categorie = c.id ORDER BY `date` DESC");
            
        //Si le formulaire de modif est soumis 
        if(isset($_POST['submit_articles_admin'])){

            //Si ce dernier ne comprend aucune zone de texte vide
            if (!empty($_POST['titre_articles_admin']) && !empty($_POST['intro_articles_admin']) && !empty($_POST['article_articles_admin']) && !empty($_POST['id_categorie_articles_admin'])){

                $titre = addslashes(htmlspecialchars($_POST['titre_articles_admin']));
                $intro = addslashes(htmlspecialchars($_POST['intro_articles_admin']));
                $article = addslashes(htmlspecialchars($_POST['article_articles_admin']));
                $id_categorie = htmlspecialchars($_POST['id_categorie_articles_admin']);
                $id = htmlspecialchars($_POST['id_articles_admin']);

                //Alors on update l'article concerné et on refresh la page directement afin d'afficher le changement sans header location.
                $update_articles_admin = mysqli_query(connexion_BDD(), "UPDATE `articles` SET `titre`='$titre',`introduction`='$intro',`article`='$article',`id_categorie`='$id_categorie' WHERE id = '$id'");
                
                $_SESSION['info_update'] = "Article modifié avec succés";
                echo "<meta http-equiv='refresh' content='0'>";
                    
            } else {
                $_SESSION['error_validation'] = "Impossible d'envoyer un champ vide";
            }
        }
            
        //Si on clique sur modifier on récupére l'id de l'article qu'on souhaite modifier en GET et on laisse apparaitre le formulaire de modif
        if(isset($_GET['modif'])){
            $id = $_GET['modif'];
            $display1 = "block";

            //On récupere les informations de l'article concerné afin d'afficher ses informatons dans le formulaire de modif
            $affiche_update_articles_admin = mysqli_query(connexion_BDD(), "SELECT id, titre, introduction, article, id_categorie FROM articles WHERE id = '$id' ");
            $result_update_articles_admin = mysqli_fetch_array($affiche_update_articles_admin, MYSQLI_ASSOC);

            $titre = $result_update_articles_admin['titre'];
            $intro = $result_update_articles_admin['introduction'];
            $article = $result_update_articles_admin['article'];
            $id_categorie = $result_update_articles_admin['id_categorie'];
            $id = $result_update_articles_admin['id'];
        }

        $display2 = "none";
        //Partie suppression d'articles avec formulaire de confirmation de supp qui apparait
        if (isset($_GET['supp'])){
            $id = $_GET['supp'];
            $display2 = "block";

            if (isset($_POST['valid_supp_non_articles'])){
                $display2 = "none";
            } 

            elseif (isset($_POST['valid_supp_oui_articles'])){
                $delete_articles_admin = mysqli_query(connexion_BDD(), " DELETE FROM articles WHERE id = '$id' ");
                $_SESSION['msg'] = "Article supprimé avec succés";
                echo '<script language="Javascript">document.location.replace("admin.php")</script>';
            }
            
            ?>
            <div class="form_supp_articles_admin" style="display: <?= $display2 ?>;">
                <p class="valid_supp_articles">Êtes-vous sur de vouloir supprimer cet article?</p>
                <form method="post" action="">
                    <button name="valid_supp_oui_articles">Oui</button>
                    <button name="valid_supp_non_articles">Non</button>
                </form>
            </div>
            <?php
            
        }
        ?>
        <div class="align_center_form" style="display: <?= $display1 ?>;">
            <form class="form_articles_admin" action="" method="post">
                <input type="hidden" name="id_articles_admin" value="<?= $id ?>">

                <label for="titre_articles_admin">Titre</label>
                    <input class="input_admin" id="titre_articles_admin" type="text" name="titre_articles_admin" value="<?= $titre ?>">

                <label for="intro_articles_admin">Intro</label> 
                    <input class="input_admin" id="intro_articles_admin" type="text" name="intro_articles_admin" value="<?= $intro ?>">

                <label for="article_articles_admin">Article</label>
                    <textarea id="article_articles_admin" name="article_articles_admin" rows="6"><?= $article ?></textarea>

                <label for="id_categorie_articles_admin">Id catégorie</label>
                    <input class="input_admin_id" id="id_categorie_articles_admin" type="text" name="id_categorie_articles_admin" value="<?= $id_categorie ?>">

                <button type="submit" name="submit_articles_admin" value="Modifiez">Modifiez</button>
            </form>
        </div>
        <table class="all_articles_admin_table">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Introduction</th>
                <th>Article</th>
                <th>Id_categorie</th>
                <th>Date</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                while ($articles_admin = mysqli_fetch_array($affiche_articles_admin, MYSQLI_ASSOC)){
                    
            ?>
            <tr class="<?= $articles_admin['style'] ?>_a_background_categories">
                <td><?= $articles_admin['titre'] ?></td>
                <td><?= $articles_admin['introduction'] ?></td>
                <td><?= nl2br($articles_admin['article']) ?></td>
                <td><?= $articles_admin['id_categorie'] ?></td>
                <td><?= $articles_admin['date'] ?></td>
                <td>
                    <a href="admin.php?modif=<?= $articles_admin['id'] ?>">Modifiez</a>
                </td>
                <td>
                    <a href="admin.php?supp=<?= $articles_admin['id'] ?>">Supprimer</a>
                </td>
            </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
    <?php
    }

    function all_categories_admin(){
        $display = "none";
        $display1 = "none";
        $display2 = "none";
        $value_btn = "";
        $affiche_categories_admin = mysqli_query(connexion_BDD(),"SELECT * FROM categories");

        if(isset($_GET['add_cat'])){
            $display = "none";
            $display1 = "block";
            $value_btn = "Ajouter";

            if(isset($_POST['submit_add_categories_admin'])){
                if(!empty($_POST['nom_categories_admin']) && !empty($_POST['accroche_categories_admin']) && !empty($_POST['descriptif_categories_admin']) && !empty($_POST['style_categories_admin'])){
            
                $nom = htmlspecialchars($_POST['nom_categories_admin']);
                $accroche = htmlspecialchars($_POST['accroche_categories_admin']);
                $descriptif = htmlspecialchars($_POST['descriptif_categories_admin']);
                $style = htmlspecialchars($_POST['style_categories_admin']);

                $add_categories_admin = mysqli_query(connexion_BDD(), "INSERT INTO `categories`(`nom`, `accroche`, `descriptif`, `style`) VALUES ('$nom','$accroche','$descriptif','$style')");
                $_SESSION['info_update'] = "Catégories ajoutées avec succés";
                echo "<meta http-equiv='refresh' content='0'>";
                } else {
                $_SESSION['error_validation'] = "Impossible d'envoyer un champ vide";
                }
            }
        }
        ?>
            <form action="" method="post" style="display: <?= $display1 ?>;">
                <label for="nom_categories_admin">Nom</label>
                <input id="nom_categories_admin" name="nom_categories_admin" type="text">
                
                <label for="accroche_categories_admin">Accroche </label>
                <input id="accroche_categories_admin" name="accroche_categories_admin" type="text">
                

                <label for="descriptif_categories_admin">Descriptif</label>
                <input id="descriptif_categories_admin" name="descriptif_categories_admin" type="text">

                <label for="style_categories_admin">Style</label>
                <input id="style_categories_admin" name="style_categories_admin" type="text">
                

                <button type="submit" name="submit_add_categories_admin" value="Modifiez"><?= $value_btn ?></button>
            </form>
        <?php

        if(isset($_GET['modif_cat'])){
            $id = $_GET['modif_cat'];
            $display = "block";
            $value_btn = "Modifier";

            $affiche_update_categories_admin = mysqli_query(connexion_BDD(), "SELECT * FROM categories WHERE id = $id");
            $result_update_categories_admin = mysqli_fetch_array($affiche_update_categories_admin, MYSQLI_ASSOC);
            
            $nom = $result_update_categories_admin['nom'];
            $accroche = $result_update_categories_admin['accroche'];
            $descriptif = $result_update_categories_admin['descriptif'];
            $style = $result_update_categories_admin['style'];

            if(isset($_POST['submit_update_categories_admin'])){
                if(!empty($_POST['nom_categories_admin']) && !empty($_POST['accroche_categories_admin']) && !empty($_POST['descriptif_categories_admin']) && !empty($_POST['style_categories_admin'])){
                    $nom = htmlspecialchars($_POST['nom_categories_admin']);
                    $accroche = htmlspecialchars($_POST['accroche_categories_admin']);
                    $descriptif = htmlspecialchars($_POST['descriptif_categories_admin']);
                    $style = htmlspecialchars($_POST['style_categories_admin']);

                    $update_categories_admin = mysqli_query(connexion_BDD(), "UPDATE `categories` SET `nom`='$nom',`accroche`='$accroche',`descriptif`='$descriptif',`style`='$style' WHERE id = '$id'");
                    $_SESSION['info_update'] = "Catégorie modifié avec succés";
                    echo "<meta http-equiv='refresh' content='0'>";
                } else {
                    $_SESSION['error_validation'] = "Impossible d'envoyer un champ vide";
                }
            }
        }

        if(isset($_GET['supp_cat'])){
            $id = $_GET['supp_cat'];
            $display2 = "block";

            ?>
                <div class="form_supp_articles_admin" style="display: <?= $display2 ?>;">
                    <p class="valid_supp_articles">Êtes-vous sur de vouloir supprimer cet article?</p>
                    <form method="post" action="">
                        <button name="valid_supp_oui_articles">Oui</button>
                        <button name="valid_supp_non_articles">Non</button>
                    </form>
                </div>
            <?php
        }

        ?>
            <form action="" method="post" style="display: <?= $display ?>;">
                <label for="nom_categories_admin">Nom</label>
                <input id="nom_categories_admin" name="nom_categories_admin" type="text" value="<?= $nom ?>">
                
                <label for="accroche_categories_admin">Accroche </label>
                <input id="accroche_categories_admin" name="accroche_categories_admin" type="text" value="<?= $accroche ?>">
                

                <label for="descriptif_categories_admin">Descriptif</label>
                <input id="descriptif_categories_admin" name="descriptif_categories_admin" type="text" value="<?= $descriptif ?>">

                <label for="style_categories_admin">Style</label>
                <input id="style_categories_admin" name="style_categories_admin" type="text" value="<?= $style ?>">
                

                <button type="submit" name="submit_update_categories_admin" value="Modifiez"><?= $value_btn ?></button>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nom</th>
                        <th>Accroche</th>
                        <th>Descriptif</th>
                        <th>Style</th>
                        <th colspan="3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while($categories_admin = mysqli_fetch_array($affiche_categories_admin, MYSQLI_ASSOC)){
                    ?>
                    <tr class="<?= $categories_admin['style'] ?>_a_background_categories">
                        <td><?= $categories_admin['id']?></td>
                        <td><?= $categories_admin['nom']?></td>
                        <td><?= $categories_admin['accroche']?></td>
                        <td><?= $categories_admin['descriptif']?></td>
                        <td><?= $categories_admin['style']?></td>
                        <td>
                            <a href="admin.php?add_cat=<?= $categories_admin['id'] ?>">Ajouter</a>
                        </td>
                        <td>
                            <a href="admin.php?modif_cat=<?= $categories_admin['id'] ?>">Modifiez</a>
                        </td>
                        <td>
                            <a href="admin.php?supp_cat=<?= $categories_admin['id'] ?>">Supprimer</a>
                        </td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        <?php
    }       
     //---------------------- AFFICHAGE MANIATURE-------------------------------//
     function affichage_miniature(){
        if(!empty(select_miniature_BDD())){
            ?>
            <img src="<?=select_miniature_BDD()?>" alt="votre image de profil">
            <?php
        }    
        else
        {
        ?>
         <img src="..\assets\img\beblog_logo_icon.png" alt="image par defaut avec le logo de beblog">
         <?php
        }
    }
     //....................... UPDATE MINIATURE ----------------------------//
    function update_miniature(){
        ?>
    <div class="modif_avatar_profil">
                <h3>Modifier son image de profil</h3>
                <form method="post" enctype="multipart/form-data">
                <input type="file" name="image_avatar">
                <input type="submit" name="sub_image" value="Changer">
                </form>
                <?php if(!empty($_FILES['image_avatar']['tmp_name'])){
                        $retour = 'ok';
                }
                elseif(isset($_POST['sub_image']) && empty($_FILES['image_avatar']['tmp_name'])){
                    $_SESSION['error_validation'] = 'Aucun fichier n\'a été selectionné';
                    unset($_POST['sub_image']);
                    echo "<SCRIPT LANGUAGE=\"JavaScript\"> document.location.href=\"profil.php\" </SCRIPT>";
                    exit();
                }
                ?>
                <div class="border_color">
                <div class="affichage_avatar_profil">
                    <?php
                    if(isset($retour)){
                    ?>
                    <img src="<?=$_FILES['image_avatar']['name']?>" alt="votre nouvelle image de profil">
                    <form action="" method=""></form>
                    <?php
                    }
                    elseif(!empty(select_miniature_BDD())){
                        ?>
                        <img src="<?=select_miniature_BDD()?>" alt="votre image de profil">
                        <?php
                    }    
                    else
                    {
                    ?>
                    <img src="..\assets\img\beblog_logo_icon.png" alt="image par defaut avec le logo de beblog">
                    <?php
                    }
                    ?>
                </div>
                </div>
                <p class="p_info_modif_profil">Fomrat 1:1(carré) conseillé.</p>
                <p class="p_info_modif_profil">Rendez-vous sur <a href="https://www.iloveimg.com/fr/recadrer-image">I&#10084;IMG</a> pour recradrer l'image</p>
                        
                <?php
            if(isset($retour)){
               $explode_file = explode(".",$_FILES['image_avatar']['name']);
                $extention = ['jpeg','jpg','JPEG','JPG'];
                $i=0;
                while(isset($extention[$i])){
                    if($extention[$i] == $explode_file[1]){
                        $approuve = 'ok';
                    }
                    $i++;
                }
                if(isset($approuve)&&$approuve=='ok'){
                    select_miniature_BDD();
                        if(!empty(select_miniature_BDD())){
                        $explode_src_icon = explode('/',select_miniature_BDD());
                        $select_icon_name = explode('.',$explode_src_icon[4]);
                        $holder_name_icon = $select_icon_name[0];
                        $explode_file[0] = $holder_name_icon;
                    }
                    else {
                        $explode_file[0] = uniqid();
                    }
                    $explode_file[1] = ".$explode_file[1]";
                    $_FILES['image_avatar']['name'] = $explode_file[0].$explode_file[1];
                    $im_miniature = $_FILES['image_avatar']['name'];
                    $taille = getimagesize($_FILES['image_avatar']['tmp_name']);
                    $largeur = $taille[0];
                    $hauteur = $taille[1];
                    $largeur_miniature = 400;
                    $hauteur_miniature = $hauteur / $largeur * 400;
                    $im = imagecreatefromjpeg($_FILES['image_avatar']['tmp_name']);
                    $im_miniature = imagecreatetruecolor($largeur_miniature, $hauteur_miniature);
                    imagecopyresampled($im_miniature, $im, 0, 0, 0, 0, $largeur_miniature, $hauteur_miniature, $largeur, $hauteur);
                    imagejpeg($im_miniature, '../assets/img/miniatures/'.$_FILES['image_avatar']['name'],90);
                    $icon = '../assets/img/miniatures/'.$_FILES['image_avatar']['name'];
                    //--- UPDATE ---//
                        $id_data = $_SESSION['id'];
                        $up_icon_query = mysqli_query(connexion_BDD(),"UPDATE `utilisateurs` SET `icon`= '$icon' WHERE `id`='$id_data'");
                        select_miniature_BDD();
                        if(!empty(select_miniature_BDD())){
                            $_SESSION['icon'] = select_miniature_BDD();
                            $_SESSION['info_update']='Votre icon à bien était mis à jour';
                            echo "<SCRIPT LANGUAGE=\"JavaScript\"> document.location.href=\"profil.php\" </SCRIPT>";
                        }
                        else{
                            $_SESSION['error_validation']='Une erreur est survenue';
                        }

                }
                else $_SESSION['error_validation'] = "OUPS ! assurer vous que l'image soit en .jpg";
            }
    ?>
    </div>
    <?php
    }            
            