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
        $message='';
        if ( isset($_POST['inscription'])){
            $login = htmlspecialchars ( $_POST['login'] );
            $email = htmlspecialchars ( $_POST['email'] );
            $password = htmlspecialchars( $_POST['password'] );
            $password2 = $_POST['password2'];
            $droit = 1;
            if ( empty($login)) {
            return $message='champ login vide';
            "test";
        }
        elseif ( empty($password)) {
            echo "<p> remplissez le champ password </p>";
            
        }
        elseif ($password != $password2) {
            echo " Les passwords ne correspondent pas .";
        }
        elseif ( !empty($login)) {
            $veriflogin = mysqli_query(connexion_BDD(),"SELECT login FROM utilisateurs WHERE login= '$login'");
            var_dump ( mysqli_num_rows($veriflogin) );
            if ( mysqli_num_rows($veriflogin) == 1) {
                echo "<p> Le LOGIN existe deja .</p> ";    
            }
            else {
                $cryptage = password_hash($password,PASSWORD_DEFAULT);
                $requete = mysqli_query(connexion_BDD(),"INSERT INTO utilisateurs (`id`,`login`,`password`,`email`,`id_droits`) VALUES (NULL,'$login','$cryptage','$email','$droit')");
                header('location:' . 'connexion.php');
            }
        }
        }
    }
#affiche les 3 premiers articles de la page index
    function affiche_article(){
        $req=mysqli_query(connexion_BDD(),"SELECT `titre`,`introduction`,`article`,`date`,`image_article` FROM `articles` order by date DESC LIMIT 3 ");
        $result=mysqli_fetch_all($req,MYSQLI_ASSOC);
        foreach ($result as $key) {
            echo "<div class=affiche_article>";
            echo "<p>". $key['titre']."</p>";
            
            echo "<div class= image_article>";
            echo "<img src=".$key['image_article'].">";
            echo "</div>";
            echo "<div class=footer_accueil>";
            echo "<p>". $key['introduction']."</p>";
            echo "<p>".$key['date']."</p>";
            echo "</div>";
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
        $titre=addslashes(htmlentities($_POST['titre']));
        $titreBDD=addslashes(htmlentities($_POST['titre']));
        $titre=$_POST['titre'];
        $titreBDD=$_POST['titre'];
        $description=addslashes( $_POST['description']);
        $article=addslashes(htmlentities($_POST['article']));
        $article=$_POST['article'];
        $space=" ";
        $replace="";
        $outString=str_replace($space,$replace,$titreBDD);
        $titreBDD=$outString;
        
            if (isset($_FILES['image_article']) ){
                $filename = $_FILES['image_article']['tmp_name']; // On récupère le nom du fichier
                list($width_orig, $height_orig) = getimagesize($filename);
                if($width_orig >= 500 && $height_orig >= 500 && $width_orig <= 6000 && $height_orig <= 6000){ 
                array('jpg' => 'image/jpg', 'JPG'=>'image/JPG', 'png' => 'image/png', 'gif' => 'image/gif');
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
                        echo "l114";
                        $extensionUpload = strtolower(substr(strrchr($_FILES['image_article']['name'], '.'), 1)); // Prend l'extension après le point, soit "jpg, jpeg ou png"
 
                        if (in_array($extensionUpload, $extensionsValides)){ // Vérifie que l'extension est correct
                            echo"l118";
                            $dossier = "../assets/images_article" . $titreBDD.$categorie . "/"; // On se place dans le dossier de la personne 
                            if (!is_dir($dossier)){ // Si le nom de dossier n'existe pas alors on le crée

                                mkdir($dossier);

                            }
                            $nom = uniqid(rand()) ; // Permet de générer un nom unique à la photo
                                $chemin = "../assets/images_article" . $titreBDD.$categorie . "/" . $nom . "." . $extensionUpload; // Chemin pour placer la photo
                                $resultat = move_uploaded_file($_FILES['image_article']['tmp_name'], $chemin); // On fini par mettre la photo dans le dossier
                                if ($resultat){ // Si on a le résultat alors on va comprésser l'image
                                        echo "l129"; 
                                        $verif_ext = getimagesize("../assets/images_article" . $titreBDD.$categorie . "/" . $nom . "." . $extensionUpload);
                                        echo "l132";
                                        // Vérification des extensions avec la liste des extensions autorisés
                                                      
                                            // J'enregistre le chemin de l'image dans filename
                                            $filename = "../assets/images_article" . $titreBDD.$categorie . "/" . $nom . "." . $extensionUpload;
                                            echo "l137";
                                            // Vérification des extensions que je souhaite prendre
                                            if($extensionUpload == 'jpg' || $extensionUpload == 'png' || $extensionUpload == "JPG"|| $extensionUpload == "gif" ){
                                                echo "l140";
                                                // Content type
                                                
                                            echo '<script language="Javascript">document.location.replace("accueil.php")</script>';

                                                
                                                
                                            }
                                            
                                           
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
                $affichage_articles_categories = mysqli_query(connexion_BDD(), "SELECT a.id as id_articles, a.titre, a.introduction, a.article, a.date, u.id as id_utilisateur, u.login, c.id as id_categorie, c.nom FROM articles as a INNER JOIN utilisateurs as u ON id_utilisateur=u.id INNER JOIN categories as c ON id_categorie = c.id WHERE `id_categorie` = '$id_categories_get' ORDER BY `date` DESC LIMIT $premier_affichage_categories, $nombre_articles_categories ");
                //Puis on boucle sur le résultat de la requete afin d'afficher les articles comme souhaité
                while($result_affiche_articles_categories = mysqli_fetch_array($affichage_articles_categories, MYSQLI_ASSOC)){
                    
            ?>
            <form method="get" action="">
                <a class="href_articles" href="../views/article.php?article=<?=$result_affiche_articles_categories['id_articles']?>">
                    <article class="presentation_articles">
                        <p class="categorie_affiche_articles"><?= htmlspecialchars ($result_affiche_articles_categories['nom']) ?></p>
                        <p class="titre_affiche_articles"><?= htmlspecialchars($result_affiche_articles_categories['titre']) ?></p>
                        <p class="introdruction_affiche-articles"><?= htmlspecialchars($result_affiche_articles_categories['introduction']) ?></p>
                        <p class="affiche_articles"><?= htmlspecialchars($result_affiche_articles_categories['article']) ?></p>
                        <p class="user_affiche_articles"> Posté par <?= htmlspecialchars($result_affiche_articles_categories['login']) ?> le <?= htmlspecialchars($result_affiche_articles_categories['date']) ?>
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
            $affiche_articles = mysqli_query(connexion_BDD(), "SELECT a.id as id_articles, a.titre, a.introduction, a.article, a.date, u.id as id_utilisateur, u.login, c.id as id_categorie, c.nom FROM articles as a INNER JOIN utilisateurs as u ON id_utilisateur=u.id INNER JOIN categories as c ON id_categorie = c.id ORDER BY `date` DESC LIMIT $premier_affichage,$nombre_articles_page");
    
                //Puis on boucle sur le résultat afin d'afficher tous les élément voulu de l'article en base de données
                while($result_affiche_articles = mysqli_fetch_array($affiche_articles, MYSQLI_ASSOC)){
                    
    ?>
    <form method="get" action="">
        <a class="href_articles" href="../views/article.php?article=<?=$result_affiche_articles['id_articles']?>">
            <article class="presentation_articles">
                <p class="categorie_affiche_articles"><?= htmlspecialchars($result_affiche_articles['nom']) ?></p>
                <p class="titre_affiche_articles"><?= htmlspecialchars($result_affiche_articles['titre']) ?></p>
                <p class="introdruction_affiche-articles"><?= htmlspecialchars($result_affiche_articles['introduction']) ?></p>
                <p class="affiche_articles"><?= nl2br($result_affiche_articles['article']) ?></p>
                <p class="user_affiche_articles"> Posté par <?= htmlspecialchars($result_affiche_articles['login']) ?> le <?= htmlspecialchars($result_affiche_articles['date']) ?><br><br>
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
                $requete_self_article = mysqli_query(connexion_BDD(),"SELECT titre, introduction, article, DATE_FORMAT(date, '%d/%m/%Y') AS 'datefr' , DATE_FORMAT(date, '%H:%i:%s') AS 'heurefr' FROM articles WHERE id = $id_article");
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
                        <article class="presentation_self_article">
                            <p class="affiche_self_article_categorie"><?= htmlspecialchars($result_self_article_categorie['nom']) ?></p>
                            <h2 class="titre_self_article"><?= htmlspecialchars($result_self_article['titre']) ?></h2>
                            <h3 class="introduction_self_article"><?= htmlspecialchars($result_self_article['introduction']) ?></h3>
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
                $requete_self_article_commentaire = mysqli_query(connexion_BDD(), "SELECT c.commentaire, c.date FROM articles AS a INNER JOIN commentaires AS c ON a.id = c.id_article WHERE a.id = $id_article ORDER BY `date` DESC");
                $result_self_article_commentaire = mysqli_fetch_all($requete_self_article_commentaire, MYSQLI_ASSOC);
        
                $requete_login_article_commentaire = mysqli_query(connexion_BDD(), "SELECT u.id, u.login FROM utilisateurs AS u INNER JOIN commentaires AS c ON u.id = c.id_utilisateur WHERE u.id = c.id_utilisateur AND c.id_article = $id_article");
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
        
                        $com_article = $_POST['commentaire_article'];
        
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

    function recup_all_articles_admin() {
        ?>
        <form method="POST" action="">
        <table class="affiche_articles_admin" >
            <thead>
                <tr>
                    <th colspan="8">Articles</th>
                </tr>
                <tr>
                    <th>Titre</th>
                    <th>Article</th>
                    <th>Id_categorie</th>
                </tr>
            </thead>
        <tbody>
        <?php
        $requete_recup_all_articles = mysqli_query(connexion_BDD(), "SELECT * FROM articles ORDER BY `date` DESC");
        $result_recup_all_articles = mysqli_fetch_all($requete_recup_all_articles, MYSQLI_ASSOC);
        $i = 0;
            while(isset($result_recup_all_articles[$i])){
                ?>
                <tr>
                    <td><input id="titre_article_admin" name="titre_article_admin" type="text" value="<?= $result_recup_all_articles[$i]['titre'] ?>"></td>
                    <td><textarea rows="3" cols="30" ><?= $result_recup_all_articles[$i]['article'] ?>...</textarea></td>
                    <td><input class="id_categorie_articles_admin" name="id_categorie_articles_admin" type="text" value="<?= $result_recup_all_articles[$i]['id_categorie'] ?>"></td>
                   
                </tr>
                <?php 
            $i++;
            }
            update_articles_admin();
        ?>
            </tbody>
        </table>
        </form>
        <?php
    }
    function update_articles_admin(){
        if (isset($_GET['update_articles']));
        
    }


    function recup_all_categorie_admin(){
        ?>
        <table>
            <thead>
                <tr>
                    <th colspan="3">Infos Catégories</th>
                </tr>
                <tr>
                    <th>Id</th>
                    <th>Nom</th>
                    <th>Style</th>
                </tr>
            </thead>
            <tbody>

        <?php
        $requete_recup_all_categorie = mysqli_query(connexion_BDD(), "SELECT id, nom, style FROM categories");
        $result_recup_all_categorie = mysqli_fetch_all($requete_recup_all_categorie, MYSQLI_ASSOC);
        $i = 0;    
            while (isset($result_recup_all_categorie[$i])){
                ?>
                    <tr>
                        <td><?= $result_recup_all_categorie[$i]['id'] ?></td>
                        <td><?= $result_recup_all_categorie[$i]['nom'] ?></td>
                        <td><?= $result_recup_all_categorie[$i]['style'] ?></td>
                    </tr>
                <?php
                $i++;
            }
            ?>
            </tbody>
        </table>
        <?php
    }

    function recup_all_users_admin(){
        ?>
            <table>
                <thead>
                    <tr>
                        <th colspan="4">Infos utilisateurs</th>
                    </tr>
                    <tr>
                        <th>Id</th>
                        <th>Login</th>
                        <th>Email</th>
                        <th>Id_droits</th>
                    </tr>
                </thead>
                <tbody>

        <?php
        $requete_recup_all_users = mysqli_query(connexion_BDD(), "SELECT * FROM utilisateurs");
        $result_recup_all_users = mysqli_fetch_all($requete_recup_all_users,MYSQLI_ASSOC);
            
        $i = 0;
        while (isset($result_recup_all_users[$i])){
            ?>  
                <tr>
                    <td><?= $result_recup_all_users[$i]['id'] ?></td>
                    <td><?= $result_recup_all_users[$i]['login'] ?></td>
                    <td><?= $result_recup_all_users[$i]['email'] ?></td>
                    <td><?= $result_recup_all_users[$i]['id_droits'] ?></td>
                    <td>
				        <a href="admin.php?update_user=<?php echo $result_recup_all_users[$i]['id']; ?>" class="update_btn" >Modifier</a>
			        </td>
			        <td>
				        <a href="admin.php?delete_user=<?php echo $result_recup_all_users[$i]['id']; ?>" class="delete_btn">Supprimer</a>
			        </td>
                    </tr>
                    
            <?php
        $i++;
        } 
        ?>
            </tbody>
        </table>
        <?php
    }
                
            
                
  

    