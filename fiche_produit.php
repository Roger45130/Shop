<?php
require_once('include/init.php');

// Vérifier et ajouter la colonne product_id à la table testimonial si elle n'existe pas
try {
  $connect_db->query("SELECT `product_id` FROM `testimonial` LIMIT 1");
} catch (PDOException $e) {
  $connect_db->exec("ALTER TABLE `testimonial` ADD COLUMN `product_id` INT(11) NOT NULL DEFAULT 0");
}

// Traitement de la soumission du formulaire de commentaire
if (isset($_POST['submit_comment'])) {
  // Vérifier que l'utilisateur est connecté et que les informations envoyées correspondent à la session
  if (isset($_SESSION['user']) && $_SESSION['user']['id_user']) {
    if ($_SESSION['user']['firstName'] === $_POST['firstName'] && $_SESSION['user']['lastName'] === $_POST['lastName']) {
      $user_id = $_SESSION['user']['id_user'];
      $commentText = $_POST['commentText'];
      $icon = isset($_POST['icon']) ? $_POST['icon'] : '0';
      $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : 0;
      // La date est automatiquement renseignée avec la date du jour
      $date = date('Y-m-d H:i:s');
      
      // Insertion du commentaire dans la table testimonial avec le produit sélectionné
      $stmt = $connect_db->prepare("INSERT INTO testimonial (message, date, user_id, icon, product_id) VALUES (:message, :date, :user_id, :icon, :product_id)");
      $stmt->execute([
        ':message'    => $commentText,
        ':date'       => $date,
        ':user_id'    => $user_id,
        ':icon'       => $icon,
        ':product_id' => $product_id
      ]);
      $success = "Votre commentaire a été enregistré avec succès.";
    } else {
      $error = "Erreur: Les informations utilisateur ne correspondent pas.";
    }
  } else {
    $error = "Vous devez être connecté pour laisser un commentaire.";
  }
}

// Récupération du produit selon l'indice 'id' dans l'URL
if (isset($_GET['id'])) {
  $data = $connect_db->prepare("SELECT * FROM product WHERE id_product = :id");
  $data->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
  $data->execute();
  
  // Si la requête ne retourne aucun résultat, on redirige vers la page product.php
  if (!$data->rowCount()) {
    header('location: product.php');
    exit;
  }
  $product = $data->fetch(PDO::FETCH_ASSOC);
} else {
  header('location: index.php');
  exit;
}

require_once('include/header.php');
?>
<!-- inner page section -->
<section class="inner_page_head">
  <div class="container_fuild">
    <div class="row">
      <div class="col-md-12">
        <div class="full">
          <h3>Product Grid</h3>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- end inner page section -->
<!-- product section -->
<section class="product_section layout_padding">
  <div class="container">
    <div class="heading_container heading_center">
      <h2>Our <span>products</span></h2>
    </div>
    <div class="row">
      <div class="col-sm-6 col-md-6 col-lg-6">
        <div class="box">
          <div class="img-box">
            <img src="<?= $product['picture'] ?>" alt="<?= $product['title'] ?>" />
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-6 col-lg-6 pt-5">
        <div class="detail-box">
          <h5><?= ucfirst($product['title']) ?></h5>
          <h6>Référence : <?= $product['reference'] ?></h6>
          <h6>Catégorie : <?= $product['category'] ?></h6>
          <h6>Taile : <?= $product['size'] ?></h6>
          <h6>Genre : <?= $product['public'] ?></h6>
          <h6>Couleur : <?= $product['color'] ?></h6>
          <h6>Description : <?= ucfirst($product['description']) ?></h6>
          <h5><?= $product['price'] ?> €</h5>
          <?php if ($product['stock'] > 0): ?>
            <form action="panier.php" method="post">
              <input type="hidden" name="id_product" value="<?= $product['id_product'] ?>">
              <select name="quantity" id="quantity" class="form-control col-2 py-2">
                <?php for ($i = 1; $i <= $product['stock'] && $i <= 10; $i++): ?>
                  <option value="<?= $i ?>"><?= $i ?></option>
                <?php endfor; ?>
              </select>
              <input type="submit" name="add_card" value="Ajouter au panier" class="m-0">
            </form>
            y'a des des produits en stock
          <?php else: ?>
            <strong class="text-color-danger">Y'en avait mais y'en a plus</strong>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="btn-box">
      <a href="product.php">Voir tous les produits</a>
    </div>
  </div>
</section>
<!-- end product section -->

<!-- customer testimonial section -->
<section class="product_section layout_padding">
  <div class="container">
    <div class="heading_container heading_center">
      <h2>Our <span>Customer Testimonials</span></h2>
    </div>
    <div class="row">
      <?php
      // Récupérer les témoignages du produit sélectionné
      $stmt = $connect_db->prepare("SELECT t.*, u.firstName, u.lastName FROM testimonial t JOIN user u ON t.user_id = u.id_user WHERE t.product_id = :product_id ORDER BY t.date DESC");
      $stmt->bindValue(':product_id', $product['id_product'], PDO::PARAM_INT);
      $stmt->execute();
      $testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);
      foreach ($testimonials as $testimonial):
        // Formater la date au format français
        $dateFr = date("d/m/Y", strtotime($testimonial['date']));
        // Calculer le nombre d'étoiles pleines et vides
        $fullStars = (int)$testimonial['icon'];
        $emptyStars = 5 - $fullStars;
      ?>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><?= ($testimonial['lastName']) . ' ' . ($testimonial['firstName']) ?></h5>
            <h6 class="card-subtitle mb-2 text-muted"><?= $dateFr ?></h6>
            <p class="card-text"><?= ($testimonial['message']) ?></p>
            <div class="card-text">
              <?php
              for ($i = 0; $i < $fullStars; $i++) {
                echo '<i class="fa-solid fa-star" style="color: orange;"></i>';
              }
              for ($i = 0; $i < $emptyStars; $i++) {
                echo '<i class="fa-regular fa-star" style="color: orange;"></i>';
              }
              ?>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- end customer testimonial section -->

<!-- testimonial section (form) -->
<section class="testimonial_section layout_padding">
  <div class="container">
    <?php if (isset($success)): ?>
      <div class="alert alert-success"><?= $success ?></div>
    <?php elseif (isset($error)): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form action="" method="post">
      <!-- Masquer les champs Prénom, Nom et Date et auto-agrémenter product_id -->
      <div style="display: none;">
        <div class="form-group">
          <label for="firstName">Prénom</label>
          <input type="text" id="firstName" name="firstName" class="form-control" value="<?= isset($_SESSION['user']['firstName']) ? htmlspecialchars($_SESSION['user']['firstName']) : '' ?>" readonly>
        </div>
        <div class="form-group">
          <label for="lastName">Nom</label>
          <input type="text" id="lastName" name="lastName" class="form-control" value="<?= isset($_SESSION['user']['lastName']) ? htmlspecialchars($_SESSION['user']['lastName']) : '' ?>" readonly>
        </div>
        <div class="form-group">
          <label for="commentDate">Date</label>
          <input type="date" id="commentDate" name="commentDate" class="form-control" value="<?= date('Y-m-d') ?>" readonly>
        </div>
        <input type="hidden" name="product_id" value="<?= $product['id_product'] ?>">
      </div>
      <div class="form-group">
        <label>Notation :</label>
        <!-- organisation des étoiles -->
        <div id="star-icon" style="cursor: pointer;">
          <span class="star" data-value="1" style="color: orange; font-size:24px;"><i class="fa-regular fa-star"></i></span>
          <span class="star" data-value="2" style="color: orange; font-size:24px;"><i class="fa-regular fa-star"></i></span>
          <span class="star" data-value="3" style="color: orange; font-size:24px;"><i class="fa-regular fa-star"></i></span>
          <span class="star" data-value="4" style="color: orange; font-size:24px;"><i class="fa-regular fa-star"></i></span>
          <span class="star" data-value="5" style="color: orange; font-size:24px;"><i class="fa-regular fa-star"></i></span>
        </div>
        <input type="hidden" id="icon" name="icon" value="0">
      </div>
      <div class="form-group">
        <label for="commentText">Commentaire :</label>
        <textarea id="commentText" name="commentText" class="form-control" rows="4" placeholder="Votre commentaire"></textarea>
      </div>
      <div class="form-group text-center mt-3">
        <button type="submit" name="submit_comment" class="btn btn-primary">Valider</button>
      </div>
    </form>
  </div>
  <script>
    // Script pour la notation par étoiles
    const stars = document.querySelectorAll('#star-icon .star');
    const iconInput = document.getElementById('icon');
    stars.forEach(star => {
      star.addEventListener('click', function() {
        const icon = this.getAttribute('data-value');
        iconInput.value = icon;
        stars.forEach(s => {
          if (s.getAttribute('data-value') <= icon) {
            s.innerHTML = '<i class="fa-solid fa-star"></i>';
          } else {
            s.innerHTML = '<i class="fa-regular fa-star"></i>';
          }
        });
      });
    });
  </script>
</section>
<!-- end testimonial section -->
<!-- footer section -->
<?php
require_once('include/footer.php');
?>
