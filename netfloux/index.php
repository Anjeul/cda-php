<?php
require_once __DIR__ . "/templates/head.php";
require_once __DIR__ . "/templates/header.php";
?>

<main class="container-fluid px-4">
  <h1 class="h3 my-4">Bienvenue sur Netfloux!</h1>

  <div id="netflouxCarousel" class="carousel slide netfloux-carousel" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#netflouxCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#netflouxCarousel" data-slide-to="1"></li>
      <li data-target="#netflouxCarousel" data-slide-to="2"></li>
      <li data-target="#netflouxCarousel" data-slide-to="3"></li>
      <li data-target="#netflouxCarousel" data-slide-to="4"></li>
    </ol>

    <div class="carousel-inner">
      <div class="carousel-item active">
        <img class="netfloux-carousel-backdrop" src="assets/films/speak_no_evil.jpg" alt="">

        <div class="netfloux-carousel-content">
          <img class="netfloux-carousel-poster" src="assets/films/speak_no_evil.jpg" alt="">
          <h2 class="netfloux-carousel-title">Speak No Evil</h2>
        </div>
      </div>

      <div class="carousel-item">
        <img class="netfloux-carousel-backdrop" src="assets/films/the_visit.jpg" alt="">

        <div class="netfloux-carousel-content">
          <img class="netfloux-carousel-poster" src="assets/films/the_visit.jpg" alt="">
          <h2 class="netfloux-carousel-title">The Visit</h2>
        </div>
      </div>

      <div class="carousel-item">
        <img class="netfloux-carousel-backdrop" src="assets/films/perfect_blue.jpg" alt="">

        <div class="netfloux-carousel-content">
          <img class="netfloux-carousel-poster" src="assets/films/perfect_blue.jpg" alt="">
          <h2 class="netfloux-carousel-title">Perfect Blue</h2>
        </div>
      </div>

      <div class="carousel-item">
        <img class="netfloux-carousel-backdrop" src="assets/films/us.jpg" alt="">

        <div class="netfloux-carousel-content">
          <img class="netfloux-carousel-poster" src="assets/films/us.jpg" alt="">
          <h2 class="netfloux-carousel-title">Us</h2>
        </div>
      </div>

      <div class="carousel-item">
        <img class="netfloux-carousel-backdrop" src="assets/films/snowpiercer.jpg" alt="">

        <div class="netfloux-carousel-content">
          <img class="netfloux-carousel-poster" src="assets/films/snowpiercer.jpg" alt="">
          <h2 class="netfloux-carousel-title">Snowpiercer</h2>
        </div>
      </div>


    </div>

    <a class="carousel-control-prev" href="#netflouxCarousel" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Film précédent</span>
    </a>

    <a class="carousel-control-next" href="#netflouxCarousel" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Film suivant</span>
    </a>
  </div>
</main>

<?php
require_once __DIR__ . "/templates/footer.php";
?>