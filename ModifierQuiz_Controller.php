<?php
    require_once "Views/NouveauQuiz_View.php";
    require_once "Models/GestionSession_Model.php";

    //On créé on récupere les variable de sessions.
    session_start(); 

    //On vérifie si un utilisateur est connecté.
    $userConnected = GestionSession::CheckLogin();

    //Si l'utilisateur n'est pas connecté on le redirige vers la page de connexion.
    if( !$userConnected  ){
        header("Location: Connexion_Controller.php");
        exit;
    }

    //On recupére le tableau associant l'id des quiz de la page au Identifiant réel des Quiz.
    $tableIdentifiantQuiz = $_SESSION['tableIdentifiantQuiz']; 
    
    //On récupére l'identifiant passé en paramétre.
    $id = $_GET['id'];

    //On traite les erreurs posssible.
    if(is_null($id) || !isset($_SESSION['tableIdentifiantQuiz']) || is_null($tableIdentifiantQuiz)){
        header("Location: Home_Controller.php");
        exit;
    }

    //On enregistre l'identifiant du Quiz que l'on modifie dans une variable de session.
    $_SESSION['idQuiz'] = $tableIdentifiantQuiz[$id];
   
    header("Location: GestionQuiz_Controller.php");
    exit;


?>