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
                // On redirige vers la page index
                header('location:index.php');
                exit;
            }
            else
            {
                $message = 'Login et/ou mot de passe incorrect';
            }
        }
        else
        {
            $message = "Veuillez renseigner un login et un mot de passe";
        }
        header('location:login.php?message='.urlencode($message));
        exit;

    break;

    case 'inscription':

        if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']))
        {
            $client = new Client('',array('nom' => $_POST['nom'], 'prenom' => $_POST['prenom'], 'email' => $_POST['email'],'credit' => 200));
            if($client)
            {
                // On envoie un mail au client
                mail($client->email,'Inscription','Voici vos identifiants: email:'.$client->email.' mot de passe:'.$client->password);
                $connect = $client->getConnexion($client->email,$client->password);
                if($connect)
                {
                    header('location:index.php');
                    exit;
                }
                else
                {
                    $message = "Login et/ou mot de passe incorrect";
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
            if(empty($_POST['nom'])) $message = 'Veuillez renseigner votre nom';
            else if(empty($_POST['prenom'])) $message = 'Veuillez renseigner votre prénom';
            else if(empty($_POST['email'])) $message = 'Veuillez renseigner votre email';
            header('location:inscription.php?message='.urlencode($message));
        }

    break;
}
?>