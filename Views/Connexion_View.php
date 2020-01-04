<?php 
class Connexion{
    function displayForm($error) {

        require_once "header.php";
        Header::displayHeader($userConnected); 
        
?>


        <!-- Début du contenus de la page -->
        <main role="main" class="flex-shrink-0">
            <div class="container">
                
                <h1 class="h3 mb-3 font-weight-normal">Connexion</h1>

                <div>
                    <span class='error'>
                        <?php echo($error); ?>
                    </span>
                </div>


                <form action="Authentification_Controller.php" method="post" class="form-signin">

                    <input type='hidden' name='formulaire' id='formulaire' value='connexion'/>

                    <input type="text" id="inputPseudo" name="inputPseudo" class="form-control" placeholder="Pseudo" required autofocus>
                    
                    <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Mot de Passe" required>

                    <input type="submit" class="btn btn-primary" value="Se Connecter">
                    
                </form>


            </div>
        </main>

<?php require_once "Views/footer.html"?>


<?php 
    }
}
?>