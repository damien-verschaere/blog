<?php
session_start();
require "../functions/function.php";

//** RENVOYER PAGE INDEX SI NON CONNECTER */
if(empty($_SESSION['id']))
    {
    header('location: index.php');
    exit();
    }
else
    {
    $conn = connexion_BDD();
    $data_id = $_SESSION['id']; //Atribution d'une variable pour definir l'utilisateur cible
    $m_email = mysqli_query($conn,"SELECT * FROM utilisateurs WHERE`id`= '$data_id'");
    $m_email_assoc = mysqli_fetch_assoc($m_email);
    $_SESSION['email'] = $m_email_assoc['email'];
    }
//** CONNEXION A LA BASE DE DONNER */
$login = $_SESSION['login'];
//** CONDITION PRELIMINAIRE A L'UTILISATION DU FORMULAIRE */

    //** UPDATE EMAIL */
if(isset($_POST['m_email']))
{
    $email = $_POST['m_email'];
    $up_prenom = mysqli_query($conn,"UPDATE `utilisateurs` SET `email`= '$email' WHERE `id`='$data_id'");
    $_SESSION['email']=$email;
    $_SESSION['info_update'] ='Votre email a bien été modifier';
    header('location: profil.php');
    exit();
}
    //** UPDATE LOGIN */
if(isset($_POST['m_login']))
{
    $data_login = $_POST['m_login'];
    $select = mysqli_query($conn, "SELECT * FROM `utilisateurs` WHERE `login` = '$data_login'");
    $result_login = mysqli_fetch_all($select);
    if (count($result_login)!==0){
        $_SESSION['error_validation'] ='le nom d\'utilisateur existe déjà';
    }
    else
    {
        $up_prenom = mysqli_query($conn,"UPDATE `utilisateurs` SET `login`= '$data_login' WHERE `id`='$data_id'");
    $_SESSION['login']=$data_login;
    $_SESSION['info_update'] = 'Votre login a bien été modifier';
    unset($_POST);
    }
}
    //** UPDATE HTML*/
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<?php
require "requires/require_meta.php"; //Récupération des meta et des link necessaire à la navigation
?>
    <title>Mon compte</title>
</head>

<body>
    <header>
        <?php
        require('requires/require_Header.php'); //Envoie de la barre de navigation 
        ?>
    </header>
    <main class="section_article">
        <table>
            <?php
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
            ?>
            <thead>
                    <th><?=$_SESSION['login']?></th>
            </thead>
            <tbody>
                </tr>
                <tr>
                    <td>Login:</td>
                    <td>
    <?php
    //** SELECTION DE MODIFICATION LOGIN*/
    if(!isset($_POST['modif_login']))
    {
        ?>
                            <p><?=$_SESSION['login']?></p>
                        </td>
                        <td>
                            <form action="profil.php" method="post">
                            <input type="submit" name="modif_login" value="&#10000;">
                            </form>
                        </td>
        <?php
        }
        else
    //** FORMULAIRE DE MODIFICATION LOGIN*/
        {
        ?>
                                <form action="profil.php" method="post">
                                <input type="text" name="m_login" value="<?=$_SESSION['login']?>">
                        </td>
                        <td>
                                <input type="submit" name="modif_login" value="&#10004;">
                                </form>
                        </td>
                        
        <?php
        }
        ?>
               <tr>
                    <td>Email:</td>
                    <td>
        <?php
        //** SELECTION DE MODIFICATION MAIL*/
        if(!isset($_POST['modif_email']))
        {
            ?>
                     
                                <p><?=$_SESSION['email']?></p>
                            </td>
                            <td>
                                <form action="profil.php" method="post">
                                <input type="submit" name="modif_email" value="&#10000;">
                                </form>
                            </td>
            <?php
            }
            else
        //** FORMULAIRE DE MODIFICATION MAIL*/
            {
            ?>
                                    <form action="profil.php" method="post">
                                    <input type="text" name="m_email" value="<?=$_SESSION['email']?>">
                            </td>
                            <td>
                                    <input type="submit" name="modif_email" value="&#10004;">
                                    </form>
                            </td>
            <?php
            }
        ?>
<tr>
                    <td>Password:</td>
                    <td>
                    <?php
                    //** SELECTION DE MODIFICATION MDP*/
                    
                    if(!isset($_POST['modif_pass']))
                    {
                        echo '********';
                    ?>
                    </td>
                    <td>
                        <form action="profil.php" method="post">
                        <input type="submit" name="modif_pass" value="&#10000;">
                        
                        </form>
                    </td>
    <?php
    }
    elseif(empty($_POST['m_pass']))
    //** 1ER FORMULAIRE DE MODIFICATION LOGIN - VERIFICATION DE L'ANCIEN MDP*/
    {
    ?>
                            <form action="profil.php" method="post">
                                <input type="text" name="m_pass" placeholder="Ancien Mot de passe">
                            </td>
                            <td>
                                <input type="submit" name="modif_pass" value="&#10004;"><br>
                                </form>
                            </td>       
    <?php
    }
    ?>
                </tr>
            </tbody>
        </table> 
    <?php
    //**FIN DE MON TABLEAU POUR LES MODIFICATION & ENTREE DANS LA FENETRE POPUP */
    if((isset($_POST['m_pass'])) || isset($_POST['Modification_mdp'])) //Début des condition de mon formulaire se trouvant en bas de la pages
    {
        if(isset($_POST['m_pass'])){
                        $password = $_POST['m_pass'];
                        $m_vmdp = mysqli_query($conn,"SELECT * FROM utilisateurs WHERE`id`= '$data_id'");
                        $vmdp2 = mysqli_fetch_assoc($m_vmdp);
                        $vmdp3 = $vmdp2['password'];

        }

        if(empty($_POST['new_pass'])&&empty($_POST['new_passv']))
            {
                $_SESSION['error_mdp'] ='Remplir les champs';
            }            
        elseif(!empty($_POST['new_pass']))
        {
                        if(($_POST['new_pass']===$_POST['new_passv']))
                        {
                            $new_password = $_POST['new_pass'];
                            $new_mdp_secure = password_hash($new_password,PASSWORD_BCRYPT);
                            $up_password = mysqli_query($conn,"UPDATE `utilisateurs` SET `password`= '$new_mdp_secure' WHERE `id`='$data_id'");
                            unset($_POST['Modification_mdp']);
                            $_SESSION['info_update'] = 'Votre mot de passe a bien été modifier';
                            $_SESSION['final']=1;
                        }
                        else
                        {
                            $_SESSION['error_mdp'] = 'Assurez vous que les mots de passes soit identiques';
                        }
        }
        if(isset($_POST['m_pass']) && (password_verify($password,$vmdp3) === TRUE) Or isset($_POST['Modification_mdp']))
        { 
            $_SESSION['popup_annule']='on';

            ?>
            <section id="popup_password">
                <div class="popup_password_content">
                    <p><b>Vous êtes sur le point de modifier votre mot de passe.</b></p>
                    <p><b><?=$_SESSION['error_mdp']?></b></p>
                <form action="profil.php" method="post">
                    <label for="new_pass">Rentrer votre nouveau mot de pass</label>
                    <input type="text" name="new_pass" placeholder="Nouveau mot de passe"><br>
                    <label for="new_passv">Récrivez votre nouveau mot de pass </label>
                    <input type="text" name="new_passv" placeholder="Verfier le nouveau mot de passe"><br>
                    <div id="input_bottom">
                        <a href="deconnexion.php">annuler</a>
                        <input type="submit" name='Modification_mdp' value="modifier">
                    </div>                            
    <?php
        }
        else
        {
            $_SESSION['error']=1;
            $_SESSION['error_validation']='Mot de passe incorrect';
        } 
        if(isset($_SESSION['final']) && $_SESSION['final']==1)
        {
            unset($_SESSION['error']);
            unset($_SESSION['popup_annule']);
            unset($_SESSION['final']);
            unset($_SESSION['error_validation']);
            echo "<SCRIPT LANGUAGE=\"JavaScript\"> document.location.href=\"profil.php\" </SCRIPT>";
            exit();
        }
       elseif(isset($_SESSION['error']) && $_SESSION['error']==1){
                unset($_POST);
                unset($_SESSION['error']);
                echo "<SCRIPT LANGUAGE=\"JavaScript\"> document.location.href=\"profil.php\" </SCRIPT>";
                exit();
            }
    }
                    ?>
                            </div>
                        </section>
    </main>
        <footer>
        <?php
    require('requires/require_Footer.php');
    ?>
        </footer>
</body>
</html>