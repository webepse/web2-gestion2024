<?php
    header("http/1.0 404 Not Found");
?>

<!DOCTYPE html>
<html lang="en">
<?php
    include("partials/header.php");
?>
<body>
    <?php
        include("partials/nav.php");
    ?>
    <div class="container">
        <h1>Page introuvable</h1>
        <a href="index.php" class="btn btn-success">Revenir au site</a>
    </div>
    <?php
        include("partials/footer.php");
    ?>
</body>
</html>