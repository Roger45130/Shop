<?php
require_once('../include/init.php');

// Connexion à la base de données `shop`
$connect_db = new PDO('mysql:host=localhost;dbname=shop;charset=utf8', 'root', '');
$connect_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Vérification si l'utilisateur est admin
if (!adminConnected()) {
  header('location: ' . URL . 'index.php');
  exit();
}

// Vérifier si la colonne 'state' existe avant de faire une mise à jour
$columnExists = $connect_db->query("SHOW COLUMNS FROM `order` LIKE 'state'")->rowCount();
if ($columnExists === 0) {
  die("Erreur : La colonne 'state' n'existe pas dans la table `order`.");
}

// Mise à jour du statut de la commande
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_state'])) {
  $orderId = $_POST['order_id'];
  $newState = $_POST['state'];

  // Vérifier si la commande existe avant de faire la mise à jour
  $checkOrder = $connect_db->prepare("SELECT id_order FROM `order` WHERE id_order = ?");
  $checkOrder->execute([$orderId]);

  if ($checkOrder->rowCount() > 0) {
    $updateQuery = $connect_db->prepare("UPDATE `order` SET state = ? WHERE id_order = ?");
    $updateQuery->execute([$newState, $orderId]);
  } else {
    die("Erreur : La commande sélectionnée n'existe pas.");
  }
}

// Récupération des commandes depuis la table `order`
$commandesData = $connect_db->query("SELECT * FROM `order`");
$commande = $commandesData->fetchAll(PDO::FETCH_ASSOC);
$nbCommandes = count($commande);

// Récupération des utilisateurs pour associer les ID utilisateur aux commandes
$usersData = $connect_db->query("SELECT id_user, lastName FROM `user`");
$users = $usersData->fetchAll(PDO::FETCH_KEY_PAIR);

require_once('include/header.php');
?>

<section class="section is-main-section">
  <div class="card has-table">
    <header class="card-header">
      <p class="card-header-title">
        <span class="icon"><span class="mdi mdi-cart-outline"></span></span>
        Commandes (<?= $nbCommandes ?> commandes)
      </p>
    </header>
    <div class="card-content">
      <div class="b-table has-pagination">
        <div class="table-wrapper has-mobile-cards">
          <table class="table is-fullwidth is-striped is-hoverable is-fullwidth">
            <thead>
              <tr>
                <th>ID Commande</th>
                <th>Client</th>
                <th>Date</th>
                <th>Etats</th>
                <th>Total</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($commande as $order): ?>
                <tr>
                  <td><?= htmlspecialchars($order['id_order']) ?></td>
                  <td><?= htmlspecialchars($users[$order['user_id']] ?? 'Inconnu') ?></td>
                  <td><?= date("d/m/Y", strtotime($order['date'])) ?></td>
                  <td>
                    <form method="post">
                      <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['id_order']) ?>">
                      <div class="field-body">
                        <div class="field is-narrow">
                          <div class="control">
                            <div class="select is-fullwidth">
                              <?php
                              // Vérification de l'existence de la clé 'state' pour éviter les erreurs
                              $state = $order['state'] ?? 'treatment';
                              ?>
                              <select name="state">
                                <option value="treatment" <?= ($state == 'treatment') ? 'selected' : '' ?>>Traitement en cours</option>
                                <option value="sent" <?= ($state == 'sent') ? 'selected' : '' ?>>Envoyé</option>
                                <option value="delivered" <?= ($state == 'delivered') ? 'selected' : '' ?>>Livré</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="field is-horizontal">
                          <div class="field-body">
                            <div class="field">
                              <div class="field is-grouped">
                                <div class="control">
                                  <button type="submit" name="update_state" class="button is-primary">
                                    <span>Valider</span>
                                  </button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </td>
                  <td><?= htmlspecialchars($order['rising']) ?> €</td>
                  <td>
                    <form method="post">
                      <input type="hidden" name="selected_order" value="<?= $order['id_order'] ?>">
                      <button class="button is-small is-primary" type="submit">
                        <span class="icon"><i class="mdi mdi-eye mdi-18px"></i></span>
                      </button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_order'])):
  $selectedOrderId = $_POST['selected_order'];
  $productsQuery = $connect_db->prepare("SELECT p.reference, p.title, p.size, p.picture, od.quantity, p.price FROM `order_details` od JOIN `product` p ON od.product_id = p.id_product WHERE od.order_id = ?");
  $productsQuery->execute([$selectedOrderId]);
  $products = $productsQuery->fetchAll(PDO::FETCH_ASSOC);
  $productCount = count($products);
?>

  <section class="section is-main-section">
    <div class="card has-table">
      <header class="card-header">
        <p class="card-header-title">
          <span class="icon"><span class="mdi mdi-cart-arrow-down"></span></span>
          Détails commande (<?= $productCount ?> articles)
        </p>
      </header>
      <div class="card-content">
        <div class="b-table has-pagination">
          <div class="table-wrapper has-mobile-cards">
            <table class="table is-fullwidth is-striped is-hoverable is-fullwidth">
              <thead>
                <tr>
                  <th>Référence Article</th>
                  <th>Titre</th>
                  <th>Taille</th>
                  <th>Photo</th>
                  <th>Quantité</th>
                  <th>Prix</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($products as $product): ?>
                  <tr>
                    <td><?= htmlspecialchars($product['reference']) ?></td>
                    <td><?= htmlspecialchars($product['title']) ?></td>
                    <td><?= htmlspecialchars($product['size']) ?></td>
                    <td><img src="<?= htmlspecialchars($product['picture']) ?>" width="70px"></td>
                    <td><?= htmlspecialchars($product['quantity']) ?></td>
                    <td><?= htmlspecialchars($product['price']) ?> €</td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>

<?php
require_once('include/footer.php');
if ($_SESSION['msg'] == false) {
  unset($_SESSION['msgValidation']);
}
?>