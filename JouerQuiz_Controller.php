<?php
    require_once "Views/QuestionJouer_View.php";
    require_once "Views/ReponseJouer_View.php";
    require_once "Views/FinisJouer_View.php";

    require_once "Models/Jouer_Model.php";
    require_once "Models/GestionSession_Model.php";

    //On créé on récupere les variable de sessions.
    session_start(); 

    //On vérifie si un utilisateur est connecté.
    $userConnected = GestionSession::CheckLogin();


    //Initiation d'une partie.
    if(isset($_GET['numero'])){ 

        //On recupére le tableau associant le numero des quiz de la page au Identifiant réel des Quiz.
        $tableIdentifiantQuiz = $_SESSION['tableIdentifiantQuiz_Jouer']; 

        //On récupére l'identifiant passé en paramétre.
        $numero = $_GET['numero'];

        //On traite les erreurs posssible.
        if(is_null($numero) || !isset($_SESSION['tableIdentifiantQuiz_Jouer']) ){
            header("Location: Home_Controller.php");
            exit;
        }

        //On enregistre l'identifiant du Quiz que l'on modifie dans une variable de session.
        $_SESSION['idQuizJoue'] = $tableIdentifiantQuiz[$numero];

        $_SESSION['question'] = 1;
        $_SESSION['score'] = 0;

        $_SESSION['action'] = 'getQuestion';

        header("Location: JouerQuiz_Controller.php");
        exit;

    }

    //Une partie est déja commencé.
    if(isset($_SESSION['idQuizJoue'])){
        
        $model = new Jouer_Model();

        //On récupére les valeurs du quiz.
        $idQuiz = $_SESSION['idQuizJoue'];
        $numQuestion = $_SESSION['question'];
        $nbQuestion = $model->getNombreQuestion($idQuiz);

        //on demande une nouvelle question
        if($_SESSION['action'] == 'getQuestion'){
            
            $question = $model->getQuestion($idQuiz, $numQuestion);
            $reponse = $model->getReponses($idQuiz, $numQuestion);

            $_SESSION['action'] = 'getReponse';

            Question::display($numQuestion, $question, $reponse, $userConnected);
            exit;
        }

        //on demande la correction.
        elseif($_SESSION['action'] == 'getReponse'){
            
            //Si l'on ne reçois pas une réponse correcte on redemande.
            //Todo rajouter un message d'erreur.
            if(!isset($_GET['reponse'])){
                $_SESSION['action'] = 'getQuestion';
                header("Location: JouerQuiz_Controller.php");
                exit;
            }

            $question = $model->getQuestion($idQuiz, $numQuestion);
            
            $bonneReponses = $model->getBonneReponses($idQuiz, $numQuestion);

            $numeroBonneReponse = $model->getNumeroBonneReponse($idQuiz, $numQuestion);

            if($numeroBonneReponse == $_GET['reponse']){
                $resultat = "Bonne réponse. Félicitation !";
                $_SESSION['score']++;
            }
            else{
                $resultat = "Mauvaise réponse !";
            }


            $numQuestion++;
            $_SESSION['question'] = $numQuestion;

            if($numQuestion<=$nbQuestion){ $_SESSION['action'] = 'getQuestion'; } 
            else { $_SESSION['action'] = 'finis'; }

            Reponse::display(($numQuestion-1), $question, $bonneReponses, $resultat, $userConnected);
            exit;

        }

        //Le Quiz est Finis.
        elseif($_SESSION['action'] == 'finis'){
            
            $_SESSION['question'] = NULL;
            $score = $_SESSION['score'];

            Finis::display($score, $nbQuestion, $userConnected);
            exit;
            
        }
        
    }

    //Une erreur.
    
 







?>