<?php
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

    $statut = Quiz_Model::GetStatut($idQuiz);

    if($statut==0){
        $statut=1;
    }
    else{
        $statut=0;
    }

    Quiz_Model::GererStatut($idQuiz, $statut);
    //Todo Gestion d'erreurs.

    header("Location: GestionQuiz_Controller.php");
    exit;


?>