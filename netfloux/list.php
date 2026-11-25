<?php
require_once "templates/head.php";
require_once "templates/header.php";

if (!isset($_SESSION['user'])) {
  header('Location: signin.php');
  exit;
}


try {
  $request = $db->query('SELECT movie.*, category.category_name FROM movie LEFT JOIN category ON category.category_id = movie.id_category');
  $movies = $request->fetchAll(PDO::FETCH_ASSOC);
  $nbrMovies = count($movies);

  $plus = $nbrMovies > 1 ? "s" : "";
  $alertSuccess = "$nbrMovies film$plus";
} catch (PDOException $e) {
  echo '' . $e->getMessage();
  $alertError = "Echec de la récupération des films.";
};

require_once "partials/alert.php";
?>
<main class="container">
  <h1>Liste des films</h1>

  <div class="netfloux-movies">
    <?php foreach ($movies as $movie) { ?>
      <article class="card bg-dark text-white netfloux-movie">
        <div class="netfloux-movie__cover">
          <?php if (!empty($movie['movie_picture'])) { ?>
            <img
              class="card-img-top netfloux-movie__poster"
              src="public/picture/<?= $movie['movie_picture'] ?>"
              alt="">
          <?php } else { ?>
            <div class="netfloux-movie__poster netfloux-movie__placeholder">
              Affiche indisponible
            </div>
          <?php } ?>

          <?php if ((int) $movie['movie_is_safe'] === 1) { ?>
            <span
              class="netfloux-movie__children-icon"
              role="img"
              aria-label="Adapté aux enfants"
              title="Adapté aux enfants">🧒</span>
          <?php } ?>
        </div>

        <div class="card-body p-3 d-flex flex-column">
          <h2 class="card-title h6 mb-2">
            <?= htmlspecialchars($movie['movie_title']) ?>
          </h2>
          <span class="badge badge-secondary">
            <?= htmlspecialchars($movie['category_name'] ?? '') ?>
          </span>


          <?php if (!empty($movie['movie_summary'])) { ?>
            <p class="card-text netfloux-movie__summary">
              <?= htmlspecialchars($movie['movie_summary']) ?>
            </p>
          <?php } ?>


          <a href="details.php?id=<?= $movie['movie_id'] ?>" class="btn btn-danger btn-sm mt-auto align-self-start">
            Consulter
          </a>

        </div>
      </article>
    <?php } ?>
  </div>
</main>

<?php
require_once "templates/footer.php";
?>