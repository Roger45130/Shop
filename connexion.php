<?php
require_once('include/init.php');



require_once('include/header.php');
?>

  <!-- inner page section -->
  <section class="inner_page_head">
    <div class="container_fuild">
      <div class="row">
        <div class="col-md-12">
          <div class="full">
            <h3>Identifiez-vous</h3>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end inner page section -->
  <!-- why section -->
  <section class="why_section layout_padding">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 offset-lg-2">

          <?php if(isset($_SESSION['msgRegisterValidate'])) echo $_SESSION['msgRegisterValidate']; ?>

          <div class="full">
            <form action="index.php">
              <fieldset>
                <input
                  type="text"
                  placeholder="Entrez votre adresse e-mail"
                  name="email"
                  required />
                <input
                  type="password"
                  placeholder="Enter votre mot de passe"
                  name="subject"
                  required />
                <input type="submit" value="Continuer" />
              </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

<?php
require_once('include/footer.php');
//  On supprime le message de validation d'inscription dans la session, afin qu'il ne soit plus affiché à chaque visite sur la page d'authentification.
unset($_SESSION['msgRegisterValidate']);
?>