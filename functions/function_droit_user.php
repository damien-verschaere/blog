<?php
/*----------------------------FONCTION DROIT UTILISATEUR------------------------------- */
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
?>
?>