<?php

namespace Models;
use PDO;

class Enregistrer extends DbConnect {

    /**
     * Primary key
     * FK Référence un objet Artiste
     * @var int
     */
    private $idArtiste;

    /**
     * Primary key
     * FK Référence un objet Disque
     * @var string (6 caractères)
     */
    private $reference;

    public function getIdArtiste(): int {
        return $this->idArtiste;
    }

    public function getReference(): string {
        return $this->reference;
    }

    public function setIdArtiste(int $id) {
        $this->idArtiste = $id;
    }

    public function setReference(string $ref) {
        $this->reference = $ref;
    }

    public function selectAll() {

        $query = "SELECT id_artiste, reference FROM enregistrer;";
        $result = $this->pdo->prepare($query);
        $result->execute();

        $datas = $result->fetchAll();
        return $datas;
    }

    public function select() {

        $query = "SELECT id_artiste, reference FROM enregistrer WHERE id_artiste = :id AND reference = :ref;";   
        $result = $this->pdo->prepare($query);

        $result->bindValue("id", $this->idArtiste, PDO::PARAM_INT);
        $result->bindValue("ref", $this->reference, PDO::PARAM_STR);

        $result->execute();
        $datas = $result->fetch();
        return $datas;
    }

    public function selectByArtiste() {

        $query = "SELECT id_artiste, reference FROM enregistrer WHERE id_artiste = :id;";
        $result = $this->pdo->prepare($query);

        $result->bindValue("id", $this->idArtiste, PDO::PARAM_INT);
        
        $result->execute();
        $datas = $result->fetchAll();
        return $datas;
    }

    public function selectByRefDisque() {

        $query = "SELECT id_artiste, reference FROM enregistrer WHERE reference = :ref;";
        $result = $this->pdo->prepare($query);

        $result->bindValue("ref", $this->reference, PDO::PARAM_STR);

        $result->execute();
        $datas = $result->fetchAll();
        return $datas;
    }

    public function insert() {

        $query = "INSERT INTO enregistrer (id_artiste, reference) VALUES(:id, :ref);";
        $result = $this->pdo->prepare($query);

        $result->bindValue("id", $this->idArtiste, PDO::PARAM_INT);
        $result->bindValue("ref", $this->reference, PDO::PARAM_STR);

        $result->execute();

    }

    public function update() {
        
    }

    public function delete() {
        
        $query = "DELETE FROM enregistrer WHERE reference = :ref AND id_artiste = :id;";
        $result = $this->pdo->prepare($query);

        $result->bindValue("id", $this->idArtiste, PDO::PARAM_INT);
        $result->bindValue("ref", $this->reference, PDO::PARAM_STR);

        $result->execute();
    }
}