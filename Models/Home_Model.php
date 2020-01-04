<?php

require_once "Models/ConnectionBDD.php";

class Home_Model{

    /**
     * Fonction récupérant les données des dernier quiz créés selon la page.
     */
    function getTableQuiz($page){

        $link = GetConnection();

        if($link == NULL){
            return "Erreur : Veuillez réessayer plus tard";
        }

        $res = $link->query("SELECT * FROM quiz WHERE Public=1 LIMIT 10 OFFSET " . $page * 10 );
        $link->close();

        $tableQuiz = "";

        $cpt=1;
        $tableIdentifiantQuiz;
        while ($row = $res->fetch_assoc()) {
            $tableQuiz .= "<tr> \n";
            $tableQuiz .= " <th scope=\"row\">" . $row['Nom'] . "</th> \n";
            $tableQuiz .= " <td> " . $row['Theme'] . "</td> \n";
            $tableQuiz .= " <td> " . $row['Descrip'] . "</td> \n";
            $tableQuiz .= " <td> " . $this->GetUserName($row['UserID']) . "</td> \n";
            $tableQuiz .= " <td> " . $row['Creation'] . "</td> \n";

            $tableQuiz .= "</td> \n";
            $tableQuiz .= " <td> <a href='JouerQuiz_Controller.php?numero=$cpt' type='button' class='btn btn-success btn-sm'> Jouer </a> </td> \n";
            $tableQuiz .= " </tr> \n";

            $tableQuiz .= " </tr> \n";


            $tableIdentifiantQuiz[$cpt] = $row['QuizID'];
            $cpt++;
        }

        //On enregistre le tableau associant l'id des quiz de la page au Identifiant réel des Quiz.
        $_SESSION['tableIdentifiantQuiz_Jouer'] = $tableIdentifiantQuiz;

        return $tableQuiz;
    }

    /**
     * Fonction retournant un bouton vers la page suivante selon la page actuelle.
     */
    function getNextPageLink($page){

        $link = GetConnection();

        if($link == NULL){
            return "Erreur : Veuillez réessayer plus tard";
        }
        else
        {
            $res = $link->query("SELECT * FROM quiz WHERE Public=1 LIMIT 10 OFFSET " . ($page + 1) * 10 );
            $link->close();

            if($res->num_rows == 0){ 
                return ""; 
            }
    
            return "<a class='btn btn-secondary btn-sm' href=Home_Controller.php?page=" . ($page + 1) .  "> -> </a>";
                
        }
    }

    /**
     * Fonction retournant un bouton vers la page précédente selon la page actuelle.
     */
    function getPreviousPageLink($page){
        
        if( $page == 0 ){ return ""; }

        return "<a class='btn btn-secondary btn-sm' href=Home_Controller.php?page=" . ($page - 1) .  "> <- </a>";
            
    }


    /**
     * Fonction retournant la page actuelle. Vérifie que le numéro de la page n'est pas négatif.
     */
    function getCurrentPage(){
    
        $page = $_GET[page];

        if($page == NULL || $page < 0){ $page = 0; }

        return $page;

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