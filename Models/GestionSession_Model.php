<?php

/**
 * Gére les variables de session.
 */

class GestionSession{

    /**
     * Vérifie qu'un utilisateur est connecté.
     */
    function CheckLogin()
    {
        if( !isset($_SESSION) ){ 
            session_start(); 
        }

        if( empty($_SESSION['nom']) || is_null($_SESSION['nom']))
        {
            return false;
        }

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


}

?>