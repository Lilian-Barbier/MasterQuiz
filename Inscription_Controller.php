<?php
    require_once "Views/Inscription_View.php";

    //On créé ou récupere les variable de sessions.
    session_start(); 

    Inscription::displayForm("");

?>