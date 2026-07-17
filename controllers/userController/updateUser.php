<?php
require_once('../../configuration/Database.php');
require_once('../../models/Utilisateur.php');

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $database = new Database();
    $db = $database->Connexion();

    $user = new Utilisateur($db);

    $data = json_decode(file_get_contents("php://input"));
    try {
        //code...

        if (!empty($data->role) && !empty($data->id)) {
            $user->id = $data->id;
            $user->role = htmlspecialchars($data->role);

            $result = $user->updateUser();
            if ($result) {
                echo json_encode(["Message", "user mis à jour avec succès"]);
            }
            else{
                echo json_encode(["Message", "user non mis à jour"]);
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