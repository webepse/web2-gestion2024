<h2>Page des produits</h2>
<ul class="pagination">
    <?php
        if($pg>1)
        {
            echo "<li class='page-item'>";
                echo "<a href='index.php?action=products&page=".($pg-1)."' class='page-link'>Previous</a>";
            echo "</li>";
        }
        echo "<li class='page-item active' aria-current='page'>";
            echo "<a href='#' class='page-link'>".$pg."</a>";
        echo "</li>";
        if($pg!=$nbPage && $pg<$nbPage)
        {
            echo "<li class='page-item'>";
                echo "<a href='index.php?action=products&page=".($pg+1)."' class='page-link'>Next</a>";
            echo "</li>";
        }
    ?>
</ul>
<div class="row d-flex justify-content-center">
    <?php
          
        foreach($datas as $donProd)
        {
            echo "<div class='card col-3 m-3'>";
                echo "<img src='images/mini_".$donProd['fichier']."' alt='image de ".$donProd['nom']."' class='img-fluid'>";
                echo "<div class='card-body'>";
                    echo "<h5><a href='produit-".$donProd['id']."'>".$donProd['nom']."</a></h5>";
                    echo "<p class='card-text'>".$donProd['description']."</p>";
                echo "</div>";
            echo "</div>";
        }
        
    ?>
</div>
