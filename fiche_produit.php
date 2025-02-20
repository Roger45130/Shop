<?php
require_once('include/init.php');

// Traitement de la soumission du formulaire de commentaire
if (isset($_POST['submit_comment'])) {
  // Vérifier que l'utilisateur est connecté et que les informations envoyées correspondent à la session
  if (isset($_SESSION['user']) && $_SESSION['user']['id_user']) {
    if ($_SESSION['user']['firstName'] === $_POST['firstName'] && $_SESSION['user']['lastName'] === $_POST['lastName']) {
      $user_id = $_SESSION['user']['id_user'];
      $commentText = $_POST['commentText'];
      $icon = $_POST['icon'];
      // La date est automatiquement renseignée avec la date du jour
      $date = date('Y-m-d H:i:s');
      
      // Insertion du commentaire dans la table testimonial (en supposant que la colonne 'rating' existe)
      $stmt = $connect_db->prepare("INSERT INTO testimonial (message, date, user_id, icon) VALUES (:message, :date, :user_id, :icon)");
      $stmt->execute([
        ':message' => $commentText,
        ':date'    => $date,
        ':user_id' => $user_id,
        ':icon'  => $icon
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
          <h5><?= $product['price'] ?></h5>
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
<!-- testimonial section -->
<section class="testimonial_section layout_padding">
  <div class="container">
    <?php if (isset($success)): ?>
      <div class="alert alert-success"><?= $success ?></div>
    <?php elseif (isset($error)): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form action="" method="post">
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
      <div class="form-group">
        <label for="commentText">Commentaire</label>
        <textarea id="commentText" name="commentText" class="form-control" rows="4" placeholder="Votre commentaire"></textarea>
      </div>
      <div class="form-group">
        <label>Notation</label>
        <div id="star-icon" style="cursor: pointer;">
          <span class="star" data-value="1" style="color: orange; font-size:24px;"><i class="fa-regular fa-star"></i></span>
          <span class="star" data-value="2" style="color: orange; font-size:24px;"><i class="fa-regular fa-star"></i></span>
          <span class="star" data-value="3" style="color: orange; font-size:24px;"><i class="fa-regular fa-star"></i></span>
          <span class="star" data-value="4" style="color: orange; font-size:24px;"><i class="fa-regular fa-star"></i></span>
          <span class="star" data-value="5" style="color: orange; font-size:24px;"><i class="fa-regular fa-star"></i></span>
        </div>
        <input type="hidden" id="icon" name="icon" value="0">
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
