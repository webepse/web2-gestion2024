<?php
    session_start();
    if(!isset($_SESSION['login']))
    {
        header("LOCATION:index.php");
    }

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
            $insert = $bdd->prepare("INSERT INTO categories(title) VALUES(?)");
            $insert->execute([$title]);
            $insert->closeCursor();
            header("LOCATION:categories.php?add=success");
        }else{
            header("LOCATION:addCategory.php?error=".$err);
        }
    }else{
        header("LOCATION:index.php");
    }