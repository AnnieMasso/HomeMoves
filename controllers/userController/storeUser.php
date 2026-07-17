<?php

require_once('../../configuration/Database.php');
require_once('../../models/Utilisateur.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $db = $database->Connexion();

    $user = new Utilisateur($db);

    $data = json_decode(file_get_contents("php://input"));
    if (!empty($data->nomprenom) && !empty($data->tel)&& !empty($data->email)&& !empty($data->role) && !empty($data->statut) && !empty($data->password) && !empty($data->profil) && !empty($data->id_equipe)) {

        // on vérifie si le user existe déjà
        try {
            $user->nomprenom = htmlspecialchars($data->nomprenom);
            if (strlen(trim($data->tel)) === 9 && str_starts_with($data->tel, 6)) {
                $user->tel = htmlspecialchars($data->tel);
            }else{
                echo json_encode(['Message' => "Numéro invalide, veuillez vous rassurer qu'il soit sur le format 6xxxxxxxxx"]);
            }
            if (filter_var($data->email, FILTER_VALIDATE_EMAIL)) {
                $user->email = htmlspecialchars($data->email);
            }else{
                echo json_encode(["Message" => "email invalide"]);
            }
            $user->role = htmlspecialchars($data->role);
            if ($data->password === $data->password_confirm) {
                $user->password = password_hash($data->password, PASSWORD_DEFAULT);
            }else{
                echo json_encode(['message' => 'les mots de passe ne correspondent pas']);
            }
            $user->profil = htmlspecialchars($data->profil);
            $user->statut = htmlspecialchars($data->statut);
            $user->id_equipe = htmlspecialchars($data->id_equipe);
            $emailExists = $user->verifyEmail();
            $telExists = $user->verifyTel();

            if ($emailExists || $telExists) {        
                echo json_encode(['Message' => "l'email ou le numéro de téléphone existe déjà"]);
            }
            else{

                $result = $user->storeUser();

                if ($result) {
                    echo json_encode(["Message" => "Utilisateur crée avec succès"]);
                }
                else{
                    echo json_encode(['Message' => "Erreur lors de l'ajout du user"]);
                }
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
            echo 'ok';
            echo $th->getLine();
            echo 'ok';
            echo $th->getCode();
        }
        
    }
    else{
        echo json_encode(["message" => "les données ne sont pas complètes"]);
    }
    
}
else{
    echo json_encode(["Message"=>"Méthode non authorisée"]);
}