<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <!-- Logo -->
    <a class="navbar-brand fw-bold text-warning" href="index.php">
      <i class="fas fa-film"></i>
      Film & Style
    </a>

    <!-- Bouton pour mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Contenu de la navbar -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php
        $list_menus = array(
          'Film' => 'Film',
          'Statistiques' => 'Statistiques',
          'Maker' => 'Film maker',
          'create_person' => 'Créer une personne',
        );

        foreach ($list_menus as $key => $menu): ?>
          <li class="nav-item">
            <a class="nav-link" href="index.php?element=pages&action=<?= urlencode($key); ?>"><?= htmlspecialchars($menu); ?></a>
          </li>
        <?php endforeach; ?>
      </ul>

      <!-- Barre de recherche -->
      <form class="d-flex" role="search" method="POST" action="index.php?element=pages&action=Film">
        <input class="form-control me-2" type="search" name="titre" placeholder="Rechercher un film..." aria-label="Search">
        <button class="btn btn-outline-light" type="submit">
            <i class="fas fa-search"></i>
        </button>
      </form>
      <ul class="navbar-nav ms-3">

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-user"></i> <?=urlencode($_SESSION['user']['username'])?>
            </a>
            <ul class="dropdown-menu bg-dark text-light" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item text-warning" href="index.php?element=pages&action=User"><i class="fas fa-user-circle"></i> Mon profil</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="login.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
            </ul>
          </li>
      </ul>
    </div>
  </div>
</nav>
