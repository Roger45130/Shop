<?php
require_once('include/init.php');
// echo '<pre>'; print_r($_SESSION); echo '</pre>';

// Si l'utilisateur n'est pas connecté, il n'a rien à faire sur la page profil, on le redirige vers la page index.php
if (!userConnected()) {
  header('location: index.php');
  exit();
}

// Gestion de la mise à jour du profil
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
  $id = $_SESSION['user']['id_user'];
  $firstName = $_POST['firstName'];
  $lastName  = $_POST['lastName'];
  $email     = $_POST['email'];
  $address   = $_POST['address'];
  $city      = $_POST['city'];
  $zipcode   = $_POST['zipcode'];

  $update = $connect_db->prepare("UPDATE user SET firstName = :firstName, lastName = :lastName, email = :email, address = :address, city = :city, zipcode = :zipcode WHERE id_user = :id");
  $update->execute([
    ':firstName' => $firstName,
    ':lastName'  => $lastName,
    ':email'     => $email,
    ':address'   => $address,
    ':city'      => $city,
    ':zipcode'   => $zipcode,
    ':id'        => $id
  ]);

  // Rafraîchir les informations de session
  $stmt = $connect_db->prepare("SELECT * FROM user WHERE id_user = :id");
  $stmt->execute([':id' => $id]);
  $_SESSION['user'] = $stmt->fetch(PDO::FETCH_ASSOC);

  $message = "Informations mises à jour avec succès";
}

$editing = isset($_GET['edit']) && $_GET['edit'] == 1;

require_once('include/header.php');
?>

<!-- inner page section -->
<section class="inner_page_head">
  <div class="container_fuild">
    <div class="row">
      <div class="col-md-12">
        <div class="full">
          <h3>Mes informations personnelles</h3>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- end inner page section -->

<?php if (isset($message)) : ?>
  <div class="alert alert-success"><?= $message ?></div>
<?php endif; ?>

<!-- why section -->
<section class="why_section layout_padding">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <div class="full">
          <div class="col-sm-12 col-md-8 col-lg-12">
            <?php if (!$editing): ?>
              <div class="box-profil">
                <div class="detail-box d-flex align-items-center justify-content-between">
                  <h5>Prénom</h5>
                  <h6><?= $_SESSION['user']['firstName'] ?></h6>
                </div>
                <div class="detail-box d-flex align-items-center justify-content-between">
                  <h5>Nom</h5>
                  <h6><?= $_SESSION['user']['lastName'] ?></h6>
                </div>
                <div class="detail-box d-flex align-items-center justify-content-between">
                  <h5>Email</h5>
                  <h6><?= $_SESSION['user']['email'] ?></h6>
                </div>
                <div class="detail-box d-flex align-items-center justify-content-between">
                  <h5>Adresse</h5>
                  <h6><?= $_SESSION['user']['address'] ?></h6>
                </div>
                <div class="detail-box d-flex align-items-center justify-content-between">
                  <h5>Ville</h5>
                  <h6><?= $_SESSION['user']['city'] ?></h6>
                </div>
                <div class="detail-box d-flex align-items-center justify-content-between">
                  <h5>Code postal</h5>
                  <h6><?= $_SESSION['user']['zipcode'] ?></h6>
                </div>
                <?php if (adminConnected()): ?>
                  <div class="detail-box d-flex align-items-center justify-content-between">
                    <h5>Vous êtes ADMINISTRATEUR</h5>
                  </div>
                <?php endif; ?>
                <div class="text-center mt-3">
                  <a href="profil.php?edit=1" class="btn btn-primary">Modifier mes informations</a>
                </div>
              </div>
            <?php else: ?>
              <div class="box-profil">
                <form method="post" action="profil.php">
                  <div class="detail-box d-flex align-items-center justify-content-between">
                    <h5>Prénom</h5>
                    <input type="text" name="firstName" class="ml-3 form-control border-success" value="<?= $_SESSION['user']['firstName'] ?>" required />
                  </div>
                  <div class="detail-box d-flex align-items-center justify-content-between py-2 rounded-3">
                    <h5>Nom</h5>
                    <input type="text" name="lastName" class="ml-3 form-control border-success" value="<?= $_SESSION['user']['lastName'] ?>" required />
                  </div>
                  <div class="detail-box d-flex align-items-center justify-content-between py-2 rounded-3">
                    <h5>Email</h5>
                    <input type="email" name="email" class="ml-3 form-control border-success" value="<?= $_SESSION['user']['email'] ?>" required />
                  </div>
                  <div class="detail-box d-flex align-items-center justify-content-between py-2 rounded-3">
                    <h5>Adresse</h5>
                    <input type="text" name="address" class="ml-3 form-control border-success" value="<?= $_SESSION['user']['address'] ?>" required />
                  </div>
                  <div class="detail-box d-flex align-items-center justify-content-between py-2 rounded-3">
                    <h5>Ville</h5>
                    <input type="text" name="city" class="ml-3 form-control border-success" value="<?= $_SESSION['user']['city'] ?>" required />
                  </div>
                  <div class="detail-box d-flex align-items-center justify-content-between py-2 rounded-3">
                    <h5>Code postal</h5>
                    <input type="text" name="zipcode" class="ml-3 form-control border-success" value="<?= $_SESSION['user']['zipcode'] ?>" required />
                  </div>
                  <div class="text-center mt-3">
                    <button type="submit" name="update_profile" class="btn btn-success">Valider</button>
                  </div>
                </form>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- end why section -->

<!-- arrival section -->
<!-- end arrival section -->
<!-- footer section -->

<?php
require_once('include/footer.php');
?>
