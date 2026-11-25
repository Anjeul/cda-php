<?php
require_once 'templates/head.php';
require_once 'templates/header.php';

if (isset($_POST['email'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  if (empty($email) || empty($password)) {
    $alertError = 'Merci de remplir tous les champs';
  } else {
    try {
      $request = $db->prepare('SELECT * FROM user WHERE user_email = ?');
      $request->execute([$email]);
      $user = $request->fetch();

      if (!$user || !password_verify($password, $user['user_pswrd'])) {
        $alertError = "Email ou mot de passe incorrect.";
      } else {
        $_SESSION['user'] = [
          'id' => $user['user_id'],
          'pseudo' => $user['user_pseudo'],
        ];

        header('Location: index.php');
        exit;
      }
    } catch (PDOException $e) {
      $alertError = $e->getMessage();
    }
  };
}


require_once 'partials/alert.php';
?>
<main class="container">
  <h1>Se connecter</h1>



  <form action="" method="post">
    <div class="form-group">
      <label for="email">E-mail</label>
      <input type="email" class="form-control" id="email" aria-describedby="email" name="email" placeholder="email@email.com">
    </div>

    <div class="form-group">
      <label for="password">Mot de passe</label>
      <input type="password" min="1900" class="form-control" id="password" aria-describedby="password" name="password" placeholder="Votre mot de passe">
    </div>



    <button type="submit" class="btn btn-danger">S'inscrire</button>
  </form>
</main>

<?php
require_once 'templates/footer.php';
?>