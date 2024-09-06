<?php
    session_start();
    if(!isset($_SESSION['login']))
    {
        header("LOCATION:index.php");
    }

    if(isset($_GET['id']))
    {
        $id = htmlspecialchars($_GET['id']);
    }else{
        header("LOCATION:index.php");
    }

    require "../connexion.php";
    $req = $bdd->prepare("SELECT * FROM products WHERE id=?");
    $req->execute([$id]);
    if(!$don = $req->fetch())
    {
        $req->closeCursor();
        header("LOCATION:index.php");
    }
    $req->closeCursor();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Administration - Ajouter une image à un produit</title>
</head>
<body>
    <?php
        include("partials/header.php");       
    ?>
    <div class="container-fluid">
        <h2>Ajouter une image à un produit</h2>
        <form action="treatmentAddImg.php?id=<?= $don['id'] ?>" method="POST" enctype="multipart/form-data">
            <?php
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
                <label for="fichier">Fichier: </label>
                <input type="file" name="fichier" id="fichier" class="form-control">
            </div>
            <div class="form-group my-2">
                <input type="submit" value="Ajouter" class="btn btn-primary">
                <a href="updateProduct.php?id=<?= $id ?>" class="btn btn-secondary mx-2">Retour</a>
            </div>
        </form>
    </div>
</body>
</html>