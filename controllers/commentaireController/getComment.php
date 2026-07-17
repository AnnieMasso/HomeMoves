<?php

// require
require_once('../../configuration/Database.php');
require_once('../../models/Commentaire.php');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $database = new Database();
    $db = $database->Connexion();

    $comments = new Commentaire($db);
    $comments = $comments->getComment();
    if ($comments->rowCount() > 0) {
        $data = [];
        $data [] = $comments->fetchAll();

        echo json_encode($data);
    }else{
        echo json_encode(['Message' => "Aucune comments n'a encore été enregistré"]);
    }
}else{
    echo json_encode(["Messge"=> "Méthode non authorisée"]);
}