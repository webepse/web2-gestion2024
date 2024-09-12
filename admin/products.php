<?php
    session_start();
    if(!isset($_SESSION['login']))
    {
        header("LOCATION:index.php");
    }

    require "../connexion.php";

    if(isset($_GET['delete']))
    {
        $id = htmlspecialchars($_GET['delete']);
        $verif = $bdd->prepare("SELECT * FROM products WHERE id=?");
        $verif->execute([$id]);
        if(!$donV = $verif->fetch())
        {
            $verif->closeCursor();
            header("LOCATION:index.php");
        }
        $verif->closeCursor();

        // je peux supprimer
        unlink("../images/".$donV['fichier']);
        unlink("../images/mini_".$donV['fichier']);

        $images = $bdd->prepare("SELECT * FROM images WHERE id_produit=?");
        $images->execute([$id]);
        while($donI = $images->fetch())
        {
            unlink("../images/".$donI['fichier']);
            unlink("../images/mini_".$donI['fichier']);
        }
        $images->closeCursor();

        $deleteImg = $bdd->prepare("DELETE FROM images WHERE id_produit=?");
        $deleteImg->execute([$id]);
        $deleteImg->closeCursor();

        $delete = $bdd->prepare("DELETE FROM products WHERE id=?");
        $delete->execute([$id]);
        $delete->closeCursor();
        header("LOCATION:products.php?deletesuccess=".$id);
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Administration - Les produits</title>
</head>
<body>
    <?php
        include("partials/header.php");       
    ?>
    <div class="container-fluid">
        <h2>Administration des produits</h2>
        <?php
            if(isset($_GET['add']))
            {
                echo "<div class='alert alert-success'>Vous avez bien ajouté un produit dans la base de données</div>";
            }
            if(isset($_GET['updatesuccess']))
            {
                echo "<div class='alert alert-warning'>Vous avez bien modifié le produit id ".$_GET['updatesuccess']."</div>"; 
            }
            if(isset($_GET['deletesuccess']))
            {
                echo "<div class='alert alert-danger'>Vous avez bien supprimé le produit id ".$_GET['deletesuccess']."</div>"; 
            }
        ?>
        <a href="addProduct.php" class="btn btn-success my-3">Ajouter un produit</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nom</th>
                    <th>Catégorie</th>
                    <th>Prix</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                  
                    $req = $bdd->query("SELECT products.id AS pid, products.nom AS pnom, products.prix AS pprix, categories.title as ctitle FROM products INNER JOIN categories ON categories.id = products.categorie");
                    while($don = $req->fetch())
                    {
                        echo "<tr>";
                            echo "<td>".$don['pid']."</td>";
                            echo "<td>".$don['pnom']."</td>";
                            echo "<td>".$don['ctitle']."</td>";
                            echo "<td>".$don['pprix']."</td>";
                            echo "<td class='text-center'>";
                                echo "<a href='updateProduct.php?id=".$don['pid']."' class='btn btn-warning mx-2'>Modifier</a>";
                                echo "<a href='products.php?delete=".$don['pid']."' class='btn btn-danger mx-2'>Supprimer</a>";
                            echo "</td>";
                        echo "</tr>";
                    }
                    $req->closeCursor();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>