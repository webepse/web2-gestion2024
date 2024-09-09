<?php
    session_start();

    // vérifier si déjà connecté
    if(isset($_SESSION['login']))
    {
        header("LOCATION:dashboard.php");
    }

    // vérifier si formulaire envoyé ou non
    if(isset($_POST['login']) && isset($_POST['password']))
    {
        // vérifier si formulaire n'est pas vide
        if(empty($_POST['login']) || empty($_POST['password']))
        {
            $erreur = "Veuillez remplir correctement le formulaire";
        }else{
            // traitement des valeurs
            $login = htmlspecialchars($_POST['login']);
            require "../connexion.php";
            $req = $bdd->prepare("SELECT login,password FROM admin WHERE login=?");
            $req->execute([$login]);
            if($don = $req->fetch())
            {
                if(password_verify($_POST['password'],$don['password']))
                {
                    $_SESSION['login'] = $don['login'];
                    header("LOCATION:dashboard.php");
                }else{
                    $erreur = "Votre mot de passe ne correspond pas";
                }
            }else{
                $erreur = "Votre login n'existe pas";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Administration</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-4 offset-4">
                <h1>Admin</h1>
                <form action="index.php" method="POST">
                    <?php
                        if(isset($erreur))
                        {
                            echo "<div class='alert alert-danger'>".$erreur."</div>";
                        }
                    ?>
                    <div class="form-group my-3">
                        <label for="login">Login: </label>
                        <input type="text" name="login" id="login" class="form-control">
                    </div>
                    <div class="form-group my-3">
                        <label for="password">Mot de passe</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <div class="form-group my-3">
                        <input type="submit" value="Connexion" class="btn btn-success">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>