<?php
require_once('../../configuration/Database.php');
require_once('../../models/Demenagement.php');

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $database = new Database();
    $db = $database->Connexion();

    $move = new Demenagement($db);

    $data = json_decode(file_get_contents("php://input"));
    try {
        //code...

        if (!empty($data->delai_execution) && !empty($data->tarif) && !empty($data->observation) && !empty($data->id_vehicule)) {
            $move->id = $data->id;
            $move->tarif = $data->tarif;
            $move->delai_execution = $data->delai_execution;
            $move->observation = $data->observation;
            $move->id_vehicule = $data->id_vehicule;

            $result = $move->planMoves();
            if ($result) {
                echo json_encode(["Message", "move planifié avec succès"]);
            }
            else{
                echo json_encode(["Message", "move non planifié"]);
            }
        }
        else {
            echo json_encode(['Message'=>"données incomplètes"]);
        }
    } catch (\Throwable $th) {
        echo $th->getLine(). " ". $th->getMessage();
    }
}else{
    echo json_encode(['Message'=>"Méthode non adaptée à cette action"]);
}