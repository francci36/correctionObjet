<?php
    //Si l'ID est vide!
    if(empty($_GET['id']))
    {
        header('location:index.php');
        exit;
    }
    require_once('config.php');
    require_once('core/class.client.php');
    require_once('core/class.ticket.php');
    require_once('core/class.partie.php');
    $verif_connect = Client::getConnexion();
    // Si le client est connecté
    if($verif_connect)
    {
        $client = new Client($_COOKIE['id']);
        $ticket = new Ticket($_GET['id']);
        // On vérifie si le client a assez de credit
        if($client->getCredit() >= $ticket->getPrix())
        {
            // Créer une partie au hasard
            // REQUETE sql pour random sur la table partie
            $req1 = $db->prepare('SELECT * FROM table_partie WHERE Partie_Ticket_ID = '.$ticket->getTicketID().' ORDER BY RAND() LIMIT 1');
            $req1->execute();
            //echo $ticket->getTicketID();
            // On récupère l'id de la partie
            $partie_id = $req1->fetch(PDO::FETCH_OBJ);
            $partie = new Partie($partie_id->Partie_ID);
            // On met à jour le crédit du client
            $nouveau_credit = $client->getCredit()-$ticket->getPrix();
            // On met à jour le crédit
            $client->setCredit($nouveau_credit);
            // On update le client dans la BDD
            $client->editer();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Ticket</title>
</head>
<body>
    <div class="container" id="js-container">
        <canvas class="canvas" id="js-canvas" width="300" height="300"></canvas>
        <form class="form" id="ticketGagnant" method="post" action="action.php?e=ajoutCredit" style="visibility: hidden;">
            <h2>Vous avez gagné : </h2>
            <h3 id="valeurPartie"><?php echo $partie->getValeur();?></h3>
            <br>
            <div>
                <input type="hidden" name="valeurPartie" value="<?php echo $partie->getId(); ?>" />
                <button type="submit" value="Submit">Valider</button>
            </div>
        </form>  
        </div>
        <script type="text/javascript" src="assets/js/ticket.js"></script>
</body>
</html>