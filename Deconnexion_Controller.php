<?php

    // On récupere la session.
    session_start();

    // Détruit toutes les variables de session.
    $_SESSION = array();

    // Si vous voulez détruire complètement la session, effacez également
    // le cookie de session.
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    //On détruit la session web.
    session_destroy(); 

    //On redirige l'utilisateur vers la page d'accueil.
    header("Location: Home_Controller.php");
    exit;

?>