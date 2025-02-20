<?php
require_once('include/init.php');

// Si l'indice '?id=' est définit dans l'URL
if (isset($_GET['id'])) {
  $data = $connect_db->prepare("SELECT * FROM product WHERE id_product = :id");
  $data->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
  $data->execute();

  // Si la requete ne retourne aucin résultat, on redirige l'utilisateur vers la page index.php
  if (!$data->rowCount()) {
    header('location: product.php');
  }

  $product = $data->fetch(PDO::FETCH_ASSOC);
} else {
  // Sinon on redirige l'internaute
  header('location: index.php');
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
            <img src="<?= $product['picture'] ?>" alt=<?= $product['title'] ?>" />
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
              <!-- <label for="quantity">Qté</label> -->
              <select name="quantity" id="quantity" class="form-control col-2 py-2">
                <!--                5           5              5 -->
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
      <a href=""> View All products </a>
    </div>
  </div>
</section>
<!-- end product section -->
 
<!-- footer section -->

<?php
require_once('include/footer.php');
?>