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

$erreur =[];
$succes_message ="";

if ($_SERVER['RESQUEST_METHOD'] == 'POST'){
  $firstName = trim($_POST['firstname'] ?? '');
  $lastName = trim($_POST['lastName'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $address = trim($_POST['address'] ?? '');
  $city = trim($_POST['city'] ?? '');
  $zipcode = trim($_POST['zipcode'] ?? '');
  $password = trim($_POST['password'] ?? '');
  $repeat_password = trim($_POST['repeat_password'] ?? '');

  if(empty($firstName)) $erreur[] = 'Saisir un prénom';
  if(empty($lastName)) $erreur[] = 'Saisir un nom';
  if(empty($email)) $erreur[] = 'Saisir un email';
  if(empty($address)) $erreur[] = 'Saisir une adresse';
  if(empty($city)) $erreur[] = 'Saisir une ville';
  if(empty($zipcode)) $erreur[] = 'Saisir un code postal';
  if(empty($password)) $erreur[] = 'Saisir un mot de passe';
  if(empty($repeat_password)) $erreur[] = 'La confirmation du mot de passe est requise';

  if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erreur[] = "L'adresse e-mail est invalide.";
  }

  if (empty($erreur)) {
    try {
        $query = $db->prepare("SELECT id FROM users WHERE email = :email");
        $query->execute(['email' => $email]);
        if ($query->rowCount() > 0) {
            $erreur[] = "Cette adresse e-mail est déjà utilisée. Veuillez en choisir une autre.";
        }
    } catch (PDOException $e) {
        $erreur[] = "Une erreur est survenue lors de la vérification de l'email.";
    }
  }

}
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
  <section class="why_section layout_padding">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 offset-lg-2">
          <div class="full">
            <form action="">
              <fieldset>
                <input
                  type="text"
                  placeholder="Enter votre prénom"
                  name="firstName"
                  required />
                <input
                  type="text"
                  placeholder="Enter votre nom"
                  name="lastName"
                  required />
                <input
                  type="text"
                  placeholder="Entrez votre adresse e-mail"
                  name="email"
                  required />
                <input
                  type="text"
                  placeholder="Entrer votre adresse"
                  name="address"
                  required />
                <input
                  type="text"
                  placeholder="Entrer votre ville"
                  name="city"
                  required />
                <input
                  type="text"
                  placeholder="Entrer votre code postal"
                  name="zipcode"
                  required />
                <input
                  type="password"
                  placeholder="Enter votre mot de passe"
                  name="subject"
                  required />
                <input
                  type="repeat_password"
                  placeholder="Répétez votre mot de passe"
                  name="subject"
                  required />
                <input type="submit" value="Submit" />
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