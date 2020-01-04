<?php

require_once "Models/ConnectionBDD.php";

class Admin_Model{

    /**
     * Vérifie si c'est un administrateur.
     */
    function CheckAdmin()
    {
        if( !isset($_SESSION) ){ 
            session_start(); 
        }

        if( empty($_SESSION['id']) || is_null($_SESSION['id']))
        {
            return false;
        }

        $userId = $_SESSION['id'];

        $link = GetConnection();

        if($link == NULL){
            return "Erreur : Veuillez réessayer plus tard";
        }

        $res = $link->query("SELECT * FROM user WHERE UserID=$userId");
        $link->close();

        $row = $res->fetch_assoc();

        if($row['Administrateur'] != 1){
            return false;
        }

        return true;
    }


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

        $res = $link->query("SELECT * FROM quiz WHERE Nom LIKE '%{$pattern}%'LIMIT 10 OFFSET " . $page * 10 );

        $tableQuiz = "";

        while ($row = $res->fetch_assoc()) {
            $tableQuiz .= "<tr> \n";
            $tableQuiz .= " <th scope=\"row\">" . $row['Nom'] . "</th> \n";
            $tableQuiz .= " <td> " . $row['Theme'] . "</td> \n";
            $tableQuiz .= " <td> " . $row['Descrip'] . "</td> \n";
            $tableQuiz .= " <td> " . $this->GetUserName($row['UserID']) . "</td> \n";
            $tableQuiz .= " <td> " . $row['Creation'] . "</td> \n";

            $quizID = $row['QuizID'];

            $tableQuiz .= " <td> <a href='AdminSupression_Controller.php?numero=$quizID' type='button' class='btn btn-danger btn-sm'> Supprimer </a> </td> \n";
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
            $res = $link->query("SELECT * FROM quiz WHERE Public=1 AND Nom LIKE '%{$pattern}%' LIMIT 10 OFFSET " . ($page+1) * 10 );
    
            if($res->num_rows <= 0){ return ""; }
    
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





    /**
     * Fonction Permetant de supprimer un quiz.
     */
    function SuppressionQuiz($idQuiz){

        $link = GetConnection();

        if($link == NULL){
            return "";
        }

        $query = "DELETE FROM quiz WHERE QuizID='$idQuiz'";
        $res = $link->query($query);
        $link->close();


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
