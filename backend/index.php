<?php
require_once('../config.php');
// On vérifie si l'utilisateur est connecté
if(!verifAdmin())
{
    // Si l'utilisateur n'est pas connecté
    $message = 'Veuillez vous connecter';
    header('location:login.php?msg='.urlencode($message));
    exit;
}
include('inc/header.php');

include('inc/footer.php');
?>