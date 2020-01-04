<?php
    require_once "Models/Home_Model.php";
    require_once "Models/Admin_Model.php";
    require_once "Models/GestionSession_Model.php";

    require_once "Views/Home_View.php";

    //On créé on récupere les variable de sessions.
    session_start(); 

    $model = new GestionSession();

    //On vérifie si un utilisateur est connecté.
    $userConnected = $model->CheckLogin();

    //On regarde si l'utilisateur est un administrateur.
    if(Admin_Model::CheckAdmin()){
        header("Location: Admin_Controller.php");
        exit;
    }

    //Récupére différentes informations utilisé dans la page.
    $homeModel = new Home_Model();

    $page = $homeModel->getCurrentPage();
    $nextPageLink = $homeModel->getNextPageLink($page);
    $previousPageLink = $homeModel->getPreviousPageLink($page);
    $tableQuiz = $homeModel->getTableQuiz($page);

    //Affiche la page
    Home::displayHome($tableQuiz, $previousPageLink, $page, $nextPageLink, $userConnected);


    
?>