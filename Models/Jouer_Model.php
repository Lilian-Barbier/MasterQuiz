<?php

require_once "Models/ConnectionBDD.php";

/**
 * Gestion de la création et la modification d'un Quiz.
 */

class Jouer_Model{


    /**
     * Retourner l'intitulé de la question.
     */
    function getQuestion($idQuiz, $numQuestion){
        
        //On récupere la connection à la base de données.
        $link = GetConnection();
        if(is_null($link))
        {
            return NULL;
        }        

        $query = "SELECT * FROM question WHERE QuizID='$idQuiz'";

        $result = $link->query($query);
        $link->close();

        $cpt = 1;

        while(($row = $result->fetch_assoc()) && $cpt != $numQuestion){
            $cpt++;
        }

        return $row['Question'];
    }

    /**
     * Retourner l'identifiant de la question.
     */
    function getIdQuestion($idQuiz, $numQuestion){
        
        //On récupere la connection à la base de données.
        $link = GetConnection();
        if(is_null($link))
        {
            return NULL;
        }        

        $query = "SELECT * FROM question WHERE QuizID='$idQuiz'";

        $result = $link->query($query);
        $link->close();

        $cpt = 1;

        while(($row = $result->fetch_assoc()) && $cpt != $numQuestion){
            $cpt++;
        }

        return $row['QuestionID'];
    }

    /**
     * Récupére et forme les réponses selectionnable.
     */
    function getReponses($idQuiz, $numQuestion){
        

        //On récupére l'identifiant de la question, pour récupérer les réponses associés.
        $idQuestion = $this->getIdQuestion($idQuiz, $numQuestion);

        if(is_null($idQuestion)){
            return NULL;
        }
 
        //On récupere la connection à la base de données.
        $link = GetConnection();
        if(is_null($link))
        {
            return NULL;
        }        

        $query = "SELECT * FROM reponse WHERE QuestionID='$idQuestion'";

        $result = $link->query($query);
        $link->close();

        $cpt = 1;
        $ret = "";
        while(($row = $result->fetch_assoc())){
            
            $reponse = $row['Reponse'];

            $ret .= "<a type='button' class='btn btn-secondary btn-lg btn-block' href='JouerQuiz_Controller.php?reponse=$cpt' > $reponse </a> \n";
            
            $cpt++;
        }

        return $ret;       

 
    }


    /**
     * Récupére et forme les réponses Non selectionnable.
     */
    function getBonneReponses($idQuiz, $numQuestion){
        

        //On récupére l'identifiant de la question, pour récupérer les réponses associés.
        $idQuestion = $this->getIdQuestion($idQuiz, $numQuestion);

        if(is_null($idQuestion)){
            return NULL;
        }
 
        //On récupere la connection à la base de données.
        $link = GetConnection();
        if(is_null($link))
        {
            return NULL;
        }        

        $query = "SELECT * FROM reponse WHERE QuestionID='$idQuestion'";

        $result = $link->query($query);
        $link->close();

        $cpt = 1;
        $ret = "";
        while(($row = $result->fetch_assoc())){
            
            $reponse = $row['Reponse'];

            if($row['ReponseVrai']){
                $ret .= "<a type='button' class='btn btn-success disabled btn-lg btn-block' > $reponse </a> \n";
            } else {
                $ret .= "<a type='button' class='btn btn-danger disabled btn-lg btn-block' > $reponse </a> \n";
            }
                
            $cpt++;
        }

        return $ret;    
    }

    /**
     * Récupére Le numéro de la bonne réponse.
     */
    function getNumeroBonneReponse($idQuiz, $numQuestion){
        

        //On récupére l'identifiant de la question, pour récupérer les réponses associés.
        $idQuestion = $this->getIdQuestion($idQuiz, $numQuestion);

        if(is_null($idQuestion)){
            return NULL;
        }
 
        //On récupere la connection à la base de données.
        $link = GetConnection();
        if(is_null($link))
        {
            return NULL;
        }        

        $query = "SELECT * FROM reponse WHERE QuestionID='$idQuestion'";

        $result = $link->query($query);
        $link->close();

        $cpt = 1;
        $ret = 0;;
        while(($row = $result->fetch_assoc())){
            
            $reponse = $row['Reponse'];

            if($row['ReponseVrai']){
                $ret = $cpt;
            } 
           
            $cpt++;
        }

        return $ret;       
    }

    /**
     * Retourner le nombre de question dans le quiz.
     */
    function getNombreQuestion($idQuiz){
        
        //On récupere la connection à la base de données.
        $link = GetConnection();
        if(is_null($link))
        {
            return NULL;
        }        

        $query = "SELECT * FROM question WHERE QuizID='$idQuiz'";

        $result = $link->query($query);
        $link->close();

        return $result->num_rows;
    }
    
}


?>