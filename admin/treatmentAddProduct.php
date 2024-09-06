<?php
    session_start();
    if(!isset($_SESSION['login']))
    {
        header("LOCATION:index.php");
    }

    if(isset($_POST['nom']))
    {
        $err = 0;
        if(empty($_POST['nom']))
        {
            $err = 1;
        }else{
            $nom = htmlspecialchars($_POST['nom']);
        }

        if(empty($_POST['categorie']))
        {
            $err = 2;
        }else{
            $categories = ["Cat1","Cat2","Cat3"];
            if(in_array($_POST['categorie'],$categories))
            {
                $categories = htmlspecialchars($_POST['categorie']);
            }else{
                $err = 3;
            }
        }

        if(empty($_POST['description']))
        {
            $err=4;
        }else{
            $description = htmlspecialchars($_POST['description']);
        }

        if(empty($_POST['date']))
        {
            $err = 5;
        }else{
            $date = htmlspecialchars($_POST['date']);
        }

        if(empty($_POST['prix']))
        {
            $err =6;
        }else{
            $prix= htmlspecialchars($_POST['prix']);
        }

        if($err == 0)
        {

        }else{
            header("LOCATION:addProduct.php?error=".$err);
        }


    }else{
        header("LOCATION:addProduct.php");
    }
?>

