<?php

// require
require_once('../../configuration/Database.php');
require_once('../../models/Equipe.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $database = new Database();
    $db = $database->Connexion();

    $team = new Equipe($db);
    
    $data = json_decode(file_get_contents("php://input"));
    if (!empty($data->libelle)) {
        $team->libelle = htmlspecialchars($data->libelle);
        $team->description = htmlspecialchars($data->description);

        $team_store = $team->storeTeam();
        if ($team) {
            echo json_encode(['Message' => "team store avec succès"]);
        }else{
        echo json_encode(['Message' => "error"]);
        }

    }else{
        echo json_encode(['Message' => "veuillez remplir tous les champs"]);
    }

}else{
    echo json_encode(['Message' => "methode non permise"]);
}