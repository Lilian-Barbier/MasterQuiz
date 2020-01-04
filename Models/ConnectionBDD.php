
<?php

    function GetConnection()
    {
        // Connexion et sélection de la base
        $link = new mysqli('127.0.0.1', 'admin_masterquiz', 'Quiz:1234', "masterquiz");
        
        /* Vérifie la connexion */
        if (mysqli_connect_errno()) {
            printf("Échec de la connexion : %s\n", mysqli_connect_error());
            return NULL;
        }

        return $link;
        
    }
    
?>
    