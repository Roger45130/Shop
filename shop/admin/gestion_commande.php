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

// Récupération des commandes depuis la table `order`
$data = $connect_db->query("SELECT * FROM `order`");
$commande = $data->fetchAll(PDO::FETCH_ASSOC);
$nbCommandes = $data->rowCount();

// Récupération des utilisateurs pour associer les ID utilisateur aux commandes
$usersData = $connect_db->query("SELECT id_user, lastName FROM `user`");
$users = $usersData->fetchAll(PDO::FETCH_KEY_PAIR);

// Récupération des détails des commandes
$orderDetails = [];
foreach ($commande as $order) {
  $orderId = $order['id_order'];
  $detailsQuery = $connect_db->prepare("SELECT product_id, quantity FROM `order_details` WHERE order_id = ?");
  $detailsQuery->execute([$orderId]);
  $orderDetails[$orderId] = $detailsQuery->fetchAll(PDO::FETCH_ASSOC);
}

require_once('include/header.php');
?>
<section class="section is-title-bar">
  <div class="level">
    <div class="level-left">
      <div class="level-item">
        <ul>
          <li>Admin</li>
          <li>Commandes</li>
        </ul>
      </div>
    </div>
    <!-- <div class="level-right">
            <div class="level-item">
              <div class="buttons is-right">
                <a
                  href="https://github.com/vikdiesel/admin-one-bulma-dashboard"
                  target="_blank"
                  class="button is-primary"
                >
                  <span class="icon"
                    ><i class="mdi mdi-github-circle"></i
                  ></span>
                  <span>GitHub</span>
                </a>
              </div>
            </div>
          </div> -->
  </div>
</section>
<section class="section is-main-section">
  <div class="notification is-primary">
    <button class="delete"></button>
    Lorem ipsum, dolor sit amet consectetur adipisicing elit.
  </div>
  <div class="card has-table">
    <header class="card-header">
      <p class="card-header-title">
        <span class="icon"><span class="mdi mdi-cart-outline"></span>
        </span>

      </p>
      <a href="#" class="card-header-icon">
        <span class="icon"><i class="mdi mdi-reload"></i></span>
      </a>
    </header>
    <div class="card-content">
      <div class="b-table has-pagination">
        <div class="table-wrapper has-mobile-cards">
          <table class="table is-fullwidth is-striped is-hoverable is-fullwidth">
            <thead>
              <tr>
                <?php
                foreach (array_keys($commande[0]) as $columnName):
                  echo "<th>" . ucfirst($columnName) . "</th>";
                endforeach;
                ?>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($commande as $order): ?>
                <tr>
                  <?php foreach ($order as $key => $value): ?>
                    <td>
                      <?php
                      if ($key == 'user_id' && isset($users[$value])) {
                        echo htmlspecialchars($users[$value]);
                      } elseif ($key == 'date') {
                        echo date("d/m/Y", strtotime($value));
                      } elseif ($key == 'status') {
                        echo ($value == 'treatment') ? 'Traitement en cours' : (($value == 'sent') ? 'Envoyé' : (($value == 'delivered') ? 'Délivré' : htmlspecialchars($value)));
                      } else {
                        echo htmlspecialchars($value);
                      }
                      ?>
                    </td>
                  <?php endforeach; ?>
                  <td class="is-actions-cell">
                    <div class="buttons is-right">
                      <button class="button is-small is-primary" type="button">
                        <span class="icon"><i class="mdi mdi-eye"></i></span>
                      </button>
                      <button class="button is-small is-danger jb-modal" data-target="sample-modal" type="button">
                        <span class="icon"><i class="mdi mdi-trash-can"></i></span>
                      </button>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <!-- <div class="notification">
                <div class="level">
                  <div class="level-left">
                    <div class="level-item">
                      <div class="buttons has-addons">
                        <button type="button" class="button is-active">
                          1
                        </button>
                        <button type="button" class="button">2</button>
                        <button type="button" class="button">3</button>
                      </div>
                    </div>
                  </div>
                  <div class="level-right">
                    <div class="level-item">
                      <small>Page 1 of 3</small>
                    </div>
                  </div>
                </div>
              </div> -->
      </div>
    </div>
  </div>
</section>

<?php if (isset($_POST['selected_order'])):
  $selectedOrderId = $_POST['selected_order'];
  $productsQuery = $connect_db->prepare("SELECT product.reference, product.title, product.size, product.picture, order_details.quantity, product.price FROM `order_details` JOIN `product` ON order_details.product_id = product.id_product WHERE order_details.order_id = ?");
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


<section class="section is-main-section">
  <div class="card">
    <header class="card-header">
      <p class="card-header-title">
        <span class="icon"><i class="mdi mdi-ballot"></i></span>
        Modification commande
      </p>
    </header>
    <div class="card-content">
      <!-- enctype="multitpart/form-data" : permet de récupérer en php les données d'un fichier uploadé -->
      <form method="post" enctype="multipart/form-data">
        <div class="field is-horizontal">
          <div class="field-label is-normal">
            <label class="label">Réference / Catégorie</label>
          </div>
          <div class="field-body">
            <div class="field">
              <input class="input" type="text" name="reference" placeholder="Entrer une référence produit" value="<?php if (isset($currentProduct['reference'])) echo $currentProduct['reference']; ?>" />
            </div>
            <div class="field">
              <input class="input" type="text" name="category" placeholder="Entrer une catégorie produit" value="<?php if (isset($currentProduct['category'])) echo $currentProduct['category']; ?>" />
            </div>
          </div>
        </div>

        <div class="field is-horizontal">
          <div class="field-label is-normal">
            <label class="label">Titre / Couleur</label>
          </div>
          <div class="field-body">
            <div class="field">
              <input class="input" type="text" name="title" placeholder="Entrer un titre produit" value="<?php if (isset($currentProduct['title'])) echo $currentProduct['title']; ?>" />
            </div>
            <div class="field">
              <input class="input" type="text" name="color" placeholder="Entrer une couleur produit" value="<?php if (isset($currentProduct['color'])) echo $currentProduct['color']; ?>" />
            </div>
          </div>
        </div>

        <div class="field is-horizontal">
          <div class="field-label is-normal">
            <label class="label">Taille / Genre</label>
          </div>
          <div class="field-body">
            <div class="field is-narrow">
              <div class="control">
                <div class="select is-fullwidth">
                  <select name="size">
                    <option value="S">S</option>

                    <option value="M" <?php if (isset($currentProduct['size']) && $currentProduct['size'] == 'M') echo 'selected' ?>>M</option>

                    <option value="L" <?php if (isset($currentProduct['size']) && $currentProduct['size'] == 'L') echo 'selected' ?>>L</option>

                    <option value="XL" <?php if (isset($currentProduct['size']) && $currentProduct['size'] == 'XL') echo 'selected' ?>>XL</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="field is-narrow">
              <div class="control">
                <div class="select is-fullwidth">
                  <select name="public">
                    <option value="homme">Homme</option>

                    <option value="femme" <?php if (isset($currentProduct['public']) && $currentProduct['public'] == 'femme') echo 'selected' ?>>Femme</option>

                    <option value="mixte" <?php if (isset($currentProduct['public']) && $currentProduct['public'] == 'mixte') echo 'selected' ?>>Mixte</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="field is-horizontal">
          <div class="field-label is-normal">
            <label class="label">Photo produit</label>
          </div>
          <div class="field-body">
            <div class="field">
              <div class="file has-name">
                <label class="file-label">
                  <input class="file-input" type="file" name="picture" />
                  <span class="file-cta">
                    <!-- <span class="file-icon">
                          <i class="fas fa-upload"></i>
                        </span> -->
                    <span class="file-label">Choisir un fichier</span>
                  </span>
                  <span class="file-name">Parcourir</span>
                </label>
              </div>
              <?php if (isset($errorPicture)) echo $errorPicture; ?>
            </div>
          </div>
        </div>
        <input type="hidden" name="current_picture" value="<?php if (isset($currentProduct['picture'])) echo $currentProduct['picture'] ?>">

        <?php if (isset($currentProduct['picture']) && !empty($currentProduct['picture'])): ?>

          <div class="field is-horizontal">
            <div class="field-label is-normal">
              <label class="label">Photo actuelle</label>
            </div>
            <div class="field-body">
              <div class="field">
                <img src="<?= $currentProduct['picture'] ?>" class="picture__product" alt="<?php if (isset($currentProduct['title'])) echo $currentProduct['title']; ?>">
              </div>
            </div>
          </div>

        <?php endif; ?>

        <div class="field is-horizontal">
          <div class="field-label is-normal">
            <label class="label">Description</label>
          </div>
          <div class="field-body">
            <div class="field">
              <div class="control">
                <textarea
                  class="textarea"
                  name="description"
                  placeholder="Entrer une description du produit"><?php if (isset($currentProduct['description'])) echo $currentProduct['description'] ?></textarea>
              </div>
            </div>
          </div>
        </div>

        <div class="field is-horizontal">
          <div class="field-label is-normal">
            <label class="label">Prix / Stock</label>
          </div>
          <div class="field-body">
            <div class="field">
              <input class="input" type="text" name="price" placeholder="Entrer un prix produit" value="<?php if (isset($currentProduct['price'])) echo $currentProduct['price']; ?>" />
            </div>
            <div class="field">
              <input class="input" type="text" name="stock" placeholder="Entrer un stock produit" value="<?php if (isset($currentProduct['stock'])) echo $currentProduct['stock']; ?>" />
            </div>
          </div>
        </div>

        <!-- <div class="field is-horizontal">
              <div class="field-label">
                <label class="label">Switch</label>
              </div>
              <div class="field-body">
                <div class="field">
                  <label class="switch is-rounded"><input type="checkbox" value="false" />
                    <span class="check"></span>
                    <span class="control-label">Default</span>
                  </label>
                </div>
              </div>
            </div> -->
        <hr />
        <div class="field is-horizontal">
          <div class="field-label">
            <!-- Left empty for spacing -->
          </div>
          <div class="field-body">
            <div class="field">
              <div class="field is-grouped">
                <div class="control">
                  <button type="submit" name="submit" class="button is-primary">
                    <span>Enregistrer</span>
                  </button>
                </div>
                <!-- <div class="control">
                      <button
                        type="button"
                        class="button is-primary is-outlined">
                        <span>Reset</span>
                      </button>
                    </div> -->
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>


<?php
require_once('include/footer.php');
if ($_SESSION['msg'] == false) {
  unset($_SESSION['msgValidation']);
}
?>