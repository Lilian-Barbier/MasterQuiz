<?php

require_once "Models/ConnectionBDD.php";

/**
 * Gestion de l'authentification et de l'inscription de l'utilisateur.container
 * Gére les variables de session.
 */

class Authentification{


    /**
     * Fonction qui vérifie le formulaire de connexion.
     */
    function LoginVerification()
    {

        //Verification des champs du formulaire :
        if(empty($_POST['inputPseudo']))
        {
            return $this->HandleError("Nom d'utilisateur vide!");
        }
        
        if(empty($_POST['inputPassword']))
        {
            return $this->HandleError("Mot de passe vide!");
        }
        
        
        $pseudo = strtolower(trim($_POST['inputPseudo']));
        $password = trim($_POST['inputPassword']);
        

        //On démarre une session web si elle n'existe pas.
        if(!isset($_SESSION)){ 
            session_start(); 
        }

        //On vérifie que les identifiants sont sauvegarder dans la Base de données
        if(!$this->CheckIdentifiantBDD($pseudo,$password))
        {
            return $this->HandleError("Erreur de connexion. Veuillez Vérifier votre identifiant ou votre mot de passe !");
        }
        
        return NULL;
    }

    /**
     * Dans le cas d'une erreur la met en forme.
     */
    function HandleError($err)
    {
        return($err."\r\n");
    }

    /**
     * Vérifie les identifiants dans la Base de données.
     */
    function CheckIdentifiantBDD($pseudo,$password)
    {
        //On récupere la connection à la base de données
        $link = GetConnection();
        if($link == NULL)
        {
            return false;
        }          

        $query = "SELECT * FROM user WHERE Nom='$pseudo'";
        //ajouter "and confirmcode='y'" si l'on souhaite une vérification du compte par email

        $result = $link->query($query);

        if(!$result || mysqli_num_rows($result) <= 0)
        {
            return false;
        }

        $row = $result->fetch_assoc();
                
        //On vérifie si le mot de passe est valide.
        if(!password_verify($password, $row['Mdp'])){
            return false;
        }
        
        //On complete les variables de session
        $_SESSION['nom']  = $row['Nom'];
        $_SESSION['id']  = $row['UserID'];
        $_SESSION['email'] = $row['Email'];

        return true;
    }

    function Inscription()
    {

        //Verification des champs du formulaire :
        if(empty($_POST['inputPseudo']))
        {
            return $this->HandleError("Veuillez entrer un nom d'utilisateur!");
        }
        
        if(empty($_POST['inputEmail']))
        {
            return $this->HandleError("Veuillez entrer une addresse mail!");
        }

        if(empty($_POST['inputPassword']))
        {
            return $this->HandleError("Veuillez entrer un mot de passe!");
        }
        
        if(empty($_POST['inputPasswordConfirm']))
        {
            return $this->HandleError("Veuillez valider votre mot de passe!");
        }
                
        if($_POST['inputPassword'] != $_POST['inputPasswordConfirm'])
        {
            return $this->HandleError("Les deux mots de passe sont différents !");
        }
        
        $email = strtolower(trim($_POST['inputEmail']));
        $pseudo = strtolower(trim($_POST['inputPseudo']));
        $password = $_POST['inputPassword'];
        
        if( $this->CheckUsernameAlreadyUsedBDD($pseudo) )
        {
            return $this->HandleError("Nom d'utilisateur déja pris !");
        }

        if( $this->CheckEmailAlreadyUsedBDD($email) )
        {
            return $this->HandleError("Mail déja utilisé !");
        }

        //On essaie de créer l'utilisateur dans la bases de données.
        if( !$this->CreateUser($email, $pseudo, $password) )
        {
            return $this->HandleError("Erreur veuillez réésayer !");
        }
        
        return $this->HandleError("L'utilisateur a été créé !");
        //return NULL;
    }


    /**
     * Vérifie si le nom de l'utilisateur est déja utilisé.
     */
    function CheckUsernameAlreadyUsedBDD($pseudo)
    {
        //On récupere la connection à la base de données
        $link = GetConnection();
        if($link == NULL)
        {
            //Exception
            return NULL;
        }          

        $query = "SELECT * FROM user WHERE Nom='$pseudo'";

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
     * Vérifie si le mail de l'utilisateur est déja utilisé.
     */
    function CheckEmailAlreadyUsedBDD($email)
    {
        //On récupere la connection à la base de données
        $link = GetConnection();
        if($link == NULL)
        {
            //Exception
            return NULL;
        }          

        $query = "SELECT * FROM user WHERE Email='$email'";

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
     * Créé un nouveau utilisateur dans la Base de données.
     */
    function CreateUser($email, $pseudo, $password)
    {
        //On récupere la connection à la base de données.
        $link = GetConnection();
        if($link == NULL)
        {
            return false;
        }        

        //On échape les caractére spéciaux.
        $email = $link->real_escape_string($email);
        $pseudo = $link->real_escape_string($pseudo);

        //On crypte le mot de passe.
        $passwordCrypt = crypt($password);

        //On prépare la requéte.
        $query = "INSERT INTO user (Nom, Mdp, Email, Administrateur) VALUES ('$pseudo', '$passwordCrypt', '$email', 0)";

        //On execute le requéte.
        if(!$link->query($query))
        {
            $link->close();
            return false;
        }
        
        $link->close();
        return true;
    }

}

?>