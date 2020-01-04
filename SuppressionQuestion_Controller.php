<?php
    require_once "Views/QuestionQuiz_View.php";
    require_once "Views/RecapQuiz_View.php";
    require_once "Models/GestionSession_Model.php";
    require_once "Models/Quiz_Model.php";

    //On créé on récupere les variable de sessions.
    session_start(); 

    //On vérifie si un utilisateur est connecté.
    $userConnected = GestionSession::CheckLogin();

    //Si l'utilisateur n'est pas connecté on le redirige vers la page de connexion.
    if( !$userConnected  ){
        header("Location: Connexion_Controller.php");
        exit;
    }

    //On récupére l'identifiant du quiz que l'on modifie.
    $idQuiz = $_SESSION['idQuiz'];

    if(is_null($idQuiz)){
        header("Location: Home_Controller.php");
        exit;
    }   

    
    if(isset($_GET['question'])){

        $idQuestion = $_GET['question'];

        Quiz_Model::SupprimerQuestion($idQuiz, $idQuestion);
        //Todo Gestion d'erreurs.
    }

    header("Location: GestionQuiz_Controller.php");
    exit;


?>