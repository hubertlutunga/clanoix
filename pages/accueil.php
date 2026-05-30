<header class="site-header" id="top">
  <div class="topbar">
    <div class="container topbar-inner">
      <button class="menu-label" type="button" id="menuToggle" aria-label="Ouvrir le menu" aria-expanded="false">
        <span></span><span></span><span></span>
        <strong>MENU</strong>
      </button>
      <div class="top-links" aria-label="Liens rapides">
        <a href="#catalogue">Catalogue</a>
        <a href="#auteur">Auteurs</a>
        <a href="#commande">Libraires</a>
        <a href="mailto:contact@clanoix.com">Contact</a>
      </div>
      <a href="#commande" class="cart-link" aria-label="Commander">Commande</a>
    </div>
  </div>

  <div class="container brand-row">
    <a href="#top" class="brand" aria-label="Accueil CLANOIX">
      <img src="images/logo_clanoix.png" alt="Logo CLANOIX" class="brand-logo">
    </a>

    <form class="search-box" action="#catalogue" role="search">
      <label for="siteSearch">Rechercher</label>
      <input id="siteSearch" type="search" placeholder="Rechercher un livre, un auteur, un thème">
      <button type="submit">OK</button>
    </form>

    <a href="#commande" class="btn btn-primary header-cta">Commander</a>
  </div>

  <nav class="category-nav" id="siteNav" aria-label="Navigation principale">
    <div class="container category-inner">
      <a href="#maison">La maison</a>
      <a href="#livre">Nouveauté</a>
      <a href="#catalogue">Meilleures ventes</a>
      <a href="#univers">Univers</a>
      <a href="#auteur">Auteur</a>
      <a href="#commande">Commande</a>
    </div>
  </nav>
</header>

<main>
  <section class="hero" id="maison">
    <div class="container hero-grid">
      <div class="hero-copy">
        <p class="eyebrow">CLANOIX, éditeur de repères</p>
        <h1>Des livres pour comprendre, décider et transmettre.</h1>
        <p class="lead">
          Une maison d’édition exigeante qui accompagne les professionnels, les leaders
          et les lecteurs engagés avec des ouvrages clairs, utiles et durables.
        </p>
        <div class="hero-actions">
          <a href="#livre" class="btn btn-primary">Découvrir la nouveauté</a>
          <a href="#catalogue" class="btn btn-secondary">Voir le catalogue</a>
        </div>
      </div>

      <div class="hero-feature">
        <div class="feature-label">Livre disponible</div>
        <img src="images/Mockup_Livre_Prise_Poste.png" alt="Couverture du livre Naviguer dans la prise de poste" class="book-hero-img">
        <div class="feature-card">
          <span>Nouveauté CLANOIX</span>
          <strong>Naviguer dans la prise de poste</strong>
          <p>Réussir ses premiers pas avec méthode, discernement et leadership.</p>
          <a href="#commande">Commander →</a>
        </div>
      </div>
    </div>
  </section>

  <section class="quick-themes" id="univers" aria-label="Univers éditoriaux">
    <div class="container theme-strip">
      <a href="#catalogue">Management</a>
      <a href="#catalogue">Leadership</a>
      <a href="#catalogue">Carrière</a>
      <a href="#catalogue">Spiritualité</a>
      <a href="#catalogue">Entreprise</a>
      <a href="#catalogue">Transmission</a>
    </div>
  </section>

  <section class="section book-section" id="livre">
    <div class="container">
      <div class="section-title-row">
        <div>
          <p class="section-kicker">Nouveauté</p>
          <h2>À la une chez CLANOIX</h2>
        </div>
        <a href="#commande" class="section-link">Commander le livre</a>
      </div>

      <div class="featured-book-panel">
        <div class="book-cover-panel">
          <img src="images/Mockup_Livre_Prise_Poste_1.png" alt="Présentation du livre Naviguer dans la prise de poste">
        </div>
        <div class="book-content">
          <span class="book-tag">Disponible maintenant</span>
          <h3>Naviguer dans la prise de poste</h3>
          <p class="book-subtitle">Transformer une transition professionnelle en aventure maîtrisée.</p>
          <p>
            Entrer dans une nouvelle fonction est un moment décisif. Cet ouvrage propose une méthode
            structurée pour comprendre son environnement, poser les bonnes priorités, fédérer les équipes
            et construire une crédibilité durable dès les premières semaines.
          </p>

          <div class="book-meta">
            <div><span>Auteur</span><strong>Aurélien NGANDZIAMI</strong></div>
            <div><span>Prix</span><strong>22,87 € / 15 000 XAF</strong></div>
            <div><span>Format</span><strong>Livre imprimé</strong></div>
          </div>

          <a href="#commande" class="btn btn-primary">Commander mon exemplaire</a>
        </div>
      </div>
    </div>
  </section>

  <section class="section catalogue-section" id="catalogue">
    <div class="container">
      <div class="section-title-row">
        <div>
          <p class="section-kicker">Catalogue</p>
          <h2>Nouveautés & prochaines parutions</h2>
        </div>
        <a href="#commande" class="section-link">Voir tout</a>
      </div>

      <div class="books-grid">
        <article class="book-card available">
          <div class="book-thumb"><img src="images/Mockup_Livre_Prise_Poste.png" alt="Naviguer dans la prise de poste"></div>
          <span>Disponible</span>
          <h3>Naviguer dans la prise de poste</h3>
          <p>Aurélien NGANDZIAMI</p>
          <strong>15 000 XAF</strong>
          <a href="#commande">Commander</a>
        </article>

        <article class="book-card soon">
          <div class="book-placeholder">CLANOIX</div>
          <span>À venir</span>
          <h3>Leadership & influence</h3>
          <p>Collection Management</p>
          <strong>Bientôt</strong>
        </article>

        <article class="book-card soon">
          <div class="book-placeholder">CLANOIX</div>
          <span>À venir</span>
          <h3>Parcours & transmission</h3>
          <p>Collection Expérience</p>
          <strong>Bientôt</strong>
        </article>

        <article class="book-card soon">
          <div class="book-placeholder">CLANOIX</div>
          <span>À venir</span>
          <h3>Stratégie personnelle</h3>
          <p>Collection Repères</p>
          <strong>Bientôt</strong>
        </article>
      </div>
    </div>
  </section>

  <section class="section preview-section" aria-label="Aperçu du livre">
    <div class="container">
      <div class="section-title-row centered">
        <div>
          <p class="section-kicker">Feuilleter</p>
          <h2>Une édition soignée, pensée pour la lecture et l’action.</h2>
        </div>
      </div>
      <div class="preview-grid">
        <img src="images/phPrise_Poste_1.jpg" alt="Aperçu intérieur du livre">
        <img src="images/phPrise_Poste_2.jpg" alt="Pages du livre Naviguer dans la prise de poste">
        <img src="images/phPrise_Poste_4.jpg" alt="Visuel éditorial du livre">
      </div>
    </div>
  </section>

  <section class="section author-section" id="auteur">
    <div class="container author-layout">
      <div class="author-photo-wrap">
        <img src="images/Aurelien-NGANDZIAMI_pp.jpg" alt="Aurélien NGANDZIAMI" class="author-photo">
      </div>
      <div class="author-content">
        <p class="section-kicker">Auteur</p>
        <h2>Aurélien NGANDZIAMI</h2>
        <p>
          Professionnel expérimenté des services financiers, spécialiste du management stratégique
          et de la conduite du changement, il partage plus de vingt années d’expérience et plusieurs
          prises de poste dans des contextes exigeants.
        </p>
        <p>
          Son approche articule stratégie, discipline personnelle et leadership spirituel pour proposer
          des repères concrets, applicables et profondément humains.
        </p>
        <div class="author-links" aria-label="Réseaux sociaux de l’auteur">
          <a target="_blank" rel="noopener" href="https://x.com/aurelienngandzm?s=21">X</a>
          <a target="_blank" rel="noopener" href="https://www.facebook.com/share/1HfuTpCUwC/?mibextid=wwXIfr">Facebook</a>
          <a target="_blank" rel="noopener" href="https://www.instagram.com/aurelienngandziami?igsh=MW1vOTZybTk4ODNsZQ%3D%3D&utm_source=qr">Instagram</a>
          <a target="_blank" rel="noopener" href="https://www.linkedin.com/in/aur%C3%A9lien-ngandziami-b39a823ba?utm_source=share_via&utm_content=profile&utm_medium=member_ios">LinkedIn</a>
        </div>
      </div>
    </div>
  </section>

  <section class="numbers-section" aria-label="CLANOIX en quelques chiffres">
    <div class="container numbers-grid">
      <div><strong>1</strong><span>titre disponible</span></div>
      <div><strong>3</strong><span>collections en préparation</span></div>
      <div><strong>100%</strong><span>ouvrages utiles</span></div>
      <div><strong>+20</strong><span>années d’expérience transmises</span></div>
    </div>
  </section>

  <section class="section order-section" id="commande">
    <div class="container order-layout">
      <div class="order-copy">
        <p class="section-kicker">Commande</p>
        <h2>Commandez votre exemplaire.</h2>
        <p>
          Le livre est disponible. L’équipe CLANOIX vous contactera pour confirmer les modalités
          de paiement, de retrait ou de livraison selon votre ville.
        </p>
        <div class="order-note">
          <strong>Prix public : 22,87 € / 15 000 XAF</strong>
          <span>Commande sans paiement en ligne immédiat.</span>
        </div>
      </div>

      <div class="form-wrap">
        <form method="post" action="" class="form-grid" id="orderForm">
          <div class="field">
            <label for="firstName">Prénom</label>
            <input id="firstName" name="firstName" type="text" placeholder="Ex. Hubert" required>
          </div>
          <div class="field">
            <label for="lastName">Nom</label>
            <input id="lastName" name="lastName" type="text" placeholder="Ex. Lutunga" required>
          </div>
          <div class="field">
            <label for="phone">Téléphone / WhatsApp</label>
            <input id="phone" name="phone" type="tel" placeholder="Ex. +242 ..." required>
          </div>
          <div class="field">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" placeholder="Ex. contact@email.com" required>
          </div>
          <div class="field">
            <label for="qty">Quantité</label>
            <select id="qty" name="qty" required>
              <option value="1">1 exemplaire</option>
              <option value="2">2 exemplaires</option>
              <option value="3">3 exemplaires</option>
              <option value="5">5 exemplaires</option>
              <option value="10">10 exemplaires</option>
            </select>
          </div>
          <div class="field">
            <label for="city">Ville / Commune</label>
            <input id="city" name="city" type="text" placeholder="Ex. Kinshasa / Gombe" required>
          </div>
          <div class="field full">
            <label for="message">Note complémentaire</label>
            <textarea id="message" name="message" placeholder="Ex. adresse de livraison, disponibilité, demande de plusieurs exemplaires..."></textarea>
          </div>
          <div class="field full">
            <button type="submit" name="submitpc" id="btnSubmit" class="btn btn-primary">Envoyer ma commande</button>
          </div>
        </form>
        <p class="form-note">
          Vos informations sont uniquement utilisées pour traiter votre commande du livre
          <em>Naviguer dans la prise de poste</em>.
        </p>
      </div>
    </div>
  </section>
</main>

<footer class="site-footer">
  <div class="container footer-main">
    <div>
      <img src="images/logo_clanoix_white.png" alt="Logo CLANOIX" class="footer-logo">
      <p>Maison d’édition dédiée aux livres de leadership, stratégie et transmission.</p>
    </div>
    <div>
      <h3>CLANOIX</h3>
      <a href="#maison">Qui sommes-nous ?</a>
      <a href="#catalogue">Catalogue</a>
      <a href="#auteur">Auteurs</a>
    </div>
    <div>
      <h3>Thèmes</h3>
      <a href="#univers">Management</a>
      <a href="#univers">Leadership</a>
      <a href="#univers">Carrière</a>
    </div>
    <div>
      <h3>Services</h3>
      <a href="#commande">Commander</a>
      <a href="mailto:contact@clanoix.com">Contact</a>
      <a href="#top">Retour en haut</a>
    </div>
  </div>
  <div class="container footer-bottom">
    <p>© <?php echo date('Y'); ?> CLANOIX — Tous droits réservés.</p>
    <a href="mailto:contact@clanoix.com">contact@clanoix.com</a>
  </div>
</footer>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const nav = document.getElementById('siteNav');
    const toggle = document.getElementById('menuToggle');
    const form = document.getElementById('orderForm');
    const btn = document.getElementById('btnSubmit');

    if (toggle && nav) {
      toggle.addEventListener('click', function () {
        const isOpen = nav.classList.toggle('active');
        toggle.classList.toggle('active', isOpen);
        toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      });

      nav.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
          nav.classList.remove('active');
          toggle.classList.remove('active');
          toggle.setAttribute('aria-expanded', 'false');
        });
      });
    }

    if (form && btn) {
      form.addEventListener('submit', function () {
        btn.disabled = true;
        btn.textContent = 'Envoi de la commande...';
      });
    }
  });
</script>
