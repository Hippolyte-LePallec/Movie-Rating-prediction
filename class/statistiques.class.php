<?php
require_once(dirname(__FILE__) . '/film.class.php');
require_once(dirname(__FILE__) . '/crew.class.php');


class Stat
{
    private $filmModel;
    private $crewModel;
    private $db;

    public function __construct($dbConnection)
    {
        $this->db = $dbConnection;
        $this->filmModel = new Film($this->db);
        $this->crewModel = new Crew($this->db);
    }


    public function getFilmStats()
    {

        $totalFilms = $this->filmModel->getTotalCount();

        $avgRating = $this->getAverageRating();

        $directorsCount = $this->getTotalDirectors();


        return [
            'totalFilms' => $totalFilms,
            'avgRating' => $avgRating,
            'directorsCount' => $directorsCount,
        ];
    }

    // Récupérer la note moyenne des films
    private function getAverageRating()
    {
        $stmt = $this->db->prepare("SELECT AVG(\"averageRating\") as avg_rating FROM rating");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['avg_rating'] ?? 0;
    }

    // Récupérer le nombre total de réalisateurs
    private function getTotalDirectors()
    {
        $stmt = $this->db->prepare("SELECT COUNT(DISTINCT perso_id) as total_directors FROM principal WHERE job = 'director'");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['total_directors'] ?? 0;
    }

    // Récupérer la répartition par genre pour les graphiques
    public function getGenreDistribution()
    {
        $stmt = $this->db->prepare("
            SELECT g.genre_name, COUNT(m.media_id) AS genre_count
            FROM genre g
            LEFT JOIN media_genre mg ON g.genre_id = mg.genre_id
            LEFT JOIN media m ON mg.media_id = m.media_id
            GROUP BY g.genre_name
            ORDER BY genre_count DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les top réalisateurs par note moyenne
    public function getTopDirectors()
    {
        $stmt = $this->db->prepare("
            SELECT p.\"primaryName\", AVG(r.\"averageRating\") as avg_rating
            FROM personne p
            JOIN principal c ON p.perso_id = c.perso_id
            JOIN media m ON c.media_id = m.media_id
            LEFT JOIN rating r ON m.media_id = r.media_id
            WHERE c.job = 'director'
            GROUP BY p.\"primaryName\"
            ORDER BY avg_rating DESC
            LIMIT 10
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer l'évolution du nombre de films par année
    public function getFilmsEvolution()
    {
        $stmt = $this->db->prepare("
        SELECT \"startYear\" AS year, COUNT(m.media_id) AS total
        FROM media m
        GROUP BY \"startYear\"
        ORDER BY year ASC
    ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer la distribution des notes des films
    public function getRatingsDistribution()
    {
        $stmt = $this->db->prepare("
            SELECT \"averageRating\", COUNT(*) AS count
            FROM rating
            GROUP BY \"averageRating\"
            ORDER BY \"averageRating\" DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer la durée moyenne des films par décennie
    public function getAverageDurationByDecade()
    {
        $stmt = $this->db->prepare("
        SELECT
            FLOOR(\"startYear\" / 10) * 10 AS decade,
            AVG(CAST(NULLIF(m.\"runtimeMinutes\", '\\N') AS INTEGER)) AS avg_runtime
        FROM media m
        GROUP BY decade
        ORDER BY decade
    ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}
?>
