<?php

require_once('../../configuration/Database.php');
require_once('../../models/Equipe.php');

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $database = new Database();
    $db = $database->Connexion();

    $team = new Equipe($db);

    $data = json_decode(file_get_contents('php://input'));
    if (!empty($data->id) && !empty($data->libelle)) {
        $team->id = $data->id;
        $team->libelle = htmlspecialchars($data->libelle);
        $verify_id = $team->verifyId();

        if ($verify_id > 0) {

            $team_updated = $team->updateTeam();
            if ($team_updated) {
                echo json_encode(['Message' => "team updated avec succès"]);
            }else{
                echo json_encode(['Message' => "error"]);
            }
        }else{
            echo json_encode(['Message' => "l'id n'existe pas"]);
        }
    }else{
        echo json_encode(['Message' => "données incomplètes"]);
    }
}else{
    echo json_encode(['Message' => "méthode non authorisée"]);
}