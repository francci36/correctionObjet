<?php
require_once('../config.php');
// On vérifie si l'utilisateur est connecté
if(!verifAdmin())
{
    // Si l'utilisateur n'est pas connecté
    $message = 'Veuillez vous connecter';
    header('location:login.php?msg='.urlencode($message));
    exit;
}
include('inc/header.php');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Gestion des Tickets</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
              <li class="breadcrumb-item active">Gestion des tickets</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des tickets</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <div class="input-group-append">
                      <button type="button" class="btn btn-default" id="btn-ticket">
                        Ajouter un ticket
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nom</th>
                      <th>Catégorie</th>
                      <th>Prix</th>
                      <th>Nombre/restant</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // On va chercher les catégories dans la BDD
                    $liste_tickets = $db->query('SELECT * FROM `Table_Ticket` INNER JOIN `Table_Categorie` ON Categorie_ID = Ticket_Categorie_ID');
                    // On vérifie qu'on a au moins une catégorie
                    if($liste_tickets->rowCount() >= 1)
                    {
                        // On créer l'objet catégorie
                        $tickets = $liste_tickets->fetchAll(PDO::FETCH_OBJ);
                        foreach($tickets as $ticket)
                        {
                            echo '<tr>';
                            echo '<td>'.$ticket->Ticket_ID.'</td>';
                            echo '<td>'.$ticket->Ticket_Nom.'</td>';
                            echo '<td>'.$ticket->Categorie_Nom.'</td>';
                            echo '<td>'.$ticket->Ticket_Prix.'</td>';
                            echo '<td>'.$ticket->Nombre_Ticket.'/XX</td>';
                            echo '<td>';
                            echo '<button type="button" class="btn btn-danger delticket" data-id="'.$ticket->Ticket_ID.'">Supprimer</button>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    }
                    else
                    {
                        echo '<div class="btn btn-warning">Aucun ticket</div>';
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- Formulaire d'ajout/édition -->
          <div class="col-12" id="div_ticket" <?php if(!empty($_SESSION['form_ticket'])) echo 'class="affiche"'; ?>>
              <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Ajouter/éditer une ticket</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?php
              if(!empty($_SESSION['form_ticket']))
              {
                // On va déserialiser notre session
                $ticket = unserialize($_SESSION['form_ticket']);
              }
              else
              {
                // Si la session est vide on initialise la variable ticket vide.
                $ticket = '';
              }
              ?>
              <form name="ticket" method="post" action="<?php if(!empty($ticket)) echo 'action.php?e=ajoutTicket'; ?>" id="form_ticket">
                <div class="card-body">
                  <div class="form-group">
                    <label for="categorie">Catégorie</label>
                    <select name="categorie" class="form-control">
                    <?php
                    $categories = $db->query('SELECT * FROM `Table_Categorie`');
                    if($categories->rowCount() >= 1)
                    {
                      $categorie = $categories->fetchAll(PDO::FETCH_OBJ);
                      // On parcourt les catégories
                      foreach($categorie as $cat)
                      {
                        echo '<option value="'.$cat->Categorie_ID.'">'.$cat->Categorie_Nom.'</option>';
                      }
                    }

                    ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" value="<?php if(!empty($ticket['nom'])) echo strip_tags($ticket['nom']); ?>">
                  </div>
                  <div class="form-group">
                    <label for="prix">Prix</label>
                    <input type="number" class="form-control" id="prix" name="prix" placeholder="Prix" value="<?php if(!empty($ticket['prix'])) echo intval($ticket['prix']); ?>">
                  </div>
                  <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="number" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?php if(!empty($ticket['nombre'])) echo intval($ticket['nombre']); ?>">
                  </div>
                  <!-- Début div partie -->
                  <div id="partie" class="row">
                     <div class="col-md-6 form-group">
                      <label for="nb_partie">Nombre de partie</label>
                      <input type="number" name="number[]" class="form-control">
                    </div>
                    <div class="col-md-6 form-group">
                      <label for="valeur_partie">Valeur</label>
                      <input type="number" name="valeur_partie[]" class="form-control">
                    </div>   
                  </div> <!-- Fin div partie -->
                  <!-- Début ajout partie -->
                  <div id="add_partie" class="row">

                  </div>
                  <!-- Fin ajout partie -->
                  <button type="button" class="btn btn-success" id="add_partie_btn">+</button>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" name="submit">Envoyer</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
          <!-- Fin formulaire ajout/édition -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
include('inc/footer.php');
?>