<?php
$classe = [
  [
    "prenom" => "Emma",
    "nom" => "Martin",
    "note" => 15,
  ],
  [
    "prenom" => "Lucas",
    "nom" => "Bernard",
    "note" => 9,
  ],
  [
    "prenom" => "Chloé",
    "nom" => "Petit",
    "note" => 18,
  ],
  [
    "prenom" => "Hugo",
    "nom" => "Dubois",
    "note" => 11,
  ],
  [
    "prenom" => "Lina",
    "nom" => "Thomas",
    "note" => 14,
  ],
  [
    "prenom" => "Nathan",
    "nom" => "Robert",
    "note" => 7,
  ],
  [
    "prenom" => "Jade",
    "nom" => "Richard",
    "note" => 16,
  ],
  [
    "prenom" => "Adam",
    "nom" => "Moreau",
    "note" => 13,
  ],
  // [
  //     "prenom" => "bob",
  //     "nom" => "bob",
  //     "note" => 20,
  // ]
];
$result = 0;
$nbr = count($classe);
$compteurAdmis = 0;
$meilleurNote = 0;
$isAdmis = false;

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    * {
      font-family: Arial, Helvetica, sans-serif;
    }

    table {
      border-collapse: collapse;
      border: 2px solid rgb(140 140 140);
      font-family: sans-serif;
      font-size: 0.8rem;
      letter-spacing: 1px;
    }

    caption {
      caption-side: top;
      padding: 10px;
      font-weight: bold;
    }

    thead,
    tfoot {
      background-color: rgb(228 240 245);
    }

    th,
    td {
      border: 1px solid rgb(160 160 160);
      padding: 8px 10px;
    }

    td:last-of-type {
      text-align: center;
    }

    tbody>tr:nth-of-type(even) {
      background-color: rgb(237 238 242);
    }

    tfoot th {
      text-align: right;
    }

    tfoot td {
      font-weight: bold;
    }
  </style>
</head>

<body>
  <table>
    <caption>Bulletin de classe</caption>
    <thead>
      <tr>
        <th scope="col">Nom</th>
        <th scope="col">Prénom</th>
        <th scope="col">Note / 20</th>
        <th scope="col">Admission</th>
      </tr>
    </thead>
    <tbody>

      <?php
      for ($i = 0; $i < $nbr; $i++) {
        $result = $result + $classe[$i]['note'];
        if ($classe[$i]['note'] >= 10) {
          $isAdmis = true;
          $compteurAdmis++;

          if ($classe[$i]['note'] > $meilleurNote) {
            $meilleurNote = $classe[$i]['note'];
          }

      ?>

        <?php
        } else {
          $isAdmis = false;
        } ?>
        <tr>
          <td><?= $classe[$i]['nom'] ?></td>
          <td><?= $classe[$i]['prenom'] ?></td>
          <td><?= $classe[$i]['note'] ?></td>
          <td><?= $isAdmis ? "Admis" : "Non Admis" ?></td>

        </tr>
      <?php }

      $moyenne = $result / $nbr;
      ?>

    </tbody>
    <tfoot>
      <tr>
        <th scope="row" colspan="2">Moyenne de la classe</th>
        <td> <?= number_format($moyenne, 2, ',', ' ') ?></td>
        <td><?= $compteurAdmis . '/' . count($classe) ?></td>
      </tr>
    </tfoot>
  </table>
  <p>Meilleure note : <?= $meilleurNote ?></p>
  <p>Nombre d'admis : <?= $compteurAdmis . " sur " . count($classe) . ' élèves' ?></p>
</body>

</html>