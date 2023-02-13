<?php
/* Smarty version 4.3.0, created on 2023-02-10 10:13:22
  from 'C:\Users\mancieri\Documents\ticket\templates\index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63e618c279b2b9_78184705',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '08d55494e471fb6699d2d251c63c1432014b1886' => 
    array (
      0 => 'C:\\Users\\mancieri\\Documents\\ticket\\templates\\index.tpl',
      1 => 1676023977,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
),false)) {
function content_63e618c279b2b9_78184705 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->smarty->ext->configLoad->_loadConfigFile($_smarty_tpl, "config.conf", null, 0);
?>

<?php $_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('title'=>'header'), 0, false);
?>
<section class="index">
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tickets']->value, 't', false, 'k');
$_smarty_tpl->tpl_vars['t']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['t']->value) {
$_smarty_tpl->tpl_vars['t']->do_else = false;
?>
        <div class="ticket">
            <h3><?php echo $_smarty_tpl->tpl_vars['t']->value['Ticket_Nom'];?>
</h3>
            <p><b>Prix :</b><?php echo $_smarty_tpl->tpl_vars['t']->value['Ticket_Prix'];?>
</p>
            <a href="ticket.php?id=<?php echo $_smarty_tpl->tpl_vars['t']->value['Ticket_ID'];?>
">Jouer</a>
        </div>
    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>    
</section>
<?php $_smarty_tpl->_subTemplateRender("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('title'=>'footer'), 0, false);
}
}
