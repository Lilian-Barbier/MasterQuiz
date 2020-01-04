<?php

    //On créé on récupere les variable de sessions.
    session_start(); 

    //On remplace l’identifiant de session courant par un nouveau pour éviter une attaque du type session fixation
    session_regenerate_id(true); 

    require_once "Views/Connexion_View.php";
    Connexion::displayForm("");

?>