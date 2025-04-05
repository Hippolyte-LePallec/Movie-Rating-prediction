<?php
class ActorRating {
    private $db;
    private $partial_title;

    public function __construct($db) {
        $this->db = $db;
    }

    // Prédiction de la note de l'acteur sans les genres
    public function predictActorRating($personId) {
        // Première requête : prédiction sans genres
        $query = $this->db->prepare("SELECT predict_actor(:personId) AS rating");
        $query->execute([':personId' => $personId]);
        $firstResult = $query->fetch(PDO::FETCH_ASSOC);
        $firstRating = $firstResult ? $firstResult['rating'] : 0;

        return $firstRating;
    }

    // Prédiction de la note de l'acteur avec les genres
    public function predictActorRatingWithGenres($personId, $genres) {
        // Deuxième requête : prédiction avec genres
        $genresArray = '{' . implode(',', $genres) . '}';
        $query = $this->db->prepare("SELECT predict_actor_with_genres(:personId, :genresArray) AS rating");
        $query->execute([':personId' => $personId, ':genresArray' => $genresArray]);
        $secondResult = $query->fetch(PDO::FETCH_ASSOC);
        $secondRating = $secondResult ? $secondResult['rating'] : 0;

        return $secondRating;
    }

    // Prédiction combinée des deux
    public function predictCombinedActorRating($personId, $genres) {
        // Récupérer les deux prédictions
        $firstRating = $this->predictActorRating($personId);
        $secondRating = $this->predictActorRatingWithGenres($personId, $genres);

        // Multiplier les résultats
        $finalRating = $firstRating * $secondRating;

        return $finalRating;
    }

    // Prédiction pour un directeur avec genres
    public function predictDirectorRatingWithGenres($directorId, $genres) {
        $genresArray = '{' . implode(',', $genres) . '}';
        $query = $this->db->prepare("SELECT get_director_rating_with_genres(:directorId, :genresArray) AS rating");
        $query->execute([':directorId' => $directorId, ':genresArray' => $genresArray]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['rating'] : 0;
    }

    // Prédiction pour un scénariste avec genres
    public function predictWriterRatingWithGenres($writerId, $genres) {
        $genresArray = '{' . implode(',', $genres) . '}';
        $query = $this->db->prepare("SELECT get_writer_rating_with_genres(:writerId, :genresArray) AS rating");
        $query->execute([':writerId' => $writerId, ':genresArray' => $genresArray]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['rating'] : 0;
    }

    // Prédiction pour les genres combinés
    public function predictCombinedGenreRating($genres) {
        $genresArray = '{' . implode(',', $genres) . '}';
        $query = $this->db->prepare("SELECT get_average_combined_genre_rating(:genresArray) AS rating");
        $query->execute([':genresArray' => $genresArray]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['rating'] : 0;
    }
}

/*
<?php
class ActorRating {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Prédiction de la note de l'acteur sans les genres
    public function predictActorRating($personId) {
        // Première requête : prédiction sans genres
        $query = $this->db->prepare("SELECT predict_actor(:personId) AS rating");
        $query->execute([':personId' => $personId]);
        $firstResult = $query->fetch(PDO::FETCH_ASSOC);
        $firstRating = $firstResult ? $firstResult['rating'] : 0;

        return $firstRating;
    }

    // Prédiction de la note de l'acteur avec les genres
    public function predictActorRatingWithGenres($personId, $genres) {
        // Deuxième requête : prédiction avec genres
        $genresArray = '{' . implode(',', $genres) . '}';
        $query = $this->db->prepare("SELECT predict_actor_with_genres(:personId, :genresArray) AS rating");
        $query->execute([':personId' => $personId, ':genresArray' => $genresArray]);
        $secondResult = $query->fetch(PDO::FETCH_ASSOC);
        $secondRating = $secondResult ? $secondResult['rating'] : 0;

        return $secondRating;
    }

    // Prédiction combinée des deux
    public function predictCombinedActorRating($personId, $genres) {
        // Récupérer les deux prédictions
        $firstRating = $this->predictActorRating($personId);
        $secondRating = $this->predictActorRatingWithGenres($personId, $genres);

        // Multiplier les résultats
        $finalRating = $firstRating * $secondRating;

        return $finalRating;
    }

    // Prédiction pour un directeur avec genres
    public function predictDirectorRatingWithGenres($directorId, $genres) {
        $genresArray = '{' . implode(',', $genres) . '}';
        $query = $this->db->prepare("SELECT get_director_rating_with_genres(:directorId, :genresArray) AS rating");
        $query->execute([':directorId' => $directorId, ':genresArray' => $genresArray]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['rating'] : 0;
    }

    // Prédiction pour un scénariste avec genres
    public function predictWriterRatingWithGenres($writerId, $genres) {
        $genresArray = '{' . implode(',', $genres) . '}';
        $query = $this->db->prepare("SELECT get_writer_rating_with_genres(:writerId, :genresArray) AS rating");
        $query->execute([':writerId' => $writerId, ':genresArray' => $genresArray]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['rating'] : 0;
    }

    // Prédiction pour les genres combinés
    public function predictCombinedGenreRating($genres) {
        $genresArray = '{' . implode(',', $genres) . '}';
        $query = $this->db->prepare("SELECT get_average_combined_genre_rating(:genresArray) AS rating");
        $query->execute([':genresArray' => $genresArray]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['rating'] : 0;
    }

    // Prédiction pour un titre partiel
    public function predictRatingByPartialTitle($partialTitle) {
        $query = $this->db->prepare("SELECT get_average_rating_by_partial_title(:partialTitle) AS rating");
        $query->execute([':partialTitle' => $partialTitle]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['rating'] : 0;
    }
}
*/