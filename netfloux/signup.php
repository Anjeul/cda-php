<?php
require_once 'templates/head.php';
require_once 'templates/header.php';

const PASSWORD_MIN_LENGTH = 8;
if (isset($_POST['pseudo'])) {
  $pseudo = $_POST['pseudo'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  if (empty($pseudo) || empty($email) || empty($password)) {
    $alertError = "Merci de remplir tous les champs.";
  } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    $alertError = "Merci de renseigner une adresse email valide.";
  } elseif (mb_strlen($password) < 8) {
    $alertError = "Le mot de passe doit contenir au moins " . PASSWORD_MIN_LENGTH . " caractères !";
  } else {
    try {
      $request = $db->prepare('SELECT * FROM user WHERE user_email = ? OR user_pseudo = ?');
      $request->execute([$email, $pseudo]);
      $user = $request->fetch();

      if ($user) {
        $alertError = "Un compte existe déjà avec ce pseudo ou email !";
      } else {
        $id = bin2hex(random_bytes(4));

        $pswdHash = password_hash($password, PASSWORD_DEFAULT);

        $request = $db->prepare("INSERT INTO user (
                                                    user_id, 
                                                    user_pseudo, 
                                                    user_email, 
                                                    user_pswrd)
                                                    VALUES (?, ?, ?, ?)");


        $request->execute([$id, $pseudo, $email, $pswdHash]);

        // $alertSuccess = "Bienvenue $pseudo ! Votre compte a bien été enregistré.";


        $_SESSION['user'] = [
          'id' => $id,
          'pseudo' => $pseudo,
        ];


        header('Location: index.php');
        exit;
      }
    } catch (PDOException $e) {
      $alertError = $e->getMessage();
    }
  }
}
require_once 'partials/alert.php';
?>
<main class="container">
  <h1>Création de compte</h1>



  <form action="" method="post">

    <div class="form-group">
      <label for="pseudo">Pseudo</label>
      <input type="text" class="form-control" id="pseudo" aria-describedby="pseudo" name="pseudo" placeholder="Votre pseudo">
    </div>

    <div class="form-group">
      <label for="email">E-mail</label>
      <input type="email" class="form-control" id="email" aria-describedby="email" name="email" placeholder="email@email.com">
    </div>

    <div class="form-group">
      <label for="password">Mot de passe</label>
      <input type="password" min="1900" class="form-control" id="password" aria-describedby="password" name="password" placeholder="Votre mot de passe">
    </div>



    <div class="form-check mb-3">
      <input type="checkbox" class="form-check-input"
        id="movie_is_safe" name="movie_is_safe" value="1" checked>
      <label class="form-check-label" for="movie_is_safe">Fabuleuse personne</label>
    </div>

    <button type="submit" class="btn btn-danger">S'inscrire</button>
  </form>
</main>

<?php
require_once 'templates/footer.php';
?>