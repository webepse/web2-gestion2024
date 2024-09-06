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
                $categorie = htmlspecialchars($_POST['categorie']);
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
            // savoir si j'ai une image à modifier ou non
            if($_FILES['fichier']['error']==0)
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
                        //modification dans la bdd
                        // require_once "../connexion.php";
                        // supprimer fichiers image 
                        unlink("../images/".$don['fichier']);
                        unlink("../images/mini_".$don['fichier']);
                        $update = $bdd->prepare("UPDATE products SET nom=:nom,categorie=:categorie,fichier=:fichier,description=:description,date=:date,prix=:prix WHERE id=:id");
                        $update->execute([
                            ":nom" => $nom,
                            ":categorie" => $categorie,
                            ":fichier" => $fichiercptl,
                            ":description"=> $description,
                            ":date" => $date,
                            ":prix" => $prix,
                            ":id"=>$id
                        ]);
                        $update->closeCursor();
                        // header("LOCATION:products.php?add=success");
                        if($extension == ".png")
                        {
                            header("LOCATION:redimpng.php?update=".$id."&image=".$fichiercptl);
                        }else{
                            header("LOCATION:redim.php?update=".$id."&image=".$fichiercptl);
                        }
                    }else{
                        header("LOCATION:updateProduct.php?id=".$id."&errorimg=3");
                    }
    
    
                }
                else{
                    header("LOCATION:updateProduct.php?id=".$id."&errorimg=".$error);
                }
            }else{
                $update = $bdd->prepare("UPDATE products SET nom=:nom,categorie=:categorie,description=:description,date=:date,prix=:prix WHERE id=:id");
                $update->execute([
                    ":nom" => $nom,
                    ":categorie" => $categorie,
                    ":description"=> $description,
                    ":date" => $date,
                    ":prix" => $prix,
                    ":id"=>$id
                ]);
                $update->closeCursor();
                header("LOCATION:products.php?updatesuccess=".$id);
            }

              
           

        }else{
            header("LOCATION:updateProduct.php?id=".$id."&error=".$err);
        }


    }else{
        header("LOCATION:updateProduct.php?id=".$id);
    }
?>

