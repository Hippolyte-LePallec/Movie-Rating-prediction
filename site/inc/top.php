<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <!-- Logo -->
    <a class="navbar-brand fw-bold text-warning" href="index.php">
      <i class="fas fa-film"></i> Film & Style
    </a>

    <!-- Bouton pour mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Contenu de la navbar -->
    <div class="collapse navbar-collapse" id="navbarNav">
    <?php
    $list_menus = array(
      'Film'=> 'Film',
      'Statistiques'=>'Statistiques',
      'Maker' => 'Film maker',
    );

    foreach ($list_menus as $key => $menu): ?>
      <div class="w3-dropdown-hover">
        <a href="index.php?element=pages&action=<?= urlencode($key); ?>" class="w3-bar-item w3-button"><?= htmlspecialchars($menu); ?></a>
      </div>
    <?php endforeach; ?>

      <!-- Barre de recherche -->
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Rechercher..." aria-label="Search">
        <button class="btn btn-outline-light" type="submit">
          <i class="fas fa-search"></i>
        </button>
      </form>

      <!-- Connexion -->
      <ul class="navbar-nav ms-3">
        <li class="nav-item">
          <a class="nav-link text-light" href="#" data-bs-toggle="modal" data-bs-target="#connexionModal">
            <i class="fas fa-sign-in-alt"></i> Connexion
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>