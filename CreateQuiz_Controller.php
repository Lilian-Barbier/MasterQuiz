<?php
    require_once "Models/Quiz_Model.php";
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

    //Todo Vérification obligatoire ? peut être pas.
    if(isset($_POST['formulaire'])){

        if($_POST['formulaire'] == 'Creation'){
           
            $quizModel = new Quiz_Model();

            $error = $quizModel->NouveauQuiz();
            if( !is_null($error) ){
                NouveauQuiz::displayForm($error);
                exit;
            }
            
            header("Location: GestionQuiz_Controller.php");
            exit;

        } 
    }

    //Si le formulaire n'existe pas on redirige vers la page d'accueil, ne devrais pas arriver.
    header("Location: Home_Controller.php");
    exit;

?>