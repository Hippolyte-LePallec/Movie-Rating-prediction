<?php
require_once __DIR__ . '/../class/maker.class.php';
require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json');

if (isset($_GET['term']) && isset($_GET['type'])) {
    $maker = new Maker($db);
    $term = $_GET['term'];
    $type = $_GET['type'];
    
    try {
        switch ($type) {
            case 'director':
                $results = $maker->searchDirectors($term);
                break;
            case 'writer':
                $results = $maker->searchWriters($term);
                break;
            case 'actor':
                $results = $maker->searchActors($term);
                break;
            default:
                $results = [];
        }
        
        echo json_encode($results);
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Paramètres manquants']);
}