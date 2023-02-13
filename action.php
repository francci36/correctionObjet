<?php
    require_once('config.php');
    require_once('core/class.client.php');
    switch($_GET['e'])
    {
        case 'connexion':

            if(!empty($_POST['login']) && !empty($_POST['password']))
            {
                $verif_connect = Client::getConnexion($_POST['login'],$_POST['password']);
                // Si verif connect nous retourne un client
                if($verif_connect)
                {
                    header('location:index.php');
                    exit;
                }
                else
                {
                    $message = 'Login ou mot de passe incorrect';
                }
            }
            else
            {
                $message = 'Veuillez renseigner un login ou mot de passe';
            }
            header('location:login.php?message='.urlencode($message));
            exit;

        break;

        case 'inscription':

            if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']))
            {
                $client = new Client('',array('nom'=>$_POST['nom'],'prenom'=>$_POST['prenom'],'email'=>$_POST['email'],'credit'=>200));
                if($client)
                {
                    // On envoie un mail au client
                    mail($client->email,'Inscription','Voici vos identifiants: email:'.$client->email.' mot de passe: '.$client->password);
                    $connect = $client->getConnexion($this->email,$this->password);
                    if($connect)
                    {
                        header('location:index.php');
                        exit;
                    }
                    else
                    {
                        $message = "Login ou mot de passe incorrect";
                        header('location:login.php?message='.urlencode($message));
                        exit;
                    }
                }
                else
                {
                    $message = "Impossible de créer le client";
                }
            }
            else
            {
                // On va renvoyer les informations du formulaire en session
                $_SESSION['inscription'] = serialize($_POST);
                if(empty($_POST['nom'])) $message = "Veuillez renseigner votre nom";
                else if(empty($_POST['prenom'])) $message = "Veuillez renseigner votre prénom";
                else if(empty($_POST['email'])) $message = "Veuillez renseigner votre email";
                header('location:inscription.php?message='.urlencode($message));
            }

        break;

        case 'ajoutCredit':

            $client = new Client($_COOKIE['id'],'');
            $partie = new Partie($_POST['valeurPartie']);
            $nouveau_credit = ($client->getCredit())+($partie->getValeur());
            var_dump($nouveau_credit);
            // On met à jour le crédit
            $client->setCredit($nouveau_credit);
            // On update le client dans la BDD
            $client->editer();
            header('location:index.php');
            exit;

        break;
    }
?>