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
      <!-- Liens principaux -->
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link text-light" href="index.php">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="?page=films">Films</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="?page=series">Séries</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href=".\pages\views\Statistiques.php">Statistiques</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href=".\pages\views\Maker.php">film maker</a>
        </li>
      </ul>

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