{config_load file="config.conf"}
{include file="header.tpl" title=header}
<section class="formulaire">
    {if $message}
        <div class="erreur">{$message}</div>
    {/if}
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
{include file="footer.tpl" title=footer}