<?php 
require_once('../include/init.php');

// Si l'utilisateur n'est pas connecté ou est connecté mais non admin, on le redirige vers la page index.php

if(!adminConnected()){
  // header('location: ' . URL . ' index.php');
  //                  http://localhost/PHP/shop/index.php
  header('location: ' . URL . 'index.php');
}

if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] === 'POST'){
  echo '<pre>'; print_r($_FILES); echo '</pre>';
  // echo '<pre>'; print_r($_POST); echo '</pre>';

  // $_FILES est une superglobale permettant de stocker les données d'un fichier uploadé (nom, extension, taile etc...)
  // Si une image a bien été uploadé
  if(!empty($_FILES['picture']['name'])){

    // Contrôle de l'extension
    $currentExtension = ['jpg', 'jpeg', 'png', 'webp'];
    $fileUploaded = new SplFileInfo($_FILES['picture']['name']);
    // echo '<pre>'; print_r($fileUploaded); echo '</pre>';
    // echo '<pre>'; print_r(get_class_methods($fileUploaded)); echo '</pre>';

    $fileUploadedExtension = $fileUploaded->getExtension();
    // echo $fileUploadedExtension;

    //                                      pdf                ['jpg', 'jpeg', 'png', 'webp']
    $positionExtension = array_search($fileUploadedExtension, $currentExtension);
    echo "Position de l'extension : " . $positionExtension . '<br>';

    if($positionExtension === false){
      $errorPicture = "Extension non prise en charge (jpg, jpeg, png, webp)";
    }else{
      // On concatène la référence saisie dans le formulaire avec le nom de l'image
      $pictureName = $_POST['reference'] . '-' . $_FILES['picture']['name'];
      // echo $pictureName . '<br>';

      // On définit l'URL de l'image qui sera stocké en BDD
      // http://localhost/PHP/shop/assets/images-produits/25A45C-p7.png
      $pictureUrlDb = URL . "assets/images-produits/$pictureName";
      // echo $pictureUrlDb . '<br>';

      // <img src="http://localhost/PHP/shop/assets/images-produits/25A45C-p7.png">

      // On définit le chemin physique sur le serveur où sera copié l'image
      // /opt/lampp/htdocs/PHP/shop/assets/images-produits/25A45C-p7.png
      $pictureFolder = RACINE_SITE . "assets/images-produits/$pictureName";
      // echo $pictureFolder;

      // La fonction prédéfinie copy() permet de copier un fichier dans un dossier, 2 arguments:
      // 1. Le nom temporaire de l'image (source de l'image) accessible dans $_FILES
      // 2. Le chemin complet de l'image vers le dossier sur le serveur
      copy($_FILES['picture']['tmp_name'], $pictureFolder);
    }
  }
}

require_once('include/header.php');
?>

    <section class="section is-title-bar">
      <div class="level">
        <div class="level-left">
          <div class="level-item">
            <ul>
              <li>Admin</li>
              <li>Boutique</li>
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
            <span class="icon"><span class="mdi mdi-shopping-outline"></span>
            </span>
            10 produits
          </p>
          <a href="#" class="card-header-icon">
            <span class="icon"><i class="mdi mdi-reload"></i></span>
          </a>
        </header>
        <div class="card-content">
          <div class="b-table has-pagination">
            <div class="table-wrapper has-mobile-cards">
              <table
                class="table is-fullwidth is-striped is-hoverable is-fullwidth">
                <thead>
                  <tr>
                    <th class="is-checkbox-cell">
                      <label class="b-checkbox checkbox">
                        <input type="checkbox" value="false" />
                        <span class="check"></span>
                      </label>
                    </th>
                    <th></th>
                    <th>Name</th>
                    <th>Company</th>
                    <th>City</th>
                    <th>Progress</th>
                    <th>Created</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="is-checkbox-cell">
                      <label class="b-checkbox checkbox">
                        <input type="checkbox" value="false" />
                        <span class="check"></span>
                      </label>
                    </td>
                    <td class="is-image-cell">
                      <div class="image">
                        <img
                          src="https://avatars.dicebear.com/v2/initials/rebecca-bauch.svg"
                          class="is-rounded" />
                      </div>
                    </td>
                    <td data-label="Name">Rebecca Bauch</td>
                    <td data-label="Company">Daugherty-Daniel</td>
                    <td data-label="City">South Cory</td>
                    <td data-label="Progress" class="is-progress-cell">
                      <progress
                        max="100"
                        class="progress is-small is-primary"
                        value="79">
                        79
                      </progress>
                    </td>
                    <td data-label="Created">
                      <small
                        class="has-text-grey is-abbr-like"
                        title="Oct 25, 2020">Oct 25, 2020</small>
                    </td>
                    <td class="is-actions-cell">
                      <div class="buttons is-right">
                        <button
                          class="button is-small is-primary"
                          type="button">
                          <span class="icon"><i class="mdi mdi-eye"></i></span>
                        </button>
                        <button
                          class="button is-small is-danger jb-modal"
                          data-target="sample-modal"
                          type="button">
                          <span class="icon"><i class="mdi mdi-trash-can"></i></span>
                        </button>
                      </div>
                    </td>
                  </tr>
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

    <section class="section is-main-section">
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><span class="mdi mdi-shopping-outline"></span></span>
            Ajout Produit
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
                  <input class="input" type="text" name="reference" placeholder="Entrer une référence produit" />
                </div>
                <div class="field">
                  <input class="input" type="text" name="category" placeholder="Entrer une catégorie produit" />
                </div>
              </div>
            </div>

            <div class="field is-horizontal">
              <div class="field-label is-normal">
                <label class="label">Titre / Couleur</label>
              </div>
              <div class="field-body">
                <div class="field">
                  <input class="input" type="text" name="title" placeholder="Entrer un titre produit" />
                </div>
                <div class="field">
                  <input class="input" type="text" name="color" placeholder="Entrer une couleur produit" />
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
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="field is-narrow">
                  <div class="control">
                    <div class="select is-fullwidth">
                      <select name="public">
                        <option value="homme">Homme</option>
                        <option value="femme">Femme</option>
                        <option value="mixte">Mixte</option>
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
                </div>
              </div>
            </div>

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
                      placeholder="Entrer une description du produit"></textarea>
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
                  <input class="input" type="text" name="price" placeholder="Entrer un prix produit" />
                </div>
                <div class="field">
                  <input class="input" type="text" name="stock" placeholder="Entrer un stock produit" />
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
?>