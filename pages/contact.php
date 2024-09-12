<h1>Contact</h1>
<?php
    if(isset($_GET['send']))
    {
        echo "<div class='alert alert-success'>Votre message à bien été envoyé</div>";
    }

?>
<form action="traitement.php" method="POST">
    <div class="form-group my-3">
        <label for="nom">Nom: </label>
        <input type="text" name="nom" id="nom" class="form-control">
    </div>
    <div class="form-group my-3">
        <label for="email">E-Mail: </label>
        <input type="email" name="email" id="email" class="form-control">
    </div>
    <div class="form-group my-3">
        <label for="sujet">Sujet: </label>
        <input type="text" name="sujet" id="sujet" class="form-control">
    </div>
    <div class="form-group my-3">
        <label for="message">Message: </label>
        <textarea name="message" id="message" class="form-control"></textarea>
    </div>
    <div class="form-group my-3">
        <input type="submit" value="Envoyer" class="btn btn-primary">
    </div>
</form>

