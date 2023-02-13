<?php
/* Smarty version 4.3.0, created on 2023-02-09 13:30:24
  from 'C:\Users\mancieri\Documents\ticket\templates\inscription.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63e4f570686661_92799720',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '38217c02e47718c83a09369a830abfe30809c0f9' => 
    array (
      0 => 'C:\\Users\\mancieri\\Documents\\ticket\\templates\\inscription.tpl',
      1 => 1675948840,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
),false)) {
function content_63e4f570686661_92799720 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->smarty->ext->configLoad->_loadConfigFile($_smarty_tpl, "config.conf", null, 0);
?>

<?php $_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('title'=>'header'), 0, false);
?>
<section class="inscription">
    <h2>Inscrivez vous et commencez à jouer</h2>
    <?php if ($_smarty_tpl->tpl_vars['message']->value) {?>
        <div class="erreur"><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</div>
    <?php }?>    
    <form name="inscription" method="post" action="action.php?e=inscription">
        <div class="form-group">
            <label for="nom">Nom :</label>
<input type="text" name="nom" placeholder="" value="<?php if ($_smarty_tpl->tpl_vars['nom']->value) {?> <?php echo $_smarty_tpl->tpl_vars['nom']->value;?>
 <?php }?>" />
        </div>
        <div class="form-group">
            <label for="prenom">Prénom :</label>
<input type="text" name="prenom" placeholder="" value="<?php if ($_smarty_tpl->tpl_vars['prenom']->value) {?> <?php echo $_smarty_tpl->tpl_vars['prenom']->value;?>
 <?php }?>" />
        </div>
        <div class="form-group">
            <label for="email">Email :</label>
<input type="email" name="email" placeholder="" value="<?php if ($_smarty_tpl->tpl_vars['email']->value) {?> <?php echo $_smarty_tpl->tpl_vars['email']->value;?>
 <?php }?>" />
        </div>
        <div class="form-group">
            <button type="submit" name="submit">Inscription</button>
        </div> 
     </form>                  
</section>
<?php $_smarty_tpl->_subTemplateRender("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('title'=>'footer'), 0, false);
}
}
