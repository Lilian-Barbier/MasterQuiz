<?php
    require_once "Models/Recherche_Model.php";
    require_once "Models/GestionSession_Model.php";
    require_once "Views/MesQuiz_View.php";
    
    //On créé on récupere les variable de sessions.
    session_start(); 

    //On vérifie si un utilisateur est connecté.
    $userConnected = GestionSession::CheckLogin();
    $UserId = GestionSession::GetUserId();

    //Si l'utilisateur n'est pas connecté on le redirige vers la page de connexion.
    if( !$userConnected || is_null($UserId) ){
        header("Location: Connexion_Controller.php");
        exit;
    }

    $mesQuizModel = new Recherche_Model();

    //Récupérer le pattern rechercher si il existe.
    $pattern = $mesQuizModel->getPattern();
    
    if( is_null($pattern) ){
        $pattern = "";
    }

    //Récupére les résultat de la recherche si le pattern n'est pas NULL.
    $page = $mesQuizModel->getCurrentPage();
    $nextPageLink = $mesQuizModel->getNextPageLinkMesQuiz($page, $pattern, $userid);
    $previousPageLink = $mesQuizModel->getPreviousPageLinkMesQuiz($page, $pattern);

    $tableQuiz = $mesQuizModel->getTableMesQuiz($page, $pattern, $UserId);


    //Affiche la page.
    MesQuiz::displayForm($tableQuiz, $previousPageLink, $page, $nextPageLink, $userConnected);
?>