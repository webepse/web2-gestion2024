<?php
    session_start();
    if(!isset($_SESSION['login']))
    {
        header("LOCATION:index.php");
    }

    if(isset($_GET['deco']))
    {
        session_destroy();
        header("LOCATION:index.php");
    }

    require "../connexion.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Administration - tableau de bord</title>
</head>
<body>
    <div class="container-fluid">
        <?php 
            include("partials/header.php");
        ?>
        <h1>Tableau de bord</h1>
        <div class="row d-flex justify-content-between">
            <div class="col-6 bg-primary text-white text-center">
                <h2>Categories</h2>
                <?php
                    $categories = $bdd->query("SELECT * FROM categories");
                    $nbCat = $categories->rowCount();
                    echo "<h3>".$nbCat."</h3>";
                    $categories->closeCursor();
                ?>  
            </div>
            <div class="col-6 bg-warning text-white text-center">
                <h2>Produits</h2>
                <?php
                    $products = $bdd->query("SELECT * FROM products");
                    $nbProd = $products->rowCount();
                    echo "<h3>".$nbProd."</h3>";
                    $products->closeCursor();
                ?>  
            </div>
            <div class="col-6 bg-secondary text-white text-center">
                <h2>Messages</h2>
                <?php
                    $messages = $bdd->query("SELECT * FROM contact");
                    $nbMess = $messages->rowCount();
                    echo "<h3>".$nbMess."</h3>";
                    $messages->closeCursor();
                ?>  
            </div>
        </div>
    </div>
</body>
</html>