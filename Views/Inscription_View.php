<?php 
class Inscription{
    function displayForm($error) {
        
        require_once "header.php";
        Header::displayHeader(false); 
        
?>

        <!-- Début du contenus de la page -->
        <main role="main" class="flex-shrink-0">
            <div class="container">
                    
                <h1 class="h3 mb-3 font-weight-normal">Inscription</h1>

                <div>
                    <span class='error'>
                        <?php echo($error); ?>
                    </span>
                </div>

                <form action="Authentification_Controller.php" method="post" class="form-signin">

                    <input type='hidden' name='formulaire' id='formulaire' value='inscription'/>

                    <input type="text" name="inputPseudo" id="inputPseudo" class="form-control" placeholder="Pseudo" required>

                    <input type="email" name="inputEmail" id="inputEmail" class="form-control" placeholder="Adresse Mail" required autofocus>
                    
                    <input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="Mot de Passe" required>

                    <input type="password" name="inputPasswordConfirm" id="inputPasswordConfirm" class="form-control" placeholder="Confirmer le Mot de Passe" required>

                    <input type="submit" class="btn btn-primary" value="S'inscrire">

                </form>


            </div>
        </main>

<?php require_once "Views/footer.html"?>


<?php 
    }
}
?>