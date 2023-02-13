<?php 
    require_once('class.ticket.php');
    class Categorie extends Ticket
    {
        public $id;
        public $nom;

        public function __construct($id='',$args='')
        {
            global $db;
            if(!empty($id))
            {
                $req = $db->prepare('SELECT * FROM `table_categorie` WHERE Categorie_ID = :id');
                $req->bindParam(':id',$id,PDO::PARAM_INT);
                // Si la requête s'éxécute correctement
                if($req->execute())
                {
                    // On regarde si il y a bien une ligne de retournée
                    if($req->rowCount() == 1)
                    {
                        // On retourne l'objet categorie
                        $obj = $req->fetch(PDO::FETCH_OBJ);
                        $this->id = $obj->Categorie_ID;
                        $this->nom = $obj->Categorie_Nom;
                    }
                    else
                    {
                        return false;
                    }
                }
                else
                {
                    return false;
                }
            }
            else if(!empty($args))
            {
                $this->nom = $args['nom'];
                $inscription = self::inscrireCategorie();
                if($inscription)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
        }

        
        public function setId($id)
        {
                $this->id = $id;
        }

        public function getId()
        {
                return $this->id;
        }

        public function setNom($nom)
        {
                $this->nom = $nom;
        }

        public function getNom()
        {
                return $this->nom;
        }

        public function inscrireCategorie()
        {
            global $db;
            // On va vérifier si le categorie n'est pas déjà dans la BDD
            $req = $db->prepare('SELECT Categorie_ID FROM `table_categorie` WHERE Categorie_Nom = :nom');
            $req->bindParam(':nom',$this->nom,PDO::PARAM_INT);
            $req->execute();
            // Si il y n'y a pas de ligne retourné
            if($req->rowCount() == 0)
            {
                // On va pouvoir insérer notre categorie dans la BDD
                $req2 = $db->prepare('INSERT INTO `table_categorie` SET
                                        Categorie_Nom = :nom
                                    ');
                $req2->bindValue(':nom',$this->nom,PDO::PARAM_STR);
                if($req2->execute())
                {
                    $last_id = $db->lastInsertId();
                    return $last_id;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }

        public function delCategorie($id)
        {
            global $db;
            $req = $db->prepare('SELECT Categorie_ID FROM `table_categorie` WHERE Categorie_ID = :id');
            $req->bindParam(':id',$id,PDO::PARAM_INT);
            $req->execute();
            if($req->rowCount() == 1)
            {
                $req2 = $db->prepare('SELECT * FROM `table_categorie` INNER JOIN `table_ticket` ON Categorie_ID = Ticket_Categorie_ID WHERE Categorie_ID = :id');
                $req2->bindParam(':id',$id,PDO::PARAM_INT);
                $req2->execute();
                if($req2->rowCount() == 0)
                {
                    $req3 = $db->prepare('DELETE FROM `table_categorie` WHERE Categorie_ID = :id');
                    $req3->bindValue(':id',$id,PDO::PARAM_INT);
                    if($req3->execute())
                    {
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
    }
?>