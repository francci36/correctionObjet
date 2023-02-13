{config_load file="config.conf"}
{include file="header.tpl" title=header}
<section class="inscription">
    <h2>Inscrivez vous et commencez à jouer</h2>
    {if $message}
        <div class="erreur">{$message}</div>
    {/if}    
    <form name="inscription" method="post" action="action.php?e=inscription">
        <div class="form-group">
            <label for="nom">Nom :</label>
<input type="text" name="nom" placeholder="" value="{if $nom} {$nom} {/if}" />
        </div>
        <div class="form-group">
            <label for="prenom">Prénom :</label>
<input type="text" name="prenom" placeholder="" value="{if $prenom} {$prenom} {/if}" />
        </div>
        <div class="form-group">
            <label for="email">Email :</label>
<input type="email" name="email" placeholder="" value="{if $email} {$email} {/if}" />
        </div>
        <div class="form-group">
            <button type="submit" name="submit">Inscription</button>
        </div> 
     </form>                  
</section>
{include file="footer.tpl" title=footer}