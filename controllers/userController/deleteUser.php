<?php

require_once('../../configuration/Database.php');
require_once('../../models/Utilisateur.php');

if ($_SERVER['REQUEST_METHOD'] === "DELETE") {

    try {
        //code...

    
    $database = new Database();
    $db = $database->Connexion();

    $users = new Utilisateur($db);

    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->id)) {
        $users->id = $data->id;
        $user_deleted = $users->deleteUser();

        if ($user_deleted) {
            echo json_encode(["message" =>"user supprimé avec succès"]);
        }else{
            echo json_encode(["message" =>"echec lors de la suppression du user"]);
        }
    }else{
        echo json_encode(["message" =>"veuillez indiquer un id"]);
    }

        } catch (\Throwable $th) {
        echo $th->getLine(). ' et '. $th->getMessage();
    }

}else{
    echo json_encode(["message" =>"méthode non permise"]);
}