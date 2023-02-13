<?php
require('config.php');
require('core/Smarty.class.php');
require('core/class.client.php');
$verif_connect = Client::getConnexion();
if($verif_connect)
{
    header('location:index.php');
    exit;
}
$tpl = new Smarty;
$tpl->debugging = true;
if(!empty($_GET['message']))
{
    $message = strip_tags($_GET['message']);
}
else
{
    $message = null;
}
$tpl->assign('message',$message);
$tpl->assign('connected',false);
$tpl->assign('credit',null);
$tpl->display('login.tpl');
?>