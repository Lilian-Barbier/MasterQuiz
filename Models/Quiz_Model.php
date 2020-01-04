<?php

require_once "Models/ConnectionBDD.php";

/**
 * Gestion de la création et la modification d'un Quiz.
 */

class Quiz_Model{

    /**
     * Dans le cas d'une erreur la met en forme.
     */
    function HandleError($err)
    {
        return($err."\r\n");
    }

    /**
     * Fonction permettant de créer un nouveau quiz.
     */
    function NouveauQuiz()
    {
        //Verification des champs du formulaire :
        if(empty($_POST['InputNomQuiz']))
        {
            return $this->HandleError("Veuillez entrer un nom pour votre Quiz!");
        }
        
        if(empty($_POST['SelectTheme']))
        {
            return $this->HandleError("Veuillez sélectionner un thème correspondant à votre Quiz!");
        }

        if(empty($_POST['TextAreaDescription']))
        {
            return $this->HandleError("Veuillez entrer une description de votre Quiz!");
        }
        
        //On Récupére et filtre les données.
        $nom = trim($_POST['InputNomQuiz']);
        $theme = $_POST['SelectTheme'];
        $description = trim($_POST['TextAreaDescription']);
        $idUser = $this->GetUserId();
        $date = date('yy-d-m');
        
        //On vérifie que le nom du quiz est unique.
        if( $this->CheckNomAlreadyUsedBDD($nom) )
        {
            return $this->HandleError("Nom de Quiz déja utilisé. Veuillez en entrez un nouveau !");
        }

        if(is_null($idUser))
        {
            return $this->HandleError("Erreur, veuillez vous reconnecter !");
        }

        //On essaie de créer le Quiz dans la bases de données.
        if( !$this->CreateQuiz($nom, $theme, $description, $idUser, $date) )
        {
            return $this->HandleError("Erreur, veuillez réésayer !");
        }

        //On enregistre l'identifiant du quiz dans une variable de session. On en auras besoins sur plusieurs page.
        $_SESSION['idQuiz'] = $this->getIdQuiz($nom);

        return NULL;
    }


    /**
     * Vérifie si le nom du quiz est déja utilisé.
     */
    function CheckNomAlreadyUsedBDD($nom)
    {
        //On récupere la connection à la base de données
        $link = GetConnection();
        if($link == NULL)
        {
            //Exception
            return NULL;
        }          

        $query = "SELECT * FROM quiz WHERE Nom='$nom'";

        $result = $link->query($query);

        //Si le nom n'est pas déja utilisé on retourne 
        if(mysqli_num_rows($result) <= 0)
        {
            $link->close();
            return false;
        }
     
        $link->close();
        return true;
    }

    /**
     * Récupére l'Identifiant du Quiz dans la Base de données.
     */
    function getIdQuiz($nom){
        //On récupere la connection à la base de données
        $link = GetConnection();
        if($link == NULL)
        {
            //Exception
            return NULL;
        }          

        $query = "SELECT * FROM quiz WHERE Nom='$nom'";

        $result = $link->query($query);
        $link->close();

        //Si le nom n'est pas déja utilisé on retourne 
        if(mysqli_num_rows($result) <= 0)
        {
            return NULL;
        }

        $row = $result->fetch_assoc();
        return $row['QuizID'];
    }

    /**
     * Créer le quiz dans la Base de données.
     */
    Function CreateQuiz($nom, $theme, $description, $id, $date){
        //On récupere la connection à la base de données.
        $link = GetConnection();
        if($link == NULL)
        {
            return false;
        }        

        //On échape les caractére spéciaux.
        $nom = $link->real_escape_string($nom);
        $theme = $link->real_escape_string($theme);
        $description = $link->real_escape_string($description);

        //On prépare la requéte.
        $query = "INSERT INTO quiz (UserId, Nom, Theme, Descrip, Creation, Public) VALUES ('$id', '$nom', '$theme', '$description', '$date', 0)";

        //On execute le requéte.
        if(!$link->query($query))
        {
            $link->close();
            return false;
        }
        
        $link->close();
        return true;
    }
   


    /**
     * Vérifie qu'un utilisateur est connecté.
     */
    function GetUserId()
    {
        if( !isset($_SESSION) ){ 
            session_start(); 
        }

        if( empty($_SESSION['id']) || is_null($_SESSION['id']))
        {
            return NULL;
        }

        return $_SESSION['id'];
    }

    /**
     * Créé le menu de gestion d'un Quiz.
     */
    function GetMenu($idQuiz){

        //On récupere la connection à la base de données.
        $link = GetConnection();
        if(is_null($link))
        {
            return NULL;
        }        

        $query = "SELECT * FROM question WHERE QuizID='$idQuiz'";

        $result = $link->query($query);
        $link->close();

        $ret  = "<li class=\"nav-item\"> \n";
        $ret .= "\t<a class=\"nav-link\" href=\"GestionQuiz_Controller.php\"> Quiz : " . $this->getNom($idQuiz) . " </a>\n";
        $ret .= "</li>\n";

        $cpt = 1;
        while($row = $result->fetch_assoc()){
            $ret .= "<li class=\"nav-item\"> \n";
            $ret .= "\t<a class=\"nav-link\" href=\"GestionQuiz_Controller.php?question=" . $cpt ."\"> Question " . $cpt ." </a>\n";
            $ret .= "</li>\n";
        
            $cpt++;
        }
        $ret .= "<li class=\"nav-item\"> \n";
        $ret .= "\t<a class=\"nav-link\" href=\"CreateQuestion_Controller.php\"> + Ajouter une question + </a>\n";
        $ret .= "</li>\n";
        return $ret;
    
    }

    /**
     * Récupére une question dans la Base de données.
     */
    function GetQuestion($idQuiz, $idQuestion){

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

        while(($row = $result->fetch_assoc()) && $cpt != $idQuestion){
            $cpt++;
        }

        return $row['Question'];

    }

    /**
     * Récupére le thème du Quiz dans la Base de données.
     */
    function GetTheme($idQuiz){

        //On récupere la connection à la base de données.
        $link = GetConnection();
        if(is_null($link))
        {
            return NULL;
        }        

        $query = "SELECT * FROM quiz WHERE QuizID='$idQuiz'";

        $result = $link->query($query);
        $link->close();

        $row = $result->fetch_assoc();

        return $row['Theme'];

    }

    /**
     * Récupére le nom du Quiz dans la Base de données.
     */
    function GetNom($idQuiz){

        //On récupere la connection à la base de données.
        $link = GetConnection();
        if(is_null($link))
        {
            return NULL;
        }        

        $query = "SELECT * FROM quiz WHERE QuizID='$idQuiz'";

        $result = $link->query($query);
        $link->close();

        $row = $result->fetch_assoc();

        return $row['Nom'];

    }
    
    /**
     * Récupére la Description du Quiz dans la Base de données.
     */
    function GetDescription($idQuiz){

        //On récupere la connection à la base de données.
        $link = GetConnection();
        if(is_null($link))
        {
            return NULL;
        }        

        $query = "SELECT * FROM quiz WHERE QuizID='$idQuiz'";

        $result = $link->query($query);
        $link->close();

        $row = $result->fetch_assoc();

        return $row['Descrip'];

    }

    /**
     * Fonction permetant de supprimer un Quiz à partir de son identifiant.
     */
    function SupprimerQuiz($idQuiz){

        //On récupere la connection à la base de données.
        $link = GetConnection();
        if(is_null($link))
        {
            return NULL;
        }        

        $query = "DELETE FROM quiz WHERE QuizID='$idQuiz'";
 
        $link->query($query);
        $link->close();

    }

    /**
     * Fonction permetant de gérer le statut d'un quiz à partir de son identifiant.
     */
    function GererStatut($idQuiz, $statut){

        //On récupere la connection à la base de données.
        $link = GetConnection();
        if(is_null($link))
        {
            return NULL;
        }        

        $query = "UPDATE quiz SET Public=$statut WHERE QuizID='$idQuiz'";
        
        $link->query($query);
        $link->close();

    }

    
    /**
     * Fonction permetant de gérer le statut d'un quiz à partir de son identifiant.
     */
    function GetStatut($idQuiz){

        //On récupere la connection à la base de données.
        $link = GetConnection();
        if(is_null($link))
        {
            return NULL;
        }        

        $query = "SELECT * FROM quiz WHERE QuizID='$idQuiz'";



        $result = $link->query($query);
        $link->close();

        $row = $result->fetch_assoc();

        return $row['Public'];

    }


    /**
     * Créer une nouvelle question vide.
     */
    function CreateQuestion($idQuiz)
    {
        
        //On récupere la connection à la base de données.
        $link = GetConnection();
        if(is_null($link))
        {
            return NULL;
        }        

        $query = "INSERT INTO question (QuizID, Question) VALUES ($idQuiz,'')";
        
        $result = $link->query($query);
        $link->close();

    }


    /**
     * Supprimer une question lié au Quiz.
     */
    function SupprimerQuestion($idQuiz, $idQuestion){

        //On récupere la connection à la base de données.
        $link = GetConnection();
        if(is_null($link))
        {
            return NULL;
        }        

        $query = "SELECT * FROM question WHERE QuizID='$idQuiz'";

        $result = $link->query($query);

        $cpt = 1;

        while(($row = $result->fetch_assoc()) && $cpt != $idQuestion){
            $cpt++;
        }

        //On récupére le réel identifiant de la question.
        $identifiant = $row['QuestionID'];

        $query = "DELETE FROM question WHERE QuestionID='$identifiant'";

        $result = $link->query($query);
        $link->close();

    }


    /**
     * Récupére le réél identifiant d'une question dans la Base de données.
     */
    function GetIdentifiantQuestion($idQuiz, $numQuestion){

        //On récupere la connection à la base de données.
        $link = GetConnection();
        if(is_null($link))
        {
            return NULL;
        }        

        $query = "SELECT * FROM question WHERE QuizID='$idQuiz'";

        $result = $link->query($query);

        $cpt = 1;

        while(($row = $result->fetch_assoc()) && $cpt != $numQuestion){
            $cpt++;
        }

        //On récupére le réel identifiant de la question.
        return $row['QuestionID'];

    }



    /**
     * Fonction permettant de créer une question associé à un quiz.
     */
    function EnregistreQuestion()
    {
        //Verification des champs du formulaire :


        //On créé ou récupere les variable de sessions.
        session_start(); 

        //On récupére différentes informations du formulaire.
        $question = $_POST['InputQuestion'];
        $nbReponse = $_POST['nbReponse'];
        $numQuestion = $_POST['numQuestion'];
        $bonneReponse = $_POST['radioReponse'];

        //On récupére l'identifiant du quiz qu'on est eb
        $idQuiz = $_SESSION['idQuiz'];

        //On récupere la connection à la base de données.
        $link = GetConnection();
        if(is_null($link))
        {
            return NULL;
        }     

        $idQuestion = Quiz_Model::GetIdentifiantQuestion($idQuiz, $numQuestion);

        //On met à jour le texte de la question dans la base de données.
        $query = "UPDATE question SET Question='$question' WHERE QuestionID=$idQuestion";
        $result = $link->query($query);
                

        $reponsesID= Quiz_Model::GetReponsesQuestion($idQuestion);
        $nombreReponseBDD = count($reponsesID);

        
        //On boucle sur le nombre de réponse envoyé.
        for ($numRep = 1; $numRep <= $nbReponse; $numRep++) {
            
            //On récupére le texte de la réponse.
            $rep = $_POST['InputReponse'.$numRep];

            //On récupére la valeur de la réponse. Si elle est vrai ou Fausse.
            $valeurReponse = 0;
            if($bonneReponse == $numRep){
                $valeurReponse = 1;
            }

            //Si la réponse existe déja on la modifie.
            if($numRep<=$nombreReponseBDD){
                $identifiantReponseModif = $reponsesID[$numRep];

                $query = "UPDATE reponse SET Reponse='$rep', ReponseVrai=$valeurReponse WHERE ReponseID=$identifiantReponseModif";            
                $result = $link->query($query);        
            }

            //Si elle n'existe pas on la créé.
            else{
                
                $query = "INSERT INTO reponse (QuestionID, Reponse, ReponseVrai) VALUES ($idQuestion, '$rep', $valeurReponse)";
                $result = $link->query($query);    
                
            }

        }
    }





    /**
     * .
     */
    function GetReponsesQuestion($idQuestion){

        //On récupere la connection à la base de données.
        $link = GetConnection();
        if(is_null($link))
        {
            return NULL;
        }        

        $query = "SELECT * FROM reponse WHERE QuestionID=$idQuestion";

        $result = $link->query($query);
        $link->close();

        $cpt = 1;

        $tableReponsesID;
        while(($row = $result->fetch_assoc())){

            $tableReponsesID[$cpt] = $row['ReponseID'];
            $cpt++;

        }

        return $tableReponsesID;

    }



    /**
     * .
     */
    function GetNombreReponses($idQuestion){

        //On récupere la connection à la base de données.
        $link = GetConnection();
        if(is_null($link))
        {
            return NULL;
        }        

        $query = "SELECT * FROM reponse WHERE QuestionID=$idQuestion";

        $result = $link->query($query);
        $link->close();
        
        //Si il n'y a pas de réponse :
        if($result->num_rows < 2){
            $ret = 2;
        } 
        else{
            $ret = $result->num_rows;
        }

        return $ret;


        
    }
    


    /**
     * .
     */
    function GetNombreQuestions($idQuiz){

        //On récupere la connection à la base de données.
        $link = GetConnection();
        if(is_null($link))
        {
            return NULL;
        }        

        $query = "SELECT * FROM question WHERE QuizID=$idQuiz";

        $result = $link->query($query);
        $link->close();
        
        return  $result->num_rows;
    }

    function GetReponsesForm($idQuestion){

        //On récupere la connection à la base de données.
        $link = GetConnection();
        if(is_null($link))
        {
            return NULL;
        }        

        $query = "SELECT * FROM reponse WHERE QuestionID=$idQuestion";

        $result = $link->query($query);
        $link->close();

        $cpt = 1;
        $ret = "";

        //Si il n'y a pas de réponse :
        if($result->num_rows < 2){

            $ret .= "<div class='row'> \n";
            $ret .= "\t<input type='text' class='form-control col-sm-8' id='InputReponse1' name='InputReponse1' placeholder='Réponse 1' value=''></input> \n";
            $ret .= "\t<label class='col-sm-4' ><input type='radio' name='radioReponse' value='1' checked> Bonne Réponse </label> \n";
            $ret .= "</div> \n";

            $ret .= "<div class='row'> \n";
            $ret .= "\t<input type='text' class='form-control col-sm-8' id='InputReponse2' name='InputReponse2' placeholder='Réponse 2' value=''></input> \n";
            $ret .= "\t<label class='col-sm-4' ><input type='radio' name='radioReponse' value='2'> Bonne Réponse </label> \n";
            $ret .= "</div> \n";
        }
        //Si il y a des réponse
        else{

            while(($row = $result->fetch_assoc())){

                $reponseText = $row['Reponse'];
                $reponseValue = $row['ReponseVrai'];

                $ret .= "<div class='row'> \n";
                $ret .= "\t<input type='text' class='form-control col-sm-8' id='InputReponse$cpt' name='InputReponse$cpt' placeholder='Réponse $cpt' value='$reponseText'></input> \n";
                
                if($reponseValue){
                    $ret .= "\t<label class='col-sm-4' ><input type='radio' name='radioReponse' value='$cpt' checked> Bonne Réponse </label> \n";
                }
                else{
                    $ret .= "\t<label class='col-sm-4' ><input type='radio' name='radioReponse' value='$cpt'> Bonne Réponse </label> \n";
                }

                $ret .= "</div> \n";

                $cpt++;

            }
        }

        return $ret;



    }



}

?>