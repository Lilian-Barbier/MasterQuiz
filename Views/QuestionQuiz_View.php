<?php 
class QuestionQuiz{
    function displayForm($question, $menu, $error, $numQuestion, $form, $nbReponses) {

        require_once "header.php";
        Header::displayHeader(true); 


?>

        <?php //todo le déplacer? ?>
        <script src="Views/JS/CreateQuiz.js"></script>

        <!-- Début du contenus de la page -->
        <main role="main" class="flex-shrink-0">
            <div class="container">

                <ul class="nav flex-column menu">
                    <?php echo($menu) ?>
                </ul>

                <div class="container contenus">
                    <form action="EnregistreQuestion_Controller.php" method="post" id="QuizForm">

                        <div id="questions">
                            <div id="question">
                        
                                <div class="form-group">
                                    <label for="InputQuestion1">Question numéro <?php echo($numQuestion); ?> :</label>
                                    <input type="text" class="form-control" id="InputQuestion" name="InputQuestion" placeholder="Question" value=<?php echo("'$question'"); ?>>
                                </div>

                                <input type='hidden' name='nbReponse' id='nbReponse' value=<?php echo($nbReponses); ?> />
                                <input type='hidden' name='numQuestion' id='numQuestion' value=<?php echo($numQuestion); ?> />

                                <div class="form-group" id="reponses">
                                    <label>Réponses :</label>
                                    
                                    <?php echo($form) ?>
                                    
                                </div>

                                <a class="btn btn-primary btn-md btn-block" role="button" id="AddReponse">Ajout Reponse</a>

                            </div>
                        </div>

                        <button type="submit" class="btn btn-success btn-md btn-block">Enregister la question</button>

                    </form>

                    <a class="btn btn-danger btn-md btn-block" role="button" href="SuppressionQuestion_Controller.php?question=<?php echo($numQuestion) ?>">Supprimer la question</a>


                </div>
                
            </div>
        </main>

        <?php require_once "Views/footer.html"?>
    
    <?php 
    }
}
?>