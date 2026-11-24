<?php 
$age = 26;
$etudiant = true;
$jour = 'jeudi';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>

  <?php
    if($age < 14) {
      $tarif = 'Enfant';
      $prix = 6;
    } elseif($jour === 'mercredi') {
      $tarif = 'Mercredi';
      $prix = 7;
    } elseif($etudiant) {
      $tarif = 'Etudiant';
      $prix = 8;
    } else {
      $tarif = 'Habituel';
      $prix = 11.50;
    }

    $message = match ($jour) {
      "mercredi" => "7€ dès 14 ans",
      "samedi", "dimanche" => "Pensez à réserver",
      default => "Bonne séance !",
    }

   
  ?>
  <p>
    <?=  "Tarif : " . $tarif . "<br> " . ($tarif == 'Etudiant' ? "Pensez à votre carte étudiante" : "") ?>
</p>
  <p> Prix : 
    <?= 
  number_format($prix,2, ",", " ")
    ?>
    € 
</p>
<p><?= $message ?></p>
</body>
</html>