<?php
    session_start();
    if(!isset($_SESSION['login']))
    {
        header("LOCATION:index.php");
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Administration - Ajouter un produit</title>
</head>
<body>
    <?php
        include("partials/header.php");       
    ?>
    <div class="container-fluid">
        <h2>Ajouter un produit</h2>
        <a href="products.php" class="btn btn-secondary my-3">Retour</a>
        <form action="treatmentAddProduct.php" method="POST" enctype="multipart/form-data">
            <?php
                if(isset($_GET['error']))
                {
                    echo "<div class='alert alert-danger'>Une erreur est survenue (code erreur: ".$_GET['error'].")</div>";
                }
                if(isset($_GET['errorimg']))
                {
                    switch($_GET['errorimg'])
                    {
                        case 1:
                            echo "<div class='alert alert-danger'>L'extension du fichier n'est pas valide</div>";
                            break;
                        case 2:
                            echo "<div class='alert alert-danger'>Le fichier est trop lourd</div>";
                            break;
                        case 3:
                            echo "<div class='alert alert-danger'>Une erreur est survenue</div>";
                            break;
                        default:
                            echo "<div class='alert alert-danger'>Une erreur est survenue</div>";
                    }
                }

            ?>
            <div class="form-group my-2">
                <label for="nom">Nom: </label>
                <input type="text" name="nom" id="nom" class="form-control">
            </div>
            <div class="form-group my-2">
                <label for="categorie">Catégorie: </label>
                <select name="categorie" id="categorie" class="form-control">
                    <option value="Cat1">Catégorie 1</option>
                    <option value="Cat2">Catégorie 2</option>
                    <option value="Cat3">Catégorie 3</option>
                </select>
            </div>
            <div class="form-group my-2">
                <label for="fichier">Fichier: </label>
                <input type="file" name="fichier" id="fichier" class="form-control">
            </div>
            <div class="form-group my-2">
                <label for="description">Description: </label>
                <textarea name="description" id="description" class="form-control"></textarea>
            </div>
            <div class="form-group my-2">
                <label for="date">Date: </label>
                <input type="date" name="date" id="date" class="form-control">
            </div>
            <div class="form-group my-2">
                <label for="prix">Prix: </label>
                <input type="number" step="0.1" name="prix" id="prix" class="form-control">
            </div>
            <div class="form-group my-2">
                <input type="submit" value="Ajouter" class="btn btn-primary">
            </div>
        </form> 
    </div>
</body>
</html>