<?php

// require
require_once('../../configuration/Database.php');
require_once('../../models/Commentaire.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $database = new Database();
    $db = $database->Connexion();

    $comment = new Commentaire($db);
    
    $data = json_decode(file_get_contents("php://input"));
    if (!empty($data->message) && !empty($data->id_user)) {
        // $comment->date = $data->date;
        $comment->message = $data->message;
        $comment->id_user = $data->id_user;

        $comment_store = $comment->storeComment();
        if ($comment_store) {
            echo json_encode(['Message' => "comment store avec succès"]);
        }else{
        echo json_encode(['Message' => "error"]);
        }

    }else{
        echo json_encode(['Message' => "veuillez remplir tous les champs"]);
    }

}else{
    echo json_encode(['Message' => "methode non permise"]);
}