<?php
    require_once "Models/Recherche_Model.php";
    require_once "Models/GestionSession_Model.php";
    require_once "Views/Recherche_View.php";

    //On créé on récupere les variable de sessions.
    session_start(); 
    
    //On vérifie si un utilisateur est connecté.
    $userConnected = GestionSession::CheckLogin();

    //Récupérer le pattern rechercher si il existe.
    $rechercheModel = new Recherche_Model();
    $pattern = $rechercheModel->getPattern();

    //Récupére les résultat de la recherche si le pattern n'est pas NULL.
    if($pattern !== NULL){

        $page = $rechercheModel->getCurrentPage();
        $nextPageLink = $rechercheModel->getNextPageLink($page, $pattern);
        $previousPageLink = $rechercheModel->getPreviousPageLink($page, $pattern);
    
        $tableQuiz = $rechercheModel->getTableQuiz($page, $pattern);

    } 

    //Affiche la page.
    Recherche::displayForm($tableQuiz, $previousPageLink, $page, $nextPageLink, $userConnected);

?>