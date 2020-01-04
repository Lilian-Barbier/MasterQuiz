<?php
    require_once "Models/Admin_Model.php";
    require_once "Views/Admin_View.php";

    
    //On créé on récupere les variable de sessions.
    session_start(); 

    $model = new Admin_Model();

    //On regarde si l'utilisateur est un administrateur.
    if(!$model->CheckAdmin()){
        header("Location: Home_Controller.php");
        exit;
    }


    //Récupére différentes informations utilisé dans la page.
    $pattern = $model->getPattern();
    $page = $model->getCurrentPage();
    $nextPageLink = $model->getNextPageLink($page, $pattern);
    $previousPageLink = $model->getPreviousPageLink($page, $pattern);
    $tableQuiz = $model->getTableQuiz($page, $pattern);


    //Affiche la page
    Admin::display($tableQuiz, $previousPageLink, $page, $nextPageLink);

?>