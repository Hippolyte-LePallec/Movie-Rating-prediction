a<?php
class Crew
{
    private $db;
    private $data = [];

    public function __construct($dbConnection)
    {
        $this->db = $dbConnection;
    }

    public function getData($key)
    {
        return $this->data[$key] ?? null;
    }

  
    public function getAllActorsWithFilms()
    {
        $stmt = $this->db->prepare("
            SELECT p.perso_id, p.\"primaryName\", p.birth_year, p.death_year, p.profession, 
                   m.media_id, m.\"primaryTitle\", m.\"startYear\", m.\"runtimeMinutes\", m.media_url, c.job, c.characters, c.ordering
            FROM personne p
            JOIN principal c ON p.perso_id = c.perso_id
            JOIN media m ON c.media_id = m.media_id
            WHERE p.profession = 'actor' 
            ORDER BY p.primary_name, c.ordering
        ");

        $stmt->execute();
        

        $actors = $stmt->fetchAll(PDO::FETCH_ASSOC);


        $result = [];
        foreach ($actors as $actor) {
            $perso_id = $actor['perso_id'];
            if (!isset($result[$perso_id])) {
                $result[$perso_id] = [
                    'perso_id' => $actor['perso_id'],
                    'primary_name' => $actor['primary_name'],
                    'birth_year' => $actor['birth_year'],
                    'death_year' => $actor['death_year'],
                    'profession' => $actor['profession'],
                    'films' => []
                ];
            }

            $result[$perso_id]['films'][] = [
                'media_id' => $actor['media_id'],
                'primaryTitle' => $actor['primaryTitle'],
                'startYear' => $actor['startYear'],
                'runtimeMinutes' => $actor['runtimeMinutes'],
                'media_url' => $actor['media_url'],
                'job' => $actor['job'],
                'characters' => $actor['characters'],
                'ordering' => $actor['ordering']
            ];
        }

        return $result;
    }

    public function getCrewMembersByFilm($media_id)
{
    $stmt = $this->db->prepare("
        SELECT p.perso_id, p.\"primaryName\", p.\"primaryProfession\", c.job, c.characters, c.ordering
        FROM principal c
        JOIN personne p ON c.perso_id = p.perso_id
        WHERE c.media_id = :media_id
        ORDER BY c.ordering
    ");

    $stmt->bindParam(':media_id', $media_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public function getFilmsByCrewMember($perso_id)
    {
        $stmt = $this->db->prepare("
            SELECT m.media_id, m.primaryTitle, m.startYear, m.runtimeMinutes, m.media_url, c.job
            FROM principal c
            JOIN media m ON c.media_id = m.media_id
            WHERE c.perso_id = :perso_id
            ORDER BY m.startYear DESC
        ");
        
        $stmt->bindParam(':perso_id', $perso_id, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }




}
?>
