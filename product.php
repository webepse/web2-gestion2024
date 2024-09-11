<?php
    if(isset($_GET['id']))
    {
        $id = htmlspecialchars($_GET['id']);
        if(!is_numeric($id))
        {
            header("LOCATION:404.php");
        }
    }else{
        header("LOCATION:404.php");
    }

    require "connexion.php";
    $req = $bdd->prepare("SELECT products.nom as pnom, categories.title as cnom, products.description AS pdescription, products.fichier AS pfichier, DATE_FORMAT(products.date,'%d/%m/%Y') as pdate FROM products INNER JOIN categories ON products.categorie = categories.id WHERE products.id=?");
    $req->execute([$id]);
    if(!$don = $req->fetch())
    {
        $req->closeCursor();
        header("LOCATION:404.php");
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
    <title>Site Gestion 2024 - <?= $don['pnom'] ?></title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1><?= $don['pnom'] ?></h1>
                <a href="products.php" class="btn btn-secondary my-3">Retour</a>
            </div>
            <div class="col-md-6">
                <img src="images/mini_<?= $don['pfichier'] ?>" alt="image de <?= $don['pnom'] ?>">
                
                <h4><?= $don['pdate'] ?></h4>
                <h3><?= $don['cnom'] ?></h3>
            </div>
            <div class="col-md-6">
                <div><?= nl2br($don['pdescription']) ?></div>
            </div>
        </div>

         <div class="row">
            <div class="col-6">
                <div id="carouselExampleIndicators" class="carousel slide">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <?php
                            $images = $bdd->prepare("SELECT * FROM images WHERE id_produit=?");
                            $images->execute([$id]);
                            $active = True;
                            $count = $images->rowCount();
                            if($count>0)
                            {
                                while($donI = $images->fetch())
                                {
                                    if($active == True)
                                    {
                                        echo '<div class="carousel-item active">';
                                            echo "<img src='images/mini_".$donI['fichier']."' alt='image galerie de ".$don['pnom']."' class='d-block w-100'>";
                                        echo "</div>";
                                        $active=False;
                                    }else{
                                        echo '<div class="carousel-item">';
                                        echo "<img src='images/mini_".$donI['fichier']."' alt='image galerie de ".$don['pnom']."' class='d-block w-100'>";
                                    echo "</div>";
                                    }
                                }
                            }else{
                                echo "<div>Ce produit n'a pas encore d'images associées</div>";
                            }

                            $images->closeCursor();
                        ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
         </div>

            
  
    </div>

</body>
</html>