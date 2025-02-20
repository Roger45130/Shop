<?php
require_once('../include/init.php');

//  Si l'utilisateur n'est pas connecté ou est connecté mais non admin, on le redirige vers la page index.php
if (!adminConnected()) {
  header('location: ' . URL . 'index.php');
}

// Récupération des utilisateurs ayant le rôle "user"
$usersData = $connect_db->prepare("SELECT id_user FROM `user` WHERE roles = ?");
$usersData->execute(['user']);
$nbUsers = $usersData->rowCount();

// Récupération du chiffre d'affaires total en additionnant la colonne `rising`
$salesQuery = $connect_db->query("SELECT SUM(rising) as totalSales FROM `order`");
$salesData = $salesQuery->fetch(PDO::FETCH_ASSOC);
$totalSales = $salesData['totalSales'] ?? 0; // Si NULL, mettre 0

// Calcul de la performance commerciale
$performance = ($nbUsers > 0) ? ($totalSales / $nbUsers) : 0;

// Formater la performance avec 2 décimales
$performanceFormatted = number_format($performance, 2, '.', ',') . ' %';

// Récupération des produits avec un stock inférieur à 10
$productsData = $connect_db->query("SELECT id_product, reference, category, title, size, public, stock FROM `product` WHERE stock < 10");
$products = $productsData->fetchAll(PDO::FETCH_ASSOC);
$nbProducts = count($products);

require_once('include/header.php');
?>
<section class="section is-title-bar">
  <div class="level">
    <div class="level-left">
      <div class="level-item">
        <ul>
          <li>Admin</li>
          <li>Dashboard</li>
        </ul>
      </div>
    </div>
  </div>
</section>
<section class="hero is-hero-bar">
  <div class="hero-body">
    <div class="level">
      <div class="level-left">
        <div class="level-item">
          <h1 class="title">Dashboard</h1>
        </div>
      </div>
      <div class="level-right" style="display: none">
        <div class="level-item"></div>
      </div>
    </div>
  </div>
</section>
<section class="section is-main-section">
  <div class="tile is-ancestor">
    <div class="tile is-parent">
      <div class="card tile is-child">
        <div class="card-content">
          <div class="level is-mobile">
            <div class="level-item">
              <div class="is-widget-label">
                <h3 class="subtitle is-spaced">Clients</h3>
                <h1 class="title"><?= $nbUsers ?></h1>
              </div>
            </div>
            <div class="level-item has-widget-icon">
              <div class="is-widget-icon">
                <span class="icon has-text-primary is-large"><i class="mdi mdi-account-multiple mdi-48px"></i></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="tile is-parent">
      <div class="card tile is-child">
        <div class="card-content">
          <div class="level is-mobile">
            <div class="level-item">
              <div class="is-widget-label">
                <h3 class="subtitle is-spaced">Total des ventes</h3>
                <h1 class="title"><?= number_format($totalSales, 2, '.', ',') ?> €</h1>
              </div>
            </div>
            <div class="level-item has-widget-icon">
              <div class="is-widget-icon">
                <span class="icon has-text-info is-large"><i class="mdi mdi-cart-outline mdi-48px"></i></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="tile is-parent">
      <div class="card tile is-child">
        <div class="card-content">
          <div class="level is-mobile">
            <div class="level-item">
              <div class="is-widget-label">
                <h3 class="subtitle is-spaced">Performance</h3>
                <h1 class="title"><?= $performanceFormatted ?></h1>
              </div>
            </div>
            <div class="level-item has-widget-icon">
              <div class="is-widget-icon">
                <span class="icon has-text-success is-large"><i class="mdi mdi-finance mdi-48px"></i></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="card has-table has-mobile-sort-spaced">
    <header class="card-header">
      <p class="card-header-title">
        <span class="icon"><i class="mdi mdi-account-multiple"></i></span>
        Produits stock insuffisant (<?= $nbProducts ?> inférieur à 10 articles)
      </p>
      <a href="#" class="card-header-icon">
        <span class="icon"><i class="mdi mdi-reload"></i></span>
      </a>
    </header>
    <div class="card-content">
      <div class="b-table has-pagination">
        <div class="table-wrapper has-mobile-cards">
          <table class="table is-fullwidth is-striped is-hoverable is-sortable is-fullwidth">
            <thead>
              <tr>
                <th>Id</th>
                <th>Référence</th>
                <th>Catégorie</th>
                <th>Titre</th>
                <th>Taille</th>
                <th>Public</th>
                <th>Stock</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                  <tr>
                    <td><?= htmlspecialchars($product['id_product']) ?></td>
                    <td><?= htmlspecialchars($product['reference']) ?></td>
                    <td><?= htmlspecialchars($product['category']) ?></td>
                    <td><?= htmlspecialchars($product['title']) ?></td>
                    <td><?= htmlspecialchars($product['size']) ?></td>
                    <td><?= htmlspecialchars($product['public']) ?></td>
                    <td class="has-text-danger"><?= htmlspecialchars($product['stock']) ?></td>
                    <td class="is-actions-cell">
                      <div class="buttons is-center">
                        <a href="gestion_boutique.php">
                          <button class="button is-small is-primary" type="button">
                            <span class="icon"><i class="mdi mdi-cart-plus mdi-18px"></i></span>
                          </button>
                        </a>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="7" class="has-text-centered has-text-grey">Aucun produit avec un stock insuffisant.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
require_once('include/footer.php');
?>