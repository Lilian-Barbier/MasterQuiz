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

    $quizModel = new Quiz_Model();

    //On récupére le menus de gestion du quiz.
    $menu = $quizModel->GetMenu($idQuiz);

    
    //
    if(isset($_GET['question'])){

        $numQuestion = $_GET['question'];

        $nbQuestion = $quizModel->GetNombreQuestions($idQuiz);

        //On vérifie que l'utilisateur n'a pas rentré un numéro de question au hasard.
        if($numQuestion<0 || $numQuestion>$nbQuestion){
            header("Location: GestionQuiz_Controller.php");
            exit;
        }

        $question = $quizModel->GetQuestion($idQuiz, $numQuestion);

        $idQuestion = $quizModel->GetIdentifiantQuestion($idQuiz, $numQuestion);
        $form = $quizModel->GetReponsesForm($idQuestion);

        $nbReponses = $quizModel->GetNombreReponses($idQuestion);

        //Affiche la page.
        QuestionQuiz::displayForm($question, $menu, $error, $numQuestion, $form, $nbReponses);
    }
    else{

        $theme = $quizModel->GetTheme($idQuiz);
        $description = $quizModel->GetDescription($idQuiz);
        $public = $quizModel->GetStatut($idQuiz);
        

        //Affiche la page.
        RecapQuiz::displayForm($theme, $description, $menu, "", $public);
    }




    
?>