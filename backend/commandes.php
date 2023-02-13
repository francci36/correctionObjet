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
            <h1>Gestion des commandes</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
              <li class="breadcrumb-item active">Gestion des commandes</li>
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
                <h3 class="card-title">Liste des commandes</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
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
                      <th>Client</th>
                      <th>Montant</th>
                      <th>Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // On va chercher les catégories dans la BDD
                    $liste_commandes = $db->query('SELECT * FROM `Table_Commande` INNER JOIN `Table_Client` ON Commande_Client_ID = Client_ID');
                    // On vérifie qu'on a au moins une catégorie
                    if($liste_commandes->rowCount() >= 1)
                    {
                        // On créer l'objet catégorie
                        $commandes = $liste_commandes->fetchAll(PDO::FETCH_OBJ);
                        foreach($commandes as $commande)
                        {
                            echo '<tr>';
                            echo '<td>'.$commande->Commande_ID.'</td>';
                            echo '<td>'.$commande->Client_Prenom.' '.$commande->Client_Nom.'</td>';
                            echo '<td>'.$commande->Commande_Montant.'</td>';
                            echo '<td>'.$commande->Commande_Date.'</td>';
                            echo '</tr>';
                        }
                    }
                    else
                    {
                        echo '<div class="btn btn-warning">Aucune commande</div>';
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
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