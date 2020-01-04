<?php 
class Admin{
    function display($tableQuiz, $previousPageLink, $page, $nextPageLink) {
   
?>

<!DOCTYPE html>
<html lang="fr"  class="h-100">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Importation de Bootstrap : https://getbootstrap.com/docs/4.4/getting-started/introduction/ -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    
        <link rel="stylesheet" href="Views/CSS/index.css">
        <title>MasterQuiz - Accueil</title>
    </head>

    <body class="d-flex flex-column h-100">

        <header>
            <!-- Création de la barre de navigation dépendant de l'utilisateur (non-connecté, joueur, modérateur, administrateur) -->
            <nav class="navbar fixed-top navbar-expand-lg navbar-dark">

                <a class="navbar-brand" href="Home_Controller.php">MasterQuiz</a>

                <!-- Définitions d'un bouton de navigation lorsque l'écran est trop petit pour afficher toute la barre nav -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navBarAgora" aria-controls="navBarAgora" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <!-- L'affichage normal de la barre de navigation -->
                <div class="collapse navbar-collapse" id="navBarAgora">

                    <!-- Partie collé à gauche de la barre nav -->
                    <ul class="navbar-nav mr-auto">


                    </ul>

                    <!-- Partie collée à droite de la barre nav -->
                    <ul class="nav navbar-nav navbar-right">


                        <li class="nav-item">
                            <a href="" class="nav-link"> <?php echo($_SESSION['nom']) ?> </a>
                        </li>

                        <li class="nav-item">
                            <a href="Deconnexion_Controller.php" class="nav-link"> Deconnexion </a>
                        </li>


                    </ul>
                </div>
            </nav>

        </header>

        <!-- Début du contenus de la page -->
        <main role="main" class="flex-shrink-0">
            <div class="container">
                   
                <h1 class="h3 mb-3 font-weight-normal">Administration des Quiz</h1>

                <form action="" method="get" class="form-search">

                    <div class="form-group">
                        <input type="text" id="inputSearch" name="pattern" class="form-control" placeholder="Nom du Quiz" autofocus>
                    </div>
                
                    <input type="submit" class="btn btn-success" value="Rechercher">

                    <a type="button" class="btn btn-primary" href="Admin_Controller.php"> Enlever les filtres </a>
                </form>
                
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nom</th>
                            <th scope="col">Theme</th>
                            <th scope="col">Description</th>
                            <th scope="col">Créateur</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                            echo($tableQuiz);
                        ?>

                    </tbody>
                </table>

                <?php echo($previousPageLink); ?>
                
                <a> <?php echo($page) ?> </a>

                <?php echo($nextPageLink); ?>
                    
            </div>
        </main>

<?php require_once "Views/footer.html"?>



<?php 
    }
}
?>