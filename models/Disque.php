<?php

namespace Models;
use PDO;

class Disque extends DbConnect {

    /**
     * Primary key
     * @var string (code de 6 caractères)
     */
    private $reference;

    /**
     * @var string
     */
    private $titre;

    /**
     * @var string (4 caractères)
     */
    private $annee;
    
    /**
     * FK Référence le nom du Label
     * @var string
     */
    private $nom;

    public function getReference(): ?string {
        return $this->reference;
    }

    public function getTitre(): ?string {
        return $this->titre;
    }

    public function getAnnee(): ?string {
        return $this->annee;
    }

    public function getNom(): ?string {
        return $this->nom;
    }

    public function setReference(string $ref) {
        // On vérifie éventuellement la longueur de $ref
        $this->reference = $ref;
    }

    public function setTitre(string $titre) {
        $this->titre = $titre;
    }

    public function setAnnee(string $annee) {
        // On vérifie éventuellement la longueur de $annee
        $this->annee = $annee;
    }

    public function setNom(string $nom) {
        $this->nom = $nom;
    }

    public function selectAll() {

        $query = "SELECT reference, titre, annee, nom FROM disques;";
        $result = $this->pdo->prepare($query);
        $result->execute();

        $datas = $result->fetchAll();
        return $datas;
    }

    public function select() {

        $query = "SELECT reference, titre, annee, nom FROM disques WHERE reference = :ref;"; 
        $result = $this->pdo->prepare($query);

        $result->bindValue("ref", $this->reference, PDO::PARAM_STR);

        $result->execute();
        $datas = $result->fetch();
        return $datas;
    }

    public function insert() {

        $query = "INSERT INTO disques (reference, titre, annee, nom) VALUES(:ref, :titre, :annee, :nom);";
        $result = $this->pdo->prepare($query);

        $result->bindValue("ref", $this->reference, PDO::PARAM_STR);
        $result->bindValue("titre", $this->titre, PDO::PARAM_STR);
        $result->bindValue("annee", $this->annee, PDO::PARAM_STR);
        $result->bindValue("nom", $this->nom, PDO::PARAM_STR);

        if(!$result->execute()) {
            var_dump($result->errorInfo());
            return false;
        }

        return $this;
            
    }

    public function update() {

        $query = "UPDATE disques SET titre = :titre, annee = :annee, nom = :nom WHERE reference = :ref;";
        $result = $this->pdo->prepare($query);

        $result->bindValue("ref", $this->reference, PDO::PARAM_STR);
        $result->bindValue("titre", $this->titre, PDO::PARAM_STR);
        $result->bindValue("annee", $this->annee, PDO::PARAM_STR);
        $result->bindValue("nom", $this->nom, PDO::PARAM_STR);

        if(!$result->execute()) {
            return false;
        }

        return $this;

    }

    public function delete() {
        
        $query = "DELETE FROM disques WHERE reference = :ref;";
        $result = $this->pdo->prepare($query);

        $result->bindValue("ref", $this->reference, PDO::PARAM_STR);

        return $result->execute();
    }

}