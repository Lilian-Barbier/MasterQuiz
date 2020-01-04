<?php 
class Finis{
    function display($score, $nbQuestion, $userConnected) {

        require_once "header.php";
        Header::displayHeader($userConnected); 
?>

        <!-- Début du contenus de la page -->
        <main role="main" class="flex-shrink-0">
            <div class="container">


                <h1> Bravo vous avez finis le quiz ! </h1>

                <h2> Résultat : </h2>
                
                <p>
                    <?php echo($score) ?> Bonne.s réponse.s sur <?php echo($nbQuestion) ?> Question.s ! 
                </p>

                <a type="button" class="btn btn-primary" href="Home_Controller.php">Retourner à la liste des quiz</a>
                

            </div>
        </main>

        <?php require_once "Views/footer.html"?>
    
    <?php 
    }
}
?>