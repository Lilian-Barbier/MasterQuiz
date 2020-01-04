<?php 
class RecapQuiz{
    function displayForm($theme, $description, $menu, $error, $public) {

        require_once "header.php";
        Header::displayHeader(true); 
?>

        <!-- Début du contenus de la page -->
        <main role="main" class="flex-shrink-0">
            <div class="container">
                
                <ul class="nav flex-column menu">
                    <?php echo($menu) ?>
                </ul>

                <div class="container contenus">
                    <div class="container-fluid">
                        Theme : 
                        <?php echo($theme) ?>
                    </div>

                    <div class="container-fluid">
                        Description : 
                        <?php echo($description) ?>
                    </div>

                    <?php if($public) { ?>
                        <a class="btn btn-info" href="StatutQuiz_Controller.php" role="button">Rendre Privé</a>
                    <?php } else { ?>
                        <a class="btn btn-info" href="StatutQuiz_Controller.php" role="button">Rendre Publique</a>
                    <?php } ?>

                    <a class="btn btn-danger" href="SuppressionQuiz_Controller.php" role="button">Supprimer le quiz</a>

                </div>
            </div>
        </main>

        <?php require_once "Views/footer.html"?>
    
    <?php 
    }
}
?>