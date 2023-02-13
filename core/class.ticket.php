<?php
require_once('config.php');
class Ticket{
    public $id;
    public $categorie;
    public $nom;
    public $prix;
    public $nombre;
    
    public function __construct($id='')
    {
        global $db;
        if($id)
        {
            $req = $db->prepare('SELECT * FROM `Table_Ticket` WHERE Ticket_ID = :id');
            $req->bindParam(':id',$id,PDO::PARAM_INT);
            $req->execute();
            if($req->rowCount() == 1)
            {
                $obj = $req->fetch(PDO::FETCH_OBJ);
                $this->id = $obj->Ticket_ID;
                $this->categorie = $obj->Ticket_Categorie_ID;
                $this->nom = $obj->Ticket_Nom;
                $this->prix = $obj->Ticket_Prix;
                $this->nombre = $obj->Ticket_Nombre;
            }
        }
        
    }
    public function getTicketID()
    {
        return $this->id;
    }
    public function getCategorie()
    {
        return $this->categorie;
    }
    public function getNom()
    {
        return $this->nom;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getPrix()
    {
        return $this->prix;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    }
    public function setNom($nom)
    {
        $this->nom = $nom;
    } 
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    // Méthode pour enregistrer l'objet dans la BDD
    public function register()
    {
        global $db;
        $req = $db->prepare('INSERT INTO `Table_Ticket` SET
                                Ticket_Categorie_ID = :categorie,
                                Ticket_Nom          = :nom,
                                Ticket_Prix         = :prix,
                                Ticket_Nombre       = :nombre
                            ');
        $req->bindValue(':categorie',$this->categorie,PDO::PARAM_INT);
        $req->bindValue(':nom',$this->nom,PDO::PARAM_STR);
        $req->bindValue(':prix',$this->prix,PDO::PARAM_INT);
        $req->bindValue(':nombre',$this->nombre,PDO::PARAM_INT);
        if($req->execute())
        {
            $id = $db->lastInsertId();
            return $id;
        }
        else
        {
            return false;
        }
    }
    // Méthode pour modifier le ticket en BDD
    public function update()
    {
        global $db;
        $req = $db->prepare('UPDATE `Table_Ticket` SET
                            Ticket_Categorie_ID = :categorie,
                            Ticket_Nom = :nom,
                            Ticket_Prix = :prix,
                            Ticket_Nombre = :nombre
                            WHERE Ticket_ID = :id
                        ');
        $req->bindValue(':categorie',$this->categorie,PDO::PARAM_INT);
        $req->bindValue(':nom',$this->nom,PDO::PARAM_STR);
        $req->bindValue(':prix',$this->prix,PDO::PARAM_INT);
        $req->bindValue(':nombre',$this->nombre,PDO::PARAM_INT);
        $req->bindValue(':id',$this->id,PDO::PARAM_INT);
        if($req->execute())
            return true;
        else
            return false;            
    }
    // Méthode pour supprimer le ticket
    public function delete()
    {
        global $db;
        $req = $db->prepare('DELETE FROM `Table_Ticket` WHERE Ticket_ID = :id');
        $req->bindValue(':id',$this->id,PDO::PARAM_INT);
        if($req->execute())
            return true;
        else
            return false;

    }
    // Méthode qui affiche tout les tickets
    public static function liste()
    {
        global $db;
        $req = $db->prepare('SELECT * FROM `Table_Ticket` ORDER BY Ticket_Prix ASC');
        $req->execute();
        // Si on a 1 ligne ou plus
        if($req->rowCount() >= 1)
        {
            // On retourne l'ensemble des lignes
            return $req->fetchAll(PDO::FETCH_ASSOC);
        }
        else
            return false;
    }

}
?>