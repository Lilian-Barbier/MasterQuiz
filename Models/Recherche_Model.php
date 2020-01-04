<?php

require_once "Models/ConnectionBDD.php";

class Recherche_Model{

    /**
     * Fonction récupérant le pattern si il à était donné.
     */
    function getPattern(){

        return $_GET[pattern];

    }

    /**
     * Fonction récupérant les données des dernier quiz créés selon la page.
     */
    function getTableQuiz($page, $pattern){

        $link = GetConnection();

        if($link == NULL){
            return "Erreur : Veuillez réessayer plus tard";
        }

        $res = $link->query("SELECT * FROM quiz WHERE Public=1 AND Nom LIKE '%{$pattern}%'LIMIT 10 OFFSET " . $page * 10 );

        $tableQuiz = "";

        while ($row = $res->fetch_assoc()) {
            $tableQuiz .= "<tr> \n";
            $tableQuiz .= " <th scope=\"row\">" . $row['Nom'] . "</th> \n";
            $tableQuiz .= " <td> " . $row['Theme'] . "</td> \n";
            $tableQuiz .= " <td> " . $row['Descrip'] . "</td> \n";
            $tableQuiz .= " <td> " . $this->GetUserName($row['UserID']) . "</td> \n";
            $tableQuiz .= " <td> " . $row['Creation'] . "</td> \n";
            $tableQuiz .= " </tr> \n";
        }

        return $tableQuiz;
    }


    /**
     * Fonction retournant un bouton vers la page suivante de la page "Recherche" selon la page actuelle.
     */
    function getNextPageLink($page, $pattern){

        $link = GetConnection();

        if($link == NULL){
            return "Erreur : Veuillez réessayer plus tard";
        }
        else
        {
            $res = $link->query("SELECT * FROM quiz WHERE Public=1 AND Nom LIKE '%{$pattern}%' LIMIT 10 OFFSET " . $page * 10 );
    
            if(empty($res) ){ return "<a> -> </a>"; }
    
            return "<a class='btn btn-secondary btn-sm' href=Recherche_Controller.php?pattern={$pattern}&page=" . ($page + 1) .  "> -> </a>";
                
        }
    }


    /**
     * Fonction retournant un bouton vers la page précédente selon la page actuelle.
     */
    function getPreviousPageLink($page, $pattern){
        
        if( $page == 0 ){ return ""; }

        return "<a class='btn btn-secondary btn-sm' href=Recherche_Controller.php?pattern={$pattern}&page=" . ($page - 1) .  "> <- </a>";
            
    }


    /**
     * Fonction retournant la page actuelle. Vérifie que le numéro de la page n'est pas négatif.
     */
    function getCurrentPage(){
    
        $page = $_GET[page];

        if( is_null($page) || $page < 0){ $page = 0; }

        return $page;

    }



    //FONCTIONS LIE A LA PAGE "MES QUIZ"


    /**
     * Fonction retournant un bouton vers la page suivante de "MesQuiz" selon la page actuelle.
     */
    function getNextPageLinkMesQuiz($page, $pattern, $userid){

        $link = GetConnection();

        if($link == NULL){
            return "Erreur : Veuillez réessayer plus tard";
        }
        else
        {
            $res = $link->query("SELECT * FROM quiz WHERE Nom LIKE '%{$pattern}%' AND UserId='{$userid}' LIMIT 10 OFFSET " . $page * 10 );
    
            if(empty($res) ){ return ""; }
    
            return "<a class='btn btn-secondary btn-sm' href=MesQuiz_Controller.php?pattern={$pattern}&page=" . ($page + 1) .  "> -> </a>";
                
        }
    }

    /**
     * Fonction retournant un bouton vers la page précédente selon la page actuelle.
     */
    function getPreviousPageLinkMesQuiz($page, $pattern){
        
        if( $page == 0 ){ return "<a> <- </a>"; }

        return "<a class='btn btn-secondary btn-sm' href=MesQuiz_Controller.php?pattern={$pattern}&page=" . ($page - 1) .  "> <- </a>";
            
    }

    /**
     * Fonction récupérant les données des dernier quiz selon l'utilisateur.
     */
    function getTableMesQuiz($page, $pattern, $userid){

        $link = GetConnection();

        if($link == NULL){
            return "Erreur : Veuillez réessayer plus tard";
        }
        else
        {
            $res = $link->query("SELECT * FROM quiz WHERE Nom LIKE '%{$pattern}%' AND UserId='{$userid}' LIMIT 10 OFFSET " . $page * 10 );

            $tableQuiz = "";
    
            $cpt=1;
            $tableIdentifiantQuiz;
            while ($row = $res->fetch_assoc()) {
                $tableQuiz .= "<tr> \n";
                $tableQuiz .= " <th scope=\"row\">" . $row['Nom'] . "</th> \n";
                $tableQuiz .= " <td> " . $row['Theme'] . "</td> \n";
                $tableQuiz .= " <td> " . $row['Descrip'] . "</td> \n";
                $tableQuiz .= " <td> " . $row['Creation'] . "</td> \n";

                $tableQuiz .= " <td> ";

                if( $row['Public'] == "1" ){ $tableQuiz .= "Public"; } 
                else { $tableQuiz .= "Privé"; }
                
                $tableQuiz .= "</td> \n";
                $tableQuiz .= " <td> <a href='ModifierQuiz_Controller.php?id=$cpt' type='button' class='btn btn-primary btn-sm'> Modifier </a> </td> \n";
                $tableQuiz .= " </tr> \n";

                $tableIdentifiantQuiz[$cpt] = $row['QuizID'];
                $cpt++;
            }
    
            //On enregistre le tableau associant l'id des quiz de la page au Identifiant réel des Quiz.
            $_SESSION['tableIdentifiantQuiz'] = $tableIdentifiantQuiz;

            return $tableQuiz;
        }
    }



    /**
     * Fonction retournant le nom d'un utilisateur selon son Id.
     */
    function GetUserName($userId){

        $link = GetConnection();

        if($link == NULL){
            return "Anonyme";
        }
        else
        {

            $res = $link->query("SELECT Nom FROM user WHERE UserId='{$userId}'");
            $link->close();

            if(empty($res) ){ 
                return "Anonyme";
            }
    
            $row = $res->fetch_assoc();
            return $row['Nom'];
                
        }
    }







}

?>