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
    $req = $bdd->prepare("SELECT * FROM products WHERE id=?");
    $req->execute([$id]);
    if(!$don = $req->fetch())
    {
        $req->closeCursor();
        header("LOCATION:index.php");
    }
    $req->closeCursor();

    if(isset($_FILES['fichier']))
    {
        if($_FILES['fichier']['error'] == 0)
        {
             // ok - traitement du ou des fichier(s)
             $dossier = "../images/"; // ../images/monfichier.jpg
             $fichier = basename($_FILES['fichier']['name']);
             $taille_maxi = 2000000;
             $taille = filesize($_FILES['fichier']['tmp_name']);
             $extensions = ['.png','.jpg','.jpeg'];
             $extension = strrchr($_FILES['fichier']['name'],'.');
           
             if(!in_array($extension, $extensions))
               {
                   $error = 1;
               }
               
               if($taille>$taille_maxi){
                   $error = 2;
               }
               if(!isset($error))
               {
                   $fichier = strtr($fichier, 
                   'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
                   'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                   $fichier = preg_replace('/([^.a-z0-9]+)/i','-',$fichier); 
                   $fichiercptl = rand().$fichier; 
   
   
                   // c:/wamp64/tmp/FILE1236.tmp , "../images/1565156carole.jpg"
                   if(move_uploaded_file($_FILES['fichier']['tmp_name'],$dossier.$fichiercptl))
                   {
                       //insertion dans la bdd
                       $insert = $bdd->prepare("INSERT INTO images(fichier,id_produit) VALUES(:fichier,:id)");
                       $insert->execute([
                           ":fichier" => $fichiercptl,
                           ":id" => $id
                       ]);
                       $insert->closeCursor();
                       header("LOCATION:updateProduct.php?id=".$id."&addsuccess=ok");
                   }else{
                       header("LOCATION:addImg.php?id=".$id."&errorimg=3");
                   }
   
   
               }
               else{
                   header("LOCATION:addImg.php?id=".$id."&errorimg=".$error);
               }


        }else{
            header("LOCATION:addImg.php?id=".$id."&error=1");
        }
    }else{
        header("LOCATION:index.php");
    }