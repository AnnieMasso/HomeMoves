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

        if (!empty($data->id)) {
            $move->id = $data->id;

            $result = $move->payMoves();
            if ($result) {
                echo json_encode(["Message", "move payé avec succès"]);
            }
            else{
                echo json_encode(["Message", "erreur"]);
            }
        }
        else {
            echo json_encode(['Message'=>"veuillez spécifier l'id"]);
        }
    } catch (\Throwable $th) {
        echo $th->getLine(). " ". $th->getMessage();
    }
}else{
    echo json_encode(['Message'=>"Méthode non adaptée à cette action"]);
}