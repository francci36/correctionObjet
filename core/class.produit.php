<?php
class Produit
{
    public $id;
    public $prix;
    public $valeur;
    public $quantite;

    public function __construct($id='',$args='')
    {
        global $db;
        if(!empty($id))
        {
            $req = $db->prepare('SELECT * FROM `Table_Produit` WHERE Produit_ID = :id');
            $req->bindParam(':id',$id,PDO::PARAM_INT);
            if($req->execute())
            {
                if($req->rowCount() == 1)
                {
                    $obj = $req->fetch(PDO::FETCH_OBJ);
                    $this->id = $obj->Produit_ID;
                    $this->prix = $obj->Produit_Prix;
                    $this->valeur = $obj->Produit_Valeur;
                    $this->quantite = $obj->Produit_Quantite;
                }
                else{
                    return false;
                }

            }
            else{
                return false;
            }
        }
        else if(!empty($args))
        {
            // on va enregistrer le produit
            $this->prix = $args['prix'];
            $this->valeur = $args['valeur'];
            $this->quantite = $args['quantite'];
            // on enregistre le produit dans la BDD
            $ins = self::inscrire();
            if($ins)
            {
                return $ins;
            }else
                return false;
            
        
        }
        
    
    }
    public function setPrix($prix)
        {
            $this->prix = $prix;
        }
        public function getPrix()
        {
            return $this->prix;
        }
        public function getId()
        {
            return $this->id;
        }
        public function setValeur($valeur)
        {
            $this->valeur = $valeur;
        }
        public function getValeur()
        {
            return $this->valeur;
        }
        public function setQuantite($quantite)
        {
            $this->prix = $quantite;
        }
        public function getquantite()
        {
            return $this->quantite;
        }
        public function inscrire()
        {
            global $db;
            $req = $db->prepare('INSERT INTO `Table_Produit`SET
                                    Produit_Prix = :prix,
                                    Produit_Valeur = :valeur,
                                    Produit_Qantité = :quantite

                                        ');
            $req->bindValue(':prix',$this->prix,PDO::PARAM_INT);
            $req->bindValue(':valeur',$this->valeur,PDO::PARAM_INT);
            $req->bindValue(':quantite',$this->quantite,PDO::PARAM_INT);
            if($req->execute())
            {
                    return $db->lastInsertId();
                
            }else
                    return false;
           
        }
        public function editer()
        {
            global $db;
            $req = $db->prepare('UPDATE `Table_Produit` SET
                                Produit_Prix = :prix,
                                Produit_Valeur = :valeur,
                                Produit_Qantité = :quantite
                                WHERE Produit_ID = :id
            
            ');
            $req->bindValue(':id',$this->id,PDO::PARAM_INT);
            $req->bindValue(':prix',$this->prix,PDO::PARAM_INT);
            $req->bindValue(':valeur',$this->valeur,PDO::PARAM_INT);
            $req->bindValue(':quantite',$this->quantite,PDO::PARAM_INT);
            if($req->execute())
            
                return true;

                else

                return false;
            
        }
        public static function delete($id='')
        {
            global $db;
            // Si pas de ID en paramètre
            if(empty($id))
            {
                // on recupere la propriete ID
                $id = self::getId();
            }
            $req = $db->prepare('DELETE FROM `Table_Produit` WHERE Produit_ID = :id');
            $req->bindValue(':id',$id,PDO::PARAM_INT);
            if($req->execute())
            return true;
            else
            return false;

        }
        // methode qui va lister l'ensemble des produits
        public static function liste($args='')
        {
            global $db;
            $default = array(
                'order' => 'Produit_ID',
                'orderby' => 'ASC',
                'limit' => 100,
                'page' => 1
            );
            // fusionne le tableau par défault avec le tableau d'arguments
            $args = array_merge($default,$args);
            //on prépare la requette sql
            $sql = 'SELECT * FROM `Table_Produit` WHERE 1';
            if($args['order'])
            $sql.=' ORDER BY '.strip_tags($args['order']);
            // si j'ai l'ordre de tri
            if($args['orderby'])
            $sql.=' '.strip_tags($args['orderby']);
            // si j'ai un limit ou une pagination
            if($args['limit'] || $args['page'])
            {
                // on regarde si l'argument page est pasée
                if($args['page'])
                $debut = intval($args['limit']*($args['page'] -1)).',';
                else
                $debut = null;
                $sql.= ' LIMIT '.$debut.intval($args['limit']);
            }
            $req = $db->query($sql);
            
            if($req->rowCount() >=1)
            {
                return $req->fetchAll(PDO::FETCH_OBJ);
            }
            else
            {
                return false;
            }

        }
        // methode qui va permettre d'exporter au format excel les produits
        public function exporter($args='')
        {
            $tab_export = ['id','prix','valeur','quantite'];
            //on va récuperer la liste des produits
            $liste = self::liste($args);
            // si on a bien des produits
            if($liste)
            {
                foreach($liste as $prod)
                {
                    // on met dans notre tableau les produits
                    $tab_export[] = [$prod->Produit_ID,$prod->Produit_Prix,$prod->Produit_Valeur,$prod->Produit_Quantite];
                }
                // on  va exporter au format CSV avec la fonction fputcsv();
                if($args['nom_fichier'])
                    $nom_fichier = $args['nom_fichier'].'.csv';
                    else
                    $nom_fichier= 'export-'.date('Y-m-d-h-i-s').'.csv';
                    // on va ensuite créer notre fichier
                    $fp = fopen($nom_fichier,'w');
                    // On va ensuite boucler sur notre tableau tab_export
                    foreach($tab_export as $ligne)
                    {
                        // on rentre chaque ligne dans notre csv
                        fputcsv($fp,$ligne);
                    }
                    fclose($fp);

            }
        }

}
?>