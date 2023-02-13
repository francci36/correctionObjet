<?php
require_once('config.php');
require_once('core/class.client.php');
require_once('core/class.ticket.php');
require_once('core/Smarty.class.php');
// On vérifie si le client est connecté
$verif_client = Client::getConnexion();
// Si le client n'est pas connecté
if(!$verif_client)
{
    header('location:login.php');
    exit;
}
$client = new Client($_COOKIE['id']);
// On récupère la liste des tickets
$tickets = Ticket::liste();
$tpl = new Smarty;
$tpl->assign('connected',true);
$tpl->assign('credit',$client->getCredit());
$tpl->assign('tickets',$tickets);
$tpl->display('index.tpl');


?>