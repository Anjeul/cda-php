<header>
  <!-- NAV -->
  <nav class="navbar navbar-expand-lg navbar-dark netfloux-navbar">
    <a class="navbar-brand" href="index.php">NETFLOUX</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Accueil <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="add.php">Ajouter</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="list.php">Liste</a>
        </li>


        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Compte
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <?php if (!isset($_SESSION['user'])) { ?>



              <a class="dropdown-item" href="signin.php">Connexion</a>
              <a class="dropdown-item" href="signup.php">Création de compte</a>
              <div class="dropdown-divider"></div>
            <?php } else { ?>
              <a class="dropdown-item" href="index.php?logout=true">Déconnexion</a>
            <?php } ?>
          </div>
        </li>

        <?php if (isset($_SESSION['user'])) { ?>
          <li class="nav-item">
            <a class="nav-link disabled" href="#"><?= $_SESSION['user']['pseudo'] ?></a>
          </li>
        <?php } ?>

      </ul>
      <form class="netfloux-search" role="search">
        <input
          type="search"
          name="q"
          placeholder="Rechercher un titre…"
          aria-label="Rechercher un titre">
        <button type="submit" aria-label="Lancer la recherche">
          <span aria-hidden="true">⌕</span>
        </button>
      </form>
    </div>
  </nav>

</header>