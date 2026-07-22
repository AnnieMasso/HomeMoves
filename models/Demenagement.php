<?php

// gestion des données de la table demenagement

class Demenagement{

    private $table = "demenagement";
    private ?object $connection = null;

    public int $id;
    public string $delai_execution;
    public string $type_local;
    public string $lieu_local;
    public string $destination;
    public string $observation;
    public int $tarif;
    public string $executé_le;
    public int $id_user;
    public int $id_vehicule;
    public string $raison_du_refus;

    public function __construct(object $db)
    {
        if ($this->connection === null) {
            $this->connection = $db;
        }
    }

    // fonction pour avoir tous les demenagements
    public function getMoves(){
        $moves = $this->connection->prepare("SELECT * FROM $this->table");
        $moves->execute();
        return $moves;

    }

    // fonction pour vérifier si l'id existe
    public function verifyId(){
        $verify_id = "SELECT type_local FROM $this->table WHERE id = ?";
        $result_id = $this->connection->prepare($verify_id);
        $result_id->bindParam(1, $this->id);
        $result_id->execute();
        if ($result_id->rowCount() > 0) {
            return true;
        }
        return false;
    }

    // enregistrement des moves
    public function storeMoves(){
        
        $requete = "INSERT INTO $this->table(type_local, lieu_local, destination, id_user) VALUE(:type_local, :lieu_local, :destination, :id_user)";
        
        $requetepreparée = $this->connection->prepare($requete);
        $requetepreparée->execute([
            ":type_local" => $this->type_local,
            ":lieu_local" => $this->lieu_local,
            ":destination" => $this->destination,
            ":id_user" => $this->id_user,
        ]);

        if ($requetepreparée) {
           return true;
        }
        else{
            return false;
        }
    }

    // planification des moves

    public function planMoves(){
        try {
            //code...

            $verify_accepté = $this->connection->prepare("SELECT etat FROM $this->table WHERE id  = ?");
            $verify_accepté->execute([$this->id]);
            $result = $verify_accepté->fetch(PDO::FETCH_ASSOC);
            $etat = $result['etat'];
            
            if ($etat === "accepté") {
                $query = "UPDATE $this->table SET delai_execution = ?, observation = ?, tarif = ?, etat = 'accepté' , id_vehicule = ? WHERE id = ?";
                $plan_moves = $this->connection->prepare($query);
                $plan_moves->execute([$this->delai_execution, $this->observation, $this->tarif, $this->id_vehicule, $this->id]);
                if ($plan_moves) {
                return true;
                }
                else{
                    return false;
                }
            }else{
                die('ce demenagement a déjà été planifié');
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
            echo $th->getLine();
        }
    }

    // annulation des moves
    public function annulationMoves(){
        $query = "UPDATE $this->table SET etat = 'annulé' WHERE id = ?";
        $query =$this->connection->prepare($query);
        $query->execute();
        if ($query) {
            return true;
        }else{
            return false;
        }
    }

    // paiement de la facturation
    public function payMoves(){
        $query = "UPDATE $this->table SET etat = 'payé' WHERE id = ?";
        $query =$this->connection->prepare($query);
        $query->execute([$this->id]);
        if ($query) {
            return true;
        }else{
            return false;
        }
    }

    // non paiement de la facturation
    public function dismissMoves(){
        $query = "UPDATE $this->table SET etat = 'rejeté', raison_du_refus = ? WHERE id = ?";
        $query =$this->connection->prepare($query);
        $query->execute([$this->raison_du_refus, $this->id]);
        if ($query) {
            return true;
        }else{
            return false;
        }
    }


    // supression des moves
    public function deleteMove(){
        $query = "UPDATE $this->table SET etat = 'supprimé' WHERE id = ?";
        $delete_move = $this->connection->prepare($query);
        $delete_move->execute([
            $this->id
        ]);

        if ($delete_move) {
            return true;
        }else{
            return false;
        }
    }
}