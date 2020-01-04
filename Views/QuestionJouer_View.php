<?php 
class Question{
    function display($numero, $question, $reponse, $userConnected) {

        require_once "header.php";
        Header::displayHeader($userConnected); 
?>

        <!-- Début du contenus de la page -->
        <main role="main" class="flex-shrink-0">
            <div class="container">

                <h1> Question n°<?php echo($numero)?></h1>

                <h2 class="question"> <?php echo($question) ?></h2>

                <?php echo($reponse) ?>
            
            </div>
        </main>

        <?php require_once "Views/footer.html"?>
    
    <?php 
    }
}
?>