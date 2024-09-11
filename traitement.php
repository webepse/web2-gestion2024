<?php
   if(isset($_POST['nom']))
   {
    $err = 0;
    if(empty($_POST['nom']))
    {
        $err=1;
    }else{
        $nom = htmlspecialchars($_POST['nom']);
    }

    if(empty($_POST['email']))
    {
        $err = 2;
    }else{
        if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,6}$#", $_POST['email']))
        {
           $email = $_POST['email'];
        }else{
            $err = 3;
        }
    }

    if($err == 0)
    {

    }else{
        header("LOCATION:index.php?action=contact&err=".$err);
    }



   }else{
    header("LOCATION:404.php");
   }

?>