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
    
    $idQuiz = $_GET['numero'];
    $model->SuppressionQuiz($idQuiz);

    header("Location: Admin_Controller.php");
    exit;

?>