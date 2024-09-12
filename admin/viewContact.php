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
    $req = $bdd->prepare("SELECT id,nom,email,sujet,message,DATE_FORMAT(date, '%d/%m/%Y %Hh%i') as mydate FROM contact WHERE id=?");
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
    <title>Administration - Message de : <?= $don['nom'] ?></title>
</head>
<body>
    <?php
        include("partials/header.php");       
    ?>
    <div class="container-fluid">
        <a href="contacts.php" class="btn btn-secondary my-3">Retour</a>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2><?= $don['nom'] ?></h2>
                    <h4><?= $don['email'] ?> <a href="mailto:<?= $don['email'] ?>" class='mx-2 btn btn-success'>Répondre</a></h4>
                    <h3><?= $don['sujet'] ?></h3>
                </div>
                <div class="col-md-6">
                    <h4><?= $don['mydate'] ?></h4>
                    <?= nl2br($don['message']) ?>
                </div>
            </div>
        </div>
        
    </div>
</body>
</html>