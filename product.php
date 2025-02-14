<?php
require_once('include/init.php');

/*
  Exercice : Afficher les produits stockés en BDD.
  1.  Sélectionner l'ensemble de la table product.
  2.  Excécuter une méthode (fetch / fetchAll) pour rendre le résultat exploitable sous forme d'Array.
  3.  Traitement pour l'affichage (boucle).
  4.  Prévoir un lien qui redirige vers la page fiche_produit.php pour chaque produit, avec envoi de l'id_product dans l'url.
*/

//  Récupérer la BDD
$pdo = new PDO('mysql:host=localhost;dbname=shop;charset=utf8', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

//  Sélectionner l'ensemble des Produits qui se trouve dans la BDD
$query = $pdo->query("SELECT * FROM product");

//  Exécuter une méthode fetchAll() pour récupérer les données sous forme d'Array
$products = $query->fetchAll();

require_once('include/header.php');
?>

<!-- inner page section -->
<section class="inner_page_head">
  <div class="container_fuild">
      <div class="row">
          <div class="col-md-12">
              <div class="full">
                  <h3>Grille de produits</h3>
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
          <h2>Nos <span>produits</span></h2>
      </div>
      <div class="row">
          <?php 
          //  Traitement pour l'affichage des produits dans une boucle
          foreach ($products as $product) : ?>
              <div class="col-sm-6 col-md-4 col-lg-3">
                  <div class="box">
                      <div class="option_container">
                          <div class="options">
                              <a href="fiche_produit.php?id_product=<?= $product['id_product'] ?>" class="option1">
                                  <?= $product['title'] ?>
                              </a>
                              <a href="panier.php?ajout=<?=$product['id_product'] ?>" class="option2">
                                  Acheter maintenant
                              </a>
                          </div>
                      </div>
                      <div class="img-box">
                          <img src= "<?= $product['picture'] ?>" alt="<?= $product['title'] ?>" />
                      </div>
                      <div class="detail-box">
                          <h5><?= $product['title'] ?></h5>
                          <h6><?= $product['price'] ?>€</h6>
                      </div>
                  </div>
              </div>
          <?php endforeach; ?>
      </div>
      <div class="btn-box">
          <a href="produits.php"> Voir tous les produits </a>
      </div>
  </div>
</section>
<!-- end product section -->

<?php require_once('include/footer.php'); ?>