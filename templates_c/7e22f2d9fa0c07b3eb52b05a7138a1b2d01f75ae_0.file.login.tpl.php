<?php
/* Smarty version 4.3.0, created on 2023-02-13 12:48:49
  from 'C:\Users\sousadossantos\Documents\exophp0202\ticketFloriant\templates\login.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63ea31b16ef1d4_60860275',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7e22f2d9fa0c07b3eb52b05a7138a1b2d01f75ae' => 
    array (
      0 => 'C:\\Users\\sousadossantos\\Documents\\exophp0202\\ticketFloriant\\templates\\login.tpl',
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
function content_63ea31b16ef1d4_60860275 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->smarty->ext->configLoad->_loadConfigFile($_smarty_tpl, "config.conf", null, 0);
?>

<?php $_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('title'=>'header'), 0, false);
?>
<section class="formulaire">
    <?php if ($_smarty_tpl->tpl_vars['message']->value) {?>
        <div class="erreur"><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</div>
    <?php }?>
    <form name="connexion" method="post" action="action.php?e=connexion">
        <div class="form-group">
            <label for="login">
            <input type="email" name="login" id="login" placeholder="" />
        </div>
        <div class="form-group">
            <label for="password">
            <input type="password" name="password" id="password" placeholder="" />
        </div>
        <div class="form-group">
            <button type="submit" name="submit" class="submit">Se connecter</button>
        </div>
    </form>
</section>
<?php $_smarty_tpl->_subTemplateRender("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('title'=>'footer'), 0, false);
}
}
