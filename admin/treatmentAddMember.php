<?php
    session_start();
    if(!isset($_SESSION['login']))
    {
        header("LOCATION:index.php");
    }

    if(isset($_POST['login']))
    {
        require "../connexion.php";
        $err = 0;
        if(empty($_POST['login']))
        {
            $err=1;
        }else{
            $login = htmlspecialchars($_POST['login']);
            $verif = $bdd->prepare("SELECT * FROM admin WHERE login=?");
            $verif->execute([$login]);
            if($don = $verif->fetch())
            {
                $err=2;
            }
            $verif->closeCursor();
        }

        if(empty($_POST['password']))
        {
            $err=3;
        }else{
            $password = $_POST['password'];
            if($password != $_POST['cpassword'])
            {
                $err=4;
            }else{
                $hash = password_hash($password,PASSWORD_DEFAULT);
            }
        }

 

        if($err == 0)
        {
       
            $insert = $bdd->prepare("INSERT INTO admin(login,password) VALUES(?,?)");
            $insert->execute([$login,$hash]);
            $insert->closeCursor();
            header("LOCATION:members.php?add=success");
        }else{
            header("LOCATION:addMember.php?error=".$err);
        }
    }else{
        header("LOCATION:index.php");
    }