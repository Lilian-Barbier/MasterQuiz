<?php

    require_once "Models/Authentification_Model.php";
    require_once "Views/Home_View.php";
    require_once "Views/Connexion_View.php";
    require_once "Views/Inscription_View.php";

    //On créé on récupere les variable de sessions.
    session_start(); 

    $authentification = new Authentification();

    if(isset($_POST['formulaire'])){

        if($_POST['formulaire'] == 'connexion'){
           
            $error = $authentification->LoginVerification();
            if( !is_null($error) ){
                Connexion::displayForm($error);
                exit;
            }
        } 

        if($_POST['formulaire'] == 'inscription'){
            
            $error = $authentification->Inscription();
            if( !is_null($error) ){
                Inscription::displayForm($error);
                exit;
            }
            
        }
    }

    header("Location: Home_Controller.php");
    exit;

?>