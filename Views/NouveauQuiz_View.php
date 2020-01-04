<?php 
class NouveauQuiz{
    function displayForm($error) {

        require_once "header.php";
        Header::displayHeader(true); 
?>

        <!-- Début du contenus de la page -->
        <main role="main" class="flex-shrink-0">
            <div class="container">

                <h2>Nouveau Quiz</h2>

                <div>
                    <span class='error'>
                        <?php echo($error); ?>
                    </span>
                </div>

                <form action="CreateQuiz_Controller.php" method="post" id="QuizForm">

                    <input type='hidden' name='formulaire' id='formulaire' value='Creation'/>

                    <div class="form-group">
                        <label for="InputNomQuiz">Nom du Quiz</label>
                        <input type="text" class="form-control" id="InputNomQuiz" name="InputNomQuiz" placeholder="Entrez le nom du quiz">
                    </div>

                    <div class="form-group">
                        <label for="SelectTheme">Thème du Quiz</label>
                        <select class="form-control" id="SelectTheme" name="SelectTheme">
                            <option value="cinema">cinema</option>
                            <option value="sciences">sciences</option>
                            <option value="jeu-vidéo">jeu-vidéo</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="TextAreaDescription">Description du Quiz :</label>
                        <textarea class="form-control" id="TextAreaDescription" name="TextAreaDescription" rows="3"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Suivant</button>

                </form>
                
            </div>
        </main>

        <?php require_once "Views/footer.html"?>
    
    <?php 
    }
}
?>