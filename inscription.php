<?php
ini_set('display_errors',false);
require_once('config.php');
require_once('core/class.client.php');
require_once('core/Smarty.class.php');
$verif_connect = Client::getConnexion();
// Si le client est connecté
if($verif_connect)
{
    header('location:index.php');
    exit;
}
$tpl = new Smarty;
$tpl->assign('connected',false);
$tpl->assign('message',strip_tags($_GET['message']));
$tpl->assign('nom',strip_tags($_POST['nom']));
$tpl->assign('prenom',strip_tags($_POST['prenom']));
$tpl->assign('email',strip_tags($_POST['email']));
$tpl->assign('credit',null);
$tpl->display('inscription.tpl');

?>