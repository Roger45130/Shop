<?php
require_once('include/init.php');

//  Récupérer la BDD
$pdo = new PDO('mysql:host=localhost;dbname=shop;charset=utf8', 'root', '', [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

// Vérifier si un id_product est passé dans l'URL
if (isset($_GET['id_product']) && is_numeric($_GET['id_product'])) {
  $id_product = (int)$_GET['id_product'];

  // Sélectionner le produit correspondant à l'id_product
  $stmt = $pdo->prepare("SELECT * FROM product WHERE id_product = ?");
  $stmt->execute([$id_product]);
  $product = $stmt->fetch();
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
        <div class="col-sm-6 col-md-6 col-lg-6">
          <div class="detail-box">
            <h5><?= $product['title'] ?></h5>
            <h6><?= $product['price'] ?>€</h6>
            <span><?= $product['reference'] ?></span><br>
            <span><?= $product['color'] ?></spam><br>
            <span><?= $product['public'] ?></spam><br>
            <span><?= $product['size'] ?></spam><br>
            <span><?= $product['description'] ?></spam>
          </div>
        </div>
      </div>
      <div class="btn-box">
        <a href=""> View All products </a>
      </div>
    </div>
  </section>
  <!-- end product section -->
<?php
require_once('include/footer.php');
?>