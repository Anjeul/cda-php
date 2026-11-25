<?php
require_once "templates/head.php";
require_once "templates/header.php";

$isOk = false;
const MAX_RANK = 5;


if (!isset($_SESSION['user'])) {
  header('Location: signin.php');
  exit;
}
if (isset($_GET['id'])) {
  $movieId = $_GET['id'];
} else {
  $alertError = "Le film selectionné n'a pas été trouvé";
}
if (isset($_POST["view"])) {
  $view = $_POST["view"];
  try {
    $request = $db->prepare('UPDATE movie SET movie_is_watched = ? WHERE movie.movie_id = ?');
    $request->execute([$view, $movieId]);
    $alertSuccess = "Le statut a été mis à jour ";
  } catch (PDOException $e) {
    $alertError = $e->getMessage();
  }
}

// NOTE DU FILM
if (isset($_POST["note"])) {
  $note = $_POST["note"];
  if (empty($note)) {
    $alertError = "Merci de remplir le champs.";
  } elseif (filter_var($_POST['note'], FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1, 'max_range' => 5]
  ]) === false) {
    $alertError = "La note doit être un nombre entier entre 1 et 5";
  } else {
    try {
      $request = $db->prepare('UPDATE movie SET movie_rank = ? WHERE movie.movie_id = ?');
      $request->execute([$note, $movieId]);
      $alertSuccess = "La note a bien été modifié";
    } catch (PDOException $e) {
      $alertError =  "Erreur lors de l'ajout de la note";
    }
  }
}


try {
  $request = $db->prepare('SELECT movie.*, category.category_name FROM movie LEFT JOIN category ON category.category_id = movie.id_category WHERE movie_id = ?');
  $request->execute([
    $movieId
  ]);

  $movieDetail = $request->fetch();

  if (!$movieDetail) {
    $isOk = false;
    $alertError = "Le film n'a pas été trouvé";
  } else {
    $isOk = true;
  }
} catch (PDOException $e) {
  $alertError =  "Erreur lors de la récupération du film.";
}

// SUPPRESSION DU FILM
if ($isOk && ($_POST['delete'] ?? null) === '1') {

  try {
    $request = $db->prepare('DELETE FROM movie WHERE movie_id = ?');
    $request->execute([$movieId]);

    $picture = $movieDetail['movie_picture'];
    $path = 'public/picture/' . $picture;
    if ($picture && file_exists($path)) {
      unlink($path);
    }
    $isOk = false;
    $alertSuccess = "La film a bien été supprimé";
    header("Location: list.php");
  } catch (PDOException $e) {
    $alertError =  "Erreur lors de la suppression du film";
  }
}

require_once "partials/alert.php";

if ($isOk) {
?>

  <main class="container">
    <a href="list.php"
      style="display: inline-block; padding: 6px 12px; color: #fff; border: 1px solid #e50914; border-radius: 6px; text-decoration: none; font-size: 0.9rem;">
      ← Retour à la liste
    </a>
    <?php if (!empty($movieDetail['movie_picture'])) { ?>
      <img
        class="card-img-top netfloux-movie__poster"
        src="public/picture/<?= htmlspecialchars($movieDetail['movie_picture']) ?>"
        alt=""
        style="max-width: 240px; height: auto;">
    <?php } else { ?>
      <div class="netfloux-movie__poster netfloux-movie__placeholder">
        Affiche indisponible
      </div>
    <?php } ?>

    <h1><?= htmlspecialchars($movieDetail['movie_title']) ?></h1>
    <p><?= htmlspecialchars($movieDetail['movie_year']) ?></p>
    <p><?= htmlspecialchars($movieDetail['movie_time']) ?></p>
    <p><?= htmlspecialchars($movieDetail['category_name']) ?></p>
    <p><?= htmlspecialchars($movieDetail['movie_summary']) ?></p>
    <p>
      <?= htmlspecialchars($movieDetail['movie_is_watched']) ? "Vous avez vu ce film" : "Vous ne l'avez pas encore regardé !" ?>
    </p>
    <p>
      <?php
      if (!$movieDetail["movie_rank"]) {
        echo "Le film n'a pas encore été noté";
      } else {
        for ($i = 1; $i <= MAX_RANK; $i++) {
          if ($i <= $movieDetail['movie_rank']) {
            echo '★';
          } else {
            echo '☆';
          }
        }
      };
      ?>
    </p>

    <!-- FORM -->
    <form action="" method="post">
      <div class="form-group">
        <label for="note">Ajouter une note :</label>
        <select id="note" name="note" class="form-control">
          <?php for ($i = 1; $i <= MAX_RANK; $i++) { ?>
            <option value="<?= $i ?>" <?= $i == $movieDetail['movie_rank'] ? 'selected' : '' ?>> <?= $i ?></option>
          <?php
          }; ?>
        </select>
        <button type="submit" class="btn btn-primary">Modifier la note</button>
      </div>
    </form>

    <form action="" method="post">
      <button type="submit" class="btn btn-secondary" name="view"
        value="<?= $movieDetail['movie_is_watched'] ? 0 : 1 ?>">
        <?= htmlspecialchars($movieDetail['movie_is_watched']) ? '❌ Marquer comme non vu' : "✔ Marquer comme vu" ?>
      </button>
    </form>

    <?php if (!empty($movieDetail['movie_trailer'])) { ?>
      <iframe src="https://www.youtube.com/embed/<?= htmlspecialchars($movieDetail['movie_trailer']) ?>" frameborder="0">
      </iframe>

    <?php } ?>


    <!-- SUPPRESSION -->
    <form action="" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer ce film ?');">
      <button type="submit" name="delete" class="btn btn-danger" value="1">Supprimer</button>
    </form>
  </main>


<?php
}

require_once "templates/footer.php";
?>