<?php
require_once('include/init.php');

// Sélectionner 4 produits aléatoires qui se trouvent dans la BDD
$query = $connect_db->query("SELECT * FROM product ORDER BY RAND() LIMIT 4");
// Exécuter une méthode fetchAll() pour récupérer les données sous forme d'Array
$products = $query->fetchAll(PDO::FETCH_ASSOC);

require_once('include/header.php');
?>

<!-- slider section -->
<section class="slider_section">
  <div class="slider_bg_box">
    <img src="assets/images-famma/slider-bg.jpg" alt="" />
  </div>
  <div id="customCarousel1" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <div class="container">
          <div class="row">
            <div class="col-md-7 col-lg-6">
              <div class="detail-box">
                <h1>
                  <span> Vente 20% de réduction </span>
                  <br />
                  Sur tout
                </h1>
                <p>
                  Explicabo esse amet tempora quibusdam laudantium,
                  laborum eaque magnam fugiat hic? Esse dicta aliquid
                  error repudiandae earum suscipit fugiat molestias,
                  veniam, vel architecto veritatis delectus repellat modi
                  impedit sequi.
                </p>
                <div class="btn-box">
                  <a href="product.php">Voir tous les produits</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <div class="container">
          <div class="row">
            <div class="col-md-7 col-lg-6">
              <div class="detail-box">
                <h1>
                  <span> Vente 20% de réduction </span>
                  <br />
                  Sur tout
                </h1>
                <p>
                  Explicabo esse amet tempora quibusdam laudantium,
                  laborum eaque magnam fugiat hic? Esse dicta aliquid
                  error repudiandae earum suscipit fugiat molestias,
                  veniam, vel architecto veritatis delectus repellat modi
                  impedit sequi.
                </p>
                <div class="btn-box">
                  <a href="product.php">Voir tous les produits</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <div class="container">
          <div class="row">
            <div class="col-md-7 col-lg-6">
              <div class="detail-box">
                <h1>
                  <span> Vente 20% de réduction </span>
                  <br />
                  Sur tout
                </h1>
                <p>
                  Explicabo esse amet tempora quibusdam laudantium,
                  laborum eaque magnam fugiat hic? Esse dicta aliquid
                  error repudiandae earum suscipit fugiat molestias,
                  veniam, vel architecto veritatis delectus repellat modi
                  impedit sequi.
                </p>
                <div class="btn-box">
                  <a href="product.php">Voir tous les produits</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <ol class="carousel-indicators">
        <li data-target="#customCarousel1" data-slide-to="0" class="active"></li>
        <li data-target="#customCarousel1" data-slide-to="1"></li>
        <li data-target="#customCarousel1" data-slide-to="2"></li>
      </ol>
    </div>
  </div>
</section>
<!-- end slider section -->
</div>
<!-- why section -->
<section class="why_section layout_padding">
  <div class="container">
    <div class="heading_container heading_center">
      <h2>Pourquoi acheter avec nous</h2>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="box">
          <div class="img-box">
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background: new 0 0 512 512" xml:space="preserve">
              <g>
                <g>
                  <path d="M476.158,231.363l-13.259-53.035c3.625-0.77,6.345-3.986,6.345-7.839v-8.551c0-18.566-15.105-33.67-33.67-33.67h-60.392
                    V110.63c0-9.136-7.432-16.568-16.568-16.568H50.772c-9.136,0-16.568,7.432-16.568,16.568V256c0,4.427,3.589,8.017,8.017,8.017
                    c4.427,0,8.017-3.589,8.017-8.017V110.63c0-0.295,0.239-0.534,0.534-0.534h307.841c0.295,0,0.534,0.239,0.534,0.534v145.372
                    c0,4.427,3.589,8.017,8.017,8.017c4.427,0,8.017-3.589,8.017-8.017v-9.088h94.569c0.008,0,0.014,0.002,0.021,0.002
                    c0.008,0,0.015-0.001,0.022-0.001c11.637,0.008,21.518,7.646,24.912,18.171h-24.928c-4.427,0-8.017,3.589-8.017,8.017v17.102
                    c0,13.851,11.268,25.119,25.119,25.119h9.086v35.273h-20.962c-6.886-19.883-25.787-34.205-47.982-34.205
                    s-41.097,14.322-47.982,34.205h-3.86v-60.393c0-4.427-3.589-8.017-8.017-8.017c-4.427,0-8.017,3.589-8.017,8.017v60.391H192.817
                    c-6.886-19.883-25.787-34.205-47.982-34.205s-41.097,14.322-47.982,34.205H50.772c-0.295,0-0.534-0.239-0.534-0.534v-17.637
                    h34.739c4.427,0,8.017-3.589,8.017-8.017s-3.589-8.017-8.017-8.017H8.017c-4.427,0-8.017,3.589-8.017,8.017
                    s3.589,8.017,8.017,8.017h26.188v17.637c0,9.136,7.432,16.568,16.568,16.568h43.304c-0.002,0.178-0.014,0.355-0.014,0.534
                    c0,27.996,22.777,50.772,50.772,50.772s50.772-22.776,50.772-50.772c0-0.18-0.012-0.356-0.014-0.534h180.67
                    c-0.002,0.178-0.014,0.355-0.014,0.534c0,27.996,22.777,50.772,50.772,50.772c27.995,0,50.772-22.776,50.772-50.772
                    c0-0.18-0.012-0.356-0.014-0.534h26.203c4.427,0,8.017-3.589,8.017-8.017v-85.511C512,251.989,496.423,234.448,476.158,231.363z
                    M375.182,144.301h60.392c9.725,0,17.637,7.912,17.637,17.637v0.534h-78.029V144.301z M375.182,230.881v-52.376h71.235
                    l13.094,52.376H375.182z M144.835,401.904c-19.155,0-34.739-15.583-34.739-34.739s15.584-34.739,34.739-34.739
                    c19.155,0,34.739,15.583,34.739,34.739S163.99,401.904,144.835,401.904z M427.023,401.904c-19.155,0-34.739-15.583-34.739-34.739
                    s15.584-34.739,34.739-34.739c19.155,0,34.739,15.583,34.739,34.739S446.178,401.904,427.023,401.904z M495.967,299.29h-9.086
                    c-5.01,0-9.086-4.076-9.086-9.086v-9.086h18.171V299.29z" />
                </g>
              </g>
              <g>
                <g>
                  <path d="M144.835,350.597c-9.136,0-16.568,7.432-16.568,16.568c0,9.136,7.432,16.568,16.568,16.568
                    c9.136,0,16.568-7.432,16.568-16.568C161.403,358.029,153.971,350.597,144.835,350.597z" />
                </g>
              </g>
              <g>
                <g>
                  <path d="M427.023,350.597c-9.136,0-16.568,7.432-16.568,16.568c0,9.136,7.432,16.568,16.568,16.568
                    c9.136,0,16.568-7.432,16.568-16.568C443.591,358.029,436.159,350.597,427.023,350.597z" />
                </g>
              </g>
              <g>
                <g>
                  <path d="M332.96,316.393H213.244c-4.427,0-8.017,3.589-8.017,8.017s3.589,8.017,8.017,8.017H332.96
                    c4.427,0,8.017-3.589,8.017-8.017S337.388,316.393,332.96,316.393z" />
                </g>
              </g>
              <g>
                <g>
                  <path d="M127.733,282.188H25.119c-4.427,0-8.017,3.589-8.017,8.017s3.589,8.017,8.017,8.017h102.614
                    c4.427,0,8.017-3.589,8.017-8.017S132.16,282.188,127.733,282.188z" />
                </g>
              </g>
              <g>
                <g>
                  <path d="M278.771,173.37c-3.13-3.13-8.207-3.13-11.337,0.001l-71.292,71.291l-37.087-37.087c-3.131-3.131-8.207-3.131-11.337,0
                    c-3.131,3.131-3.131,8.206,0,11.337l42.756,42.756c1.565,1.566,3.617,2.348,5.668,2.348s4.104-0.782,5.668-2.348l76.96-76.96
                    C281.901,181.576,281.901,176.501,278.771,173.37z" />
                </g>
              </g>
              <g></g>
              <g></g>
              <g></g>
              <g></g>
              <g></g>
              <g></g>
              <g></g>
              <g></g>
              <g></g>
              <g></g>
              <g></g>
              <g></g>
              <g></g>
              <g></g>
              <g></g>
            </svg>
          </div>
          <div class="detail-box">
            <h5>Livraison rapide</h5>
            <p>variations de passages de Lorem Ipsum disponibles</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="box">
          <div class="img-box">
            <svg id="_30_Premium" height="512" viewBox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg" data-name="30_Premium">
              <g id="filled">
                <path d="m252.92 300h3.08a124.245 124.245 0 1 0 -4.49-.09c.075.009.15.023.226.03.394.039.789.06 1.184.06zm-96.92-124a100 100 0 1 1 100 100 100.113 100.113 0 0 1 -100-100z" />
                <path d="m447.445 387.635-80.4-80.4a171.682 171.682 0 0 0 60.955-131.235c0-94.841-77.159-172-172-172s-172 77.159-172 172c0 73.747 46.657 136.794 112 161.2v158.8c-.3 9.289 11.094 15.384 18.656 9.984l41.344-27.562 41.344 27.562c7.574 5.4 18.949-.7 18.656-9.984v-70.109l46.6 46.594c6.395 6.789 18.712 3.025 20.253-6.132l9.74-48.724 48.725-9.742c9.163-1.531 12.904-13.893 6.127-20.252zm-339.445-211.635c0-81.607 66.393-148 148-148s148 66.393 148 148-66.393 148-148 148-148-66.393-148-148zm154.656 278.016a12 12 0 0 0 -13.312 0l-29.344 19.562v-129.378a172.338 172.338 0 0 0 72 0v129.38zm117.381-58.353a12 12 0 0 0 -9.415 9.415l-6.913 34.58-47.709-47.709v-54.749a171.469 171.469 0 0 0 31.467-15.6l67.151 67.152z" />
              </g>
            </svg>
          </div>
          <div class="detail-box">
            <h5>Meilleure qualité</h5>
            <p>variations de passages de Lorem Ipsum disponibles</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- end why section -->

<!-- arrival section -->
<section class="arrival_section">
  <div class="container">
    <div class="box">
      <div class="arrival_bg_box">
        <img src="assets/images-famma/arrival-bg.png" alt="" />
      </div>
      <div class="row">
        <div class="col-md-6 ml-auto" style="z-index: 1000">
          <div class="heading_container remove_line_bt">
            <h2>Nouveautés</h2>
          </div>
          <p style="margin-top: 20px; margin-bottom: 30px">
            Vitae fugiat laboriosam officia perferendis provident aliquid
            voluptatibus dolorem, fugit ullam sit earum id eaque nisi hic?
            Tenetur commodi, nisi rem vel, ea eaque ab ipsa, autem similique
            ex unde!
          </p>
          <div class="btn-box">
            <a href="product.php">Voir tous les produits</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- end arrival section -->

<!-- product section -->
<section class="product_section layout_padding">
  <div class="container">
    <div class="heading_container heading_center">
      <h2>Nos <span>produits</span></h2>
    </div>
    <div class="row">
      <?php foreach ($products as $product) : ?>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="box">
          <div class="option_container">
            <div class="options">
              <a href="fiche_produit.php?id=<?= $product['id_product'] ?>" class="option1">
                <?= $product['title'] ?>
              </a>
              <a href="panier.php?ajout=<?= $product['id_product'] ?>" class="option2">
                Acheter maintenant
              </a>
            </div>
          </div>
          <div class="img-box">
            <img src="<?= $product['picture'] ?>" alt="<?= $product['title'] ?>" />
          </div>
          <div class="detail-box">
            <h5><?= $product['title'] ?></h5>
            <h6><?= $product['price'] ?> €</h6>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="btn-box">
      <a href="product.php">Voir tous les produits</a>
    </div>
  </div>
</section>
<!-- end product section -->

<!-- subscribe section -->
<section class="subscribe_section">
  <div class="container-fuild">
    <div class="box">
      <div class="row">
        <div class="col-md-6 offset-md-3">
          <div class="subscribe_form">
            <div class="heading_container heading_center">
              <h3>Abonnez-vous pour obtenir des offres de réduction</h3>
            </div>
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
              do eiusmod tempor
            </p>
            <form action="">
              <input type="email" placeholder="Enter your email" />
              <button>s'abonner</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- end subscribe section -->

<!-- client section -->
<section class="client_section layout_padding">
  <div class="container">
    <div class="heading_container heading_center">
      <h2>Témoignage des clients</h2>
    </div>
    <div id="testimonialCarousel" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
        <?php
        // Récupérer tous les témoignages en joignant la table user pour obtenir firstName et lastName
        $stmt = $connect_db->prepare("SELECT t.*, u.firstName, u.lastName FROM testimonial t JOIN user u ON t.user_id = u.id_user ORDER BY t.date DESC");
        $stmt->execute();
        $testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $active = 'active';
        foreach ($testimonials as $testimonial):
          // Formater la date au format français
          $dateFr = date("d/m/Y", strtotime($testimonial['date']));
          // Calculer le nombre d'étoiles pleines et vides pour la notation
          $fullStars = (int)$testimonial['icon'];
          $emptyStars = 5 - $fullStars;
        ?>
        <div class="carousel-item <?= $active ?>">
          <div class="detail-box">
            <h5><?= ($testimonial['firstName']) . ' ' . ($testimonial['lastName']) ?></h5>
            <h6><?= $dateFr ?></h6>
            <p><?= ($testimonial['message']) ?></p>
            <div class="star-rating">
              <?php
              for ($i = 0; $i < $fullStars; $i++) {
                echo '<i class="fa-solid fa-star" style="color: orange; font-size:24px;"></i>';
              }
              for ($i = 0; $i < $emptyStars; $i++) {
                echo '<i class="fa-regular fa-star" style="color: orange; font-size:24px;"></i>';
              }
              ?>
            </div>
          </div>
        </div>
        <?php
        $active = '';
        endforeach;
        ?>
      </div>
      <!-- <div class="carousel_btn_box">
        <a class="carousel-control-prev" href="#testimonialCarousel" role="button" data-slide="prev">
          <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#testimonialCarousel" role="button" data-slide="next">
          <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
          <span class="sr-only">Next</span>
        </a>
      </div> -->
    </div>
  </div>
</section>
<!-- end client section -->

<?php
require_once('include/footer.php');
?>
