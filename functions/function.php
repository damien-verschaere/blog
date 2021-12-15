<?php
    /*Fonction de connexion à la base de données */
    function connexion_BDD(){
        $connexion = mysqli_connect('localhost', 'root', '', 'blog');
        mysqli_set_charset($connexion, 'utf8');
        return $connexion;
    }
    /*----------------------------PAGE INSCRIPTION------------------------------- */
    function inscription(){
        $message='';
        if ( isset($_POST['inscription'])){
            $login = htmlspecialchars ( $_POST['login'] );
            $email = htmlspecialchars ( $_POST['email'] );
            $password = htmlspecialchars( $_POST['password'] );
            $password2=$_POST['password2'];
            $droit = 1;
            if ( empty($login)) {
            echo '<p> champ login vide </p>';
            
        }
        elseif ( empty($password)) {
            echo "<p> remplissez le champ password </p>";
            
        }
        elseif ($password != $password2) {

            echo "<p> Les passwords ne correspondent pas </p>";
        }
        elseif ( !empty($login)) {
            $veriflogin = mysqli_query(connexion_BDD(),"SELECT login FROM utilisateurs WHERE login= '$login'");
            var_dump ( mysqli_num_rows($veriflogin) );
            if ( mysqli_num_rows($veriflogin) == 1) {
                echo "<p> Le LOGIN existe deja .</p> ";    
            }
            else {
                $cryptage=password_hash($password,PASSWORD_DEFAULT);
                $requete=mysqli_query(connexion_BDD(),"INSERT INTO utilisateurs (`id`,`login`,`password`,`email`,`id_droit`) VALUES (NULL,'$login','$cryptage','$email','$droit')");
                header('location:' . 'accueil.php');
            }
        }
        }
    }
#affiche les 3 premiers articles de la page index
    function affiche_article(){
        $req=mysqli_query(connexion_BDD(),"SELECT * FROM `articles` order by date DESC LIMIT 3 ");
        $result=mysqli_fetch_all($req,MYSQLI_ASSOC);
        foreach ($result as $key) {
            echo "<div class =com_accueil>";
            echo   "<p>". $key['titre']."</p><br>";
            echo "<img src=".$key['image_article'].">";
            echo "<p>". $key['introduction']."</p><br>";
            echo  "<p>".$key['article'] ."</p><br>";
            echo "<p>".$key['date']."</p><br>";
            echo"</div>";
        }
        
    }
    /*----------------------------PAGE CREER-ARTICLE------------------------------- */
    function affiche_categorie(){
        $requete=mysqli_query(connexion_BDD(),"SELECT * FROM `categories`");
        $result=mysqli_fetch_all($requete,MYSQLI_ASSOC);
        foreach ($result as $key ) {
            echo "<option value=".$key['id'].">".$key['nom']."</option>";
        }
        
    }
    function creer_article(){
        if (isset($_POST['creer'])) {
            $categorie=$_POST['categorie'];
            $titre=$_POST['titre'];
            $description=addslashes( $_POST['description']);
            $article=$_POST['article'];
        
            if (!empty($titre || $description || $article)) {
                if (isset($_FILES['image_article']) ){
                    $filename = $_FILES['image_article']['tmp_name']; // On récupère le nom du fichier
                    list($width_orig, $height_orig) = getimagesize($filename);
                    if($width_orig >= 500 && $height_orig >= 500 && $width_orig <= 6000 && $height_orig <= 6000){ 
                        $ListeExtension = array('jpg' => 'image/jpg', 'JPG'=>'image/JPG', 'png' => 'image/png', 'gif' => 'image/gif');
                        $ListeExtensionIE = array('jpg' => 'image/pjpg', 'jpeg'=>'image/pjpeg');
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
     
                                $dossier = "../assets/css/images_article" . $titre.$categorie . "/"; // On se place dans le dossier de la personne 
                                if (!is_dir($dossier)){ // Si le nom de dossier n'existe pas alors on le crée
    
                                    mkdir($dossier);
    
                                }
                             
     
                                $nom = $titre.$categorie ; // Permet de générer un nom unique à la photo
                                $chemin = "../assets/css/images_article" . $titre.$categorie . "/" . $nom . "." . $extensionUpload; // Chemin pour placer la photo
                                $resultat = move_uploaded_file($_FILES['image_article']['tmp_name'], $chemin); // On fini par mettre la photo dans le dossier
                                if ($resultat){ // Si on a le résultat alors on va comprésser l'image
     
                                    if (is_readable("../assets/css/images_article" . $titre.$categorie . "/" . $nom . "." . $extensionUpload)) {
                                        $verif_ext = getimagesize("../assets/css/images_article" . $titre.$categorie . "/" . $nom . "." . $extensionUpload);
     
                                        // Vérification des extensions avec la liste des extensions autorisés
                                        if($verif_ext['mime'] == $ListeExtension[$extensionUpload]  || $verif_ext['mime'] == $ListeExtensionIE[$extensionUpload]){              
                                            // J'enregistre le chemin de l'image dans filename
                                            $filename = "../assets/css/images_article" . $titre.$categorie . "/" . $nom . "." . $extensionUpload;
     
                                            // Vérification des extensions que je souhaite prendre
                                            if($extensionUpload == 'jpg' || $extensionUpload == 'png' || $extensionUpload == "JPG"|| $extensionUpload == "gif" ){
                                                
                                                // Content type
                                                header('Content-Type: image/jpeg'); // Important !!
                                            }
                                            
                                           
                                        }
                                    } 
                                }
                                
                            }
                        }
                        
                    }
                   
                }
                
            }
            mysqli_query(connexion_BDD(),"INSERT INTO `articles`(`id`, `titre`, `introduction`, `article`, `id_utilisateur`, `id_categorie`, `date`,`image_article`) VALUES ( NULL,'$titre','$description','$article','$_SESSION[id]','$categorie',NOW(),'$filename')");
                var_dump($filename);
        }
       
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
                        header("location: ../views/profil.php");
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
    /*----------------------------FONCTION DROIT UTILISATEUR------------------------------- */
function droit_user(){
    if(!isset($_SESSION['id_droit'])){
        $droit_user = 'none';
    }
    elseif($_SESSION['id_droit']=='42'){
        $droit_user = 'modo';
    }
    elseif($_SESSION['id_droit']=='1337'){
        $droit_user = 'admin';
    }
    elseif($_SESSION['id_droit']=='1'){
        $droit_user = 'user';
    }
    return  $droit_user;
}

    /*----------------------------PAGE ARTICLES------------------------------- */

    function affiche_all_articles(){
   
        //On selectionne la totalité des infos des catégories afin des les afficher dans nos inputs
        $requete_categories = mysqli_query(connexion_BDD(),"SELECT * FROM categories");

        //on récupere le résultat en gardant le nom de nos index
        $result_categories = mysqli_fetch_all($requete_categories, MYSQLI_ASSOC);

            //Puis on boucle de l'index du résultat de notre requête afin de créer le nombre d'input équivalent au nombre de catégorie
            $i = 0;
            while(isset($result_categories[$i])){
            ?>
                <button type="submit" name="categories" value="<?= $result_categories[$i]['id']?>"><?= $result_categories[$i]['nom']?></button>
            <?php
                $i++;
            }
        //Si une catégorie est définie
        if (isset($_GET['categories'])){

                //Alors on récupere la valeur de l'url et on l'assimile à notre variable 'id de categorie'
                $id = $_GET['categories'];

                //Afin de préparer la pagination, on choisit un nombre d'article à afficher sur notre page
                $nombre_articles_categories = 5;
                
                //On compte le nombre total d'articles ou '$id' correspond à l'id de catégorie connu en base de donnée
                //Afin de n'afficher que le nombre de page pour les articles concernés
                //Sans sa la pagination sera faite pour des articles dont la catégorie ne correspond pas et cela créera des pages vides
                $count_total_articles_categories = mysqli_query(connexion_BDD(),"SELECT COUNT(*) AS nombre_articles_cat FROM articles WHERE id_categorie = '$id'");

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
                $affichage_articles_categories = mysqli_query(connexion_BDD(), "SELECT * FROM articles INNER JOIN utilisateurs ON articles.id_utilisateur=utilisateurs.id INNER JOIN categories ON articles.id_categorie=categories.id WHERE id_categorie = '$id' ORDER BY date DESC LIMIT $premier_affichage_categories, $nombre_articles_categories ");
                while($result_affiche_articles_categories = mysqli_fetch_array($affichage_articles_categories, MYSQLI_ASSOC)){
            ?>
<article class="presentation_articles">
                    <p class="categorie_affiche_articles"><?= $result_affiche_articles_categories['nom'] ?></p>
                    <p class="titre_affiche_articles"><?= $result_affiche_articles_categories['titre'] ?></p>
                    <p class="introdruction_affiche-articles"><?= $result_affiche_articles_categories['introduction'] ?></p>
                    <p class="affiche_articles"><?= $result_affiche_articles_categories['article'] ?></p>
                    <p class="user_affiche_articles"> Posté par <?= $result_affiche_articles_categories['login'] ?> le <?= $result_affiche_articles_categories['date'] ?>
                </article>
            <?php
                }echo "Page : ";
                $i = 0;
                for ($i = 1 ; $i <= $nombre_pages; $i++){
                    echo '<a href="articles.php?categories='.$id.'&page=' . $i . '">' . $i . '</a> ';
                }   
        } else {
            
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
            $affiche_articles = mysqli_query(connexion_BDD(), "SELECT * FROM articles INNER JOIN utilisateurs ON articles.id_utilisateur=utilisateurs.id INNER JOIN categories ON articles.id_categorie = categories.id ORDER BY date DESC LIMIT $premier_affichage,$nombre_articles_page");
            
            while($result_affiche_articles = mysqli_fetch_array($affiche_articles, MYSQLI_ASSOC)){
    ?>
            <p class="categorie_affiche_articles"><?= $result_affiche_articles['nom'] ?></p>
            <p class="titre_affiche_articles"><?= $result_affiche_articles['titre'] ?></p>
            <p class="introdruction_affiche-articles"><?= $result_affiche_articles['introduction'] ?></p>
            <p class="affiche_articles"><?= $result_affiche_articles['article'] ?></p>
            <p class="user_affiche_articles"> Posté par <?= $result_affiche_articles['login'] ?> le <?= $result_affiche_articles['date'] ?><br><br>
    
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
?>
