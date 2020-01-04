<?php 
class MesQuiz{
    function displayForm($tableQuiz, $previousPageLink, $page, $nextPageLink, $userConnected) {

        require_once "header.php";
        Header::displayHeader($userConnected); 
        
?>

        <!-- Début du contenus de la page -->
        <main role="main" class="flex-shrink-0">
            <div class="container">
                   
                <h1 class="h3 mb-3 font-weight-normal">Mes Quiz</h1>

                <form action="" method="get" class="form-search">

                    <div class="form-group">
                        <input type="text" id="inputSearch" name="pattern" class="form-control" placeholder="Nom du Quiz" autofocus>
                    </div>
                
                    <input type="submit" class="btn btn-primary" value="Rechercher">
                    
                </form>
                
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nom</th>
                            <th scope="col">Theme</th>
                            <th scope="col">Description</th>
                            <th scope="col">Date</th>
                            <th scope="col">Status</th>
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