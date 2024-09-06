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
        <a href="addProduct.php" class="btn btn-success my-3">Ajouter un produit</a>
        <table class="table table-striped">
            <tr>
                <th>Id</th>
                <th>Nom</th>
                <th>Catégorie</th>
                <th>Prix</th>
                <th class="text-center">Action</th>
            </tr>
            <tr>
                <?php
                    require "../connexion.php";
                    $req = $bdd->query("SELECT * FROM products");
                    while($don = $req->fetch())
                    {
                        echo "<tr>";
                            echo "<td>".$don['id']."</td>";
                            echo "<td>".$don['nom']."</td>";
                            echo "<td>".$don['categorie']."</td>";
                            echo "<td>".$don['prix']."</td>";
                            echo "<td class='text-center'>";
                                echo "<a href='updateProduct.php?id=".$don['id']."' class='btn btn-warning mx-2'>Modifier</a>";
                                echo "<a href='products.php?delete=".$don['id']."' class='btn btn-danger mx-2'>Supprimer</a>";
                            echo "</td>";
                        echo "</tr>";
                    }
                    $req->closeCursor();
                ?>
            </tr>
        </table>
    </div>
</body>
</html>