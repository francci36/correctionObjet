<?php
/* Smarty version 4.3.0, created on 2023-02-13 12:49:23
  from 'C:\Users\sousadossantos\Documents\exophp0202\ticketFloriant\templates\index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63ea31d3aa20a1_42546379',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3e2be6ee726b73a5333e8061eb6e084877108414' => 
    array (
      0 => 'C:\\Users\\sousadossantos\\Documents\\exophp0202\\ticketFloriant\\templates\\index.tpl',
      1 => 1676280412,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
),false)) {
function content_63ea31d3aa20a1_42546379 (Smarty_Internal_Template $_smarty_tpl) {
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
