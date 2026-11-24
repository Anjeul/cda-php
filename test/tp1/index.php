<?php 
$estVrai = true;
$nom = 'HI'
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>La page du jour</title>
</head>
<body>
  <h1>La page du jour</h1>
  <p>Bienvenue sur la page du jour, aujourd'hui nous somme le : <?= date('d/m') ?></p>
  <?php 
  var_dump($estVrai);
  ?>
  
  <footer>
    <?= date('Y') ?>
    <?= "Coucou $nom ça va ?" ?>
    <?= `Hello {$nom}`?>
  </footer>
</body>
</html>