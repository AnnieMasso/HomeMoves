<?php

require_once('../../models/Equipe.php');
require_once('../../configuration/Database.php');

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $database = new Database();
    $db = $database->Connexion();

    $team = new Equipe($db);

    $data = json_decode(file_get_contents('php://input'));

    if (!empty($data->id)) {
        $team->id = $data->id;

        $verify_id = $team->verifyId();
        if ($verify_id > 0) {
            $team_deleted = $team->deleteTeam();
            if ($team_deleted) {
                echo json_encode(['Message' => "team deleted avec succès"]);
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
    echo json_encode(['Message' => "methode non authorisée"]);
}