<?php 
class Home{
    function displayHome($tableQuiz, $previousPageLink, $page, $nextPageLink, $userConnected) {

        require_once "header.php";
        Header::displayHeader($userConnected); ?>

        <!-- Début du contenus de la page -->
        <main role="main" class="flex-shrink-0">
            <div class="container">
                <h2>Dernier Quiz : </h2>

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