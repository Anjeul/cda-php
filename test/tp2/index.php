<?php
const DEPART = 'Lyon';
const ARRIVEE = 'Paris';
const DISTANCE = 468;
const CONSOMMATION = 5.7;

$prixLitre = 1.90;
$nombrePersonnes = 2;
$peage = 41.30;

$litres = DISTANCE * CONSOMMATION / 100;
$coutCarburant = $litres * $prixLitre;
$coutTotal = $coutCarburant + $peage;
$coutParPersonne = $coutTotal / $nombrePersonnes;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Coût du trajet <?= DEPART ?> – <?= ARRIVEE ?></title>
</head>
<body>
  <h1><?= DEPART ?> – <?= ARRIVEE ?></h1>

  <p>La distance est de <?= DISTANCE ?> km.</p>
  <p>Le péage coûte <?= number_format($peage, 2, ',', ' ') ?> €.</p>
  <p>
    À <?= number_format($prixLitre, 2, ',', ' ') ?> € le litre,
    le carburant coûte <?= number_format($coutCarburant, 2, ',', ' ') ?> €.
  </p>
  <p>Le trajet coûte <?= number_format($coutTotal, 2, ',', ' ') ?> € au total.</p>
  <p>
    À <?= $nombrePersonnes ?> personnes,
    ça revient à <?= number_format($coutParPersonne, 2, ',', ' ') ?> € par personne.
  </p>
</body>
</html>