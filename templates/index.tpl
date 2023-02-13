{config_load file="config.conf"}
{include file="header.tpl" title=header}
<section class="index">
    {foreach from=$tickets key=k item=t}
        <div class="ticket">
            <h3>{$t.Ticket_Nom}</h3>
            <p><b>Prix :</b>{$t.Ticket_Prix}</p>
            <a href="ticket.php?id={$t.Ticket_ID}">Jouer</a>
        </div>
    {/foreach}    
</section>
{include file="footer.tpl" title=footer}