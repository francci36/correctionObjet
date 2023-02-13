<?php
require_once('config.php');
class Client
{
    private $id;
    public $nom;
    public $prenom;
    public $email;
    public $password;
    public $credit;

    // Constructeur de notre classe
    public function __construct($id='',$args='')
    {
        global $db;
        if(!empty($id))
        {
            $req = $db->prepare('SELECT * FROM `Table_Client` WHERE Client_ID = :id');
            $req->bindParam(':id',$id,PDO::PARAM_INT);
            // Si la requête s'éxécute correctement
            if($req->execute())
            {
                // On regarde si il y a bien une ligne de retourné
                if($req->rowCount() == 1)
                {
                    // On retourne l'objet user
                    $obj = $req->fetch(PDO::FETCH_OBJ);
                    $this->id = $obj->Client_ID;
                    $this->prenom = $obj->Client_Prenom;
                    $this->nom = $obj->Client_Nom;
                    $this->email = $obj->Client_Email;
                    $this->password = $obj->Client_Password;
                    $this->credit = $obj->Client_Credit;
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
            $this->prenom = $args['prenom'];
            $this->email = $args['email'];
            $this->password = self::generatePassword();
            $this->credit = $args['credit'];
            $inscription = self::inscrire();
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
    public function setNom($nom)
    {
        $this->nom = $nom;
    }
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function setCredit($credit)
    {
        $this->credit = $credit;
    }
    private function generatePassword()
    {
        $str = 'azertyuiopqsdfghjklmwxcvbn1234567890AZERTYUIOPQSDFGHJKLMWXCVBN';
        // On transforme la chaine de caractère en tableau
        $tab = str_split($str);
        // On génère la longueur du mot de passe entre 12 et 16
        $long = rand(12,16);
        // On fait une boucle sur la longueur du mdp
        $mdp = '';
        for($i=0;$i<$long;$i++)
        {
            // on ajoute les caractères au hasard avec array_rand
            $str_rand = array_rand($tab);
            $mdp.= $tab[$str_rand];
        }
        return $mdp;
    }
    public function getNom()
    {
        return $this->nom;
    }
    public function getPrenom()
    {
        return $this->prenom;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getCredit()
    {
        return $this->credit;
    }
    // Méthode pour inscrire un client
    public function inscrire()
    {
        global $db;
        // On va vérifier si le client n'est pas déjà dans la BDD
        $req = $db->prepare('SELECT Client_ID FROM `Table_Client` WHERE Client_Email = :email');
        $req->bindParam(':email',$this->email,PDO::PARAM_STR);
        $req->execute();
        // Si il n'y a pas de ligne retourné
        if($req->rowCount() == 0)
        {
            // On va pouvoir insérer notre client dans la BDD
            $req2 = $db->prepare('INSERT INTO `Table_Client` SET
                                    Client_Nom = :nom,
                                    Client_Prenom = :prenom,
                                    Client_Email = :email,
                                    Client_Password = :password,
                                    Client_Credit = :credit
                                ');
            $req2->bindValue(':nom',$this->nom,PDO::PARAM_STR);
            $req2->bindValue(':prenom',$this->prenom,PDO::PARAM_STR);
            $req2->bindValue(':email',$this->email,PDO::PARAM_STR);
            $req2->bindValue(':password',self::generatePassword($this->password),PDO::PARAM_STR);
            $req2->bindValue(':credit',$this->credit,PDO::PARAM_INT);  
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
    public function editer()
    {
        global $db;
        $req = $db->prepare('SELECT Client_ID FROM `Table_Client` WHERE Client_Email = :email AND Client_ID != :id');
        $req->bindParam(':id',$this->id,PDO::PARAM_INT);
        $req->bindParam(':email',$this->email,PDO::PARAM_STR);
        $req->execute();
        // Si on trouve pas d'email enregistré
        if($req->rowCount() == 0)
        {
            $req2 = $db->prepare('UPDATE `Table_Client` SET
                                    Client_Prenom = :prenom,
                                    Client_Nom = :nom,
                                    Client_Email = :email,
                                    Client_Credit = :credit
                                    WHERE Client_ID = :id
                                ');
            $req2->bindValue(':id',$this->id,PDO::PARAM_INT);
            $req2->bindValue(':prenom',$this->prenom,PDO::PARAM_STR);
            $req2->bindValue(':nom',$this->nom,PDO::PARAM_STR);
            $req2->bindValue(':email',$this->email,PDO::PARAM_STR);
            $req2->bindValue(':credit',$this->credit,PDO::PARAM_INT);
            if($req2->execute())
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
    // Fonction pour la connection
    public static function getConnexion($email='',$password='')
    {
        global $db;
        // On vérifie si email et mot de passe sont renseigné
        if($email && $password)
        {
            $req = $db->prepare('SELECT Client_ID, Client_Password FROM `Table_Client` WHERE Client_Email = :email AND Client_Password = :password');
            $req->bindParam(':email',$email,PDO::PARAM_STR);
            $req->bindParam(':password',$password,PDO::PARAM_STR);
        }
        // Sinon on vérifie avec les cookies
        if(!empty($_COOKIE['id']) && !empty($_COOKIE['password']))
        {
            $req = $db->prepare('SELECT Client_ID, Client_Password FROM `Table_Client` WHERE Client_ID = :id AND Client_Password = :password');
            $req->bindParam(':id',$_COOKIE['id'],PDO::PARAM_INT);
            $req->bindParam(':password',$_COOKIE['password'],PDO::PARAM_STR);
        }
        if(isset($req) && $req->execute())
        {
            // Si on a bien un utilisateur
            if($req->rowCount() == 1)
            {
                $obj = $req->fetch(PDO::FETCH_OBJ);
                $_SESSION['connect'] = 1;
                setcookie('id',$obj->Client_ID,(time()+86400));
                setcookie('password',$obj->Client_Password,(time()+86400));
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
}
?>