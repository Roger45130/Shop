<?php
require_once('../include/init.php');

$connect_db = new PDO('mysql:host=localhost;dbname=shop;charset=utf8', 'root', '');
$connect_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Si l'utilisateur n'est pas connecté ou est connecté mais non admin, on le redirige vers la page index.php
if (!adminConnected()) {
  header('location: ' . URL . 'index.php');
  exit();
}

// Traitement des formulaires
$editing = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['update_role'])) {
    $userId = $_POST['user_id'];
    $newRole = $_POST['roles'];
    // Mise à jour du rôle dans la base de données
    $updateQuery = $connect_db->prepare("UPDATE `user` SET roles = ? WHERE id_user = ?");
    $updateQuery->execute([$newRole, $userId]);
    $editing = false;
  } elseif (isset($_POST['edit_user'])) {
    $editing = true;
    $editUserId = $_POST['edit_user'];
    $stmt = $connect_db->prepare("SELECT roles FROM `user` WHERE id_user = ?");
    $stmt->execute([$editUserId]);
    $userToEdit = $stmt->fetch(PDO::FETCH_ASSOC);
    $currentRole = $userToEdit['roles'];
  }
}

// Récupération des utilisateurs ayant le rôle "user"
$usersData = $connect_db->prepare("SELECT id_user, password, firstName, lastName, email, address, zipcode, city, roles FROM `user` WHERE roles = ?");
$usersData->execute(['user']);
$users = $usersData->fetchAll(PDO::FETCH_ASSOC);
$userCount = count($users);

// Récupération des utilisateurs ayant le rôle "admin"
$adminsData = $connect_db->prepare("SELECT id_user, password, firstName, lastName, email, address, zipcode, city, roles FROM `user` WHERE roles = ?");
$adminsData->execute(['admin']);
$admins = $adminsData->fetchAll(PDO::FETCH_ASSOC);
$adminCount = count($admins);

require_once('include/header.php');
?>
<section class="section is-title-bar">
  <div class="level">
    <div class="level-left">
      <div class="level-item">
        <ul>
          <li>Admin</li>
          <li>Utilisateurs</li>
        </ul>
      </div>
    </div>
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
        <span class="icon"><i class="mdi mdi-account-multiple"></i></span>
        Clients (<?= $userCount ?> users)
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
                <th>Id</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Adresse</th>
                <th>Code Postal</th>
                <th>Ville</th>
                <th>Rôle</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($users as $user): ?>
                <tr>
                  <td><?= htmlspecialchars($user['id_user']) ?></td>
                  <td><?= htmlspecialchars($user['firstName']) ?></td>
                  <td><?= htmlspecialchars($user['lastName']) ?></td>
                  <td><?= htmlspecialchars($user['email']) ?></td>
                  <td><?= htmlspecialchars($user['address']) ?></td>
                  <td><?= htmlspecialchars($user['zipcode']) ?></td>
                  <td><?= htmlspecialchars($user['city']) ?></td>
                  <td><?= htmlspecialchars($user['roles']) ?></td>
                  <td class="is-actions-cell">
                    <div class="buttons is-right">
                      <form method="post">
                        <input type="hidden" name="edit_user" value="<?= htmlspecialchars($user['id_user']) ?>">
                        <button class="button is-small is-primary" type="submit">
                          <span class="icon"><i class="mdi mdi-pencil mdi-18px"></i></span>
                        </button>
                      </form>
                    </div>
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

<section class="section is-main-section">
  <div class="card has-table">
    <header class="card-header">
      <p class="card-header-title">
        <span class="icon"><i class="mdi mdi-account-multiple"></i></span>
        Administrateurs (<?= $adminCount ?> admins)
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
                <th>Id</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Adresse</th>
                <th>Code Postal</th>
                <th>Ville</th>
                <th>Rôle</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($admins as $admin): ?>
                <tr>
                  <td><?= htmlspecialchars($admin['id_user']) ?></td>
                  <td><?= htmlspecialchars($admin['firstName']) ?></td>
                  <td><?= htmlspecialchars($admin['lastName']) ?></td>
                  <td><?= htmlspecialchars($admin['email']) ?></td>
                  <td><?= htmlspecialchars($admin['address']) ?></td>
                  <td><?= htmlspecialchars($admin['zipcode']) ?></td>
                  <td><?= htmlspecialchars($admin['city']) ?></td>
                  <td><?= htmlspecialchars($admin['roles']) ?></td>
                  <td class="is-actions-cell">
                    <div class="buttons is-right">
                      <form method="post">
                        <input type="hidden" name="edit_user" value="<?= htmlspecialchars($admin['id_user']) ?>">
                        <button class="button is-small is-primary" type="submit">
                          <span class="icon"><i class="mdi mdi-pencil mdi-18px"></i></span>
                        </button>
                      </form>
                    </div>
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

<?php if ($editing): ?>
  <section class="section is-main-section">
    <div class="card">
      <header class="card-header">
        <p class="card-header-title">
          <span class="icon"><i class="mdi mdi-ballot"></i></span>
          Modification utilisateur
        </p>
      </header>
      <form method="post">
        <input type="hidden" name="user_id" value="<?= htmlspecialchars($editUserId) ?>">
        <div class="field-body">
          <div class="field is-narrow">
            <div class="control">
              <div class="select is-fullwidth">
                <select name="roles">
                  <option value="user" <?= (isset($currentRole) && $currentRole == 'user') ? 'selected' : '' ?>>user</option>
                  <option value="admin" <?= (isset($currentRole) && $currentRole == 'admin') ? 'selected' : '' ?>>admin</option>
                </select>
              </div>
            </div>
          </div>
          <hr />
          <div class="field is-horizontal">
            <div class="field-label">
            </div>
            <div class="field-body">
              <div class="field">
                <div class="field is-grouped">
                  <div class="control">
                    <button type="submit" name="update_role" class="button is-primary">
                      <span>Valider</span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </section>
<?php endif; ?>

<?php
require_once('include/footer.php');
?>