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
    $req = $bdd->prepare("SELECT * FROM categories WHERE id=?");
    $req->execute([$id]);
    if(!$don = $req->fetch())
    {
        $req->closeCursor();
        header("LOCATION:index.php");
    }
    $req->closeCursor();


    if(isset($_POST['title']))
    {
        $err = 0;
        if(empty($_POST['title']))
        {
            $err=1;
        }else{
            $title = htmlspecialchars($_POST['title']);
        }

        if($err == 0)
        {
            require "../connexion.php";
            $update = $bdd->prepare("UPDATE categories SET title=:title WHERE id=:myid ");
            $update->execute([
                ":title"=> $title,
                ":myid" => $id
            ]);
            $update->closeCursor();
            header("LOCATION:categories.php?updatesuccess=".$id);
        }else{
            header("LOCATION:updateCategory.php?id=".$id."&error=".$err);
        }
    }else{
        header("LOCATION:index.php");
    }