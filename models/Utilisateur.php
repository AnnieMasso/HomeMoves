<?php
// gestion des données de la table utilisateur
// require '../configuration/Database.php';
class Utilisateur{

    private string $table = "utilisateur";
    private ?object $connection = null;
    
    public int $id;
    public string $nomprenom;
    public string $tel;
    public string $email;
    public string $role;
    public string $password;
    public string $password_confirm;
    public string $profil; 
    public string $statut;
    public string $id_equipe;

    public function __construct(object $db)
    {
        // throw new \Exception('Not implemented');

        if ($this->connection === null) {
            $this->connection = $db;
        }

    }
    
    // fonction pour avoir tous les users
    public function getUser(){
        $requete= "SELECT * FROM $this->table WHERE statut = 1";
        $utilisateurs = $this->connection->prepare($requete);
        $utilisateurs->execute();
        return $utilisateurs;

    }

    // fonction pour vérifier si l'email existe
    public function verifyEmail(){
        $verify_email = "SELECT id FROM $this->table WHERE email = ?";
        $result_email = $this->connection->prepare($verify_email);
        $result_email->bindParam(1, $this->email);
        $result_email->execute();
        if ($result_email->rowCount() > 0) {
            return true;
        }
        return false;
    }

    // fonction pour vérifier si le tel existe
    public function verifyTel(){
        $verify_tel = "SELECT id FROM $this->table WHERE tel = ?";
        $result_tel = $this->connection->prepare($verify_tel);
        $result_tel->bindParam(1, $this->tel);
        $result_tel->execute();
        if ($result_tel->rowCount() > 0) {
            return true;
        }
        return false;
    }

    // enregistrement des users
    public function storeUser(){
        
        $requete = "INSERT INTO $this->table(nomprenom, tel, email, role, password, profil, statut, id_equipe) VALUE(:nomprenom, :tel, :email, :role, :password, :profil, 1, :id_equipe)";
        
        $requetepreparée = $this->connection->prepare($requete);
        $requetepreparée->execute([
            ":nomprenom" => $this->nomprenom,
            ":tel" => $this->tel,
            ":email" => $this->email,
            ":role" => $this->role,
            ":password" => $this->password,
            ":profil" => $this->profil,
            // ":statut" => $this->statut,
            ":id_equipe"=>$this->id_equipe,
        ]);

        if ($requetepreparée) {
           return true;
        }
        else{
            return false;
        }
    }

    // modification des users

    public function updateUser(){
        try {
            //code...

        $query = "UPDATE $this->table SET role = ?, nomprenom = ?, tel = ?, email = ?, profil = ? WHERE id = ?";
        $update_user = $this->connection->prepare($query);
        $update_user->execute([
            $this->role,
            $this->nomprenom,
            $this->tel,
            $this->email,
            $this->profil,
            $this->id,
            ]);
        if ($update_user) {
           return true;
        }
        else{
            return false;
        }
                } catch (\Throwable $th) {
            echo $th->getMessage();
            echo $th->getLine();
        }
    }

    // supression des users
    public function deleteUser(){
        $query = "UPDATE $this->table SET statut = 0 WHERE id = ?";
        $delete_user = $this->connection->prepare($query);
        $delete_user->execute([
            $this->id
        ]);

        if ($delete_user) {
            return true;
        }else{
            return false;
        }
    }

}