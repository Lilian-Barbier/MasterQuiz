<?php 
class Reponse{
    function display($numQuestion, $question, $bonneReponse, $resultat, $userConnected) {

        require_once "header.php";
        Header::displayHeader($userConnected); 
?>

        <!-- Début du contenus de la page -->
        <main role="main" class="flex-shrink-0">
            <div class="container">

            <h1> Reponse - Question n°<?php echo($numQuestion)?></h1>

            <h2 class="question"> <?php echo($question) ?></h2>

            <?php echo($bonneReponse) ?>

            <p> <?php echo($resultat) ?> </p>

            <a type="button" class="btn btn-primary" href="JouerQuiz_Controller.php">Continuer</a>
                
            </div>
        </main>

        <?php require_once "Views/footer.html"?>
    
    <?php 
    }
}
?>
