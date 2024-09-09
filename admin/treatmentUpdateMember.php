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
    $req = $bdd->prepare("SELECT * FROM admin WHERE id=?");
    $req->execute([$id]);
    if(!$don = $req->fetch())
    {
        $req->closeCursor();
        header("LOCATION:index.php");
    }
    $req->closeCursor();


    if(isset($_POST['login']))
    {
        $err = 0;
        if(empty($_POST['login']))
        {
            $err=1;
        }else{
            $login = htmlspecialchars($_POST['login']);
            if($login != $don['login'])
            {
                $verif = $bdd->prepare("SELECT * FROM admin WHERE login=?");
                $verif->execute([$login]);
                if($don = $verif->fetch())
                {
                    $err=2;
                }
                $verif->closeCursor();
            }
        }

        if($err == 0)
        {
            if(empty($_POST['password']))
            {
                $update = $bdd->prepare("UPDATE admin SET login=:login WHERE id=:myid");
                $update->execute([
                    ":login" => $login,
                    ":myid" => $id
                ]);    
                header("LOCATION:members.php?updatesuccess=".$id);
                
            }else{
                $password = $_POST['password'];
                if($password != $_POST['cpassword'])
                {
                    header("LOCATION:updateMember.php?id=".$id."&error=4");
                }else{
                    $hash = password_hash($password,PASSWORD_DEFAULT);
                    $update = $bdd->prepare("UPDATE admin SET login=:login, password=:pass WHERE id=:myid");
                    $update->execute([
                        ":login" => $login,
                        ":pass" => $hash,
                        ":myid" => $id
                    ]);    
                    header("LOCATION:members.php?updatesuccess=".$id);
                }
            }
        }else{
            header("LOCATION:updateMember.php?id=".$id."&error=".$err);
        }

        


    }else{
        header("LOCATION:index.php");
    }