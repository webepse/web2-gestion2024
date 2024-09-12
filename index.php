<?php
    require "connexion.php";
    // router
    $tabMenu = [
        "home" => "home.php",
        "presentation" => "presentation.php",
        "product" => "product.php",
        "products" => "products.php",
        "contact" => "contact.php"
    ];

    // design patern : Router => Model View Controller MVC
    // Router => Controller => Model => Controller => View

    if(isset($_GET['action']))
    {
        $action = htmlspecialchars($_GET['action']);
        if(array_key_exists($action,$tabMenu))
        {
            if($action == "product")
            {
                if(isset($_GET['id']))
                {
                    $id = htmlspecialchars($_GET['id']);
                    if(!is_numeric($id))
                    {
                        header("LOCATION:404.php");
                    }
                }else{
                    header("LOCATION:404.php");
                }
            
                $req = $bdd->prepare("SELECT products.nom as pnom, categories.title as cnom, products.description AS pdescription, products.fichier AS pfichier, DATE_FORMAT(products.date,'%d/%m/%Y') as pdate FROM products INNER JOIN categories ON products.categorie = categories.id WHERE products.id=?");
                $req->execute([$id]);
                if(!$don = $req->fetch())
                {
                    $req->closeCursor();
                    header("LOCATION:404.php");
                }
                $req->closeCursor();
                // View 
                $menu = $tabMenu['product'];
            }elseif($action == "products")
            {
                // controller
                // model
                $limit = 3;
                $reqCount = $bdd->query("SELECT * FROM products");
                $count = $reqCount->rowCount(); // recup le nombre d'entrée suivant la req
                $reqCount->closeCursor();
                $nbPage = ceil($count/$limit); // arrondi au sup
                //vérifier si le get page existe
                if(isset($_GET['page']))
                {
                    // vérifier si la valeur de get page est numérique?
                    if(is_numeric($_GET['page']))
                    {
                        $pg = htmlspecialchars($_GET['page']);
                        // vérifier la valeur de pg si elle est supérieur à nombre de page max
                        if($pg > $nbPage)
                        {
                            $pg = $nbPage;
                        }elseif($pg <= 0){
                            // vérifier si get page est égal à 0 ou inférieur
                            $pg = 1;
                        }
                    }else{
                        // redirection si pas numérique
                        header("LOCATION:404.php");
                    }
                }else{
                    // si get page n'existe pas, le pg est automatiquement à 1
                    $pg= 1;
                }
                $offset = ($pg-1)*$limit;
                // plus tard la req (fetchAll)
                // $data
                // View
                $menu = $tabMenu['products'];
            }else{
                $menu = $tabMenu[$action];
            }
           
        }else{
            header("LOCATION:404.php");
        }
    }else{
        $menu = $tabMenu['home'];
    }

?>
<!DOCTYPE html>
<html lang="en">
<?php
    include("partials/header.php");
?>
<body>
    <?php
        include ("partials/nav.php");
    ?>
    <main>
        <div class="container">
            <?php
                include("pages/".$menu);
            ?>
        </div>
    </main>
    <?php
        include ("partials/footer.php");
    ?>
</body>
</html>