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

        if (!empty($data->id) && !empty($data->raison_du_refus)) {
            $move->id = $data->id;
            $move->raison_du_refus = $data->raison_du_refus;

            $result = $move->dismissMoves();
            if ($result) {
                echo json_encode(["Message", "move refusé avec succès"]);
            }
            else{
                echo json_encode(["Message", "erreur"]);
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