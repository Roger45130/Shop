<?php
require_once('include/init.php');
// echo '<pre>'; print_r($_SESSION); echo '</pre>';

/*
    Exercice : Créer une fiche utilisateur qui regroupe les informations personnelles de l'utilisateur en passant par le fichier session.
*/

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
  <!-- why section -->
  <section class="why_section layout_padding">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 offset-lg-2">
          <div class="full">
            <ul>
              <li><strong>Prénom : </strong> <?php echo $_SESSION['user']['firstName'] ?? 'Non renseiné'; ?></li>
              <li><strong>Nom : </strong> <?php echo $_SESSION['user']['lastName'] ?? 'Non renseiné'; ?></li>
              <li><strong>Email : </strong> <?php echo $_SESSION['user']['email'] ?? 'Non renseiné'; ?></li>
              <li><strong>Adresse : </strong> <?php echo $_SESSION['user']['address'] ?? 'Non renseiné'; ?></li>
              <li><strong>Code Postal : </strong> <?php echo $_SESSION['user']['zipcode'] ?? 'Non renseiné'; ?></li>
              <li><strong>Ville : </strong> <?php echo $_SESSION['user']['city'] ?? 'Non renseiné'; ?></li>
            </ul>
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