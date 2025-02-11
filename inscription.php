<?php
require_once('include/init.php');

/*
    1.  Contrôler que l'on réceptionne bien toute les données saisie dans le formulaire en PHP.
    2.  Contrôler la validité de l'email (select + rowCount).
    3.  Afficher un message d'erreur si le champs email est vide.
    4.  Contrôler la validité de l'email (filter_var).
    5.  Afficher un message si le champs mot de passe est vide.
    6.  Contrôler que les mots de passe correspondent.
*/
$connect_db = new PDO('mysql:host=localhost;dbname=shop', 'root', '', [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
  PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
]);
//1.  Contrôler que l'on réceptionne bien toute les données saisie dans le formulaire en PHP.
echo '<pre>'; print_r($_POST); echo '</pre>';

if(isset($_POST['submit']) && $_SERVER['RESQUET_METHOD'] === 'POST'){
  //2.  Contrôler la validité de l'email (select + rowCount).
  // On sélectionne tous dans la BDD à condition que la colonne email dans la BDD soit égale à l'email saisi dans le formulaire.
  $data = connect_db->prepare("SELECT * FROM user WHERE email = :email");
  $data->bindValue(':email', $_POST['email'], PSO::PARAM_STR);
  $data->execute();

  echo $data->rowCount();
}

// $erreur = [];
// $success_message = "";

// // Traitement du formulaire lorsqu'il est soumis
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//   // Récupération des données du formulaire
//   $firstName = trim($_POST['firstName'] ?? '');
//   $lastName = trim($_POST['lastName'] ?? '');
//   $email = trim($_POST['email'] ?? '');
//   $address = trim($_POST['address'] ?? '');
//   $city = trim($_POST['city'] ?? '');
//   $zipcode = trim($_POST['zipcode'] ?? '');
//   $password = trim($_POST['password'] ?? '');
//   $repeat_password = trim($_POST['repeat_password'] ?? '');

//   // 1. Vérification des champs obligatoires
//   if (empty($firstName)) $erreur[] = "Le prénom est requis.";
//   if (empty($lastName)) $erreur[] = "Le nom est requis.";
//   if (empty($address)) $erreur[] = "L'adresse est requise.";
//   if (empty($city)) $erreur[] = "La ville est requise.";
//   if (empty($zipcode)) $erreur[] = "Le code postal est requis.";

//   // 2. Contrôle du champ email
//   if (empty($email)) {
//       $erreur[] = "L'adresse e-mail est requise.";
//   } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//       $erreur[] = "L'adresse e-mail est invalide.";
//   } else {
//       // Vérification si l'email existe déjà dans la base de données
//       $query = $connect_db->prepare("SELECT id_user FROM user WHERE email = :email");
//       $query->execute(['email' => $email]);

//       if ($query->rowCount() > 0) {
//           $erreur[] = "Cette adresse e-mail est déjà reliée à un utilisateur. Veuillez en saisir une autre.";
//       }
//   }

//   // 3. Contrôle du champ mot de passe
//   if (empty($password)) {
//       $erreur[] = "Le mot de passe est requis.";
//   }

//   // 4. Vérification que les mots de passe correspondent
//   if (!empty($password) && !empty($repeat_password) && $password !== $repeat_password) {
//       $erreur[] = "Les mots de passe ne correspondent pas.";
//   }

//   // 5. Si aucune erreur, insérer les données dans la base de données
//   if (empty($erreur)) {
//       $hashed_password = password_hash($password, PASSWORD_DEFAULT);

//       // Requête d'insertion dans la table `user`
//       $insert_query = $connect_db->prepare(
//           "INSERT INTO user (firstName, lastName, email, address, city, zipcode, password) VALUES (:firstName, :lastName, :email, :address, :city, :zipcode, :password)"
//       );

//       $insert_query->execute(['firstName' => $firstName, 'lastName' => $lastName, 'email' => $email, 'address' => $address, 'city' => $city, 'zipcode' => $zipcode,'password' => $hashed_password]);

//       $success_message = "Votre compte a été créé avec succès.";
//   }
// }

require_once('include/header.php');
?>
  <!-- inner page section -->
  <section class="inner_page_head">
    <div class="container_fuild">
      <div class="row">
        <div class="col-md-12">
          <div class="full">
            <h3>Créer votre compte</h3>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end inner page section -->
  <!-- why section -->
  <!-- why section -->
<section class="why_section layout_padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="full">

                    <?php if (!empty($erreur)): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach ($erreur as $erreur): ?>
                                    <?= htmlspecialchars($erreur) ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($succes_message)): ?>
                        <div class="alert alert-success">
                            <?= htmlspecialchars($succes_message) ?>
                        </div>
                    <?php endif; ?>
                    <form action="" method="POST">
                        <fieldset>
                            <input type="text" placeholder="Enter votre prénom" name="firstName" value="<?= htmlspecialchars($firstName ?? '') ?>" />
                            <input type="text" placeholder="Enter votre nom" name="lastName" value="<?= htmlspecialchars($lastName ?? '') ?>" />
                            <input type="email" placeholder="Entrez votre adresse e-mail" name="email" value="<?= htmlspecialchars($email ?? '') ?>" />
                            <input type="text" placeholder="Entrer votre adresse" name="address" value="<?= htmlspecialchars($address ?? '') ?>" />
                            <input type="text" placeholder="Entrer votre ville" name="city" value="<?= htmlspecialchars($city ?? '') ?>" required />
                            <input type="text" placeholder="Entrer votre code postal" name="zipcode" value="<?= htmlspecialchars($zipcode ?? '') ?>" />
                            <input type="password" placeholder="Enter votre mot de passe" name="password" />
                            <input type="password" placeholder="Répétez votre mot de passe" name="repeat_password" />
                            <input type="submit" value="Créer un compte" />
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
  <!-- end why section -->
  <!-- arrival section -->
  <!-- end arrival section -->

<?php
require_once('include/footer.php');
?>