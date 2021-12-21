<?php
/**-----FONCTION DROIT------ */
function droit_utilisateur(){
    if(!isset($_SESSION['id_droits'])){
        $droit_user = 'none';
    }
    elseif($_SESSION['id_droits']=='42'){
        $droit_user = 'modo';
    }
    elseif($_SESSION['id_droits']=='1337'){
        $droit_user = 'admin';
    }
    return  $droit_user;
}
?>