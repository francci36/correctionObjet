<?php
require_once('../config.php');
require_once('../core/class.produit.php');
switch($_GET['e'])
{
    case 'login':

        // On vérifie qu'email et mot de passe ne sont pas vide
        if(!empty($_POST['email']) && !empty($_POST['password']))
        {
            // On vérifie la connexion à l'utilisateur
            $verif = verifAdmin($_POST['email'],$_POST['password'],$_POST['remember']);
            // Si on a un utilisateur
            if($verif)
            {
                header('location:index.php');
                exit;
            }
            else
            {
                // Si l'utilisateur n'est pas trouvé
                $message = 'Login et/ou mot de passe incorrect';
            }
        }
        else
        {
            // Si l'email ou le mot de passe sont vides
            $message = 'Veuillez renseigner un email et un mot de passe';
        }
        header('location:login.php?msg='.urlencode($message));
        exit;

    break;

    case 'printuser':

        // On vérifie que l'id de l'user est bien passé
        if(!empty($_GET['userid']))
        {
            $req = $db->prepare('SELECT * FROM `Table_Client` WHERE Client_ID = :id');
            $req->BindParam(':id',$_GET['userid'],PDO::PARAM_INT);
            $req->execute();
            // On vérifie si on a bien un utilisateur de retourné
            if($req->rowCount() == 1)
            {
                $user = $req->fetch(PDO::FETCH_OBJ);
                // On envoie en json les données
                echo json_encode($user);
            }
        }

    break;

    case 'ajoutUser':

        if(!verifAdmin()) exit;
        if(!empty($_POST['email']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['password']) && !empty($_POST['credit']))
        {
            $verif = $db->prepare('SELECT Client_ID FROM `Table_Client` WHERE Client_Email = :email');
            $verif->bindParam(':email',$_POST['email'],PDO::PARAM_STR);
            $verif->execute();
            // On vérifie si la requête nous retourne aucun résultat
            if($verif->rowCount() == 0)
            {
                // Si pas d'user on va l'enregistrer
                $user_rec = $db->prepare('INSERT INTO `Table_Client` SET
                                        Client_Nom      = :nom,
                                        Client_Prenom   = :prenom,
                                        Client_Email    = :email,
                                        Client_Password = :password,
                                        Client_Credit   = :credit
                                    ');
                $user_rec->bindValue(':nom',$_POST['nom'],PDO::PARAM_STR);
                $user_rec->bindValue(':prenom',$_POST['prenom'],PDO::PARAM_STR);
                $user_rec->bindValue(':email',$_POST['email'],PDO::PARAM_STR);
                $user_rec->bindValue(':password',sha1(md5($_POST['password'])),PDO::PARAM_STR);
                $user_rec->bindValue(':credit',$_POST['credit'],PDO::PARAM_INT);
                if($user_rec->execute())
                {
                    $message = 'Utilisateur enregistré avec succès';
                } 
                else
                {
                    $_SESSION['form_utilisateur'] = serialize($_POST);
                    $message = 'Erreur lors de la création';
                }                   
            }
            else
            {
                $_SESSION['form_utilisateur'] = serialize($_POST);
                $message = 'Cette adresse email est déjà enregistrée';
            }
        }
        else
        {
            $_SESSION['form_utilisateur'] = serialize($_POST);
            $message = 'Veuillez remplir tout les champs';
        }
        header('location:utilisateurs.php?message='.urlencode($message));
        exit;

    break;

    case 'editUser':

        if(!verifAdmin()) exit;
        // Si on a bien un ID Utilisateur
        if(!empty($_GET['id']))
        {
            if(!empty($_POST['email']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['credit']))
            {
                // On vérifie que l'email n'appartient pas a un autre utilisateur
                $verif = $db->prepare('SELECT Client_ID FROM `Table_Client` WHERE Client_Email = :email AND Client_ID != :id');
                $verif->bindParam(':email',$_POST['email'],PDO::PARAM_STR);
                $verif->bindParam(':id',$_GET['id'],PDO::PARAM_INT);
                $verif->execute();
                // Si jamais on a pas d'utilisateur avec cette adresse email
                if($verif->rowCount() == 0)
                {
                    $user_up = $db->prepare('UPDATE `Table_Client` SET
                                            Client_Nom      = :nom,
                                            Client_Prenom   = :prenom,
                                            Client_Email    = :email,
                                            Client_Credit   = :credit
                                            WHERE Client_ID = :id
                                        ');
                    $user_up->bindValue(':id',$_GET['id'],PDO::PARAM_INT);
                    $user_up->bindValue(':nom',$_POST['nom'],PDO::PARAM_STR);
                    $user_up->bindValue(':prenom',$_POST['prenom'],PDO::PARAM_STR);
                    $user_up->bindValue(':email',$_POST['email'],PDO::PARAM_STR);
                    $user_up->bindValue(':credit',$_POST['credit'],PDO::PARAM_INT);
                    if($user_up->execute())
                    {
                        $message = 'Utilisateur édité avec succès';
                    }
                    else
                    {
                        $_SESSION['form_utilisateur'] = serialize($_POST);
                        $message = "Impossible de modifier l'utilisateur";
                    }
                    // Si le mot de passe a été modifié
                    if(!empty($_POST['password'])) 
                    {
                        $pass_up = $db->prepare('UPDATE `Table_Client` SET Client_Password = :password WHERE Client_ID = :id');
                        $pass_up->bindValue(':id',$_GET['id'],PDO::PARAM_INT);
                        $pass_up->bindValue(':password',sha1(md5($_POST['password'])),PDO::PARAM_STR);
                        if($pass_up->execute())
                        {
                            $message.= '<br />Mot de passe modifié avec succès';
                        }
                        else
                        {
                            $_SESSION['form_utilisateur'] = serialize($_POST);
                            $message.= "<br />Erreur lors de l'édition du mot de passe";
                        }
                    }
                }
                else
                {
                    $_SESSION['form_utilisateur'] = serialize($_POST);
                    $message = 'Email déjà enregistré';
                }
            }
            else
            {
                $_SESSION['form_utilisateur'] = serialize($_POST);
                $message = "Vous devez remplir l'ensemble des champs";
            }    
        }
        else
        {
            $message = "Tu n'as pas le droit d'être ici!!!";
        }
        header('location:utilisateurs.php?message='.urlencode($message));
        exit;

    break;

    case 'deluser':

        if(!verifAdmin()) exit;
        if(!empty($_GET['id']))
        {
            $del_user = $db->prepare('DELETE FROM `Table_Client` WHERE Client_ID = :id');
            $del_user->bindValue(':id',$_GET['id'],PDO::PARAM_INT);
            if($del_user->execute())
            {
                $message = 'Utilisateur supprimé avec succès !!';
            }
            else
            {
                $message = "Erreur lors de la suppression de l'utilisateur";
            }
        }
        else
        {
            $message = "Tu n'as rien à faire ici !!!";
        }
        header('location:utilisateurs.php?message='.urlencode($message));
        exit;

    break;

    case 'printCategorie':

        if(!verifAdmin()) exit;
        if(!empty($_GET['id']))
        {
            $cat = $db->prepare('SELECT * FROM `Table_Categorie` WHERE Categorie_ID = :id');
            $cat->bindParam(':id',$_GET['id'],PDO::PARAM_INT);
            $cat->execute();
            // On vérifie si une catégorie est retourné
            if($cat->rowCount() == 1)
            {
                $categorie = $cat->fetch(PDO::FETCH_OBJ);
                echo json_encode($categorie);
            }
        }

    break;

    case 'ajoutCategorie':

        if(!verifAdmin()) exit;
        if(!empty($_POST['nom']))
        {
            $cat_add = $db->prepare('INSERT INTO `Table_Categorie` SET Categorie_Nom = :nom');
            $cat_add->bindValue(':nom',$_POST['nom'],PDO::PARAM_STR);
            if($cat_add->execute())
            {
                $message = 'Catégorie ajouté avec succès';
            }
            else
            {
                $_SESSION['form_categorie'] = serialize($_POST);
                $message = "Une erreur est survenue lors de l'ajout de la catégorie";
            }
        }
        else
        {
            $message = 'Vous devez indiquer le nom de la catégorie';
        }
        header('location:categories.php?message='.urlencode($message));
        exit;

    break;

    case 'editCategorie':

        if(!verifAdmin()) exit;
        if(!empty($_GET['id']))
        {
            if(!empty($_POST['nom']))
            {
                $cat_up = $db->prepare('UPDATE `Table_Categorie` SET Categorie_Nom = :nom WHERE Categorie_ID = :id');
                $cat_up->bindValue(':id',$_GET['id'],PDO::PARAM_INT);
                $cat_up->bindValue(':nom',$_POST['nom'],PDO::PARAM_STR);
                if($cat_up->execute())
                {
                    $message = 'Catégorie modifié avec succès';
                }
                else
                {
                    $_SESSION['form_categorie'] = serialize($_POST);
                    $message = "Une erreur est survenue lors de l'édition";
                }
            }
            else
            {
                $message = 'Veuillez indiquer un nom';
            }
        }
        else
        {
            $message = "Tu n'as rien à faire ici !!!!!!!!!";
        }
        header('location:categories.php?message='.urlencode($message));
        exit;
    break;

    case 'delCategorie':

        if(!verifAdmin()) exit;
        if(!empty($_GET['id']))
        {
            $cat_del = $db->prepare('DELETE FROM `Table_Categorie` WHERE Categorie_ID = :id');
            $cat_del->bindValue(':id',$_GET['id'],PDO::PARAM_INT);
            if($cat_del->execute())
            {
                $message = 'Catégorie supprimé avec succès';
            }
            else
            {
                $message = "Erreur lors de la suppression de la catégorie";
            }
        }
        else
        {
            $message = "Tu n'as rien à faire ici !!!!";
        }
        header('location:categories.php?message='.urlencode($message));
        exit;
    break;

    case 'ajoutTicket':

        if(!verifAdmin()) exit;
        if(!empty($_POST['categorie']) && !empty($_POST['nom']) && !empty($_POST['prix']) && !empty($_POST['nombre']))
        {
            $ticket_add = $db->prepare('INSERT INTO `Table_Ticket` SET
                                        Ticket_Categorie_ID = :id,
                                        Ticket_Nom          = :nom,
                                        Ticket_Prix         = :prix,
                                        Ticket_Nombre       = :nombre
                                    ');
            $ticket_add->bindValue(':id',$_POST['categorie'],PDO::PARAM_INT);
            $ticket_add->bindValue(':nom',$_POST['nom'],PDO::PARAM_STR);
            $ticket_add->bindValue(':prix',$_POST['prix'],PDO::PARAM_INT);
            $ticket_add->bindValue(':nombre',$_POST['nombre'],PDO::PARAM_INT);
            if($ticket_add->execute())
            {
                $id_ticket = $db->lastInsertId();
                // On boucle les parties Youpi !
                $k = 0;
                foreach($_POST['number'] as $nb)
                {
                    // On boucle sur la valeur de number
                    for($i=0;$i<=$_POST['number'][$k];$i++)
                    {
                        //echo $_POST['valeur_partie'][$k];
                        $partie_add = $db->prepare('INSERT INTO `table_partie` SET
                                                    Partie_Ticket_ID = :id,
                                                    Partie_Valeur = :valeur,
                                                    Partie_Date = CURDATE(),
                                                    Partie_Etat = "0"
                                                ');
                        $partie_add->bindValue(':id',$id_ticket,PDO::PARAM_INT);
                        $partie_add->bindValue(':valeur',$_POST['valeur_partie'][$k],PDO::PARAM_INT);
                        if(!$partie_add->execute())
                        {
                            var_dump($db->errorInfo());
                        }
                       
                    }
                    $k++;
                }
                $message = 'Ticket ajouté avec succès';
            }
            else
            {
                $message = 'Erreur avec le ticket';
                $_SESSION['form_ticket'] = serialize($_POST);
            }                        
        }
        else
        {
            $message = "Vous devez saisir l'ensemble des champs";
            $_SESSION['form_ticket'] = serialize($_POST);
        }
        //header('location:tickets.php?message='.urlencode($message));
        exit;

    break;

    case 'delTicket':

        if(!verifAdmin()) exit;
        if(!empty($_GET['id']))
        {
            $del_partie = $db->prepare('DELETE FROM `Table_Partie` WHERE Partie_Ticket_ID = :id');
            $del_partie->bindValue(':id',$_GET['id'],PDO::PARAM_INT);
            $del_partie->execute();
            $del_ticket = $db->prepare('DELETE FROM `Table_Ticket` WHERE Partie_ID = :id');
            $del_ticket->bindValue(':id',$_GET['id'],PDO::PARAM_INT);
            if($del_ticket->execute())
            {
                $message = 'Ticket supprimé avec succès';
            }
            else
            {
                $message ='Erreur avec la suppression';
            }
        }
        else
        {
            $message = "Tu n'as rien à faire ici !!!";
        }

    break;

    case 'ajoutproduit':

        if(!verifAdmin()) exit;
       // Instancier un nouvel objet Produit
        $produit = new Produit();

        // Récupérer les données du formulaire
        $valeur = $_POST['valeur'];
        $prix = $_POST['prix'];
        $qte = $_POST['quantite'];

        // Modifier les propriétés de l'objet
        $produit->setValeur($valeur);
        $produit->setPrix($prix);
        $produit->setQuantite($qte);

        // Appeler la méthode "inscrire" pour enregistrer le produit en base de données
        $id_produit = $produit->inscrire();

        if($id_produit) {
            $message = 'Produit ajouté avec succès';
        } else {
            $message = 'Erreur avec le produit';
        }

        header('location:produit.php?message='.urlencode($message));
        exit;
        break;

        case 'editproduit':
        
            if(!verifAdmin()) exit;
        
            if(!empty($_POST['valeur']) && !empty($_POST['prix']) && !empty($_POST['quantite'])) {
        
                // Récupérer l'objet produit correspondant à l'ID passé en GET
                $produit = new Produit($_GET['id']);
        
                // Récupérer les données du formulaire
                $valeur = $_POST['valeur'];
                $prix = $_POST['prix'];
                $qte = $_POST['quantite'];
        
                // Modifier les propriétés de l'objet
                $produit->setValeur($valeur);
                $produit->setPrix($prix);
                $produit->setQuantite($qte);
        
                // Appeler la méthode "enregistrer" pour mettre à jour le produit en base de données
                if($produit->editer()) {
                    $message = 'Produit modifié avec succès';
                } else {
                    $message = 'Erreur avec le produit';
                }
        
            } else {
                $message = "Vous devez saisir l'ensemble des champs";
            }
        
            header('location:produit.php?message='.urlencode($message));
            exit;
            break;

            case 'delproduit':
                if(!verifAdmin()) exit;
            
                if(!empty($_GET['id'])) {
                    $produit = new Produit($_GET['id']);
            
                    if($produit->delete()) {
                        $message = 'Produit supprimé avec succès';
                    } else {
                        $message ='Erreur avec la suppression';
                    }
                } else {
                    $message = "Tu n'as rien à faire ici !!!";
                }
            
                header('location:produit.php?message='.urlencode($message));
                exit;
                break;
}
?>