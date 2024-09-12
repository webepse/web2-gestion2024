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
        $delete = $bdd->prepare("DELETE FROM contact WHERE id=?");
        $delete->execute([$id]);
        $delete->closeCursor();
        header("LOCATION:contacts.php?deletesuccess=".$id);
       
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Administration - Les contacts</title>
</head>
<body>
    <?php
        include("partials/header.php");       
    ?>
    <div class="container-fluid">
        <h2>Administration des contacts</h2>
        <?php
          
            if(isset($_GET['deletesuccess']))
            {
                echo "<div class='alert alert-danger'>Vous avez bien supprimé le message id ".$_GET['deletesuccess']."</div>"; 
            }
           
        ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nom</th>
                    <th>E-mail</th>
                    <th>Sujet</th>
                    <th>date</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                  
                    $req = $bdd->query("SELECT id, nom, email, sujet, DATE_FORMAT(date, '%d/%m/%Y %Hh%i') AS mydate FROM contact ORDER BY date DESC");
                    while($don = $req->fetch())
                    {
                        echo "<tr>";
                            echo "<td>".$don['id']."</td>";
                            echo "<td>".$don['nom']."</td>";
                            echo "<td>".$don['email']."</td>";
                            echo "<td>".$don['sujet']."</td>";
                            echo "<td>".$don['mydate']."</td>";
                            echo "<td class='text-center'>";
                                echo "<a href='viewContact.php?id=".$don['id']."' class='btn btn-primary mx-2'>Afficher</a>";
                                echo "<a href='contacts.php?delete=".$don['id']."' class='btn btn-danger mx-2'>Supprimer</a>";
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