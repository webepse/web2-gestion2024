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


    if(isset($_GET['delete']))
    {
        $idV = htmlspecialchars($_GET['delete']);
        $verif = $bdd->prepare("SELECT * FROM images WHERE id=?");
        $verif->execute([$idV]);
        if(!$donV = $verif->fetch())
        {
            $verif->closeCursor();
            header("LOCATION:index.php");
        }
        $verif->closeCursor();

        unlink("../images/".$donV['fichier']);
        unlink("../images/mini_".$donV['fichier']);

        $reqDel = $bdd->prepare("DELETE FROM images WHERE id=?");
        $reqDel->execute([$idV]);
        $reqDel->closeCursor();
        header("LOCATION:updateProduct.php?id=".$id."&deletesuccess=".$idV."#galerie");
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Administration - Modifier un produit</title>
</head>
<body>
    <?php
        include("partials/header.php");       
    ?>
    <div class="container-fluid">
        <h2>Modifier un produit</h2>
        <a href="products.php" class="btn btn-secondary my-3">Retour</a>
        <form action="treatmentUpdateProduct.php?id=<?= $don['id'] ?>" method="POST" enctype="multipart/form-data">
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
            <input type="hidden" name="id" value="<?= $id ?>">
            <div class="form-group my-2">
                <label for="nom">Nom: </label>
                <input type="text" name="nom" id="nom" class="form-control" value="<?= $don['nom'] ?>">
            </div>
            <div class="form-group my-2">
                <label for="categorie">Catégorie: </label>
                <select name="categorie" id="categorie" class="form-control">
                    <?php
                        $categories = ['Cat1','Cat2','Cat3'];
                        foreach($categories as $key => $value)
                        {
                            if($value == $don['categorie'])
                            {
                                echo "<option value='".$value."' selected>Catégorie ".($key+1)."</option>";
                            }else{
                                echo "<option value='".$value."'>Catégorie ".($key+1)."</option>";
                            }
                        }
                    ?>

                </select>
            </div>
            <div class="form-group my-2">
                <div class="col-4">
                    <img src="../images/<?= $don['fichier'] ?>" alt="image" class="img-fluid">
                </div>
                <label for="fichier">Fichier: </label>
                <input type="file" name="fichier" id="fichier" class="form-control">
            </div>
            <div class="form-group my-2">
                <label for="description">Description: </label>
                <textarea name="description" id="description" class="form-control"><?= $don['description'] ?></textarea>
            </div>
            <div class="form-group my-2">
                <label for="date">Date: </label>
                <input type="date" name="date" id="date" class="form-control" value="<?= $don['date'] ?>">
            </div>
            <div class="form-group my-2">
                <label for="prix">Prix: </label>
                <input type="number" step="0.1" name="prix" id="prix" class="form-control" value="<?= $don['prix'] ?>">
            </div>
            <div class="form-group my-2">
                <input type="submit" value="Modifier" class="btn btn-warning">
                <a href="products.php" class="btn btn-secondary mx-2">Retour</a>
            </div>
        </form>
        <div class="row" id="galerie">
            <h2>Gestion des images</h2>
            <?php
                if(isset($_GET['addsuccess']))
                {
                    echo "<div class='alert alert-success'>Vous avez bien ajouté une image au produit</div>";
                }
                if(isset($_GET['deletesuccess']))
                {
                    echo "<div class='alert alert-danger'>Vous avez bien supprimer l'image id ".$_GET['deletesuccess']."</div>";
                }
            ?>
            <a href="addImg.php?id=<?= $id ?>" class='btn btn-success'>Ajouter une image</a>
            <table class="table table-striped">
                <tr>
                    <th>id</th>
                    <th>image</th>
                    <th>action</th>
                </tr>
                <?php
                    $images = $bdd->prepare("SELECT * FROM images WHERE id_produit=?");
                    $images->execute([$id]);
                    while($donI = $images->fetch())
                    {
                        echo "<tr>";
                            echo "<td>".$donI['id']."</td>";
                            echo "<td><div class='col-2'><img src='../images/".$donI['fichier']."' alt='img' class='img-fluid'></div></td>";
                            echo "<td><a href='updateProduct.php?id=".$id."&delete=".$donI['id']."' class='btn btn-danger'>Supprimer</a></td>";
                        echo "</tr>";
                    }
                    $images->closeCursor();
                ?>
            </table>


        </div> 
    </div>
</body>
</html>