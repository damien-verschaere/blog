<?php
    /*Fonction de connexion à la base de données */
    function connexion_BDD(){
        $connexion = mysqli_connect('localhost', 'root', '', 'blog');
        mysqli_set_charset($connexion, 'utf8');
        return $connexion;
    }
    function select_all_categories_BDD(){
        $requete = mysqli_query(connexion_BDD(),"SELECT * FROM categories");
        $result = mysqli_fetch_all($requete,MYSQLI_ASSOC);
        return $result;
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
            return $message='champ login vide';
            
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
                $cryptage=password_hash($password,PASSWORD_DEFAULT);
                $requete=mysqli_query(connexion_BDD(),"INSERT INTO utilisateurs (`id`,`login`,`password`,`email`,`id_droits`) VALUES (NULL,'$login','$cryptage','$email','$droit')");
                header('location:' . 'connexion.php');
            }
        }
        }
    }
#affiche les 3 premiers articles de la page index
    function affiche_article(){
        $req=mysqli_query(connexion_BDD(),"SELECT `titre`,`introduction`,`article`,`date` FROM `articles` order by date DESC LIMIT 3 ");
        $result=mysqli_fetch_all($req,MYSQLI_ASSOC);
        foreach ($result as $key) {
            echo "<div class =com_index>";
            echo $key['titre']."<br>";
            echo $key['introduction']."<br>";
            echo  $key['article'] ."<br>";
            echo $key['date']."<br>";
            echo"</div>";
        }
        
    }

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
            $description=$_POST['description'];
            $article=$_POST['article'];
        
            if (!empty($titre || $description || $article)) {
             $requete= mysqli_query(connexion_BDD(),"INSERT INTO `articles`(`id`, `titre`, `introduction`, `article`, `id_utilisateur`, `id_categorie`, `date`) VALUES ( NULL,'$titre','$description','$article',1,'$categorie',NOW() )");
                var_dump($_POST['creer']);
            }
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
    /*----------------------------PAGE ARTICLES------------------------------- */

    function affiche_all_articles(){
        $affiche_articles = mysqli_query(connexion_BDD(), "SELECT * FROM articles INNER JOIN utilisateurs ON articles.id_utilisateur=utilisateurs.id ORDER BY `date` DESC");
        
        while($result_affiche_articles = mysqli_fetch_array($affiche_articles, MYSQLI_ASSOC)){
            var_dump($result_affiche_articles);
?>
        <p class="titre_affiche_articles"><?= $result_affiche_articles['titre'] ?></p>
        <p class="introdruction_affiche-articles"><?= $result_affiche_articles['introduction'] ?></p>
        <p class="affiche_articles"><?= $result_affiche_articles['article'] ?></p>
        <p class="user_affiche_articles"> Posté par <?= $result_affiche_articles['login'] ?> le <?= $result_affiche_articles['date'] ?>

<?php
        }
    }
?>