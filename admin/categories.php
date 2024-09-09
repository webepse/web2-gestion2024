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
        $verif = $bdd->prepare("SELECT * FROM products WHERE categorie=?");
        $verif->execute([$id]);
        while($donV = $verif->fetch())
        {
            unlink("../images/".$donV['fichier']);
            unlink("../images/mini_".$donV['fichier']);
            $myId = $donV['id'];
            $images = $bdd->prepare("SELECT * FROM images WHERE id_produit=?");
            $images->execute([$myId]);
            while($donI = $images->fetch())
            {
                unlink("../images/".$donI['fichier']);
                unlink("../images/mini_".$donI['fichier']);
            }
            $images->closeCursor();

            $deleteImg = $bdd->prepare("DELETE FROM images WHERE id_produit=?");
            $deleteImg->execute([$myId]);
            $deleteImg->closeCursor();

            $delete = $bdd->prepare("DELETE FROM products WHERE id=?");
            $delete->execute([$myId]);
            $delete->closeCursor();
        }
        $verif->closeCursor();

        $deleteC = $bdd->prepare("DELETE FROM categories WHERE id=?");
        $deleteC->execute([$id]);
        $deleteC->closeCursor();
        header("LOCATION:categories.php?deletesuccess=".$id);
        
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Administration - Les catégories</title>
</head>
<body>
    <?php
        include("partials/header.php");       
    ?>
    <div class="container-fluid">
        <h2>Administration des catégories</h2>
        <?php
            if(isset($_GET['add']))
            {
                echo "<div class='alert alert-success'>Vous avez bien ajouté une catégorie dans la base de données</div>";
            }
            if(isset($_GET['updatesuccess']))
            {
                echo "<div class='alert alert-warning'>Vous avez bien modifié la catégorie id ".$_GET['updatesuccess']."</div>"; 
            }
            if(isset($_GET['deletesuccess']))
            {
                echo "<div class='alert alert-danger'>Vous avez bien supprimé la catégorie id ".$_GET['deletesuccess']."</div>"; 
            }
        ?>
        <a href="addCategory.php" class="btn btn-success my-3">Ajouter une catégorie</a>
        <table class="table table-striped">
            <tr>
                <th>Id</th>
                <th>Nom</th>
                <th class="text-center">Action</th>
            </tr>
            <tr>
                <?php
                  
                    $req = $bdd->query("SELECT * FROM categories");
                    while($don = $req->fetch())
                    {
                        echo "<tr>";
                            echo "<td>".$don['id']."</td>";
                            echo "<td>".$don['title']."</td>";
                            echo "<td class='text-center'>";
                                echo "<a href='updateCategory.php?id=".$don['id']."' class='btn btn-warning mx-2'>Modifier</a>";
                                echo "<a href='categories.php?delete=".$don['id']."' class='btn btn-danger mx-2'>Supprimer</a>";
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