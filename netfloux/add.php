<?php
require_once "templates/head.php";
require_once "templates/header.php";

if (!isset($_SESSION['user'])) {
  header('Location: signin.php');
  exit;
}

if (isset($_POST['title'])) {

  $title = $_POST['title'];
  $resume = $_POST['resume'];
  $year = $_POST['year'] === '' ? null : $_POST['year'];
  $time = $_POST['time'];
  $trailer = $_POST['trailer'];
  $category = $_POST['category'];
  $movieIsSafe = isset($_POST['movie_is_safe']) ? 1 : 0;

  if (empty($title) || empty($category)) {
    $alertError = "Merci de remplir tous les champs.";
  } else {
    try {

      $file = null;
      if (!empty($_FILES['picture']['name'])) {
        // permet de recuperer l'extension de l'image (jpg, png, svg)
        $imageFileType = strtolower(pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION));


        // designe le dossier où ça attérit
        $targetDir = "public/picture/";
        // genere un nom avec l'extension
        $fileName = bin2hex(random_bytes(4)) . '.' . $imageFileType;
        // Chemin complet
        $targetFile = $targetDir . $fileName;

        // LES VERIFICATIONS
        if ($_FILES['picture']['error'] !== UPLOAD_ERR_OK) {
          $alertError = "Une erreur est suurvenue lors de l'envoi de votre image";
        } elseif ($_FILES["picture"]["size"] > 500000) {
          $alertError = "Le fichier est trop volumineux (max 500ko)";
        } elseif (!in_array($imageFileType, ['jpg', 'png', 'jpeg'], true)) {

          $alertError = "Uniquement JPG, JPEG ou PNG";
        } elseif (getimagesize($_FILES['picture']['tmp_name']) === false) {
          $alertError = "Le fichier n'est pas une image";
        } elseif (file_exists($targetFile)) {
          // a ne pas faire en prod : ce n'est pas le pb de l'user vu que c'est nous qui générons le nom
          $alertError = "Un fichier du même nom existe déjà";
        } elseif (move_uploaded_file($_FILES["picture"]["tmp_name"], $targetFile)) {
          $file = $fileName;
        } else {
          $alertError = "Une erreur est survenue lors de l'envoi de votre image";
        }
      }
      if (!$alertError) {

        $request = $db->prepare('INSERT INTO movie (
        movie_title, 
        movie_summary, 
        movie_year, 
        movie_time, 
        movie_trailer, 
        movie_picture, 
        id_category,
        movie_is_safe
        ) VALUE (?, ?, ?, ?, ?, ?, ?, ?)');

        $request->execute([
          $title,
          $resume,
          $year,
          $time,
          $trailer,
          $file,
          $category,
          $movieIsSafe
        ]);

        $alertSuccess = "Votre film $title a bien été ajouté !";
      }
    } catch (PDOException $e) {
      echo 'Erreur : ' . $e->getMessage();
    }
  }
}

try {
  $request = $db->query('SELECT * FROM category');
  $categories = $request->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo 'Erreur : ' . $e->getMessage();
  $alertError = "Impossible de récupérer les catégories pour l'instant.";
};

require_once "partials/alert.php";

?>
<main class="container">
  <h1>Ajouter un film</h1>



  <form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
      <label for="title">Titre du film</label>
      <input type="text" class="form-control" id="title" aria-describedby="title" name="title" placeholder="Rosemary's Baby">
    </div>

    <div class="form-group">
      <label for="resume">Résumé<small class="ml-2 text-muted">Facultatif</small></label>
      <input type="text" class="form-control" id="resume" aria-describedby="resume" name="resume" placeholder="Description">
    </div>

    <div class="form-group">
      <label for="year">Année<small class="ml-2 text-muted">Facultatif</small></label>
      <input type="number" min="1900" class="form-control" id="year" aria-describedby="year" name="year" placeholder="1968">
    </div>

    <div class="form-group">
      <label for="time">Durée du film<small class="ml-2 text-muted">Facultatif</small></label>
      <input type="time" class="form-control" id="time" aria-describedby="time" name="time">
    </div>

    <div class="form-group">
      <label for="picture">Affiche du film<small class="ml-2 text-muted">Facultatif</small></label>
      <input type="file" class="form-control" id="picture" aria-describedby="picture" name="picture" placeholder="URL de l'affiche">
    </div>

    <div class="form-group">
      <label for="trailer">Bande annonce<small class="ml-2 text-muted">Facultatif</small></label>
      <input type="text" class="form-control" id="trailer" aria-describedby="trailer" name="trailer">
    </div>


    <div class="form-group">
      <label for="category">Catégorie</label>
      <select class="form-control" id="category" name="category">
        <?php foreach ($categories as $category) { ?>
          <option value="<?= $category['category_id'] ?>">
            <?= $category['category_name'] ?>
          </option>
        <?php } ?>
      </select>
    </div>

    <div class="form-check mb-3">
      <input type="checkbox" class="form-check-input"
        id="movie_is_safe" name="movie_is_safe" value="1" checked>
      <label class="form-check-label" for="movie_is_safe">Adapté aux enfants</label>
    </div>

    <button type="submit" class="btn btn-danger">Ajouter un film</button>
  </form>

</main>

<?php
require_once "templates/footer.php";
?>