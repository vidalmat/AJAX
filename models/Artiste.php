<?php

namespace Models;
use PDO;

class Artiste extends DbConnect {

    /**
     * Primary key - auto_increment
     * @var int
     */
    private $idArtiste;

    /**
     * @var string
     */
    private $nom;

    public function getIdArtiste(): ?int {
        return $this->idArtiste;
    }

    public function getNom(): ?string {
        return $this->nom;
    }

    public function setIdArtiste(int $id) {
        $this->idArtiste = $id;
    }

    public function setNom(string $nom) {
        $this->nom = $nom;
    }

    public function selectAll() {

        $query = "SELECT id_artiste, nom FROM artistes;";
        $result = $this->pdo->prepare($query);
        $result->execute();

        $datas = $result->fetchAll();
        return $datas;
    }

    public function select() {

        $query = "SELECT id_artiste, nom FROM artistes WHERE id_artiste = :id;";
        $result = $this->pdo->prepare($query);

        $result->bindValue("id", $this->idArtiste, PDO::PARAM_INT);

        $result->execute();
        $datas = $result->fetch();
        return $datas;
    }

    public function selectByNom() {

        $query = "SELECT id_artiste, nom FROM artistes WHERE nom = :nom;";
        $result = $this->pdo->prepare($query);
        
        $result->bindValue("nom", $this->nom, PDO::PARAM_STR);

        $result->execute();
        $datas = $result->fetch();

        // Si $datas ne vaut pas FALSE (= aucune ligne correspondante)
        if($datas) {
            $this->idArtiste = $datas['id_artiste'];
            $this->nom = $datas['nom'];
        }

        return $datas;
    }

    public function insert() {

        $query = "INSERT INTO artistes (nom) VALUES(:nom);";
        $result = $this->pdo->prepare($query);
        
        $result->bindValue("nom", $this->nom, PDO::PARAM_STR);

        if(!$result->execute()) {
            var_dump($result->errorInfo());
            return false;
        }

        $this->idArtiste = $this->pdo->lastInsertId();
        return $this;
    }

    public function update() {

        $query = "UPDATE artistes SET nom = :nom WHERE id_artiste = :id;";
        $result = $this->pdo->prepare($query);

        $result->bindValue("nom", $this->nom, PDO::PARAM_STR);
        $result->bindValue("id", $this->idArtiste, PDO::PARAM_INT);

        $result->execute();

    }

    public function delete() {
        
        $query = "DELETE FROM artistes WHERE id_artiste = :id;";
        $result = $this->pdo->prepare($query);
        
        $result->bindValue("id", $this->idArtiste, PDO::PARAM_INT);

        if(!$result->execute())
            var_dump($result->errorInfo());

    }
}